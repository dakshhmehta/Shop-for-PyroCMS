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

require_once('Core_library.php');

class Fraud_control extends Core_library
{


	public function __construct($params = array())
	{
	
		parent::__construct();
		log_message('debug', "Class Initialized");
		
	}



	/**
	 *  
	 * @param  [type] $order_data [description]
	 * @return [type]             [description]
	 */
	public function get_trust_score($order_data)
	{
		$lib = $this->loadlib('trust');

		if($order_data['checkout_version'] == '0.1')
		{ 
			return $lib->get_trust_score($order_data);
		}


		//
		// We dont have the tools for this version so
		// we just return 0 - orders can always be placed een with -100, 0 is considers normal
		//
		$ret_object = new stdClass();
		$ret_object['score'] = 0;
		$ret_object['events'] = array(); //empty array

		return $ret_object;
	}




	/**
	 *  
	 * @param  [type] $order_data [description]
	 * @return [type]             [description]
	 */
	public function validate_order($order_data)
	{
		$lib = $this->loadlib('blacklist');
		
		if($order_data['checkout_version'] == '0.1')
		{ 
			return $lib->validate_order($order_data);
		}

		//
		// We dont have the tools for this version
		// so its best we just pass
		//
		return TRUE;
	}





}
// END Cart Class
