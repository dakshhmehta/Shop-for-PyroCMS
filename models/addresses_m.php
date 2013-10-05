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
class Addresses_m extends MY_Model {
	
	
	public $_table = 'shop_addresses';
		
		
	public function __construct() 
	{
	
		parent::__construct();
		
		$this->address_validation = array(
		
			array(
				'field' => 'first_name',
				'label' => lang('first_name'),
				'rules' => 'required|trim'
			),
			array(
				'field' => 'last_name',
				'label' => lang('last_name'),
				'rules' => 'required|trim'
			),
			array(
				'field' => 'company',
				'label' => lang('company'),
				'rules' => 'trim'
			),
			array(
				'field' => 'phone',
				'label' => lang('phone'),
				'rules' => 'required|trim'
			),
			array(
				'field' => 'email',
				'label' => lang('email'),
				'rules' => 'required|trim|valid_email'
			),
			array(
				'field' => 'address1',
				'label' => lang('address1'),
				'rules' => 'required|trim'
			),
			array(
				'field' => 'address2',
				'label' => lang('address2'),
				'rules' => 'trim'
			),
			array(
				'field' => 'city',
				'label' => lang('city'),
				'rules' => 'required|trim'
			),
			array(
				'field' => 'state',
				'label' => lang('state'),
				'rules' => 'required|trim'
			),
			array(
				'field' => 'country',
				'label' => lang('country'),
				'rules' => 'required|trim'
			),
			array(
				'field' => 'zip',
				'label' => lang('zip'),
				'rules' => 'required|trim'
			),

		);
		
		$this->shipping_address_validation = array(
		
			array(
				'field' => 'shipping_first_name',
				'label' => lang('shipping_first_name'),
				'rules' => 'required|trim'
			),
			array(
				'field' => 'shipping_last_name',
				'label' => lang('shipping_last_name'),
				'rules' => 'required|trim'
			),
			array(
				'field' => 'shipping_company',
				'label' => lang('shipping_company'),
				'rules' => 'trim'
			),
			array(
				'field' => 'shipping_phone',
				'label' => lang('shipping_phone'),
				'rules' => 'required|trim'
			),
			array(
				'field' => 'shipping_email',
				'label' => lang('shipping_email'),
				'rules' => 'required|trim|valid_email'
			),
			array(
				'field' => 'shipping_address1',
				'label' => lang('shipping_address1'),
				'rules' => 'required|trim'
			),
			array(
				'field' => 'shipping_address2',
				'label' => lang('shipping_address2'),
				'rules' => 'trim'
			),
			array(
				'field' => 'shipping_city',
				'label' => lang('shipping_city'),
				'rules' => 'required|trim'
			),
			array(
				'field' => 'shipping_state',
				'label' => lang('shipping_state'),
				'rules' => 'required|trim'
			),
			array(
				'field' => 'shipping_country',
				'label' => lang('shipping_country'),
				'rules' => 'required|trim'
			),
			array(
				'field' => 'shipping_zip',
				'label' => lang('shipping_zip'),
				'rules' => 'required|trim'
			),

		);		
	}
	
	// create a new item
	public function create($input) 
	{
	
		$this->db->trans_start();
		
		$to_insert = array(
				'user_id' => $input['user_id'],
				'email' => ($input['email']),
				'first_name' => ($input['first_name']),
				'last_name' => $input['last_name'],
				'company' => ($input['company']),
				'address1' => ($input['address1']),
				'address2' => $input['address2'],
				'state' => ($input['state']),
				'city' => ($input['city']),
				'country' =>($input['country']),
				'zip' => ($input['zip']),
				'phone' => ($input['phone'])
		);
	
		$input['id'] = $this->insert($to_insert);
		
		$this->db->trans_complete();
		
		return ($this->db->trans_status() === FALSE) ? FALSE : $input['id'];
	}	
	
	/**
	 * this is prefered over create when in checkout
	 *
	 */
	public function set_address($input, $type='billing') 
	{
	
		$data = array(
				'user_id' => $input['user_id'],
				'email' => $input['email'],
				'first_name' => $input['first_name'],
				'last_name' => $input['last_name'],
				'company' => $input['company'],
				'address1' => $input['address1'],
				'address2' => $input['address2'],
				'city' => $input['city'],
				'state' => $input['state'],
				'country' => $input['country'],
				'zip' => $input['zip'],
				'phone' => $input['phone'],
		);
		

		return $this->insert($data);
	
	}
		
		
	

	// NEVER DELETE an address
	public function delete($address_id,$user_id) 
	{
	
		$update_record = array(	   
			'deleted' =>  1,
		);
		
		return $this->where('user_id', $user_id)->update($address_id, $update_record); //returns id		

	}
	
	public function get_active_by_user($user_id)
	{
	
	
		return $this->where('deleted',0)->get_many_by('user_id', $user_id);
	
	}
	
	
	

	
	
}





























