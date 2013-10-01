<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
/*
 * NITRO-CART Developer Preview
 * 
 *
 *
 * Copyright (c) 2013, Salvatore Bordonaro
 * All rights reserved.
 *
 * Author: Salvatore Bordonaro
 * Version: 0.90.0.000
 *
 * Credits: - Salvatore Bordonaro (DB, Development, JavaScript)
 *
 * 			- Guido Grazioli (DB and Development)
 *
 *          - Alison McDonald (Usability, Language and Testing)
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */
 
/**
 * NITRO CART	An explosive e-commerce solution for PyroCMS - ......and 'Open Source'
 *
 * @author		Guido Grazioli
 * @version		0.90.0.000
 * @website		http://www.inspiredgroup.com.au/
 * @package		Brands Admin Contoller for NITRO-CART
 * @system		PyroCMS 2.1.x
 *
 */
class Pgroups extends Admin_Controller 
{

	protected $section = 'pgroups';

	public function __construct() 
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model('pgroups_m');
		$this->load->library('form_validation');
		

		//check if has access
		role_or_die('shop', 'layouts');


		$this->_validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'lang:brand_name',
				'rules' => 'trim|required|max_length[100]'
			),			
			array(
				'field' => 'description',
				'label' => 'lang:description',
				'rules' => 'trim|xss_clean|prep_for_form'
			),
			array(
				'field' => 'base_cost',
				'label' => 'lang:base_cost',
				'rules' => 'trim|numeric'
			),
			
				
		);
		
		$this->template->append_css('module::admin.css');
		$this->template->append_css('module::admin_brands.css');
		$this->template->append_js('module::admin/pgroups.js');

	}

	/**
	 * List all items
	 */
	public function index() 
	{

		// Build the view with shop/views/admin/clearances.php
		$data->productgroups = $this->pgroups_m->get_all();
		$this->template
				->title($this->module_details['name'])
				->build('admin/pgroups/list', $data);
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
			$this->pgroups_m->create($input);
			$this->session->set_flashdata('success', lang('success'));
			redirect('admin/shop/pgroups');
			
		} else 
		{
			foreach ($this->_validation_rules as $key => $value) 
			{
				$data->{$value['field']} = '';
			}
		}

		// Build page
		$this->template
			->title($this->module_details['name'])
			->append_js('module::admin/admin.js')
			->append_js('module::admin/brands.js')			
			->append_metadata($this->load->view('fragments/wysiwyg', $data, TRUE))
			->build('admin/pgroups/edit', $data);
	}

	/**
	 *	We need to alter edit to stop allow changing product.
	 *	Product and category can not change
	 */
	public function edit($id) 
	{

		// Get row
		$row = $this->pgroups_m->get($id);


		
		// Check if exist
		if (!$row) 
		{
			$this->session->set_flashdata('error', 'Unable to find group');
			redirect('admin/shop/pgroups');
		}
		
		$data = (object) $row;
		$this->form_validation->set_rules($this->_validation_rules);

		// if postback-validate
		if ($this->form_validation->run()) 
		{
			$input = $this->input->post();
			$this->pgroups_m->edit($id,$input);
			$this->session->set_flashdata('success', lang('success'));
			redirect('admin/shop/pgroups');
		} 


		// Build page
		$this->template
			->title($this->module_details['name'])
			->append_js('module::admin/admin.js')
			->append_js('module::admin/brands.js')
			->append_metadata($this->load->view('fragments/wysiwyg', $data, TRUE))
			->build('admin/pgroups/edit', $data);
	}

	/**
	 * Simple delete, will need to work on validation and return messages
	 * @param unknown_type $id
	 */
	public function delete($id = null) 
	{
		
		$this->pgroups_m->delete($id);

		redirect('admin/shop/pgroups');
	}


	public function ajax_call() 
	{
		echo json_encode($response);die;
	}   

}
