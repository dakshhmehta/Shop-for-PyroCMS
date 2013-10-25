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


include_once( dirname(__FILE__) . '/' . 'Products_admin_Controller.php');

class Products extends Products_admin_Controller 
{

	protected $section = 'products';
	

	public function __construct() 
	{
		parent::__construct();

	}

	public function sum()
	{
		$this->load->model('orders_m');
		return $this->orders_m->sum(180);
	}


	public function index($offset = 0) 
	{

		

		$data->quick_search = $this->_get_filter_setting( 'f_keyword_search', 'display_search_filter' , ''); //blank for default
		$data->category = $this->_get_filter_setting( 'f_category', 'display_category_filter' , 0); //0 is ALL
		$data->visibility = $this->_get_filter_setting( 'f_visibility', 'display_visibility_filter', 0); //0 is ALL
		$data->order_by = $this->_get_filter_setting( 'f_order_by', 'display_order_filter' , 0);
		$data->limit = $this->_get_filter_setting( 'f_items_per_page', 'display_qty_filter' , 5);


		if( ! ($this->input->is_ajax_request() ))
		{
			//since this is a full page built
			$data->price_ranges = array(0 => lang('global:select-all'),1=>lang('range_0_50'), 2=>lang('range_25_75'), 3=>lang('range_100_0') );
			$data->categories = $this->categories_m->build_dropdown( array('current_id' => $data->category, 'field_property_id' => 'f_category') );

		}


		//
		// Only add these to the filter when the value is not ZERO 0
		//
		if ($data->visibility != 0) 	
		{
			$filter['visibility'] 	= $data->visibility;
		}


		if ($data->category != 0) 
		{
			$filter['category_id'] = $data->category;
		}

		//
		// Always add these to the filter
		//
		$filter['search'] = trim($data->quick_search);
		$filter['order_by'] = orderby_helper($data->order_by); 
		

		
		// 
		// Get the count of items
		// 
		$total_items = $this->products_admin_m->filter_count($filter);


		//
		// Create Pagination
		//
		$data->pagination = create_pagination('admin/shop/products/callback', $total_items, $data->limit, 5);  



		//
		// Get the results
		//
		$data->products =  $this->products_admin_m->filter($filter , $data->pagination['limit'] , $data->pagination['offset']);




		// Build the view with shop/views/admin/products.php
		$this->template->title($this->module_details['name'])
				->append_js('admin/filter.js')
				->append_js('module::admin/products.js')
				->build('admin/products/products', $data);
	


	}	



	/**
	 * Gets or sets the filter value for products searching/filtering.
	 *
	 * $this->_get_filter_setting( 'f_items_per_page', 'display_qty_filter' , 5) 
	 * 
	 * @param  string  $f_filter_name       [description]
	 * @param  [type]  $filter_session_name [description]
	 * @param  integer $def_val             [description]
	 * @return [type]                       [description]
	 */
	private function _get_filter_setting( $f_filter_name = '', $filter_session_name, $def_val = 0 , $pre_save=FALSE) 
	{

		if($pre_save)
		{

			$filter_value = $this->input->post($f_filter_name);
			$this->session->set_userdata($filter_session_name, $filter_value );
			return $filter_value;

		}


		//
		if( $this->input->post($f_filter_name) )
		{
			$def_val = $this->input->post($f_filter_name);

			if($this->session->userdata($filter_session_name) != $this->input->post($f_filter_name))
			{
				//save for use later
				$this->session->set_userdata($filter_session_name, $def_val );
			}
		}
		else
		{
			$def_val = ($this->session->userdata($filter_session_name))? $this->session->userdata($filter_session_name) : $def_val ;
		}

		return $def_val;
	}



	public function callback($offset = 0) 
	{


		$data->quick_search = $this->_get_filter_setting( 'f_keyword_search', 'display_search_filter' , '',TRUE); //blank for default
		$data->category = $this->_get_filter_setting( 'f_category', 'display_category_filter' , 0,TRUE); //0 is ALL
		$data->visibility = $this->_get_filter_setting( 'f_visibility', 'display_visibility_filter' , 0,TRUE); //0 is ALL
		$data->order_by = $this->_get_filter_setting( 'f_order_by', 'display_order_filter' , 0,TRUE); // 0 is ID
		$data->limit = $this->_get_filter_setting( 'f_items_per_page', 'display_qty_filter' , 5,TRUE);

		

		//
		// Only add these to the filter when the value is not ZERO 0
		//
		if ($data->visibility != 0) 	
		{
			$filter['visibility'] 	= $data->visibility;
		}




		if ($data->category != 0) 
		{
			$filter['category_id'] = $data->category;
		}


		//
		// Always add these to the filter
		//
		$filter['search'] = trim($data->quick_search);
		$filter['order_by'] = orderby_helper($data->order_by); 
		


		// 
		// Get the count of items
		// 
		$total_items = $this->products_admin_m->filter_count($filter);


		//
		// Create Pagination
		//
		$data->pagination = create_pagination('admin/shop/products/callback/', $total_items, $data->limit, 5);  



		//
		// Get the results
		//
		$data->products =  $this->products_admin_m->filter($filter , $data->pagination['limit'] , $data->pagination['offset']);

				
	

		// set the layout to FALSE and load the view
		$this->template
				->set_layout(FALSE)
				->build('admin/products/line_item',$data);	

	}
	



	public function action()
	{

		// Check for multi delete
		//
		if(  $this->input->post('btnAction') && $this->input->post('action_to') && $this->input->post('multi_edit_option') )
		{ 
			$continue = TRUE;
		}
		else
		{
			//go back
			redirect('admin/shop/products');
		}


		$products = $this->input->post('action_to');
		
		switch($this->input->post('multi_edit_option'))
		{

			case PostAction::Delete:
				$this->delete($products);
				break;

			case 'visible':
				$this->change_visibility($products,  1) ;
				break;

			case 'invisible':
				$this->change_visibility($products,  0) ;
				break;	
			default:
				break;				

		}


		// Redirect after done
		redirect('admin/shop/products');		
				
	}


	private function delete($products = array()) 
	{
		
		foreach($products as $key =>$id)
		{

			if( $this->products_admin_m->delete($id) )
			{
				Events::trigger('evt_product_deleted', $id );
			}
			
		}
		
	}


	private function change_visibility($products, $new_value = 0) 
	{

		foreach($products as $key =>$id)
		{

			if( $this->products_admin_m->update_property($id, 'public', $new_value ) )
			{
				//Events::trigger('evt_product_deleted', $id );
			}
	
		}

	}
}
