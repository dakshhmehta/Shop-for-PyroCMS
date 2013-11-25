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
class Brands extends Admin_Controller 
{

	protected $section = 'brands';
	private $data;

	public function __construct() 
	{
		parent::__construct();

		$this->data = new StdClass();

		// Load all the required classes
		$this->load->model('brands_m');
		$this->load->library('form_validation');


		//check if has access
		role_or_die('shop', 'admin_brands');

		
		$this->template
				->append_css('module::admin.css');

		$this->_validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'lang:brand_name',
				'rules' => 'trim|required|max_length[100]'
			),
			array(
				'field' => 'slug',
				'label' => 'lang:slug',
				'rules' => 'trim|max_length[100]|required'
			),				
			array(
				'field' => 'notes',
				'label' => 'lang:description',
				'rules' => 'trim|xss_clean|prep_for_form'
			),
			array(
				'field' => 'image_id',
				'label' => 'lang:brand_logo',
				'rules' => 'trim'
			),
				
		);
		
	}

	/**
	 * List all items
	 */
	public function index() 
	{

		// Build the view with shop/views/admin/clearances.php
		$this->data->brands = $this->brands_m->get_all();
		$this->template
				->title($this->module_details['name'])
				->build('admin/brands/brands', $this->data);
	}

	
	/**
	 * Create a new Brand
	 */
	public function create() 
	{
	
		// Check for post this->data
		$this->form_validation->set_rules($this->_validation_rules);
		
		
		// if postback-validate
		if ($this->form_validation->run()) 
		{
			$input = $this->input->post();
			$this->brands_m->create($input);
			$this->session->set_flashdata('success', lang('success'));
			redirect('admin/shop/brands');
			
		} else 
		{
			foreach ($this->_validation_rules as $key => $value) 
			{
				$this->data->{$value['field']} = '';
			}
		}

		// prepare dropdown image folders
		$this->data->folders = $this->_prep_folders();

		// Build page
		$this->template
			->title($this->module_details['name'])
			->append_js('module::admin/admin.js')
			->append_js('module::admin/brands.js')			
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->build('admin/brands/edit', $this->data);
	}

	/**
	 *	We need to alter edit to stop allow changing product.
	 *	Product and category can not change
	 */
	public function edit($id) 
	{

		// Get row
		$row = $this->brands_m->get($id);
		
		// prepare dropdown image folders
		$folders = $this->_prep_folders();

		// Check if exist
		if (!$row) 
		{
			$this->session->set_flashdata('error', lang('product_not_found'));
			redirect('admin/shop/brands');
		}
		
		$this->data = (object) $row;
		$this->form_validation->set_rules($this->_validation_rules);

		// if postback-validate
		if ($this->form_validation->run()) 
		{
			$input = $this->input->post();
			$this->brands_m->edit($id,$input);
			$this->session->set_flashdata('success', lang('success'));
			redirect('admin/shop/brands');
		} 

		// Build page
		$this->template
			->title($this->module_details['name'])
			->set('folders',$folders)
			->append_js('module::admin/admin.js')
			->append_js('module::admin/brands.js')
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->build('admin/brands/edit', $this->data);
	}

	/**
	 * Simple delete, will need to work on validation and return messages
	 * @param unknown_type $id
	 */
	public function delete($id = null) 
	{
		$this->brands_m->delete($id);
		redirect('admin/shop/brands');
	}

	/*This is found in a few controllers, we could centarlize the method*/
	private function _prep_folders() 
	{
		 
		// Prep folders for Image selection
		// Load Files Module
		$this->load->library('files/files');
		$this->load->model('files/file_folders_m');
		 
		// Set up the Dropdown Array for edit and create
		$folders = array(0 => lang('global:select-pick'));
		 
		// Get All folders
		$tree = $this->file_folders_m->order_by('parent_id', 'ASC')->order_by('id', 'ASC')->get_all();
		 
		 
		// Build the Folder Tree
		foreach ($tree as $folder) 
		{
			$id = $folder->id;
			if ($folder->parent_id != 0) 
			{
				$folders[$id] = $folders[$folder->parent_id] . ' &raquo; ' . $folder->name;
			} 
			else
			{
				$folders[$id] = $folder->name;
			}
		}
		 
		return $folders;
		 
	}
	
	/**
	 * Handles the Ajax callback to set the Brand Image
	 */
	public function set_cover() 
	{
	
		$success_add = array();
	
		$response['url'] = site_url();
		$response['status'] = 'error';
		$response['html'] = '<img src="">';
	 

		if ($this->input->post() ) 
		{
			$input = $this->input->post();
	
			$image = $input['image_id'];
			$category_id = $input['brand_id'];
			 
			if ($this->brands_m->set_cover($category_id, $image)) 
			{
				$response['status'] = 'success';
				$response['html'] = '<img src="'.site_url().'files/thumb/'.$image.'/100/100">';
			}
		}

		echo json_encode($response);die;

	}   

}