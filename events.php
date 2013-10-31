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
class Events_Shop 
{

	protected $ci;
	
	
	// Put code here for everywhere
	public function __construct() 
	{
		// Get CI
		$this->ci =& get_instance();

	
		

		
		$this->ci->load->library('shop/enums');

		//trigger the global event - before all other events
		$this->evt_global();		


		// Register the events
		Events::register('evt_audit', array($this, 'evt_audit')); /*debuging event */
		Events::register('evt_clear_cache', array($this, 'evt_clear_cache'));
		Events::register('evt_order_lodged', array($this, 'evt_order_lodged')); 


		Events::register('evt_admin_load_assests', array($this, 'evt_admin_load_assests'));	
		Events::register('admin_controller', array($this, 'evt_admin_controller'));		
		Events::register('public_controller', array($this, 'evt_public_controller'));
		Events::register('evt_cart_item_added', array($this, 'evt_cart_item_added'));
		Events::register('evt_product_created', array($this, 'evt_product_created'));		
		Events::register('evt_product_deleted', array($this, 'evt_product_deleted'));	
		Events::register('evt_product_changed', array($this, 'evt_product_changed'));
		Events::register('evt_inventory_updated', array($this, 'evt_inventory_updated'));
		Events::register('evt_category_created', array($this, 'evt_category_created')); 
		Events::register('evt_category_changed', array($this, 'evt_category_changed')); 
		Events::register('evt_category_deleted', array($this, 'evt_category_deleted')); 	
		Events::register('evt_options_changed', array($this, 'evt_options_changed')); 		
		Events::register('evt_gateway_callback', array($this, 'evt_payment_callback'));
		Events::register('evt_blacklist_attempt', array($this, 'evt_blacklist_attempt'));
		Events::register('evt_product_stock_low', array($this, 'evt_product_stock_low')); 
		Events::register('post_user_register', array($this, 'resume_checkout'));
		Events::register('evt_send_admin_email', array($this, 'evt_send_admin_email')); 	



		Events::register('post_user_login', array($this, 'evt_user_login'));
		Events::register('post_admin_login', array($this, 'evt_admin_login')); 	



		
	}
	public function evt_user_login($data=NULL)
	{
		//echo "user";

	}

	/**
	 * Login strait to shop dashboard
	 * 
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function evt_admin_login($data=NULL)
	{

		$redir = Settings::get('shop_admin_login_location');

		switch ($redir) 
		{
			case '0':
				$redir = 'admin';
				break;
			case '1':
				$redir = 'admin/shop';
				break;	
			case '2':
				$redir = 'admin/shop/products';
				break;	
			case '3':
				$redir = 'admin/shop/orders';
				break;															
			default:
				$redir = 'admin/shop';
				break;
		}

	

		redirect($redir);

	}


	public function evt_global()
	{
		
	}
	
	
	/**
	 *
	 * Events::trigger('evt_audit', array('Admin_Products_Controller','assign_image()' , 'image:'.$image  ));
	 */
	public function evt_audit($data = array()) 
	{	
		// Load the Common libraries
		$this->ci->load->model('shop/audit_m');
		
		$this->ci->audit_m->create($data);
		
	}
	
	/**
	 * if redir is set redir to that page, otherwise redirect to checkout
	 * 
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function resume_checkout($id) 
	{
 
		//
		// first decide if it is a standard user or stockist group
		/*
		if(isset($this->ci->post('group_id')))
		{
			$group = $this->ci->post('group_id');

			if($group == 'stockist')
			{

				redirect('shop/checkout');
			}

		}
		*/


		

