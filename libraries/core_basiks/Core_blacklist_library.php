<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * 
 * CoreBasiks::Blacklist - Admins can blacklist IP/country or email. This No orders can be made by a blacklisted user
 *
 * TODO:Implement a white list to override possible an email or IP address. As if a IP is blacklisted, but we know there is a user
 *  that is allowed to make orders
 *
 * Other classes loaded from here donot need to include Core_library as this file includes it.
 *
 * 
 */
class Core_blacklist_library extends Core_library
{

	// Private variables.  Do not change!
	private $_user_emails = array();
	private $_user_ips = array();
	private $_user_country = array();


	public function __construct($params = array())
	{
	
		parent::__construct();
		log_message('debug', "Class Initialized");
		
	}



	
	public function validate_order($order_data)
	{
		//var_dump($order_data);die;


		// firsat check if using the existing address data
		$this->collect_ip_data($order_data);

		$this->collect_email_data($order_data);

		$this->collect_country_data($order_data);

		return $this->do_validation();

	}




	private function collect_country_data(&$order_data)
	{

	
		if(isset($order_data['country']))
		{
			$country = $order_data['country'];

			if(trim($country) != '')
			{
				$this->_user_country[] = $this->prep_country($country);
			}

		}

		
		if(isset($order_data['shipping_country']))
		{
			$country = $order_data['shipping_country'];

			if(trim($country) != '')
			{
				$this->_user_country[] = $this->prep_country($country);
			}

		}


	}


	private function collect_email_data(&$order_data)
	{


		// Check billing email		
		if(isset($order_data['email']))
		{
			$email = $order_data['email'];

			if(trim($email) != '')
			{
				$this->_user_emails[] = $email;
			}

		}

		if(isset($order_data['shipping_email']))
		{
			$email = $order_data['shipping_email'];

			if(trim($email) != '')
			{
				$this->_user_emails[] = $email;
			}

		}

		//
		// Now collect data if using existing on file data
		//
		//
		//
		$this->load->model('addresses_m');


		//if ok - do nothing else

		// Check billing email		
		if(isset($order_data['existing_address_id']))
		{
			$addr = $this->addresses_m->get($order_data['existing_address_id']);

			if($addr)
			{
				$this->_user_emails[] =$addr->email;
			}

		}

		// Check Shipping email		
		if(isset($order_data['existing_address_shipping_id']))
		{
			$addr = $this->addresses_m->get($order_data['existing_address_shipping_id']);

			if($addr)
			{
				$this->_user_emails[] = $addr->email;
			}
		}

	}

	
	
	private function collect_ip_data(&$order_data)
	{

		$this->_user_ips[] = $order_data['ip_address'];

	}



	private function do_validation()
	{

		$this->load->model('blacklist_m');

		/*
	 		$items[0]  = 'None';
			$items[1]  = 'IP Address';
			$items[2]  = 'Email';
			$items[3]  = 'Country';
		*/

		$blocked_ips = $this->blacklist_m->where('enabled',1)->where('method',1)->get_all();
		$blocked_emails = $this->blacklist_m->where('enabled',1)->where('method',2)->get_all();
		$blocked_country = $this->blacklist_m->where('enabled',1)->where('method',3)->get_all();




		if(!$this->_validate($blocked_emails, $this->_user_emails))
			return FALSE;

		if(!$this->_validate($blocked_ips, $this->_user_ips))
			return FALSE;

		if(!$this->_validate($blocked_country, $this->_user_country))
			return FALSE;

		//
		// Passed the test
		//
		return TRUE;

	}


	private function _validate($data_set, $user_data)
	{

		foreach($data_set as $blocked)
		{

			foreach($user_data as $data)
			{
				if($blocked->value == $data)
				{
					return FALSE;
				}
			}
			
		}

		return TRUE;

	}



	private function prep_country($country)
	{
		return trim(strtolower($country));
	}

}
// END Cart Class
