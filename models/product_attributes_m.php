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
	 */
	public function get_by_product($id) 
	{

		return $this->where('prod_id',$id)->get_all(); 
		
	}
	
	
	
}