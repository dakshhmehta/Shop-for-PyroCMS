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
class Brands_m extends MY_Model 
{

    public $_table = 'shop_brands';
	
	
	public function __construct() 
	{
		parent::__construct();
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

		$input['id'] = $this->insert($to_insert);


		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		
		$this->db->trans_commit();
		return $input['id'];

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


	// make sure the slug is valid
	public function _check_slug($slug) 
	{
		$slug = strtolower($slug);
		$slug = preg_replace('/\s+/', '-', $slug);
		return $slug;
	}


	/**
	 * This could be useful if using ajax calls to update a single property.
	 * Will definiantly be needed with the API calls.
	 * 
	 * @param [id|slug|image_id] 	$field    
	 * @param [Mixed] 				$value    [Mixed]
	 * @param [INT] 				$brand_id [INT]
	 */
	public function set_field($field, $value, $brand_id ) 
	{

		$update_record = array(
				$field => $value,
		);
	
		return $this->update($brand_id, $update_record);
	}
	

	/**
	 * build_dropdown(INT)
	 * 
	 * @param INT $current_id (Optional) The selected brand to display as a default in the list
	 * @return HTMLString	The string that represents the Select dropdown object of brands.
	 * @access public
	 *
	 */
	public function build_dropdown($current_id = 0) 
	{
		// Prepare
		$items = array();
		$items['0']  = 'None';

		// Get brands	
		$brands = $this->db->order_by('name')->select('id, name')->get($this->_table)->result();			

		// Built list
		foreach ($brands as $item)
			$items[$item->id] = $item->name;
		
		// Create the drop down
        $drop = form_dropdown('brand_id', $items, $current_id );

        // Return it
        return $drop;		
	}


}