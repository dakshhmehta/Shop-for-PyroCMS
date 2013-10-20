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
require_once(dirname(__FILE__) . '/' .'shop_model.php');


class Brands_m extends Shop_model 
{


    public $_table = 'shop_brands';
	
	
	public function __construct() 
	{
		parent::__construct();

		$this->_pyrosearch_uri_edit = 'admin/shop/brands/edit/';
		$this->_pyrosearch_uri_delete = 'admin/shop/brands/delete/';
		$this->_pyrosearch_singular = 'brand';
		$this->_pyrosearch_plural = 'brands';

	}


	// Create a new item
	public function create($input) 
	{
		
		$this->db->trans_begin();
		
		$to_insert = array(
			'name' => $input['name'],
			'notes' => strip_tags($input['notes']),
			'image_id' =>  $input['image_id'],
			'slug' => $this->_check_slug($input['slug'])
		);

		$id = $this->insert($to_insert);


		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		
		$this->db->trans_commit();

		if($id)
		{
			$this->add_to_search($id, $input['name'], strip_tags($input['notes'] ) );
		}

		return $id;

	}

	public function edit($id, $input) 
	{
		
		$this->db->trans_start();
		
		$update_array = array(
				'name' => $input['name'],
				'notes' => strip_tags($input['notes']),
				'image_id' =>  $input['image_id'],
				'slug' => $this->_check_slug($input['slug'])
		);
				
		$result = $this->update($id, $update_array);
		
		if (!$result)
			return FALSE;
	   
		$this->db->trans_complete();

		return ($this->db->trans_status() === FALSE) ? FALSE : $result;
	}




	public function build_dropdown($current_id = 0) 
	{

		$options =array();
		$options['field_property_id'] = 'brand_id';
		$options['current_id'] = $current_id;

		$brands = $this->db->order_by('name')->select('id, name')->get($this->_table)->result();
		return $this->_build_dropdown( $brands , $options );

	}






}