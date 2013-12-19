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
class FlatratePerOrder_ShippingMethod {

	public $name = 'Flat Rate Per Order'; 
	public $desc = 'Flat Rate Per Order';
	public $author = 'inspiredgroup.com.au';
	public $website = 'http://inspiredgroup.com.au';
	public $version = '1.0';
	public $image = '';

	public $fields = array(
		array(
			'field' => 'options[amount]',
			'label' => 'Shipping Charge Per Order',
			'rules' => 'trim|max_length[5]|is_numeric|required'
		),
	);
	
	
	public function __construct() {		}

	public function form($options) { return $options; }

	public function run($options)  { return $options; }

	public function calc($options, $items, $from_address = array(), $to_address = array() )
	{
		
		$cost = 0;

		$shippable_item_count = 0; //if no shiipable items - return free shpping
		
		foreach ($items as $package)
		{	

			$shippable_item_count++;
		}			


		$this->trim_shipping($cost, $options, $shippable_item_count);


		return $cost;

	}
	




	/**
	 * Trims shipping cost - only call after your shipping calcs
	 * 
	 * @param  [type] $cost [description]
	 * @return [type]       [description]
	 */
	private function trim_shipping(&$cost, $options, $items_count=0)
	{

		if($items_count == 0)
		{
			$cost = 0;
		}
		else
		{

			$cost = floatval($options['amount']);

		}

	}


	
}




