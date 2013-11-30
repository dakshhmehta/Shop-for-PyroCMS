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
class Products_library 
{




	// Private variables.  Do not change!
	private $CI;
	

	public function __construct($params = array())
	{
	
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();

		log_message('debug', "Products Library Class Initialized");
		
	}

	
	
	/**
	 * Set/clear cover image on product
	 * 
	 * @return [type] [description]
	 */
	public function cover_image() 
	{	

		$this->CI->load->model('products_admin_m');


		$response['status'] = JSONStatus::Error;


		if($this->CI->input->post('id') ) 
		{


			$id = intval( $this->CI->input->post('id'));
			

			$file_id =  $this->CI->input->post('file_id') ;
			

			$resp = site_url().'files/thumb/'.$file_id.'/100/100';


			if ($this->CI->products_admin_m->update_property($id, 'cover_id', $file_id ) ) 
			{	
				$response['status'] = JSONStatus::Success;
				$response['src'] = $resp;
				
				Events::trigger('evt_product_changed', $id);
			} 


		}

		echo json_encode($response);die;

	}




	public function process_for_list(&$products)
	{
		foreach($products as $product)
		{

			$this->process_category($product);

			$this->process_price($product);

			$this->process_inventory($product);

		}
	}



	private function process_category(&$product)
	{

		$this->CI->load->model('shop/categories_m');
		$category = $this->CI->categories_m->get($product->category_id);

		$cat = ($category->parent_id == 0) ? $category->name :  ss_category_name($category->parent_id) . ' &rarr; ' . $category->name;


		if($product->category_id > 0) 
		{

			$product->_category_data = anchor('admin/shop/categories/edit/' . $product->category_id,  $cat , array('class'=>'')); 
		}
		else
		{
			$product->_category_data = 'no category';
		}

	}


	private function process_price(&$product)
	{

		
		$_class = 's_status s_complete'; 
		$_text = nc_format_price($product->price);	


		if($product->pgroup_id > 0)
		{
			//MID pricing
			$_class = 's_status s_processing'; 
			$_text = lang('shop:products:variable_pricing');												
		}


		$product->_price_data = "<span class='".$_class."''>".$_text."</span>";


	}	


	private function process_inventory(&$product)
	{


		if($product->inventory_type == 1)
		{
			$class_name = 's_unlimited';
			$_inv_text = lang('shop:products:unlimited');
		}
		else
		{
			if($product->inventory_on_hand <= $product->inventory_low_qty)
			{
				$class_name = 's_low';
			}
			else
			{
				$class_name = 's_normal';
			}

			$_inv_text =  $product->inventory_on_hand; 
		}

		$product->_inventory_data  ="<div class='s_status $class_name'>$_inv_text</div>";


	}
	
	/**
	 * Function to get products
	 * used by shop front end and widget
	 * $params = array()
	 */
	public function get_products($params = array(), $details = false, $url = "", $row = 10, $page = 1){
		
		$results = Array('total'=> false, 'pagination'=> false, 'data'=> false);
		if(empty($url)){
			$url = site_url('shop/home/%s');
		}
		
		$this->CI->load->library('shop/libpaging');
		$this->CI->load->model('shop/products_front_m');

        // Create pagination links
        $total_rows = $this->CI->products_front_m->count_custom('public', $params);
//        $total_rows = $this->pyrocache->model('products_front_m', 'count_custom', array('public', $params));
        $paging_param = array('page' => $page, 'maxrow' => $total_rows, 'pagerow' => $row, 'wide' => 2, 'url' => $url);
        $pagination = $this->CI->libpaging->_paging($paging_param);

        $results['data'] = $this->CI->products_front_m->get_many_custom('public', $params+array('limit'=>$pagination['limit']));
	//      $results['data'] = $this->pyrocache->model('products_front_m', 'get_many_custom', array('public', $params+array('limit'=>$pagination['limit'])));
	
		if($total_rows > 0){
			foreach($results['data'] as $key => $row){
				$results['data'][$key]->options = $this->CI->products_front_m->get_product_options_info($row->id);
			}
		}
		$results['total'] = $total_rows;
		if($details){
			$results['pagination'] = $pagination;
		}
		return $results;
	}
}
// END Cart Class
