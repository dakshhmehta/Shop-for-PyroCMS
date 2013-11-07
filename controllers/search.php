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
class Search extends Public_Controller 
{

	/**
	 * 
	 * @constructor
	 */
	public function __construct() 
	{
		parent::__construct();
		
		// Retrieve some core settings
		$this->shop_title = Settings::get('ss_name');		//Get the shop name
		//$this->shop_subtitle = Settings::get('ss_slogan');		//Get the shop subtitle
		
		// Load required classes
		$this->load->model('products_front_m');

	}
	

		

	/**
	 * The Search handler
	 *
	 * Search is extendable - this will load all the search modules
	 * And allow the different parts of the site to be queried
	 *
	 * @param unknown_type $terms
	 */
	public function index( $offset = 0 )  
	{
		$limit = Settings::get('ss_qty_perpage_limit_front');

		$search_terms = $this->_pre_search();

		if($search_terms === FALSE)
		{
			//
			// We need a better way of doing this if no search terms are found
			//
			redirect('404');
		}



		// Prepare Results Array
		$search_results = array();
		

		//
		// Get some results
		//
		$data->products = $this->products_front_m->search($search_terms,$offset,$limit);


		//remove duplicates
		//http://stackoverflow.com/questions/307674/how-to-remove-duplicate-values-from-a-multi-dimensional-array-in-php
		//$data->products = array_map("unserialize", array_unique(array_map("serialize", $search_results)));


		
		// set the layout to FALSE and load the view
		$this->template
			->title($this->module_details['name'].' | '.shop_lang('shop:search:search')) 
			->build('common/products_list', $data);		

	}


	/*return Array|FALSE*/
	private function _pre_search()
	{

		if($input = $this->input->post('shop_search_box'))
		{

			return array($input);

			// Explode search query into an array
			return explode(' ',$input['shop_search_box']);
		}


		return FALSE;
	}

}