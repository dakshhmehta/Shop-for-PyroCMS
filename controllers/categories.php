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
		$this->shop_title = Settings::get('ss_name');		//Get the shop name
		$this->limit = Settings::get('ss_qty_perpage_limit_front');
		
		
		// Load required classes
		$this->load->model('products_front_m');
		$this->load->model('categories_m');
				
	}

	/**
	 * Display  a list of all categories
	 * 
	 * @param  integer $offset [description]
	 * @return [type]          [description]
	 */
	public function index($offset =0) 
	{
		

		$data->pagination = create_pagination('shop/categories/', $this->categories_m->count_all(), $this->limit, 3);


		$data->categories = $this->categories_m
							->limit($this->limit,$data->pagination['offset'])
							->get_all();


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
	public function category( $category = 0, $offset = 0) 
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

			$uri = 'shop/categories/category/' . $category->slug;

			$filter['category_id'] = $category->id;

			// Count the items
			$total_items = $this->products_front_m->filter_count($filter);

			$data->pagination = create_pagination( $uri, $total_items, $this->limit, 5);

			//Get the items for the display
			$data->products = $this->products_front_m->filter($filter, $data->pagination['limit'] , $data->pagination['offset']);		


		}
		else
		{
			$data->products = NULL;
			
		}

		
		$this->template
			->title($this->module_details['name'].' |' .lang('shop:label:products'))
			->set_breadcrumb($this->shop_title)
			->set('product_count',$total_items)
			->build('common/products_list', $data);

	}


}