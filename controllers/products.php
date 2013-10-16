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
class Products extends Public_Controller 
{

	/**
	 * 
	 * @constructor
	 */
	public function __construct() 
	{
		parent::__construct();
		

		// Retrieve some core settings
		//$this->use_css =  Settings::get('nc_css');
		$this->shop_title = Settings::get('ss_name');		//Get the shop name
		$this->shop_subtitle = Settings::get('ss_slogan');		//Get the shop subtitle
		
		// Load required classes
		$this->load->model('products_front_m');
		$this->load->model('categories_m');
		$this->load->model('brands_m');		
		
	

		// Apply default CSS if required
		//if ($this->use_css) _setCSS($this->template);

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
	
		$limit = Settings::get('ss_qty_perpage_limit_front');

		// 
		//  Count total items by the given filter
		// 
		$total_items = $this->products_front_m->filter_count($filter);


		// 
		//  Build pagination for these items
		// 
		$data->pagination = create_pagination( 'shop/products' , $total_items, $limit, 3);



		// 
		//  Filter and select only a subset of the items based on input data
		// 
		$data->products =  $this->products_front_m->filter($filter , $data->pagination['limit'] , $data->pagination['offset']);
		

		//
		// finally
		//
		$this->template
			->title($this->module_details['name'].' |' .lang('products'))
			->set_breadcrumb($this->shop_title)
			->build('common/products_list', $data);
			
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
			
			if( ($item->date_archived != NULL)||($item->public == 0) )
			{
				//unset from bad search
				unset($search_results[$key]);
			}
		}

		// Pass the items into the right page variable
		$data->items = $search_results;
				
		// Clear limit
		$limit = NULL;
		
		
		// set the layout to FALSE and load the view
		$this->template
			->title($this->module_details['name'].' | '.lang('search')) 
			->set_breadcrumb('Search')
			->set('user_display_qty_filter',$limit)
			->build('products/products', $data);		

	}

}