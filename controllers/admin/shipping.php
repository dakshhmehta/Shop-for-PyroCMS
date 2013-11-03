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
class Shipping extends Admin_Controller 
{

	protected $section = 'shipping';

	public function __construct() 
	{
		parent::__construct();

		//check if has access
		role_or_die('shop', 'admin_checkout');		

		$this->load->library('Shipping_library');
		$this->load->library('form_validation');

	}

	/**
	 * List all items
	 */
	public function index() 
	{

		
		$data->installed = $this->shipping_library->get_all();
		$data->uninstalled = $this->shipping_library->get_uninstalled();
		$data->countries = $this->shipping_library->get_countries();

		
		$this->template
				->title($this->module_details['name'])
				->append_css('module::admin.css')
				->build('admin/shipping/items', $data);
				
		
	}

	public function edit($id)
	{

		$data->shipping_method = $this->shipping_library->get($id);

		$data->options = $data->shipping_method->options;
	
	
		//  Load the fields from the Gateway
		$this->form_validation->set_rules($data->shipping_method->fields);
	

		if ($this->form_validation->run()) 
		{
			 
	
			if ($this->shipping_library->edit($this->input->post())) 
			{
				$this->session->set_flashdata('success', lang('success'));
				redirect('admin/shop/shipping/');
			} 
			else 
			{

				//error validating values
				$this->session->set_flashdata('error', lang('error'));
				redirect('admin/shop/shipping/edit/' . $id);

			}
	
	
		}
	
		$this->template
					->title($this->module_details['name'], lang('create'))
					->build('admin/shipping/form', $data);
	}
	
	

	
	public function install($slug) 
	{
	
		if ($this->shipping_library->install($slug))
		{
			$this->session->set_flashdata('success', lang('success'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('error'));
		}
	
		redirect('admin/shop/shipping/');
	}

	
	public function uninstall($id = 0) 
	{
	
		if (is_numeric($id))
		{
			$result = $this->shipping_library->uninstall($id);
	
			if (!$result)
			{
				$this->session->set_flashdata('error', lang('shipping_delete_err'));
			}
		}

		redirect('admin/shop/shipping');
			
	}
	
	
	public function enable($id) 
	{
			 
		$this->shipping_library->enable($id);
   
		redirect('admin/shop/shipping/');
	}
	

	public function disable($id) 
	{
		 
		$this->shipping_library->disable($id);
			 
		redirect('admin/shop/shipping/');
		
	}


	public function country($enable, $id) 
	{

		 if($enable)
		 {
		 	$this->shipping_library->enable_country($id);
		 }
		 else
		 {
		 	$this->shipping_library->disable_country($id);
		 }

			 
		redirect('admin/shop/shipping/');
		
	}	
		
}
