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
 * @package		Products Model Contoller for NITRO-CART
 * @system		PyroCMS 2.1.x
 *
 */
class Product_attributes_m extends MY_Model
{


	public $_table = 'shop_attributes';
	
	//
	// All tags that are ok for description fields
	//
	private $_description_tags = '<b><div><strong><em><i><u><ul><ol><li><p><span><a><br><br />';

	

	
	public function __construct() 
	{
		parent::__construct();
		
	}




	public function create( $input )
	{

		$to_insert = array(
			'name' => $input['name'],
			'prod_id' => $input['id'],
			'type' => '',
			'value' => $input['value'],
		);
	
		$id =  $this->insert($to_insert); 

		return $id;
	}



	/**
	 *
	 * @param INT $id of the property record
	 *
	 */
	public function delete($id)
	{

		//check that id is int
		return parent::delete($id);
		
	}



	/**
	 *
	 *
	 * @deprecated
	 * @see get_by_product(id)
	 */
	public function duplicate_attributes($from_prod_id, $to_prod_id) 
	{

		$attributes = $this->db->where('prod_id',$from_prod_id)->get('shop_attributes')->result();


		// No matching records - return default
		if (!$attributes)
			return TRUE;
		
		foreach($attributes as $result)
		{

			$values = array( 'id' => $to_prod_id,  'name' => $result->name ,  'value' => $result->value );

			$this->create($values);

		}


		return TRUE;

	}
	



	/**
	 * This Gets all attributes to the assigned product(id) that is passing in.
	 *
	 *This is replacing get_product_attributes(id)
	 */
	public function get_by_product($id) 
	{

		return $this->where('prod_id',$id)->get_all(); 
		
	}
	

	/**
	 *
	 *
	 * @deprecated
	 * @see get_by_product(id)
	 */
	public function get_product_attributes($id) 
	{

		return $this->db->where('prod_id',$id)->get('shop_attributes')->result(); 
		
	}
	
	
	
}