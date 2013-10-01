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
class FreePost_ShippingMethod {

	public $name = 'Free Postage (Free)'; 
	public $title =  'Free Postage (Free)'; 
	public $desc = 'Free Postage for All Items - Please assign all items to a FP package.';
	public $author = 'inspiredgroup.com.au';
	public $website = 'http://inspiredgroup.com.au';
	public $version = '1.0';
	public $image = '';

	public $_shipping = 0;
	public $_handling = 0;
	public $_discount = 0;


	public $fields = array(	);
	
	
	public function __construct() {		}

	
	public function form($options) { return $options; }

	public function run($options)  { return $options; }

	public function calc($options, $parcels, $from_address = array(), $to_address = array() )
	{
		return array($this->id,'FreePost','Free postage special',0,0,0); // == $0 total

	}
	

	
}
