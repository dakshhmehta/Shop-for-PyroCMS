<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * 
 * CoreBasiks::Trust Score - An idea I had to evaluate incoming orders much like a Spam Score.
 *
 *
 *
 * 
 * Each of the below tests compare the order data to retrieve a score 
 * based on the likelyhood of the newly placed order to see if it was 
 * a robot or human. 
 *
 * These test are not 100% they check against keywords, consistancy of data .
 *
 * The idea is that it can also help prevent against ChargeBacks. 
 * If you get a lower score it may trigger the admin to confirm the order
 * with the customerbefore orders are shipped out.
 *
 *
 *
 * 
 * 
 */
class Core_trust_library extends Core_library
{

	/**
	 * List of reasons why the score is the way it is
	 * @var array
	 */
	private $list_reasons = array();
	private $untrusted_words = array();

	const SYMBOL_POSITIVE = '+';
	const SYMBOL_NEGATIVE = '-';

	//
	// Threshold values represent the max time or amount the propery is set to.
	//
	const THRESHOLD_MAX_ORDER_TOTAL = 500;
	const THRESHOLD_KEYWORD_USE_COUNT = 2;

	//
	// Const strings for reason messages
	//
	const REASON_PASS_ORDER_TOTAL = 'Order total is normal';
	const REASON_FAIL_ORDER_TOTAL = 'Uncommon order amount';


	//
	// Array keys for Trust score reasons
	//
	const TRUST_SCORE_KEY_ORDER_TOTAL = 'TrustScore-CT';
	const TRUST_SCORE_KEY_KEYWORD_USE = 'TrustScore-KU';




	//
	// Order array keys: do not change these values
	// These string values represent the keys of the incoming order  array.
	// Do NOT change these values.
	// 
	private $key_order_total = 'order_total';





	public function __construct($params = array())
	{
		
		parent::__construct();
		log_message('debug', "Class Initialized");
		
	}





	/**
	 * Award 1 point for less than 2 spam words
	 *
	 * 
	 * @param  [type] $order_data [description]
	 * @return [type]             [description]
	 */
	public function get_trust_score($order_data)
	{
		//start at 0
		$score = 0;


		/*
		 * Step 1: Collect data and load models
		 *
		 * 
		 */

		// Extract data from order
		$data = $this->collect_data($order_data);


		//build word list
		$word_list = $this->get_word_list($data);



		// Load db model
		$this->load->model('shop/trust_data_m');



		// Get the list of untrusted words
		$this->_untrusted_words = $this->trust_data_m->get_all();




		/*
		 * Step 2: Now do all the evaluations
		 *
		 * 
		 */



		//
		//check order total
		//
		$this->evaluate_order_total($order_data, $score);



		// 
		// Check Keywords used, i.e Viagra, SEX, MAKE MONEY ect....
		// 
		$this->evaluate_keywords($word_list, $score);



		//
		// Now check if user is entering domain names
		//
		$this->evaluate_addresses($data, $score);




		//
		// Step 3: prep the score for return to the system 
		//
		return $this->_prep_return_object($score);



	}






	/**
	 * Evaluates the order total and assignes a score + or  - based on the order total
	 *
	 * if the order max threshold is 50, then any orders above 50 are awarded a negative score
	 * 
	 * @param  [type] $order_data [description]
	 * @param  [type] $score      [description]
	 * @return [type]             [description]
	 */
	private function evaluate_order_total($order_data, &$score)
	{

		//if order total is rediculusly high then remove a point
		
		$_score = 1;
		$_description = self::REASON_PASS_ORDER_TOTAL;


		if( $order_data[$this->key_order_total] > self::THRESHOLD_MAX_ORDER_TOTAL )
		{
			$_score = -1;
			$_description = self::REASON_FAIL_ORDER_TOTAL;
		}

		
		$this->list_reasons[self::TRUST_SCORE_KEY_ORDER_TOTAL] = "" .  $this->_score_string($_score) . ' points for ' . $_description;

		//adjust the score
		$score = + $_score;

	}
	

	/**
	 * This evaluate both if a trigger word is used and the amount of times a trigger word is used
	 * 
	 * @param  [type] $word_list [description]
	 * @param  [type] $score     [description]
	 * @return [type]            [description]
	 */
	private function evaluate_keywords( &$word_list, &$score)
	{

		//counter
	 	$array_count= 0; 


		foreach($this->_untrusted_words as $row)
		{
			/*
			 * $word_used is the key of the array, the key is the word, the value/keyword_usage is the amount
			 * of times the word is used
			 */
			foreach($word_list as $word_used => $keyword_usage)
			{
				 
				if($this->str_contains($word_used,  $row->word, TRUE))
				{


					//inc so we can add a new key to the array
					$array_count++; 
					$score = $score - $row->score;

					// add this event to the list
					$this->list_reasons[self::TRUST_SCORE_KEY_KEYWORD_USE . $array_count] = "" . $this->_score_string( $row->score )  . ' points for KEYWORD: '. $row->word .' usage';



					/*
					 * Now we evaluate the amount of times this word is used
					 */
					$_score = ( $keyword_usage <= self::THRESHOLD_KEYWORD_USE_COUNT )? 1 : -1 ;



					$score = $score + $_score;
					$this->list_reasons['TrustScore-MKC'] = "" . $this->_score_string( $_score ) . ' points for min KEYWORD usage';


				}

			}

		}


	}


