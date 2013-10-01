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
 * NITRO CART	An explosive e-commerce solution for PyroCMS - ......and 'Open Source'
 *
 * @author		Salvatore Bordonaro
 * @version		0.90.0.000
 * @website		http://www.inspiredgroup.com.au/
 * @package		Product Public Contoller for NITRO-CART
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
		

		//$this->output->enable_profiler( Settings::get('sf_profiler') );
		
		// Retrieve some core settings
		$this->use_css =  Settings::get('nc_css');
		$this->shop_title = Settings::get('nc_name');		//Get the shop name
		$this->shopsubtitle = Settings::get('nc_slogan');		//Get the shop subtitle

		

		// Load required classes
		$this->load->model('products_front_m');
		$this->load->model('options_m');
		$this->load->library('Options_library');
		
		$this->load->model('brands_m');
		$this->load->model('categories_m');
		
		
		$this->load->library(array('keywords/keywords'));
		
		// NC Markup theme
		$this->nc_page_layout = Settings::get('nc_markup_theme'); /*standard or legacy*/
		$this->nc_page_layout_path = 'products/'.$this->nc_page_layout.'/single';			

		
		// Apply default CSS if required - 
		if ($this->use_css) _setCSS($this->template,TRUE); 

		// Setup default crumbs
		$this->template->set_breadcrumb($this->shop_title,'shop');
		$this->template->set_breadcrumb('Categories','shop/categories');
		$this->template->set_breadcrumb('Products', 'shop/products'); 
	}

	
	/**
	 * @description If the system doesnt find the product it will redirect away
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
		$data->product = $this->pyrocache->model('products_front_m', 'shop_get', array($param,$method) );
		

		
		//
		// redirect if not found
		//
		if ($data->product === NULL) redirect('shop/special/notfound');
		



		//
		// Display the product
		//
		$this->template
			//->enable_parser(FALSE)
			->title($this->module_details['name'].' &rarr;'.$data->product->name)		
			->set_breadcrumb($data->product->name) // current crumb
			->set_metadata('description', strip_tags($data->product->meta_desc)) 						
			->build($this->nc_page_layout_path, $data); 


			//			->enable_parser(TRUE)
			//->enable_minify(TRUE)
			//->set_layout(FALSE)	
	}	

}