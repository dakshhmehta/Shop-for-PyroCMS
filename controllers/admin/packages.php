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
class Packages extends Admin_Controller 
{

	protected $section = 'packages';

	public function __construct() 
	{
		
		parent::__construct();


		//check if has access
		role_or_die('shop', 'packages');


		$this->load->library('package_library');
		$this->load->library('form_validation');

	}

	/**
	 * List all items
	 */
	public function index() 
	{

		$data->installed = $this->package_library->get_all_merge();
		$data->uninstalled = $this->package_library->get_uninstalled();

		$this->template
				->title($this->module_details['name'])
				->append_css('module::admin.css')
				->build('admin/packages/items', $data);
	}

	/**
	 * Edit a package with its options
	 * @param unknown_type $id
	 */
	public function edit($id) 
	{
	
		// Get the Package from the system 
		$data->package_type = $this->package_library->get($id);

		//Get any package options
		$data->options = $data->package_type->options;
	

		//  Set Validation Rules Package fields
		$this->form_validation->set_rules($data->package_type->fields);
	
		// If post back lets call validation
		if ($this->form_validation->run()) 
		{
	
			if ($this->package_library->edit($this->input->post())) 
			{
				$this->session->set_flashdata('success', lang('success'));
	
				redirect('admin/shop/packages/');
			} 
			else 
			{
				$this->session->set_flashdata('error', lang('error'));
				redirect('admin/shop/packages/edit/' . $id);
			}
	
	
		}
	
		$this->template
					->title($this->module_details['name'], lang('create'))
					->build('admin/packages/form', $data);
	}
	
	

	/*
	 * Install Package 
	 */
	public function install($slug) 
	{
	
		if ($this->package_library->install($slug)) 
		{
			$this->session->set_flashdata('success', lang('success'));
		}
		else 
		{
			$this->session->set_flashdata('error', lang('error'));
		}
	
		redirect('admin/shop/packages/');
	}
	

	
	/**
	 * Uninstall package
	 * @param unknown_type $id
	 */
	public function uninstall($id = 0) 
	{
			if (is_numeric($id)) 
			{
				$result = $this->package_library->uninstall($id);
		
				if (!$result)
				{
	  
					$this->session->set_flashdata('error', lang('packages_delete_err'));
				}
			}

			redirect('admin/shop/packages');
	}
	
}
