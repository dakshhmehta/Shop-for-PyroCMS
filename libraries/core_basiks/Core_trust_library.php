<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');


class Core_trust_library extends Core_library
{
	/**
	 * List of reasons why the score is the way it is
	 * @var array
	 */
	private $list_reasons = array();


	public function __construct($params = array())
	{
		
		parent::__construct();
		log_message('debug', "Class Initialized");
		
	}

	private function check_order_total($order_data)
	{
		//if order total is rediculusly high then remove a point
		
		$_score = 1;
		$symbol = '+';
		$_description = 'respectable order amount';


		if( $order_data['order_total'] > 500 )
		{
			$_score = -1;
			$symbol = '';
			$_description = 'uncommon order amount';
		}

		
		$this->list_reasons['TrustScore-CT'] = "Awarded " . $symbol . $_score . ' points for ' . $_description;
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

		//check cart total
		$this->check_order_total($order_data);


		$data = $this->collect_data($order_data);

 
		$this->load->model('shop/trust_data_m');


		//if ok - do nothing else

		$this->_untrusted_words = $this->trust_data_m->get_all();


		//start at 0
		$score = 0;
		$spam_words_count = 0;
		$url_words_count = 0; // total number of URLS domains listed
		$spam_words_count_threshold = 0; // the max # of words allowed before we award a POINT
		$url_words_award_point = 1;
		$spam_words_award_point = 1;
		$url_count_threshold = 0;

		//build word list
		$word_list = $this->get_word_list($data);


	 	$array_count= 0; //counter

		foreach($this->_untrusted_words as $row)
		{


			foreach($data->billing as $key => $haystack)
			{
				 
				if($this->str_contains($haystack,  $row->word, TRUE))
				{
					$array_count++;
					$score = $score - $row->score;
					//echo $needle;die;
					$spam_words_count++;

					$this->list_reasons['TrustScore-KC' . $array_count] = "Awarded -" . $row->score . ' points for KEYWORD: '. $row->word .' usage';

				}

			}

		}


		//now check if user is entering domain names
		$score = $this->compare_addresses($data, $score);


		/*
		 * Now we can start awarding points
		 */
		if($spam_words_count <= $spam_words_count_threshold)
		{
			
			$score = $score + $spam_words_award_point;
			$this->list_reasons['TrustScore-MKC'] = "Awarded +" . $spam_words_award_point . ' points for min KEYWORD usage';
		}


		if($url_words_count <= $url_count_threshold)
		{
			$score = $score + $url_words_award_point;
			$this->list_reasons['TrustScore-MUC'] = "Awarded +" . $url_words_award_point . ' points for min URL usage';
		}


		$ret_object = new stdClass();
		$ret_object->score = $score;
		$ret_object->events = $this->list_reasons;

		return $ret_object;


	}

	private function get_word_list($data)
	{

		$word_list = array();

		foreach($data->billing as $key => $word)
		{
			 
			 $word_list[] =  $word;

		}

		foreach($data->shipping as $key => $word)
		{
			 
			 $word_list[] =  $word;

		}


		$word_list = array_unique ( $word_list  );

		return $word_list;

	}




	/**
	 * 
	 * @param  [type] $order_data [description]
	 * @return [type]             [description]
	 */
	private function compare_addresses($data, $score)
	{

		$symbol = '';

		$adjustment = $this->compare_and_score(  $data->billing , $data->shipping  );

		if($adjustment > 0)
			$symbol = '+';

		$this->list_reasons['TrustScore-AC'] = "Awarded " . $symbol . $adjustment . ' points address comparison';

		//add to the score -+ 
		$score = $score + $adjustment;

	
		return $score;

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
		// Get billing data
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


}
// END Cart Class
