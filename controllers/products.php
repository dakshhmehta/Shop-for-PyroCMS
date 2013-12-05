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
			->title(lang('shop:label:shop').' |' .lang('shop:label:products'))
			->set_breadcrumb($this->shop_title)
			->build('common/products_list', $data);
			
	}


	/**
	 * 
	 * @description If the system doesnt find the product it will redirect away
	 * 
	 * OPTION 1 : domain.com/product/slug   	
	 * OPTION 2 : domain.com/product/7  		 
	 */
	public function product($param = '', $admin_as_customer = FALSE) 
	{
	
		// Load required classes
		$this->load->model('products_front_m');
		$this->load->model('options_m');
		$this->load->library('Options_library');
		
		$this->load->model('brands_m');
		$this->load->model('categories_m');
		
		
		$this->load->library(array('keywords/keywords'));


		//
		// Determine whether to get by id or slug
		//
		$method = (is_numeric($param))  ? 'id' : 'slug' ;

		
		//
		// Increment View count
		//
		$increment = TRUE; 

		//
		// Get the product and all its goodness
		//
		$data->product = $this->products_front_m->get($param, $method, $increment );
		

		//
		// if product does not exist, redirect away
		//
		if( (!$data->product) OR ($admin_as_customer == 'customer' && group_has_role('shop', 'admin_products') ) )
		{
			if (($data->product->date_archived != NULL) || ($data->product->public == ProductVisibility::Invisible ))
			{
				redirect('404');
			}
		}


		//
		// If viewing this as an admin, notify about this product
		//
		$notification_messages[] = array();
		$notification_messages['error'] = array();
		$notification_messages['success'] = array();



		if(group_has_role('shop', 'admin_products') && $admin_as_customer == FALSE)
		{
			$site_url = base_url();
			
			$notification_messages['error'][] = 'You are viewing this product as an Administrator &bull; <a target="_new" href="'.$site_url.'admin/shop/product/edit/'.$param.'">click here to edit this item</a>';

			if($data->product->public == 0)
			{
				$notification_messages['error'][] = lang('shop:messages:product_is_hidden') ;
			}
		}


		$data->notification_messages = $notification_messages;


	
		//
		// We need to get the specific view for this product
		//
		$_view_file = $this->_get_view_file($data->product);

		//$this->template->set_layout('default.html');

		//
		// Display the product
		//
		$this->template
			->title($this->module_details['name'].' &rarr;'.$data->product->name)		
			->set_breadcrumb($data->product->name) // current crumb
			->set_metadata('description', strip_tags($data->product->meta_desc)) 						
			->build($_view_file, $data); 

	}	


	/**
	 * 
	 * 1st will get by the set view in product_databse
	 * 2nd will try to get a thview from the layout by product slug
	 * 3rd will return the default products_single (default) which is always available
	 * 
	 * @param  [type] $product_slug [description]
	 * @return [type]               [description]
	 */
	private function _get_view_file($product)
	{
		$view_name = 'products_single_' . $product->page_design_layout;
		
		$this->load->library('design_library');

		$path = $this->design_library->get_custom_path();
		$path = $path . '/' . $view_name;


		if(file_exists($path. '.php'))
		{
			return 'custom/'.$view_name;
		}
		elseif('products_single' == $product->page_design_layout)
		{
			return 'common/products_single';
		}
		else
		{
			return 'common/products_single';
		}

		/*
		elseif($this->template->layout_exists($product->slug .'.html'))
		{
			$this->template->set_layout($product->slug .'.html');
		}
		*/		

	}


}