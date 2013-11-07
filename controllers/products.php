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
		$this->shop_title = Settings::get('ss_name');		//Get the shop name
		//$this->shop_subtitle = Settings::get('ss_slogan');		//Get the shop subtitle
		
		// Load required classes
		$this->load->model('products_front_m');
		$this->limit = Settings::get('ss_qty_perpage_limit_front');

		

	}
	


	/**
	 *
	 * This displays the list of ALL products.
	 *
	 * @description -Products Controller to view all Products
	 * @uri yourdomain.com/shop/products
	 *
	 */
	public function index(  $offset = 0) 
	{
	

 		$filter = array();
	

		// 
		//  Count total items by the given filter
		// 
		$total_items = $this->products_front_m->filter_count($filter);


		// 
		//  Build pagination for these items
		// 
		$data->pagination = create_pagination( 'shop/products/' , $total_items, $this->limit, 3);



		// 
		//  Filter and select only a subset of the items based on input data
		// 
		$data->products =  $this->products_front_m->filter($filter , $data->pagination['limit'] , $data->pagination['offset'],true);
		

		//
		// finally
		//
		$this->template
			->title($this->module_details['name'].' |' .lang('products'))
			->set_breadcrumb($this->shop_title)
			->build('common/products_list', $data);
			
	}

	/* redirect */
	public function product($parm)
	{
		redirect('shop/product/'.$parm);
	}


}