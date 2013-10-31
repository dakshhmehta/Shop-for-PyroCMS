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
class Orders extends Admin_Controller 
{

	// Define Section
	protected $section = 'orders';

	
	/**
	 * @constructor
	 */
	public function __construct() 
	{
		
		parent::__construct();

		//check if has access
		role_or_die('shop', 'orders');

		// Load all the required classes
		$this->load->model('orders_m');

		$this->load->library('orders_library');


		Events::trigger('evt_admin_load_assests');

		$this->template->append_js('module::admin/orders.js');


	}
	
	public function callback($offset = 0) 
	{
		$this->index($offset);
	}
	   
	/**
	 * @description This is the Default list view page of Orders
	 * $index refers to the pagination index, 0 as default is get from first , but we can pass 5 and orders from 5-> will appeaer
	 */
	public function index($offset = 0) 
	{

		$limit = 5;
		//by default all visible
		$filter=array();

		if ($this->input->post('f_order_status')) 
		{
			
			$data->curr_status_filter = $this->input->post('f_order_status');
		
		}
		else
		{
			$data->curr_status_filter = $this->session->userdata('sf_orders_filter_status');
			
			if(!(isset($data->curr_status_filter) ) or ($data->curr_status_filter == NULL)) $data->curr_status_filter = 'all_open';
		}
		

		$filter['order_status'] = $data->curr_status_filter;

	
 


		$this->session->set_userdata('sf_orders_filter_status',  $data->curr_status_filter);	


		//count
		$total_rows = $this->orders_m->admin_filter_count($filter);
		


		$data->pagination = create_pagination('admin/shop/orders/callback', $total_rows, $limit,5);


		$data->items = $this->orders_m->admin_filter($filter,  $data->pagination['limit'] ,$data->pagination['offset']);


		$this->orders_library->process_for_list($data->items);
				


		// set the layout to FALSE and load the view
		$this->template
				->title($this->module_details['name'])
				->build('admin/orders/orders', $data);
	}

	/**
	 * Create a new order (Backend)
	 */
	public function create() 
	{  
		redirect('shop/');   
	}
	

	/**
	 * Admin access to View an order placed by customer
	 * @param unknown_type $id
	 */
	public function order($id) 
	{
		
		// Load Message Model
		$this->load->model('messages_m');
	
		// Get the order
		$data->order = $this->orders_m->get($id);
		
		// Order Contents
		$data->contents = $this->orders_m->get_order_items($data->order->id);		
				
		// Get Shipping Address
		$data->shipping_address = $this->orders_m->get_address($data->order->shipping_address_id);
		
		// Get Billing Address
		$data->invoice = $this->orders_m->get_address($data->order->billing_address_id);
		
		
		// Shipping Method ID
		$data->shipping_method = $this->orders_m->get_shipping($data->order->shipping_id);
				
		
		// Get Payment Name + data (For Payment Type in details tab)
		$data->payments = $this->orders_m->get_payment($data->order->gateway_id); 
		

		// Get All messages from customer
		$data->messages = $this->messages_m->where('order_id', $id)->get_all();
		

		// Get All transaction history
		$data->transactions = $this->db->where('order_id', $id)->order_by('id desc')->get('shop_transactions')->result();
		
		
		$data->notes = $this->orders_m->get_notes_by_order($id);
		
		
		// Get User Details
		$data->customer = $this->orders_m->get_user_data($data->order->user_id);  
		
		
		// Build Output
		$this->template
					->title($this->module_details['name'])
					->set('user', $this->current_user)
					->enable_parser(TRUE)
					->build('admin/orders/order', $data);
	}
	
		
	public function setstatus($id = 0, $status) 
	{

		$this->load->model('transactions_m');

		// get the order
		$order = $this->orders_m->get($id);
		
		$due = array('amount'=>0,'refund'=>0) ;

		$message = strtoupper($status) ;

		$st = 2;
		
		
		if( $status == OrderStatus::ReOpened ) 
		{
			$message = 'RE-OPENED';

			$status = OrderStatus::Pending;
		}
		elseif($status == OrderStatus::Paid ) 
		{
			$this->orders_m->mark_as_paid($id);
		}
		
		$result = $this->orders_m->set_status($id,$status);
		 
		if ($result) 
		{
			$result = $this->transactions_m->log($id, 0, 0 ,'ADMIN ',$message,$st);
		}
	
		redirect('admin/shop/orders/order/'.$id);
	}
	

	/**
	 * 
	 * @param INT $id - This shall be the Shipping address of the order (Not the order ID)
	 */
	public function map($id) 
	{
			
		$address = $this->db->where('id', $id)->get('shop_addresses')->row();
		$clean = $address->address1.' '.$address->address2.' '.$address->city.', '.$address->zip.' '.$address->country;
		
		$this->template
			->set_layout(FALSE)
			->title('Map')
			->set('address',$clean)
			->build('admin/map/map');

	}
	

	/**
	 * Handles the admin pressing send Send message to user about order
	 */
	public function messages() 
	{
	
		$this->load->model('messages_m');
		 
		$order_id = $this->input->post('order_id');
	
		$input = $this->input->post();
	
		 
		if ($order_id && $this->messages_m->send($order_id,$input, FALSE))
		{
			$this->session->set_flashdata('success', lang('success'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('error'));
		}
	
		redirect('admin/shop/orders/order/'.$order_id);
	}
	


	
	public function notes() 
	{
		
		if ($this->input->post('order_id')) 
		{
	
			$order_id = $this->input->post('order_id');
			$user_id = $this->input->post('user_id');
			$message = $this->input->post('message');
			
			if ($order_id && $this->orders_m->create_note($order_id,$user_id,$message))
			{
				$this->session->set_flashdata('success', lang('success'));
			}
			else
			{
				$this->session->set_flashdata('error', lang('error'));
			}
			
		}
	
		redirect('admin/shop/orders/order/'.$order_id);
	}


	
	public function viewtx($txn_id = 0) 
	{
		
		/*if from post*/
		if ($this->input->post()) 
		{
			$input = $this->input->post();
		
			$txn_id = $input['txn_id'];
		}
		
		$arr = array();
		
		// replace this with transaction details
		$tdata = $this->db->where('id',$txn_id)->get('shop_transactions')->row();
		
		if ($tdata) 
		{
			$arr['status'] = 'Retrieved Transaction Details @ ' . date("H:M:s d-M-Y");
			$arr['message'] = '';		
			$arr['user'] = $tdata->user;
			$arr['id'] = $tdata->id;
			$arr['order_id'] = $tdata->order_id;
			$arr['txn_id'] = $tdata->txn_id;
			$arr['txn_status'] = $tdata->status;
			$arr['reason'] = $tdata->reason;
			$arr['amount'] = $tdata->amount;
			$arr['refund'] = $tdata->refund;
			$arr['timestamp'] = $tdata->timestamp;
			
			$arr['data'] = $tdata->data;
		}
		else 
		{
			$arr['status'] = 'error';
			$arr['message'] = 'Cant find TXN details';
			$arr['id'] = $arr['order_id'] = $arr['txn_id'] = $arr['txn_status'] = $arr['reason'] = $arr['amount'] = $arr['data'] = '';			
		}
		echo json_encode($arr);die;

	}

}
