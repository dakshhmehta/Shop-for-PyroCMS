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
class Categories extends Public_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		
		// Retrieve some core settings
		//$this->use_css =  Settings::get('nc_css');
		$this->shop_title = Settings::get('ss_name');		//Get the shop name
		$this->shopsubtitle = Settings::get('ss_slogan');		//Get the shop subtitle
		$this->limit = Settings::get('ss_qty_perpage_limit');
		
		
		// Load required classes
		$this->load->model('products_front_m');
		$this->load->model('categories_m');
		
		// Apply default CSS if required
		//if ($this->use_css) _setCSS($this->template);
		
	}

	/**
	 * Display  a list of all categories
	 * 
	 * @param  integer $offset [description]
	 * @return [type]          [description]
	 */
	public function index($offset =0, $limit = 6) 
	{

		$data->categories = $this->categories_m
							->limit($limit)
							->offset($offset)
							->get_all($limit);
				

		$data->pagination = create_pagination('shop', $this->categories_m->count_all(), $limit, 2);

		$data->shop_title = $this->shop_title;
		
		
		$this->template
			->set_breadcrumb($this->shop_title)
			->title($this->module_details['name'])
			->build('common/categories_list', $data);



	
	}
	

   /**
	* List all products by a category
	*
	*
	*/
	public function category( $category = 0, $offset = 0, $limit = 6 ) 
	{
	
		//initialize
		$data = (object) array();

		//id or slug
		$field = ( is_numeric($category) ) ? 'id' : 'slug' ;
		
		// get the category
		$category = $this->pyrocache->model( 'categories_m', 'get_by', array($field , $category) );
	
		//if the category exist
		if($category)
		{

			$uri = 'shop/category/' . $category->slug;

			$filter['category_id'] = $category->id;

			// Count the items
			$total_items = $this->products_front_m->filter_count($filter);

			$data->pagination = create_pagination( $uri, $total_items, $limit, 4);

			//Get the items for the display
			$data->products = $this->products_front_m->filter($filter, $data->pagination['limit'] , $data->pagination['offset']);		


		}
		else
		{
			$data->products = NULL;
			
		}

		
		$this->build_page($data);

	}



	private function build_page($data)
	{

		
		$this->template
			->title($this->module_details['name'].' |' .lang('products'))
			->set_breadcrumb($this->shop_title)
			->build('common/products_list', $data);
	}



}