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
class Guest extends Public_Controller 
{

	public function __construct() 
	{
   	
		parent::__construct();
		
		//
		// This section is only available for users not logged in
		//
		if ($this->current_user) 
		{
			redirect('shop/');
		}


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
		if($this->input->post())
		{
			$input = $this->input->post();
			$this->order($input['guest_order_id'], $input['guest_email']);
		}
		else
		{


			$this->template
					->set_breadcrumb(lang('my'))
					->title($this->module_details['name'].' | '.lang('dashboard'))
					->build('guest/dashboard');
		}
	}



	
	/**
	 * @url site.com/shop/my/orders/order
	 * TODO:This will need some changing to make it unique
	 * @param unknown_type $id
	 */
	public function order($order_id,$email) 
	{
		 
		// after viewing the order mark all messages to READ
		$this->load->model('orders_m');
		$this->load->model('messages_m');
	
	
		$data->order = $this->orders_m->where('user_id', 0)->get($order_id);
		$billing_address = $this->orders_m->get_address($data->order->billing_address_id);



		if($billing_address->email != $email)
		{
			echo 'The data you have entered does not match our records';die;	
		}


		if (!$data->order ) 
		{
			$this->session->set_flashdata('error', 'There are no orders for this Email');
			redirect('shop/guest/orders');
		}
	

		// Send Message Mail to admin
		if ($this->input->post('message')) 
		{
			if ($this->messages_m->send($id, $this->input->post('message'))) 
			{
				$this->session->set_flashdata('success', 'Message sent');
				redirect('shop/guest/order/' . $id);
			} 
			else
			{
				$this->session->set_flashdata('error', 'Error sending message');
				redirect('shop/guest/order/' . $id);
			}
		}
	
		$data->shipping = $this->orders_m->get_address($data->order->billing_address_id);
		$data->invoice = $this->orders_m->get_address($data->order->shipping_address_id);
		$data->messages = $this->db->where('order_id', $order_id)->get('shop_order_messages')->result();
		$data->transactions = $this->db->where('order_id', $order_id)->get('shop_transactions')->result();
		$data->contents = $this->orders_m->get_order_items($data->order->id);



		$data->download_key = md5($billing_address->email);

		

		// mark as read
		$this->messages_m->markAsRead($data->order->id);
	
		$this->template
				->title($this->module_details['name'])
				->build('guest/order', $data);
	}




	public function download_file($id, $order_id, $key)
	{
		//pin is only req for guest customers, logged in customers will be valiated against logged in status
		$this->load->helper('download');
		$this->load->model('orders_m');
		$this->load->model('shop_files_m');
		//we must check that both the file and the pin are correct
		
		$order = $this->orders_m->get($order_id);
		$billing_address = $this->orders_m->get_address($order->billing_address_id);


		if(md5($billing_address->email) != $key)
		{
			echo 'The data you have entered does not match our records';die;	
		}

		if($order->pmt_status != 'paid')
		{
			echo 'Please pay for your order first';die;
		}


		$fileObject = $this->shop_files_m->do_download($id, $order_id);


		if(!$fileObject->pass)
		{
			die(json_encode(
						array(
								'status' => 'error', 
								'message'=>$fileObject->message,
								'dlcount'=>$fileObject->download_count
							)
						)
			);
		}


		force_download($fileObject->file->filename, $fileObject->file->data); 


	}
	 

}