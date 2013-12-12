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
class Addresses extends Public_Controller 
{

	public function __construct() 
	{
   	
		parent::__construct();
		

		// If User Not logged in
		if (!$this->current_user) 
		{
			$this->session->set_flashdata('error', lang('shop:my:user_not_authenticated'));
			
			// Send User to login then Redirect back after login
			$this->session->set_userdata('redirect_to', 'shop/my');
			redirect('users/login');
		}
		
		
		$this->address_validation = array(
				array(
						'field' => 'first_name',
						'label' => lang('shop:address:field:first_name'),
						'rules' => 'required|trim'
				),
				array(
						'field' => 'last_name',
						'label' => lang('shop:address:field:last_name'),
						'rules' => 'required|trim'
				),
				array(
						'field' => 'company',
						'label' => lang('shop:address:field:company'),
						'rules' => 'trim'
				),
				array(
						'field' => 'phone',
						'label' => lang('shop:address:field:phone'),
						'rules' => 'required|trim'
				),
				array(
						'field' => 'email',
						'label' => lang('shop:address:field:email'),
						'rules' => 'required|trim|valid_email'
				),
				array(
						'field' => 'address1',
						'label' => lang('shop:address:field:address1'),
						'rules' => 'required|trim'
				),
				array(
						'field' => 'address2',
						'label' => lang('shop:address:field:address2'),
						'rules' => 'trim'
				),
				array(
						'field' => 'city',
						'label' => lang('shop:address:field:city'),
						'rules' => 'required|trim'
				),
				array(
						'field' => 'state',
						'label' => lang('shop:address:field:state'),
						'rules' => 'trim'
				),
				array(
						'field' => 'country',
						'label' => lang('shop:address:field:country'),
						'rules' => 'trim'
				),
				array(
						'field' => 'zip',
						'label' => lang('shop:address:field:zip'),
						'rules' => 'required|trim'
				),
		);
		
		
		// Define the top level breadcrumb
		$this->template->set_breadcrumb(lang('shop:label:shop'), 'shop');
		

	}
	
		
	/**
	 *
	 * @url site.com/shop/my/address
	 *
	 * This will display a dashboard to the customer
	 * of the options they can do Essentially provide
	 * a list of links so they can modify their data
	 */
	public function index() 
	{
		
		$this->load->model('addresses_m');

		$data->items = $this->addresses_m->get_active_by_user($this->current_user->id); 


		$this->template
			->set_breadcrumb(lang('shop:my:my'), 'shop/my')
			->set_breadcrumb(lang('shop:label:address'))
	  		->title($this->module_details['name'])
			->build('my/addresses', $data);
	}
	
	public function create()
	{

		$this->data = new stdClass();


		$this->load->model('addresses_m');


		$this->data->user_id = $this->current_user->id;


		// Add new address
		if ($input = $this->input->post())
		{

			unset($input['submit']);

			$input['user_id'] = $this->current_user->id;


			$this->form_validation->set_rules($this->address_validation);
			$this->form_validation->set_rules('useragreement', 'User Agreement field', 'required|numeric|trim');


			if ( $this->form_validation->run() )
			{
				$this->session->set_flashdata('success', lang('shop:messages:address:address_created_success'));
				$success = $this->addresses_m->create($input);
				redirect('shop/my/addresses');
			}

			
		}


		$countryList = get_country_from_iso2alpha( '','normal', TRUE );
		$this->data->countries = array(); 	
		foreach($countryList as $code => $name)
		{
			$this->data->countries[] = array('code'=>$code,'name'=>$name);
		}


		foreach ($this->address_validation as $item)
		{
			$this->data->{$item['field']} = '';
		}


		$this->template->set_breadcrumb(lang('shop:my:my'), 'shop/my')
						->set_breadcrumb(lang('shop:label:address'), 'shop/my/addresses')
						->title($this->module_details['name'])
						->build('my/create_address', $this->data);


	}


	public function delete($id) 
	{
		
		$this->load->model('addresses_m');
		
		$result = $this->addresses_m->delete($id , $this->current_user->id);
		
		if ($result) 
		{
			$this->session->set_flashdata('success', lang('shop:messages:address:address_deleted_success'));
		}
		
		redirect('shop/my/addresses');
	}


}