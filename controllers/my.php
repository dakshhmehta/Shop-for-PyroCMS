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
class My extends Public_Controller 
{

	public function __construct() 
	{
   	
		parent::__construct();
		
		// Should we use the default CSS
		//$this->use_css =  Settings::get('nc_css');

		// If User Not logged in
		if (!$this->current_user) 
		{
			$this->session->set_flashdata('notice', lang('user_not_auth'));
			
			// Send User to login then Redirect back after login
			$this->session->set_userdata('redirect_to', 'shop/my');
			redirect('users/login');
		}

		//$this->template->set_layout('default.html');
		
		
		$this->address_validation = array(
				array(
						'field' => 'first_name',
						'label' => lang('first_name'),
						'rules' => 'required|trim'
				),
				array(
						'field' => 'last_name',
						'label' => lang('last_name'),
						'rules' => 'required|trim'
				),
				array(
						'field' => 'company',
						'label' => lang('company'),
						'rules' => 'trim'
				),
				array(
						'field' => 'phone',
						'label' => lang('phone'),
						'rules' => 'required|trim'
				),
				array(
						'field' => 'email',
						'label' => lang('email'),
						'rules' => 'required|trim|valid_email'
				),
				array(
						'field' => 'address1',
						'label' => lang('address1'),
						'rules' => 'required|trim'
				),
				array(
						'field' => 'address2',
						'label' => lang('address2'),
						'rules' => 'trim'
				),
				array(
						'field' => 'city',
						'label' => lang('city'),
						'rules' => 'required|trim'
				),
				array(
						'field' => 'state',
						'label' => lang('state'),
						'rules' => 'trim'
				),
				array(
						'field' => 'country',
						'label' => lang('country'),
						'rules' => 'trim'
				),
				array(
						'field' => 'zip',
						'label' => lang('zip'),
						'rules' => 'required|trim'
				),
		);
		
		
		// Define the top level breadcrumb
		$this->template->set_breadcrumb(lang('shop'), 'shop');
		
		// Apply default CSS if required
		//if ($this->use_css) _setCSS($this->template);

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
				
		$this->load->model('orders_m');
		$this->load->model('wishlist_m');
		
		$data->recent_orders = $this->orders_m->order_by('id','desc')->get_all_by_user($this->current_user->id);
		$data->total_wish = $this->wishlist_m->where('user_id',$this->current_user->id)->count_all();
			 	
		$this->template
				->set_breadcrumb(lang('my'))
				->title($this->module_details['name'].' | '.lang('dashboard'))
				->build('my/dashboard',$data);
	}

	
	/**
	 *
	 * @url site.com/shop/my/orders
	 *
	 * This will display a list of orders the customer
	 * has placed with the shop.
	 * 
	 */
	public function orders() 
	{
		
		// Load Libraies
		$this->load->model('orders_m');
		
		$data->items = $this->orders_m->order_by('id','desc')->get_all_by_user($this->current_user->id);
	 	
		// Display the page
		$this->template
			->set_breadcrumb(lang('my'), 'shop/my')
			->set_breadcrumb(lang('orders'))   	
			->title($this->module_details['name'])
			->build('my/orders', $data);
	}
	

	/**
	 *
	 * @url site.com/shop/my/orders
	 *
	 * This will display a list of orders the customer
	 * has placed with the shop.
	 *
	 */
	public function messages() 
	{

		// Load Libraies
		$this->load->model('orders_m');
		$this->load->model('messages_m');
   
		$data->messages = $this->messages_m->where('user_id',$this->current_user->id)->order_by('id','desc')->get_all();
	

		// Display the page
		$this->template
			->set_breadcrumb(lang('my'), 'shop/my')
			->set_breadcrumb(lang('messages'))
			->title($this->module_details['name'])
			->build('my/messages', $data);
	}
	
	
	
	
	/**
	 * @url site.com/shop/my/orders/order
	 * TODO:This will need some changing to make it unique
	 * @param unknown_type $id
	 */
	public function order($id) 
	{
		 
		// after viewing the order mark all messages to READ
		$this->load->model('orders_m');
		$this->load->model('messages_m');
	
	
		// Retrieve the order
		$data->order = $this->orders_m->where('user_id', $this->current_user->id)->get($id);
		if (!$data->order ) 
		{
			$this->session->set_flashdata('error', lang('error'));
			redirect('shop/my/orders');
		}
	
		// Send Message Mail to admin
		if ($this->input->post('message')) 
		{
			if ($this->messages_m->send($id, $this->input->post('message'))) 
			{
				$this->session->set_flashdata('success', lang('success'));
				redirect('shop/my/order/' . $id);
			} 
			else
			{
				$this->session->set_flashdata('error', lang('error'));
				redirect('shop/my/order/' . $id);
			}
		}
	
		$data->shipping = $this->orders_m->get_address($data->order->billing_address_id);
		$data->invoice = $this->orders_m->get_address($data->order->shipping_address_id);
		$data->messages = $this->db->where('order_id', $id)->get('shop_order_messages')->result();
		$data->transactions = $this->db->where('order_id', $id)->get('shop_transactions')->result();
		$data->contents = $this->orders_m->get_order_items($data->order->id);
	
		// mark as read
		$this->messages_m->markAsRead($data->order->id);
	
		$this->template
				->set_breadcrumb(lang('my'), 'shop/my')
				->set_breadcrumb(lang('orders'),'shop/my/orders')
				->set_breadcrumb(lang('order'))
				->title($this->module_details['name'])
				->build('my/order', $data);
	}
	 
	

