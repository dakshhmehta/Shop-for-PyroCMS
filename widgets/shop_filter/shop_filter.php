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
class Widget_Shop_Filter extends Widgets
{
	public $title		= array(
		'en' => 'Shop - Products Filter',
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