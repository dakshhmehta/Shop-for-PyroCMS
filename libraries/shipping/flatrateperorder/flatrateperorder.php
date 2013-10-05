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
	public $title = 'Flat Rate Per Order'; 
	public $desc = 'Flat Rate Per Order';
	public $author = 'inspiredgroup.com.au';
	public $website = 'http://inspiredgroup.com.au';
	public $version = '1.0';
	public $image = '';

	public $_shipping = 0;
	public $_handling = 0;
	public $_discount = 0;


	public $fields = array(
		array(
			'field' => 'options[amount]',
			'label' => 'Shipping Charge Per Order',
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
		
		$handling = floatval($options['handling']);
		$cost = floatval($options['amount']);
		
		//
		// This is the simplest, just return the amount set by the admin
		//
		return array($this->id,'Flat Rate Shipping','',$cost ,$handling,0); // == $0 total

	}
	

	
}
