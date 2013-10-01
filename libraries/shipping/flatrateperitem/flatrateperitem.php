<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
/*
 * NITRO-CART Developer Preview
 * 
 *
 *
 * Copyright (c) 2013, Salvatore Bordonaro
 * All rights reserved.
 *
 * Author: Salvatore Bordonaro
 * Version: 0.90.0.000
 *
 * Credits: - Salvatore Bordonaro (DB, Development, JavaScript)
 *
 * 			- Guido Grazioli (DB and Development)
 *
 *          - Alison McDonald (Usability, Language and Testing)
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */
class FlatratePerItem_ShippingMethod {

	public $name = 'Flat Rate Per Item'; 
	public $title = 'Flat Rate Per Item'; 
	public $desc = 'Flat Rate Per Item';
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

	public function calc($options, $parcels, $from_address = array(), $to_address = array() )
	{
		
		$pi  = floatval($options['amount']); //multiplier
		
		$cost = 0;
		$handling =  floatval($options['handling']);
		$discount = 0;
		
		//parcels_array[]
		//0 = package_id,
		//1 = package_count
		//2 = MAX this package can hold
		//3 = Qty of items in this package
		//4 = height
		//5 = width
		//6 = depth
		//7 = weight
		//8 = max_weight_allowed
		//9 = Ignor shipping
		
		//Now lets just loop through the parcels
		foreach ($parcels as $package)
		{
			$cost  += ( $package[3] * $pi ) ;
		}
		
		
		return array($this->id,'Flat Rate Shipping Per Item','', $cost ,$handling,$discount); // == $0 total

	}
	

	
}
