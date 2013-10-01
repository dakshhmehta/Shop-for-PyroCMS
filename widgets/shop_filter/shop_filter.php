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

/**
 *
 */
class Widget_Shop_Filter extends Widgets
{
	public $title		= array(
		'en' => 'NitroCart - Products Filter',
	);
	public $description	= array(
		'en' => 'Display a Filter to search for products',
	);
	public $author		= 'NitroCart Dev team';
	public $website		= 'http://inspiredgroup.com.au';
	public $version		= '1.2';
	
	public function run($options)
	{

		$this->load->model('categories_m');
		//Get the categories
		$categories = $this->categories_m->build_select_filter();

		//return empty array
		return array('categories' => $categories,'selected_category' => 0);

	}	
}