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
 * @package		WishList Model Contoller for NITRO-CART
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

	public function get_brand($id) 
	{
		$result = $this->get($id);
		return $result;
	}
	
	
	public function get_brand_id_by_slug($slug) 
	{
		$this->db->select('shop_brands.id');
		$ret = $this->db->where('shop_brands.slug =',trim($slug))->get($this->_table)->result();
		if ($ret) 
		{
			return $ret[0]->id;
		}
		return FALSE;
	}	
	
	
	/**
	 * Set a cover image to the product gallery
	 * @param unknown_type $id
	 * @param unknown_type $cover_id
	 */
	public function set_cover($brand_id, $image_id) 
	{
		$update_record = array(
				'image_id' => $image_id,
		);
	
		return $this->update($brand_id, $update_record); //returns id
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