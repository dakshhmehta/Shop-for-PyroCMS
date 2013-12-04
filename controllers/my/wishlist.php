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
		
		// If User Not logged in
		if (!$this->current_user) 
		{
			$this->session->set_flashdata('notice', lang('shop:my:user_not_authenticated'));
			
			// Send User to login then Redirect back after login
			$this->session->set_userdata('redirect_to', 'shop/my');
			redirect('users/login');
		}

	
		// Define the top level breadcrumb
		$this->template->set_breadcrumb(lang('shop'), 'shop');
		
	}
	
	
	/**
	 * 
	 * @url site.com/shop/my
	 * 
	 * Show the main dashboard menu and also display some usefull summary information about
	 * their transactions ect.
	 */
	public function index()
	{
		$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'shop/my/wishlist';

		$this->load->model('wishlist_m');
		
		$data->items = $this->wishlist_m->get_many_by('shop_wishlist.user_id', $this->current_user->id );

		$this->template
			->set_breadcrumb(lang('my'), 'shop/my')
			->set_breadcrumb(lang('wishlist'))
			->title($this->module_details['name'])
			->build('my/wishlist', $data);

	}



	public function delete($id = 0)
	{
		$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'shop/my/wishlist';


		$this->_wishlist_delete($id);

	}



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
		if($prod = $this->_wishlist_preadd($product_id) )
		{
			// if all good add it to the db
			$this->wishlist_m->add($this->current_user->id, $prod); // pass the price of product at time of adding (historical data)

			$this->session->set_flashdata('success',  lang('shop:wishlist:successfully_added_item_to_wishlist')  ); 
		}
		else
		{
			//flash message from validation
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
	private function _wishlist_preadd($product_id = 0) 
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
		
		
		if( $this->current_user )
		{

		}
		else
		{
			$this->session->set_flashdata('error',  lang('shop:wishlist:you_must_first_login_to_use_this_feature') ); 
			return FALSE;
		}



		//
		// Check if the item already exist - do this before fetching the Item
		//
		if ($this->wishlist_m->item_exist( $this->current_user->id, $product_id)) 
		{
			$this->session->set_flashdata('error',  lang('shop:wishlist:item_already_in_wishlist') ); 
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
			$this->session->set_flashdata('error',  lang('shop:wishlist:product_not_found') ); 
			return FALSE;
		}
		
		
		//
		// Check product validady (visible or deleted)
		//
		if ( is_deleted($product) || ($product->public == 0))
		{
			$this->session->set_flashdata('error',  lang('shop:wishlist:product_unavailable') ); 
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
	private function _wishlist_delete($product_id = 0) 
	{

		$status = JSONStatus::Error;
		$this->load->model('wishlist_m');

		//
		// Get the product ID - First check if posted, if not use the direct product_id passed in
		//
		$product_id = $this->input->post('product_id') ? $this->input->post('product_id') : $product_id;


		if( $this->_wishlist_predelete( $this->current_user->id, $product_id ) )
		{
			if( $this->wishlist_m->delete($this->current_user->id, $product_id) ) 
			{
				$status = JSONStatus::Success;
			}
		}

		$this->session->set_flashdata($status,  lang('shop:wishlist:delete_'.$status)  );  

		redirect('shop/my/wishlist');

	}
	
	
	
	
	/**
	 * Provides an ability to pre-check the product that is beeing requested to be removed from the wishlist
	 *
	 * There are not too many checks for delete, at least check the the ID are numeric.
	 * If we need to expand upon the checking, i.e in future we may want to warn the customer on specials of the product then we can put
	 * more checking codition here.
	 */
	private function _wishlist_predelete($product_id = 0) 
	{

		//
		// Check validity of product ID
		//
		if ( (is_numeric($product_id)) && ($product_id <= 0) )
		{
			return FALSE;
		}		
		
	
		return TRUE;
		
	}
}