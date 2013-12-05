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

/*date('d / M / Y ', $order->order_date)*/
if (!function_exists('nc_format_date')) 
{

	function nc_format_date($date,$in_format='timestamp') 
	{

		$formats = array(0 =>"d-m-Y",1=>"d/m/Y",2=>"m-d-Y",3=>"m/d/Y");
		
		$format = Settings::get('nc_date_format');
		
		if($in_format=='timestamp') return date($formats[$format],$date);

		//if not timestamp then its date time
		$date = new DateTime($date);
		return $date->format($formats[$format]);


	}

}


if (!function_exists('generate_pin')) 
{

	/**
	 * 
	 * @param  [type] $min [description]
	 * @param  [type] $max [description]
	 * @return [type]      [description]
	 */
	function generate_pin() 
	{
       
		//create a PIN - Only needed if user is guest. This helps the user access the guest portal to check status of order
		$pin = md5(  time() . mt_rand(1000000,9999999) );
		$pin = substr($pin ,0,5);

		return $pin;

	}

}

