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


class Widget_Shop_categories extends Widgets 
{

	public $title = array(
		'en' => 'Shop - Categories',
	);
	public $description = array(
		'en' => 'Display a list of categories in your shop',
	);
	public $author = 'Inspired Group';
	public $website = 'http://inspiredgroup.com.au/';
	public $version = '1.0';
	public $fields = array(
		array(
			'field' => 'order',
			'label' => 'Order by',
			'rules' => 'required'
		)
	);

	public function run($options) 
	{
		$this->load->model('shop/categories_m');

		$categories = $this->categories_m->get_all();

		return array(
			'categories' => $categories,
		);
	}



}
