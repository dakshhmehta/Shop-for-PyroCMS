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
class Wishlist extends Public_Controller 
{

	public function __construct() 
	{
   	
		parent::__construct();
		
		// Should we use the default CSS
		$this->use_css =  Settings::get('nc_css');

		// If User Not logged in
		if (!$this->current_user) 
		{
			$this->session->set_flashdata('notice', lang('user_not_auth'));
			
			// Send User to login then Redirect back after login
			$this->session->set_userdata('redirect_to', 'shop/my');
			redirect('users/login');
		}
		

		// Define the top level breadcrumb
		$this->template->set_breadcrumb( lang('shop'), 'shop' );
		
		// Apply default CSS if required
		if ($this->use_css) _setCSS($this->template);

	}
	
	

	/**
	 * The public interface to add,delete and view wishlist items.
	 * 
	 * 
	 * @param String $action = '' del/add/view
	 * @param INT $product_id Product ID
	 * @access public
	 */
	public function index($action = 'view', $product_id = -1) 
	{

		$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'shop/my/wishlist';

		switch($action)
		{

			
			case PostAction::View:
			default:
				$this->view();
				break;

		}
		
	}

	
	/** 
	 * 
	 */
	public function view() 
	{
	
		$this->load->model('wishlist_m');
		
		$data->items = $this->wishlist_m->get_many_by('shop_wishlist.user_id', $this->current_user->id );

		$this->template
			->set_breadcrumb(lang('my'), 'shop/my')
			->set_breadcrumb(lang('wishlist'))
			->title($this->module_details['name'])
			->build('my/wishlist', $data);
	}

	
	
	/**
	 * Adds a product Item to the wishlist
	 * To access this, use the wishlist method : site.com/shop/my/wishlist/add/PROD_ID
	 * 
	 * 
	 */
	public function add($product_id = 0) 
	{

	
		// Load Libraries
		$this->load->model('products_front_m');
		$this->load->model('wishlist_m');

		
		
		// prepare redirect
		$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'shop/my/wishlist';

		
		
		// Get the product ID - First check if posted, if not use the direct product_id passed in
		$product_id = $this->input->post('product_id') ? $this->input->post('product_id') : $product_id;
		
		
		//
		// Validate the Item for the wishlist
		//
		if ($prod = $this->_wishlist_add($product_id) )
		{
			// if all good add it to the db
			$this->wishlist_m->add($this->current_user->id, $prod); // pass the price of product at time of adding (historical data)
			$this->session->set_flashdata('success',  lang('item_added_successfully')  ); 
		}

		
		redirect($redirect);



	}
	
	
	
	
	/**
	 * Adds a product Item to the wishlist
	 * To access this, use the wishlist method : site.com/shop/my/wishlist/add/PROD_ID
	 *
	 * @param $product_id 	The ID of the product that is being requested to add to the wishlist
	 * @access private
	 * @return Mixed (FALSE|Product [Object] )
	 */
	private function _wishlist_add($product_id = 0) 
	{
	
		//
		// Load Libraries
		//
		$this->load->model('products_front_m');
		$this->load->model('wishlist_m');
		


		//
		// Get the product ID - First check if posted, if not use the direct product_id passed in
		//
		$product_id = $this->input->post('product_id') ? $this->input->post('product_id') : $product_id;
		
		
		
		
		//
		// Check validity of product ID
		//
		if ( (is_numeric($product_id)) && ($product_id <= 0) )
		{
			// If not numeric stop and return
			$this->session->set_flashdata('error', lang('wishlist_add_error')); 
			return FALSE;
		}		
		
		
		

		//
		// Check if the item already exist - do this before fetching the Item
		//
		if ($this->wishlist_m->item_exist( $this->current_user->id, $product_id)) 
		{
			$this->session->set_flashdata('notice',  lang('already_in_wishlist') ); 
			return FALSE;
		} 
		
		

		//
		// Get the product from DB
		//
		$product = $this->pyrocache->model('products_front_m', 'get', $product_id);  //$this->products_m->get($product_id);
		

		
		
		//
		// Check if the produyct exist in the DB
		//
		if(!$product)
		{
			$this->session->set_flashdata('notice',  lang('wl:no_product') ); 
			return FALSE;
		}
		
		
		//
		// Check product validady (visible or deleted)
		//
		if ( ($product->deleted) || ($product->public == 0))
		{
			$this->session->set_flashdata('feedback', lang('wishlist_not_avail') );
			return FALSE;
		}
		

		

		// OK to add now if it passes the above test, return the object
		return $product;
		
		
	}
	
	
	
	/**
	 * To access this, use the wishlist method : site.com/shop/my/wishlist/del/PROD_ID
	 *
	 * @param INT $product_id
	 * @access private
	 */
	public function delete($product_id = 0) 
	{
	
		$this->load->model('wishlist_m');

		
		if( $this->_wishlist_delete( $this->current_user->id, $product_id ) )
		{
		
			if( $this->wishlist_m->delete($this->current_user->id, $product_id) ) 
			{
				$this->session->set_flashdata('success', lang('success')); 
			}
			else
			{
				$this->session->set_flashdata('success', lang('error'));
			}
		
		}
		else
		{
			$this->session->set_flashdata('success', lang('error')); 
		}
		
		redirect('shop/my/wishlist');
	}
	
	
	
	
	/**
	 * Provides an ability to pre-check the product that is beeing requested to be removed from the wishlist
	 *
	 * There are not too many checks for delete, at least check the the ID are numeric.
	 * If we need to expand upon the checking, i.e in future we may want to warn the customer on specials of the product then we can put
	 * more checking codition here.
	 */
	private function _wishlist_delete($product_id = 0) 
	{

	
		//
		// Get the product ID - First check if posted, if not use the direct product_id passed in
		//
		$product_id = $this->input->post('product_id') ? $this->input->post('product_id') : $product_id;
		
		
		//
		// Check validity of product ID
		//
		if ( (is_numeric($product_id)) && ($product_id <= 0) )
		{
			// If not numeric stop and return
			$this->session->set_flashdata('error', lang('wishlist_del_error') ); 
			return FALSE;
		}		
		
	
		return TRUE;
		
	}

	
}