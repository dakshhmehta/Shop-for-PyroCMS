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
class Product extends Public_Controller 
{

	/**
	 * @constructor
	 */
	public function __construct() 
	{
		parent::__construct();
		
		
		// Retrieve some core settings
		$this->shop_title = Settings::get('ss_name');		//Get the shop name
		$this->shop_subtitle = Settings::get('ss_slogan');		//Get the shop subtitle

		

		// Load required classes
		$this->load->model('products_front_m');
		$this->load->model('options_m');
		$this->load->library('Options_library');
		
		$this->load->model('brands_m');
		$this->load->model('categories_m');
		
		
		$this->load->library(array('keywords/keywords'));
	


		// Setup default crumbs
		$this->template->set_breadcrumb($this->shop_title,'shop');
		$this->template->set_breadcrumb('Categories','shop/categories');
		$this->template->set_breadcrumb('Products', 'shop/products'); 
	}

	
	
	/**
	 * 
	 * @description If the system doesnt find the product it will redirect away
	 * 
	 * OPTION 1 : domain.com/product/slug   	
	 * OPTION 2 : domain.com/product/7  		 
	 */
	public function index($param = '') 
	{
	
	
		//
		// Determine whether to get by id or slug
		//
		$method = (is_numeric($param))  ? 'id' : 'slug' ;

		
		//
		// Get the product and all its goodness
		//
		$data->product = $this->products_front_m->get($param, $method );
		

		//
		// if product does not exist, redirect away
		//
		$data->product OR redirect('404');
		
	

		//
		// Display the product
		//
		$this->template
			->title($this->module_details['name'].' &rarr;'.$data->product->name)		
			->set_breadcrumb($data->product->name) // current crumb
			->set_metadata('description', strip_tags($data->product->meta_desc)) 						
			->build('common/products_single', $data); 

	}	

}