        $this->ci->session->set_userdata('user_id', $id);
        redirect('shop/checkout');
    	

    }



	// This gets fired upon oading a public controller
	public function evt_public_controller($data = array()) 
	{
			
		// Is the Shop Open ?
		$this->open_shop 	= Settings::get('nc_open_status');  /* shop open closed */
		$this->open_shop OR redirect('shop/special/closed'); /* if not open redirect */
		
		// Load the Common libraries
		$this->ci->load->helper('shop/shop');
		$this->ci->load->helper('shop/shop_public');
		$this->ci->load->helper('shop/shop_debug'); //only for debugging ??

		$this->ci->load->library('shop/SFCart');
		
		//Lang
		$this->ci->lang->load('shop/shop_front');  



	}

	// This gets fired upon oading a public controller
	public function evt_admin_controller($data = array()) 
	{

		$this->ci->load->helper('shop/shop');
		$this->ci->load->helper('shop/shop_admin');
		$this->ci->load->helper('shop/shop_public');
		$this->ci->load->helper('shop/shop_debug'); //only for debugging ??

		// Lang
		$this->ci->lang->load('shop/shop_admin');





	}

	/**
	 * Common assests for application Admin
	 * @return [type] [description]
	 */
	public function evt_admin_load_assests()
	{
		$this->ci->template
					->append_js('module::admin/util.js')
					->append_js('module::admin/admin.js')
					->append_css('module::admin.css');		

		$this->ci->template
					->append_js('module::lib/buttons.js')
					->append_css('module::lib/buttons/buttons.css')
					->append_css('module::lib/buttons/font-awesome.min.css');


	}


	// Array  Structure => $dataarray($id,$data['name'], $success)
	public function evt_cart_item_added($data = array()) 
	{
	
		// If Shop is closed then do not allow to add to cart
        if ( $this->ci->settings->get('nc_open_status') == '0' ) 
        {
            $this->ci->sfcart->destroy();
            $this->ci->session->set_flashdata('error', $this->ci->settings->get('shop_is_disabled'));
            redirect($this->ci->input->server('HTTP_REFERER'));
        }
			
		if (($data['success'])  )
		{
			$this->ci->session->set_flashdata('success', lang('success'). ': '. $data['name']);
		} 
		else 
		{
			$this->ci->session->set_flashdata('error', lang('error').': '. $data['name']);
		}

	}
	

	
	public function evt_blacklist_attempt($array) 
	{
		
		// prep the email
		$email_variables['slug'] = 'sf_admin_blacklist';
		$email_variables['date'] = date('d-M-Y');
		$email_variables['email'] = $array['email'];
		$email_variables['phone'] = $array['phone'];
		$email_variables['ip_address'] = $this->ci->input->ip_address();
		$email_variables['cost_total'] =  $array['cost_total'];
		$email_variables['shipping_address'] = $array['shipping_address'];
		$email_variables['billing_address'] =  $array['billing_address'];
		

		// Send Admin Email Now
		Events::trigger('email', $email_variables, 'array');
		

	}
	

	// Send Admin and User Email notification that order has been placed
	public function evt_send_admin_email($input = array()) 
	{
	

 
		
		
	}


	// Send Admin and User Email notification that order has been placed
	public function evt_order_lodged($id) 
	{
	
		// Load Libraries
		$this->ci->load->model('shop/orders_m');
		$this->ci->load->model('shop/addresses_m');
		$this->ci->load->library('shop/gateway_library');
		$this->ci->load->library('shop/shipping_library');
		
		// Collect the data
		$order = $this->ci->orders_m->get($id);
		$shipping_details = $this->ci->addresses_m->get($order->shipping_address_id);
		$billing_details = $this->ci->addresses_m->get($order->billing_address_id);
		$customer = $this->ci->db->select('email, username')->from('users')->where('id', $order->user_id)->get()->row();
		$contents = $this->ci->db->where('order_id', $id)->get('shop_order_items')->result();

		// prep the email
		$email_variables['slug'] = 'sf_admin_order_notification';
		$email_variables['order_id'] = $id;
		$email_variables['order_date'] = date('d-M-Y', $order->order_date);
		$email_variables['email'] = $customer->email;
		$email_variables['phone'] = $billing_details->phone;
		$email_variables['sender_ip'] = $this->ci->input->ip_address();
		$email_variables['customer_ip'] = $this->ci->input->ip_address();
		$email_variables['cost_total'] = $order->cost_total ;
		$email_variables['shipping_address'] = nc_bind_address($shipping_details); 
		$email_variables['billing_address'] =  nc_bind_address($billing_details); 
		
		// Build the content list 
		$order_items = '';
		foreach ($contents as $item) 
		{
			$order_items .= '<li>'.$item->title.'</li>';
		}
		
		$email_variables['order_contents'] = '<ul>'.$order_items.'</ul>';

		// Send Admin Email Now
		Events::trigger('email', $email_variables, 'array');
		
		// Override some values for customer email
		$email_variables['slug'] = 'sf_user_order_notification';
		$email_variables['to'] = $customer->email;

		// Send User Email Now
		Events::trigger('email', $email_variables, 'array');
		
	}

	
	
	// Send User email notification thah payment was received
	public function evt_gateway_callback($transaction) 
	{

		// Build the email here
		if ($transaction['status'] != 'accepted') 
		{
			return;
		}
				
		// Send the emails
		//Events::trigger('email', $email_variables, 'array');

	}

	
	
	// When a new product is created by admin
	public function evt_inventory_updated($id) 
	{
		$this->ci->pyrocache->delete_all('products_m');
		$this->ci->pyrocache->delete_all('products_front_m');
		$this->ci->pyrocache->delete_all('products_admin_m');
	}
	
	
	// When a new product is created by admin
	public function evt_product_created($id) 
	{
		$this->evt_clear_cache();
	}
	
	
	// Notify System about deleted product
	public function evt_product_deleted($id) 
	{
		$this->evt_clear_cache();
	}
	
	

	// Used to signal specials/sales to be updated
	public function evt_product_changed($id) 
	{
		$this->evt_clear_cache();
	}
	
	
	
	// Category Changed
	public function evt_category_changed($id) 
	{
		$this->evt_clear_cache();
	}	
	
	
	
	// Category Changed
	public function evt_category_created($id) 
	{
		$this->evt_clear_cache();
	}	
	
	
	// Category Changed
	public function evt_category_deleted($id) 
	{
		$this->evt_clear_cache();
	}		
	
	
	// Category Changed
	public function evt_options_changed( $data= array() ) 
	{
		$this->evt_clear_cache();
	}	
	
	
	
	// Let admin know in notifications
	public function evt_product_stock_low($id) 
	{
	
	}	


	// install and un-install event handler
	public function evt_maintenance() 
	{
		$this->evt_clear_cache();
	}		
		
	/** Clear all cache for all DB records
	 * 
	 * @access public
	 */
	public function evt_clear_cache() 
	{
	

		$this->ci->pyrocache->delete_all('products_m');
		$this->ci->pyrocache->delete_all('products_admin_m');
		$this->ci->pyrocache->delete_all('products_front_m');
		
		$this->ci->pyrocache->delete_all('categories_m');
		$this->ci->pyrocache->delete_all('brands_m');
		$this->ci->pyrocache->delete_all('options_m');
		
	}
	

		
		

}

/* End of file events.php */