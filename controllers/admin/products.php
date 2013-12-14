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


include_once( dirname(__FILE__) . '/' . 'products_admin_controller.php');

class Products extends Products_admin_Controller 
{

	protected $section = 'products';
	

	public function __construct() 
	{
		parent::__construct();

		$this->load->library('products_library');

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
		$data->f_dynamic_field = $this->_get_filter_setting( 'f_dynamic_field', 'dynamic_field' , 'page_design_layout'); 


		if( ! ($this->input->is_ajax_request() ))
		{
			//since this is a full page built
			$data->price_ranges = array(0 => lang('global:select-all'),1=>lang('range_0_50'), 2=>lang('range_25_75'), 3=>lang('range_100_0') );
			$data->categories = $this->categories_m->build_dropdown( array('current_id' => $data->category, 'field_property_id' => 'f_category') );

			//
			// Load a list of views that can be set in the multi edit area
			//
			$this->load->library('design_library');
			$_path = Settings::get('default_theme');
			$data->design_select 	= $this->design_library->build_list_select( $_path, array('current_id' => 0)  );	
			$data->f_dynamic_field = 'page_design_layout';
			//var_dump($data->design_select);die;
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

		$orderby_data = orderby_helper($data->order_by); 
		$filter['order_by'] = $orderby_data['field'];
		$filter['order_by_order'] = $orderby_data['order'];

		
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


		$this->products_library->process_for_list($data->products);






		// Build the view with shop/views/admin/products.php
		$this->template->title($this->module_details['name'])
				->set('design_select',$data->design_select)
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
		$data->f_dynamic_field = $this->_get_filter_setting( 'f_dynamic_field', 'dynamic_field' , 'page_design_layout',TRUE); 

		

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

		$orderby_data = orderby_helper($data->order_by); 
		$filter['order_by'] = $orderby_data['field'];
		$filter['order_by_order'] = $orderby_data['order'];
		


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


		$this->products_library->process_for_list($data->products);					
	

		// set the layout to FALSE and load the view
		$this->template
				->set_layout(FALSE)
				->set('jsexec', "$('.tooltip-s').tipsy()") //re-init tooltip (tipsy) plugin
				->set('pagination', $data->pagination)
				->build('admin/products/line_item',$data);	

	}
	



	public function action()
	{

		// Check for multi delete
		//
		if(  $this->input->post('btnAction') && $this->input->post('action_to') )
		{ 
			$continue = TRUE;
		}
		else
		{
			//go back
			redirect('admin/shop/products');
		}




		$products = $this->input->post('action_to');



		switch($this->input->post('page_design_layout'))
		{
			case 'nochange':
				break;
			default:
				$this->change_page_design($products,  $this->input->post('page_design_layout') ) ;
				break;
		}


		
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

		foreach($products as $key => $id)
		{

			if( $this->products_admin_m->update_property($id, 'public', $new_value ) )
			{
				Events::trigger('evt_product_changed', $id);
			}
	
		}

	}


	private function change_page_design($products, $value)
	{

		$update_record['page_design_layout'] = $value;

		foreach($products as $key => $id)
		{
			$result =  $this->products_admin_m->update($id, $update_record); 
			if($result)
			{
				Events::trigger('evt_product_changed', $id);	
			}
			
		}
		
	}
}
