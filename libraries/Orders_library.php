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
class Orders_library 
{




	// Private variables.  Do not change!
	private $CI;
	

	public function __construct($params = array())
	{
	
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();

		log_message('debug', "Orders Library Class Initialized");
		
	}





	public function process_for_list(&$orders)
	{
		foreach($orders as $order)
		{

			$this->process_trust_score($order);

				
		}
	}



	private function process_trust_score(&$order)
	{

		$_title = "";
		$_text = "";
		$class_name = '';
		$order->_trust_data = "";


		switch($order->trust_score)
		{
			case 5: break;
			case 4: break;
			case 3: break;
			case 2: break;
			case 1: 
				$class_name = 's_closed';
				$_title = "Your trust score for this order is low, see transactions for more info";
				$_text = "!";			
			break;
				$class_name = 's_closed';
				$_title = "Your trust score for this order is EXTREMELY low, see transactions for more info";
				$_text = "!";			
			default:	//and anything lower		

		} 
	

		
		$order->_trust_data = "<div title='".$_title."' class='tooltip-s s_status ".$class_name."'>".$_text."</div>";


	}


}
// END Cart Class