	/**
	 * 
	 * @param  [type] $order_data [description]
	 * @return [type]             [description]
	 */
	private function evaluate_addresses($data, &$score)
	{


		$adjustment = $this->compare_and_score(  $data->billing , $data->shipping  );


		$this->list_reasons['TrustScore-AC'] = "" . $this->_score_string( $adjustment ) . ' points address comparison';

		//add to the score -+ 
		$score = $score + $adjustment;


	}







	/**
	 * Here we can compare both addreses. Shipping and billing. Although it is normal to have a seperate shipping address
	 *
	 * These rules will award 
	 * 
	 *  	+2 points for having the same address exactly
	 *  	+1 points for having the same state
	 *  	 0 points for having the same country + same person names
	 *  	-1 points for having the different country + same person names
	 *  	-2 points for having the different names and diff country !! risky !!
	 *  	
	 */
	private function compare_and_score($data_set1, $data_set2)
	{


		if($data_set1 == $data_set2)
			return 2;


		if( $data_set1['country'] == $data_set2['country'])
		{
			if( $data_set1['state'] == $data_set2['state'])
			{
				return 1;
			}

			if( $data_set1['first_name'] == $data_set2['first_name'])
			{
				return 0;
			}
			else
			{
				return -1;
			}
		
		}

		if( $data_set1['country'] != $data_set2['country'])
		{

			if( $data_set1['first_name'] == $data_set2['first_name'])
			{
				return -1;
			}

		}

		return -2; // diff country and diff name

	}






	private function collect_data($order_data)
	{



		$address_fields = array('first_name','last_name','phone', 'country', 'state','city','address1','address2','zip','email');

		$billing_address = array();
		$shipping_address = array();

		$this->load->model('shop/addresses_m');



		//
		// Get billing data
		//
		if(isset($order_data['existing_address_id']))
		{
			//
			// this checks to see if an existing address is used
			//
			if($order_data['existing_address_id'] > 0)
			{
				$addr = $this->addresses_m->get($order_data['existing_address_id']);

				$this->build_address_from_db($addr, $billing_address);
			}
			else
			{
				foreach($address_fields as $field)
				{
					//billing data
					if($value = $this->get_field($field))
					{
						$billing_address[$field] = $value;
					}
				}
			}

		}





		//
		// Get Shipping data
		//
		if(isset($order_data['existing_address_shipping_id']))
		{
			//
			// this checks to see if an existing address is used
			//
			if($order_data['existing_address_shipping_id'] > 0)
			{
				$addr = $this->addresses_m->get($order_data['existing_address_shipping_id']);

				$this->build_address_from_db($addr, $shipping_address);
			}
			else
			{


				foreach($address_fields as $field)
				{
					$key_field = 'shipping_' . $field;
					//billing data
					if($value = $this->get_field($key_field))
					{
						$shipping_address[$field] = $value;
					}

				}


			}

		}


		//
		// package arrays for return
		//
		$returnObject = new stdClass();

		$returnObject->billing = $billing_address;
		$returnObject->shipping = $shipping_address;

		return $returnObject;

	}


	private function get_field($field)
	{

		if(isset($order_data[$field]))
		{
			$value = $order_data[$field];

			if(trim($value) != '')
			{
				 
				return $value;

			}

		}

		return FALSE;

	}


	private function build_address_from_db($row, &$array)
	{

		foreach($row as $field => $value)
		{
			$array[$field] = $value;
		}

	}


	private function str_contains($haystack, $needle, $ignoreCase = false) 
	{
	    if ($ignoreCase) 
	    {
	        $haystack = strtolower($haystack);
	        $needle   = strtolower($needle);
	    }

	    $needlePos = strpos($haystack, $needle);
	    
	    return ($needlePos === false ? false : ($needlePos+1));
	}



	/**
	 * Prepares and Retrieves the list of words used in the order
	 * 
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	private function get_word_list($data)
	{

		$word_list = array();

		foreach($data->billing as $key => $word)
		{

			 if(isset($word_list[$word]))
			 {
					$word_list[$word]['count'] =  $word_list[$word]['count'] + 1;
			 }
			 else
			 {
					$word_list[$word]['count'] = 1;
			 }

		}

		foreach($data->shipping as $key => $word)
		{
			 
			 if(isset($word_list[$word]))
			 {
					$word_list[$word]['count'] =  $word_list[$word]['count'] + 1;
			 }
			 else
			 {
					$word_list[$word]['count'] = 1;
			 }

		}

		//
		// removes duplicate entries of words used
		//
		//$word_list = array_unique ( $word_list  );

		return $word_list;

	}



	/** _score_string

	 * Simple function to get the string representation of the score
	 * 
	 * @param  [type] $score [description]
	 * @return [type]        [description]
	 */
	private function _score_string($score)
	{

		$symbol = ($score < 0)?  self::SYMBOL_NEGATIVE :  self::SYMBOL_POSITIVE ;

		return $symbol . abs($score);

	}



	/**
	 * This preps the score by binding it with the list of resons found
	 * into a single object for returning to the system
	 *
	 * The format is
	 * 		-Object->score
	 * 		-Object->events
	 * 
	 * @param  [type] $score [description]
	 * @return [type]        [description]
	 */
	private function _prep_return_object(&$score)
	{

		$ret_object = new stdClass();
		$ret_object->score = $score;
		$ret_object->events = $this->list_reasons;

		return $ret_object;

	}



}
// END Cart Class
