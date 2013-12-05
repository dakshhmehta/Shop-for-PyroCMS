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
class Messages extends Public_Controller 
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
	 * List all messages
	 */
	public function index() 
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
	 * Can only request 1 file at a time.
	 * Future enhancement could allow for a a single ZIP of all files
	 * @param  [type] $id       [description]
	 * @param  [type] $order_id [description]
	 * @param  string $pin      [description]
	 * @return [type]           [description]
	 */
	public function download_file($id, $order_id)
	{
		//pin is only req for guest customers, logged in customers will be valiated against logged in status
		$this->load->helper('download');
		$this->load->model('orders_m');
		$this->load->model('shop_files_m');
		//we must check that both the file and the pin are correct
		
		$order = $this->orders_m->get($order_id);


		if($order->pmt_status == 'paid')
		{

		}
		else
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