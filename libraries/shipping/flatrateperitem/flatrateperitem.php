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
class FlatratePerItem_ShippingMethod {

	public $name = 'Flat Rate Per Item'; 
	public $desc = 'Flat Rate Per Item';
	public $author = 'inspiredgroup.com.au';
	public $website = 'http://inspiredgroup.com.au';
	public $version = '1.0';
	public $image = '';

	public $fields = array(
		array(
			'field' => 'options[amount]',
			'label' => 'Shipping Charge Per Item',
			'rules' => 'trim|max_length[5]|is_numeric|required'
		),
		array(
			'field' => 'options[handling]',
			'label' => 'Handling',
			'rules' => 'trim|max_length[5]|is_numeric|required'
		)		
	);
	
	
	public function __construct() {		}

	public function form($options) { return $options; }

	public function run($options)  { return $options; }

	public function calc($options, $packages, $from_address = array(), $to_address = array() )
	{
		
		/**
		 * In the options we store the multiplier
		 * @var [type]
		 */
		$pi  = floatval($options['amount']); 



		/**
		 * Set the cost to the default handling
		 * @var [type]
		 */
		$cost = floatval($options['handling']);

		
		/**
		 * Each package contains a set of items,
		 * We count the items multiply by the amount per item
		 */
		foreach ($packages as $package)
		{
			$cost += ($package->item_count * $pi);
		}


		/**
		 * Then simply return the total cost
		 */
		return $cost;

	}
	

	
}
