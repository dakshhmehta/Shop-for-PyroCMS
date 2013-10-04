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
class Tax extends Admin_Controller 
{

	protected $section = 'tax';

	// Common
	public function __construct()
	{
		parent::__construct();

		
		//check if has access
		role_or_die('shop', 'tax');


		$this->load->model('tax_m');
		$this->load->library('form_validation');
		
		// Set the validation rules
		$this->validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'lang:label_name',
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'rate',
				'label' => 'lang:slug',
				'rules' => 'trim|numeric|required'
			),

		);

	}

	// Default page 
	public function index($data="") 
	{
	
		$all = $this->tax_m->get_all();
		
		$this->template
				->title($this->module_details['name'])
				->append_css('module::admin.css')
				->set('taxes',$all)
				->build('admin/tax/tax');
	}

	
	
	public function create($data="")
	{

		//postback
		$this->form_validation->set_rules($this->validation_rules);
		
		if( $this->form_validation->run() ) 
		{
			
			$input = $this->input->post();
		
			$this->tax_m->create($input);

			redirect('admin/shop/tax'); //list all

		}
	
		$data->name = '';
		$data->rate = '';
		$data->id = -1;
		
		$this->template
				->title('Creating a tax')
				->build('admin/tax/form',$data);

	}
	
	public function edit($tax_record)
	{
		
		//postback
		$this->form_validation->set_rules($this->validation_rules);
	
		//save
		if ($this->form_validation->run()) 
		{
			$input = $this->input->post();
			
			$this->tax_m->edit($input['id'], $input);
			
			redirect('admin/shop/tax'); //list all
		}
	
	
		$data = $this->tax_m->get($tax_record);
			
		$this->template
				->title('Edit a tax rate')
				->build('admin/tax/form',$data);
	
	}
	
	
	public function delete($id = 0) 
	{
	
		$this->load->model('products_admin_m');
	
	
		if( is_numeric($id) ) 
		{
			
			//		
			// First, make sure that no products are using the tax rate.
			// If a product is using the tax rate we can not remove it
			//
			// If a product is deleted, thats ok, but if the product is "Invisible" (public ==0) 
			// then we still can not delete as the product intends to use this tax rate
			// at a later stage
			//
			$results = $this->products_admin_m->select('tax_id')->where('tax_id',$id)->get_all();
			
			if ($results) 
			{
				//show message, can not delete for this reason
			} 
			else 
			{
				$this->tax_m->delete($id);
			}
			
		}
	
		//
		// Redirect to list all
		//
		redirect('admin/shop/tax'); 
		
	}

}
