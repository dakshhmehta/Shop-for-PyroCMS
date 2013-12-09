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
class FreePost_ShippingMethod {

	public $name =  'Free Postage (Free)'; 
	public $desc = 'Free Postage for All Items';
	public $author = 'inspiredgroup.com.au';
	public $website = 'http://inspiredgroup.com.au';
	public $version = '1.0';
	public $image = '';


	public $fields = array(	
			array(
			'field' => 'title',
			'label' => 'Title',
			'rules' => 'trim|required'
		));
	
	
	public function __construct() {		}

	
	public function form($options) { return $options; }

	public function run($options)  { return $options; }

	public function calc($options, $items, $from_address = array(), $to_address = array() )
	{
		return 0; 		
	}
	

	
}
