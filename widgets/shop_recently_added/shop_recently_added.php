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


class Widget_Shop_Recently_Added extends Widgets {

	public $title = array(
		'en' => 'Shop - Recenly Added',
	);
	public $description = array(
		'en' => 'Display recently added products to your site',
	);
	public $author = 'Inspired Group Dev Team';
	public $website = 'http://inspiredgroup.com.au/';
	public $version = '1.0';
	public $fields = array(
		array(
			'field' => 'max',
			'label' => 'Max',
			'rules' => 'required'
		)		
	);

	public function run($options) 
	{
		

		$this->load->model('shop/products_front_m');
		
		//Get the last added record from the products table that is active
		$this->products_front_m->where('public', 1)->where('deleted',0)->order_by("id", "desc");
	   
		$max = ($options['max'] > 0) ? $options['max']  : 1 ;

		$this->products_front_m->limit($max);
		
		$new = $this->products_front_m->order_by('date_created', 'desc')->get_all();
		
		return count($new) ? array('items' => $new) : false;
	}

}