	/**
	 *
	 * @url site.com/shop/my/address
	 *
	 * This will display a dashboard to the customer
	 * of the options they can do Essentially provide
	 * a list of links so they can modify their data
	 */
	public function addresses() 
	{
		
		$this->load->model('addresses_m');

		$data->items = $this->addresses_m->get_active_by_user($this->current_user->id); 



		$this->template
			->set_breadcrumb(lang('my'), 'shop/my')
			->set_breadcrumb(lang('address'))
	  		->title($this->module_details['name'])
			->build('my/addresses', $data);
	}
	
	


	public function address($id = 0)
	{

		$this->load->model('addresses_m');

		$data = $id ? $this->addresses_m->where('user_id', $this->current_user->id)->get($id) : (object) array();

		$data OR redirect('shop/my/addresses');

		$data->user_id = $this->current_user->id;

		// Add new address
		if ($this->input->post())
		{

			$input = $this->input->post();

			unset($input['submit']);

			$this->form_validation->set_rules($this->address_validation);
			$success = FALSE;

			if ( $this->form_validation->run() )
			{
				$success = $this->addresses_m->create($input);
			}

			if ($success)
			{
				$this->session->set_flashdata('success', lang('success'));
				redirect('shop/my/addresses');
			}

		}

		if (!$id)
		{
			foreach ($this->address_validation as $item)
			{
				$data->{$item['field']} = '';
			}
		}

		$data->countryList = get_country_from_iso2alpha( '','normal', TRUE ); 		

		$this->template->set_breadcrumb(lang('my'), 'shop/my')
						->set_breadcrumb(lang('address'), 'shop/my/addresses')
						->title($this->module_details['name'])
						->build('my/address', $data);
	}


	public function delete_address($id) 
	{
		
		$this->load->model('addresses_m');
		
		$result = $this->addresses_m->delete($id , $this->current_user->id);
		
		if ($result) 
		{
			$this->session->set_flashdata('success', lang('success'));
		}
		
		redirect('shop/my/addresses');
	}



	public function wishlist($action = 'view', $id = 0)
	{
		$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'shop/my/wishlist';

		switch($action)
		{
			case PostAction::Add:
				$this->_wishlist_add($id);
				break;
			case PostAction::Delete:
				$this->_wishlist_delete($id);
				break;
			case PostAction::View:
			default:
				$this->_wishlist_view();
				break;

		}
	}


	/** 
	 * 
	 */
	private function _wishlist_view() 
	{
	
		$this->load->model('wishlist_m');
		
		$data->items = $this->wishlist_m->get_many_by('shop_wishlist.user_id', $this->current_user->id );

		$this->template
			->set_breadcrumb(lang('my'), 'shop/my')
			->set_breadcrumb(lang('wishlist'))
			->title($this->module_details['name'])
			->build('my/wishlist', $data);
	}	


	private function _wishlist_add($product_id = 0) 
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

			$this->session->set_flashdata('success',  shop_lang('shop:wishlist:successfully_added_item_to_wishlist')  ); 
		}
		else
		{
			$this->session->set_flashdata('error',  shop_lang('shop:wishlist:failed_to_add_item')  ); 
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
		if ( is_deleted($product) || ($product->public == 0))
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

		$this->session->set_flashdata($status,  shop_lang('shop:wishlist:delete_'.$status)  );  

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