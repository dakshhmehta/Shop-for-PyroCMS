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
class Gateways extends Admin_Controller 
{

	protected $section = 'gateways';
	private $data;

	public function __construct() 
	{	
		parent::__construct();

		$this->data = new StdClass();

		//check if has access
		role_or_die('shop', 'admin_checkout');

		$this->load->library('gateway_library');
		$this->load->library('form_validation');		
	}

	/**
	 * List all Installed and Not installed gateways
	 * 
	 * 
	 */
	public function index() 
	{
		$this->data->installed = $this->gateway_library->get_all();
		$this->data->uninstalled = $this->gateway_library->get_uninstalled();

		$this->template
				->title($this->module_details['name'])
				->append_css('module::admin.css')
				->build('admin/gateways/items', $this->data);
	}

	public function edit($id) 
	{
		$this->data->gateway = $this->gateway_library->get($id);
		$this->data->options = $this->data->gateway->options;

		//  Load the fields from the Gateway
		$this->form_validation->set_rules($this->data->gateway->fields);

		if ($this->form_validation->run()) 
		{
			if ($this->gateway_library->edit($this->input->post())) 
			{
				$this->session->set_flashdata('success', lang('success'));
				redirect('admin/shop/gateways/');
			} 
			else
			{
				// error validating values
				$this->session->set_flashdata('error', lang('error'));
				redirect('admin/shop/gateways/edit/' . $id);  
			}	
		}

		$this->template
				->title($this->module_details['name'], lang('create'))
				->build('admin/gateways/form', $this->data);
	}

	public function install($slug)
	{
		if ($this->gateway_library->install($slug))
		{
			$this->session->set_flashdata('success', lang('success'));
		} 
		else 
		{
			$this->session->set_flashdata('error', lang('error'));
		}
		
		redirect('admin/shop/gateways/');
	}
	
	public function uninstall($id = 0) 
	{
		if (is_numeric($id))
		{
			$result = $this->gateway_library->uninstall($id);
			
			if (!$result)  
			{
				$this->session->set_flashdata('error', lang('gateway_delete_err'));
			}
		}
		
		redirect('admin/shop/gateways');
	}

	/**
	 * 
	 * @param unknown_type $id
	 * @param Bool $enable TRUE|FALSE if set to false it will disable the gateway
	 * @todo Make this a Ajax call
	 */
	public function enable($id, $enable=1) 
	{
		
		if ($enable)
			$this->gateway_library->enable($id);
		else
			$this->gateway_library->disable($id);
		
		redirect('admin/shop/gateways/');
	}
}