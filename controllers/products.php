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
 * @package		Products Public Contoller for NITRO-CART
 * @system		PyroCMS 2.1.x
 *
 */
class Products extends Public_Controller 
{

	/**
	 * 
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
		$this->load->model('categories_m');
		$this->load->model('brands_m');		
		
		
		// NC Markup theme
		$this->nc_page_layout = Settings::get('nc_markup_theme'); /*standard or legacy*/
		$this->nc_page_layout_path = 'products/'.$this->nc_page_layout.'/products';		
		
		// Apply default CSS if required
		if ($this->use_css) _setCSS($this->template);

	}
	

		
	/**
	 * This displays the main list of products.
	 * @description -Products Controller to view all Products
	 * @uri yourdomain.com/shop/products
	 *
	 * @param Int $offset The offset to show items with pagination www.site.com/shop/20
	 */
	public function index( $offset = 0, $limit = 6, $filter = array() ) 
	{
	


		// Count the items
		$total_items = $this->products_front_m->count_by_filter($filter);



		//Get the items for the display
		$data->items = $this->products_front_m->shop_filter($filter, $limit, $offset);		


		$uri = 'shop/products/';

		/*
		 Using CI pagination library until the Pyro one is fixed
		 */

		$data->pagination2 = nc_pagination( base_url() . $uri  , $total_items, $limit);
		//$data->pagination = create_pagination( $uri, $total_items, $limit, 3);
		
	

		//
		// Pass the layout name as views may require it for includes
		//
		$data->nc_layout =  $this->nc_page_layout;
		

		//
		// 
		//
		$this->template
			->title($this->module_details['name'].' |' .lang('products'))
			->set_breadcrumb($this->shop_title)
			->build($this->nc_page_layout_path, $data);
	}
	
	
	/**
	 * The Search handler
	 *
	 * Search is extendable - this will load all the search modules
	 * And allow the different parts of the site to be queried
	 *
	 * @param unknown_type $terms
	 */
	public function search($terms = null )  
	{


		// Prepare Results Array
		$search_results = array();
		
		// Get Search Terms from User
		$search_terms = $this->input->post();
		 
		 // First Check if the correct form was used
		if (isset($search_terms['shop_search_box']))
		{
		
			// Explode search query into an array
			$search_query = explode(' ',$search_terms['shop_search_box']) ;
		
			// Run search for module->pass the query  array
			$s_results = $products_front_m->shop_search_products($search_query);
			


		}

		//remove duplicates
		//http://stackoverflow.com/questions/307674/how-to-remove-duplicate-values-from-a-multi-dimensional-array-in-php
		$search_results = array_map("unserialize", array_unique(array_map("serialize", $search_results)));


		//items dont have category or slug names - just create blank
		foreach ( $search_results as $key=>$item) 
		{
			$item->category_name = '';
			$item->category_slug = '';
			
			if( ($item->deleted == 1)||($item->public == 0) )
			{
				//unset from bad search
				unset($search_results[$key]);
			}
		}

		// Pass the items into the right page variable
		$data->items = $search_results;
				
		// Clear limit
		$limit = null;
		
		
		// set the layout to FALSE and load the view
		$this->template
			->title($this->module_details['name'].' | '.lang('search')) 
			->set_breadcrumb('Search')
			->set('user_display_qty_filter',$limit)
			->build('products/products', $data);		

	}

}