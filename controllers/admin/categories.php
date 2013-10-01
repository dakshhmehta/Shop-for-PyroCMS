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
 * @package		Categories Admin Contoller for NITRO-CART
 * @system		PyroCMS 2.1.x
 *
 */
class Categories extends Admin_Controller 
{

	protected $section = 'categories';

	public function __construct() 
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model('categories_m');
		$this->load->library('form_validation');

		//check if has access
		role_or_die('shop', 'categories');		
		
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
				'field' => 'description',
				'label' => 'lang:description',
				'rules' => 'trim|xss_clean|prep_for_form'
			),
			array(
				'field' => 'image_id',
				'label' => 'lang:brand_logo',
				'rules' => 'trim'
			),
				
		);
		
		$this->template->append_css('module::admin_brands.css');
	}

	/**
	 * List all items
	 */
	public function index() 
	{

		// Build the view with shop/views/admin/clearances.php
		$data->categories = $this->categories_m->get_all_categories(); //get_all();
		//$data->categories = $this->categories_m->get_all(); //get_all();
		$this->template
				->title($this->module_details['name'])
				->build('admin/categories/categories', $data);
	}

	
	/**
	 * Create a new Brand
	 */
	public function create() 
	{
	
		$data = (object) array();
		// Check for post data
		$this->form_validation->set_rules($this->_validation_rules);
		
		
		// if postback-validate
		if ($this->form_validation->run()) 
		{
			$input = $this->input->post();
			$id = $this->categories_m->create($input);
			
			Events::trigger('evt_category_created', $id );
			
			$this->session->set_flashdata('success', lang('success'));
			redirect('admin/shop/categories');
			
		} 
		else 
		{
			foreach ($this->_validation_rules as $key => $value) 
			{
				$data->{$value['field']} = '';
			}
		}

		$data->parent_category_select 	= $this->categories_m->build_parent_dropdown( );  


		// prepare dropdown image folders
		$folders = $this->_prep_folders();


		// Build page
		$this->template
			->title($this->module_details['name'])
			->append_js('module::admin/admin.js')
			->set('folders',$folders)
			->append_js('module::admin/categories.js')			
			->append_metadata($this->load->view('fragments/wysiwyg', $data, TRUE))
			->build('admin/categories/form', $data);
	}



	/** 
     *
	 */
	public function ajax_add_values()
	{
	

		if( $this->input->post('id') )
		{
		
			$input = $this->input->post();
		
			$id = $input['id'];
		
			//basic cleanup from input


			$order = intval($input['start_order_from']);


			//remove these from the input
			unset($input['id']);
			unset($input['save']);
			unset($input['start_order_from']);

			//do not add null empty values
			foreach($input as $data)
			{

				if(trim($data) == "") continue;

				$input_to_add = array();
				$input_to_add['name'] = trim($data);
				$input_to_add['description'] = '';
				$input_to_add['slug'] =  trim($data);
				$input_to_add['image_id'] = 0;
				$input_to_add['parent_id'] = $id;
				$input_to_add['order'] = $order;

				$this->categories_m->create($input_to_add); //create simple just adds name/value not other optins
				$order++;


			}

		
			redirect('admin/shop/categories/edit/'.$id );
		}
		
		redirect('admin/shop/categories/');
			

	}


	/**
	 *	We need to alter edit to stop allow changing product.
	 *	Product and category can not change
	 */
	public function edit($id) 
	{

		// Get row
		$row = $this->categories_m->get($id);
		
		// prepare dropdown image folders
		$folders = $this->_prep_folders();

		// Check if exist
		if (!$row) 
		{
			$this->session->set_flashdata('error', lang('product_not_found'));
			redirect('admin/shop/categories');
		}
		

		$data = (object) $row;
		$this->form_validation->set_rules($this->_validation_rules);

		// if postback-validate
		if ($this->form_validation->run()) 
		{
			$input = $this->input->post();
			$this->categories_m->edit($id,$input);
			
			Events::trigger('evt_category_changed', $id );
			
			$this->session->set_flashdata('success', lang('success'));
			redirect('admin/shop/categories');
		} 



		$data->parent_category_select 	= $this->categories_m->build_parent_dropdown( $data->id, $data->parent_id );

		
		//get children if a parent category
		if($data->parent_id == 0)
		{
			$data->children = $this->categories_m->get_children($data->id);
		}
		

		{
		
			// Build page
			$this->template
				->title($this->module_details['name'])
				->set('folders',$folders)
				->append_js('module::admin/admin.js')
				->append_js('module::admin/categories.js')
				->append_metadata($this->load->view('fragments/wysiwyg', $data, TRUE))
				->build('admin/categories/form', $data);
		}


	}

	/**
	 * Simple delete, will need to work on validation and return messages
	 * @param unknown_type $id
	 */
	public function delete($id = null) 
	{
		
		$this->categories_m->delete($id);
		
		Events::trigger('evt_category_deleted', $id );

		redirect('admin/shop/categories');
	}

	
	public function addoption($id) 
	{

		//
		//we need to bind the new option with the curreent object (id)
		//
		$data->id = $id;
	
		
		//
		// return the view
		//
		return $this->load->view('admin/categories/addmultipleoption',$data); die;
		

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
	

}