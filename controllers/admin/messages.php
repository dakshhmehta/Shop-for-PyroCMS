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
class Messages extends Admin_Controller 
{

	// Define Section
	protected $section = 'messages';

	
	/**
	 * @constructor
	 */
	public function __construct() 
	{
		parent::__construct();


		//check if has access
		//role_or_die('shop', 'orders');


		// Load all the required classes
		$this->load->model('messages_m');

		//$this->template
		//	->append_js('module::admin/orders.js')
		//	->append_css('module::admin.css')
		//	->append_css('module::admin_orders.css');

	}
	

	/**
	 * Can only view with an order id
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function index($id) 
	{
		
		// Load Message Model
		$this->load->model('messages_m');
	

		// Get All messages from customer
		$data->messages = $this->messages_m->where('order_id', $id)->get_all();
		

	
		// Build Output
		$this->template
					->title($this->module_details['name'])
					->build('admin/orders/order', $data);
	}
	
		


}
