<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
/*
 * SHOP for PyroCMS
 * 
 * Copyright (c) 2013, Salvatore Bordonaro
 * All rights reserved.
 *
 * Author: Salvatore Bordonaro
 * Version: 1.0.0.051
 *
 *
 *
 * 
 * See Full license details on the License.txt file
 */
 
/**
 * SHOP			A full featured shopping cart system for PyroCMS
 *
 * @author		Salvatore Bordonaro
 * @version		1.0.0.051
 * @website		http://www.inspiredgroup.com.au/
 * @system		PyroCMS 2.1.x
 *
 */
class Fraud_control 
{



	private $_score = 0;
	private $_blacklisted;
	private $_messages;

	private $_blocked_ips;
	private $_blocked_emails;
	private $_blocked_country;


	private $_shipping_address = NULL;
	private $_billing_address = NULL;

	private $_input_data;

	public function __construct($params = array())
	{

		$this->_score = 0;
		$this->_blacklisted = FALSE;
		$this->_messages = array();
		$this->_input_data = array();
		
		$this->_blocked_ips = array();
		$this->_blocked_emails = array();
		$this->_blocked_country = array();

		log_message('debug', "Class Initialized");
		
	}

	/**
	 * The resulting score
	 */
	public function score()
	{
		return $this->_score;
	}


	/**
	 * Was the order blacklisted ? (Y/N)
	 */
	public function is_blacklisted()
	{
		return $this->_blacklisted;
	}

	/**
	 * List of messages to return to system
	 */
	public function messages()
	{
		return $this->_messages;
	}




	/**
	 * Expected data
	 *
	 * array
	 *   'user_id' => string '1' - a number but in string format
	 *   'cost_items' => float 5
	 *   'cost_shipping' => float 2 
	 *   'shipping_id' => string '4' this is the id of the shipping methof
	 *   'gateway_method_id' => string '2' gateway method id
	 *   'billing_address_id' => string '1' (length=1)
	 *   'shipping_address_id' => string '1' (length=1)
	 *   'session_id' => string 'phpsessionID' 
	 *   'ip_address' => string '127.0.0.1' 
	 *
	 *   --any extra data will be ignored
	 *
	 *
	 * 
	 * @param  array  $order_data [description]
	 * @return [type]             [description]
	 */
	public function inspect( $input = array() )
	{
		

		$this->_input_data = $input;


		// 
		// we can not continue
		// if the data was bad from the start
		//
		if(!$this->_validate_inputdata())
		{
			
			$this->input_data = NULL;

			return FALSE; 

		}



		//
		// Collects addresses, blacklist and spam words
		//
		$this->_collect_data();





		// 
		// Check blacklisting
		// 
		$this->_check_blacklisting();




		// 
		// Compare to see if the addresses match, to get a higher score usually both billing and shipping match
		// 
		$this->_compare_addresses();



		//
		// Compare if Country matches the IP address country




		// 1: Collect data
		// 2: Check against blacklisting
		// 3: Check TrustScore
		// 		- Compare Shipping and Billing Address (country only)
		// 		- Compare Shipping address with IP Location (Country Only)
		// 		- Compare words used with trust words
		//$this->_score = ( $this->_score + 1 );
		//$this->_blacklisted = FALSE;
		//$this->_messages[] = 'unable to locate address';
		//$this->_messages[] = 'bad use of word $s';

	}



	/**
	 * This is a very simple function that makes sure that we have the correct fields
	 * @return [type] [description]
	 */
	private function _validate_inputdata()
	{

		if(isset($this->_input_data['billing_address_id']))
		{

			if(isset($this->_input_data['shipping_address_id']))
			{

				if(isset($this->_input_data['cost_items']))
				{				

					if(isset($this->_input_data['ip_address']))
					{
						return TRUE;
					}
				}
			}
		}

		echo 'end';

		return FALSE;

	}




	/**
	 * Collect data - we only retrieve the Address ID so we need to get the actual input from the user
	 * @return [type] [description]
	 */
	private function _collect_data()
	{
		$this->load->model('shop/addresses_m');
		$this->load->model('shop/blacklist_m');


		$this->_shipping_address = $this->addresses_m->get( $this->_input_data['shipping_address_id'] );
		$this->_billing_address = $this->addresses_m->get( $this->_input_data['billing_address_id'] );


		$this->_blocked_ips = $this->blacklist_m->select('value')->where('enabled',1)->where('method',1)->get_all();
		$this->_blocked_emails = $this->blacklist_m->select('value')->where('enabled',1)->where('method',2)->get_all();
		$this->_blocked_country = $this->blacklist_m->select('value')->where('enabled',1)->where('method',3)->get_all();

		//var_dump( $this->_blocked_emails );
		//var_dump( $this->_shipping_address );
		//var_dump( $this->_billing_address );
		//var_dump( $this->_input_data );
		//die;



	}

	/**
	 * Expected data
	 *
	 * array
	 *   'user_id' => string '1' - a number but in string format
	 *   'cost_items' => float 5
	 *   'cost_shipping' => float 2 
	 *   'shipping_id' => string '4' this is the id of the shipping methof
	 *   'gateway_method_id' => string '2' gateway method id
	 *   'billing_address_id' => string '1' (length=1)
	 *   'shipping_address_id' => string '1' (length=1)
	 *   'session_id' => string 'nc1n7m5lqd5hkm132f5co9qlu2' 
	 *   'ip_address' => string '127.0.0.1' 
	 */
	private function _check_blacklisting()
	{

		//
		// First check if the ip_address s blosed
		//
		foreach ($this->_blocked_ips as $blacklisted) 
		{
			if($blacklisted->value == $this->_input_data['ip_address'] )
			{
				$this->_blacklisted = TRUE;
				$this->_add_message('TrustScore-IP', 'Users IP address is blocked: ' . $blacklisted->value );
				break;
			}
		}


		foreach ($this->_blocked_emails as $blacklisted) 
		{
			if($blacklisted->value == $this->_shipping_address->email )
			{
				$this->_blacklisted = TRUE;
				$this->_add_message('TrustScore-Email', 'Users Email address is blocked: ' . $blacklisted->value );				
				break;
			}
		}


		foreach ($this->_blocked_emails as $blacklisted) 
		{
			if($blacklisted->value == $this->_billing_address->email )
			{
				$this->_blacklisted = TRUE;
				$this->_add_message('TrustScore-Email', 'Users Email address is blocked: ' . $blacklisted->value );					
				break;
			}
		}
	}





	/**
	 * Check the user data against the black list database
	 * @return [type] [description]
	 */
	private function _compare_addresses()
	{
		$points = 0;

		if($this->_billing_address->country == $this->_shipping_address->country)
		{
			$points++;

			if($this->_billing_address->state == $this->_shipping_address->state)
			{
				$points++;

				if($this->_billing_address->zip == $this->_shipping_address->zip)
				{
					$points++;
				}
			}

		}
		else
		{
			$points--;
		}

		// apply to score
		$this->_score += $points;


		$this->_add_message('TrustScore-AddressComparison', 'Awarded '. $points .' point(s) for address comparison' );
	}



	private function _add_message($key ='TrustScore', $message = '')
	{
		$this->_messages[$key] = $message;
	}




}
// END Cart Class
