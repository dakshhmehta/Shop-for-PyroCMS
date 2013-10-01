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
 * @author		Salvatore Bordonaro
 * @version		0.90.0.000
 * @website		http://www.inspiredgroup.com.au/
 * @package		API Public Contoller for NITRO-CART
 * @system		PyroCMS 2.1.x
 *
 */
class Api extends Admin_Controller 
{

	protected $section = 'api';

	public function __construct() 
	{
		parent::__construct();
	}
	
	/**
	 * 
	 * @param String $key
	 * @return AjaxResponse Javascript Object Array of all the active catgeories in system
	 */
	public function Get_All_Getegories($key) 
	{
	
		if (!$this->_validate_key($key))
			return FALSE;
	
	
		$this->load->model('categories_m');
	
		$value = $this->categories_m->get_all();
		 
		//Set default
		$response['status'] = JSONStatus::Error;
		$response['value'] = '';
		 
		if ($value) 
		{
			$response['status'] = JSONStatus::Success;
			$response['value'] = $value;
		}
	
		echo json_encode($response);die;
	
	}
	
	/**
	 *
	 * @param String $key
	 * @return AjaxResponse Javascript Object representing the category details
	 */
	public function Get_Getegory($key,$id) 
	{
		 
		if (!$this->_validate_key($key))
			return FALSE;
	
		 
		$this->load->model('categories_m');
		 
		$value = $this->categories_m->get($id);
		
		//Set default
		$response['status'] = JSONStatus::Error;
		$response['value'] = '';
		
		if ($value) {
			$response['status'] = JSONStatus::Success;
			$response['value'] = $value;
		}

		echo json_encode($response);die;
			
	}

	
	/**
	 *
	 * @param String $key The API Key
	 * @return AjaxResponse Javascript Object returning all active products in system
	 */
	public function Get_Total_Products($key) 
	{
		
		if (!$this->_validate_key($key))
			return FALSE;
	
		
		$this->load->model('products_front_m');
		
		$total_rows = $this->products_front_m->count_all();

		$response['status'] = JSONStatus::Success;
		$response['value'] = $total_rows;	
		
		echo json_encode($response);die;

	}
	

	/**
	 * Make sure we only allow POST not GET via url
	 * @param unknown_type $api_key
	 */
	public function Get_Product($id, $key) 
	{

		if (!$this->_validate_key($key))
			return FALSE;

		$this->load->model('products_front_m');
		 
		$value = $this->products_fron_m->get($id);
	
		$response['status'] = JSONStatus::Success;
		$response['value'] = $value;
	
	
		echo json_encode($response);die;
			
	}
	
	
	public function Get_All_Products($key,$stock_status="in_stock") 
	{
		
		//by default only products that are in stock
			
		if (!$this->_validate_key($key))
			return FALSE;
	

		$this->load->model('products_front_m');
			
		$value = $this->products_front_m->where('status',$stock_status)->get_all();
	
		$response['status'] = JSONStatus::Success;
		$response['value'] = $value;

		echo json_encode($response);die;
			
	}
	
	
	public function Get_Image($key,$id) 
	{
		return "";
	}
	
	

	
	private function _validate_key($key) 
	{
		//need to code the database of user keys in
		return ($key == "21e6a55f568f579b8705114d0f32b6ae") ? TRUE : FALSE;
	
	}

}
