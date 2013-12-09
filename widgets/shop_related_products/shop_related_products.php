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
class Widget_Shop_related_products extends Widgets 
{

	public $title = array(
		'en' => 'Shop - Recenly Added',
	);
	public $description = array(
		'en' => 'Display related products',
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
		//$options['identifier'];
		//$options['getby'];

		//$this->load->model('shop/products_front_m');
		

	}

}
