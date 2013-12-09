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
class Orders extends Public_Controller 
{

	public function __construct() 
	{
   	
		parent::__construct();
		
		// If User Not logged in
		if (!$this->current_user) 
		{
			$this->session->set_flashdata('error', lang('shop:messages:my:user_not_authenticated'));
			
			// Send User to login then Redirect back after login
			$this->session->set_userdata('redirect_to', 'shop/my');
			redirect('users/login');
		}
	
		// Define the top level breadcrumb
		$this->template->set_breadcrumb(lang('shop:label:shop'), 'shop');
		
	}
	

	/**
	 *
	 * @url site.com/shop/my/orders
	 *
	 * This will display a list of orders the customer
	 * has placed with the shop.
	 * 
	 */
	public function index() 
	{
		
		// Load Libraies
		$this->load->model('orders_m');

		$data = new stdClass;
		
		$data->items = $this->orders_m->order_by('id','desc')->get_all_by_user($this->current_user->id);


		// Display the page
		$this->template
			->set_breadcrumb(lang('shop:my:my'), 'shop/my')
			->set_breadcrumb(lang('shop:label:orders'))   	
			->title($this->module_details['name'])
			->build('my/orders', $data);
	}


	/**
	 * 
	 * @url site.com/shop/my
	 * 
	 * Show the main dashboard menu and also display some usefull summary information about
	 * their transactions ect.
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
			$this->session->set_flashdata('error', lang('shop:status:error'));
			redirect('shop/my/orders');
		}
	
		// Send Message Mail to admin
		if ($this->input->post('message')) 
		{
			if ($this->messages_m->send($id, $this->input->post('message'))) 
			{
				$this->session->set_flashdata('success', 'Message sent');
				redirect('shop/my/order/' . $id);
			} 
			else
			{
				$this->session->set_flashdata('error', 'Error sending message');
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
				->set_breadcrumb(lang('shop:my:my'), 'shop/my')
				->set_breadcrumb(lang('shop:label:orders'),'shop/my/orders')
				->set_breadcrumb(lang('shop:public:order'))
				->title($this->module_details['name'])
				->build('my/order', $data);
	}


}