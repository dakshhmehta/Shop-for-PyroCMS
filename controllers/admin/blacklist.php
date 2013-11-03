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
class Blacklist extends Admin_Controller 
{

	protected $section = 'blacklist';

	public function __construct() 
	{
		parent::__construct();

		//check if has access
		role_or_die('shop', 'admin_blacklist');


		// Load all the required classes
		$this->load->model('blacklist_m');
		$this->load->library('form_validation');


		Events::trigger('evt_admin_load_assests');

		$this->_validation_rules = $this->blacklist_m->_validation_rules;


	}

	/**
	 * List all items
	 */
	public function index() 
	{

		// Build the view with shop/views/admin/clearances.php
		$data->blacklist = $this->blacklist_m->order_by('method','DESC')->order_by('enabled','DESC')->get_all();

		$this->template
				->title($this->module_details['name'])
				->build('admin/blacklist/list', $data);
	}




	/**
	 * Create a new Brand
	 */
	public function create() 
	{
	
		// Check for post data
		$this->form_validation->set_rules($this->_validation_rules);
		
		
		// if postback-validate
		if ($this->form_validation->run()) 
		{
			$input = $this->input->post();
			$this->blacklist_m->create($input);
			$this->session->set_flashdata('success', lang('success'));
			redirect('admin/shop/blacklist');
			
		} 
		else 
		{
			foreach ($this->_validation_rules as $key => $value) 
			{
				$data->{$value['field']} = '';
			}
		}

		$data->method_select = $this->blacklist_m->build_dropdown();

		// Build page
		$this->template
			->title($this->module_details['name'])	
			->append_metadata($this->load->view('fragments/wysiwyg', $data, TRUE))
			->build('admin/blacklist/form', $data);
	}

	/**
	 *	We need to alter edit to stop allow changing product.
	 *	Product and category can not change
	 */
	public function edit($id) 
	{

		// Get row
		$row = $this->blacklist_m->get($id);
		


		// Check if exist
		if (!$row) 
		{
			$this->session->set_flashdata('error', lang('product_not_found'));
			redirect('admin/shop/blacklist');
		}
		

		$data = (object) $row;
		$this->form_validation->set_rules($this->_validation_rules);

		// if postback-validate
		if ($this->form_validation->run()) 
		{
			$input = $this->input->post();
			$this->blacklist_m->edit($id,$input);
			$this->session->set_flashdata('success', lang('success'));
			redirect('admin/shop/blacklist');
		} 

		$data->method_select = $this->blacklist_m->build_dropdown($data->method);


		// Build page
		$this->template
			->title($this->module_details['name'])
			->append_js('module::admin/admin.js')
			->append_metadata($this->load->view('fragments/wysiwyg', $data, TRUE))
			->build('admin/blacklist/form', $data);
	}

	/**
	 * Simple delete, will need to work on validation and return messages
	 * @param unknown_type $id
	 */
	public function delete($id = null) 
	{
		$this->blacklist_m->delete($id);
		redirect('admin/shop/blacklist');
	}


	public function block_ip()
	{

		$status = 'fail to block IP address';

		if($this->input->post('ip'))
		{

			$ip = $this->input->post('ip');
			$input=array();


			$input = array(
				'name' => 'Blocked IP-'.$ip,
				'method' => 1,
				'value' =>  $ip,
				'enabled' => 1,
			);		

			$this->blacklist_m->create($input);

			$status = 'Successfully blocked';
		}

		echo $status;
		die;
	}
	

}