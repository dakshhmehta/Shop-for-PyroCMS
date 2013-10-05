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
	public $version = '1.1';
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
