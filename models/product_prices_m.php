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
class Product_prices_m extends MY_Model
{


	public $_table = 'shop_discounts';
	
	//
	// All tags that are ok for description fields
	//
	private $_description_tags = '<b><div><strong><em><i><u><ul><ol><li><p><span><a><br><br />';

	
	
	
	public function __construct() 
	{
		parent::__construct();

		$this->load->model('shop/tax_m');
		$this->load->model('shop/pgroups_m');
		$this->load->library('shop/options_library');
		$this->load->model('shop/options_product_m');	
		$this->load->model('shop/categories_m');	



		log_message('debug', "Product_prices_m Initialized");

	}


	/**
	 *
	 * @param INT $id of the discount price record
	 *
	 */
	public function delete($id)
	{

		//check that id is int
		return parent::delete($id);
		
	}

	
	public function set_discounts_by_product($id,$values) 
	{
		

		// First delete all old records   	
		$this->delete_discounts_by_product($id);
		
		foreach ($values as $value) 
		{
			 
			// Then create new ones
			$to_insert = array(
				'prod_id' => $id,
				'min_qty' => $value['min_qty'],
				'price' => $value['price'],
				'date_start' => '1970-05-01',
				'date_end' =>'1970-05-01',
			);
			
			$this->db->insert('shop_discounts',$to_insert); 
			
		}
		
		return TRUE;

	}
	
	public function delete_discounts_by_product($id) 
	{
		return $this->db->delete('shop_discounts', array('prod_id' => $id));
	} 
	
	public function get_discounts_by_product($id) 
	{
		return $this->db->where('prod_id',$id)->get('shop_discounts')->result();
	}
	
	/**
	 * 
	 * @param INT $p_id The product ID
	 * @param INT $qty - The qty selector to search by
	 * @param DEC $def_price The default price to return if no record found
	 */
	public function get_discounted_price($p_id, $qty, $def_price)
	{
	
		// First get all the results that may fit the part
		$this->db->where('prod_id',$p_id);
		$this->db->where('min_qty <= ',intval($qty) );
		$this->db->order_by('min_qty desc');
		$this->db->limit(1);
		$results = $this->db->get('shop_discounts')->result();
	 
		// No matching records - return default
		if (!$results)
			return $def_price;
		
		return  $results[0]->price;
	}


	public function duplicate_discounts( $from_prod, $to_product_id)
	{
	
		// First get all the results that may fit the part
		$this->db->where('prod_id',$from_prod);
		$results = $this->db->get('shop_discounts')->result();
	 
		// No matching records - return default
		if (!$results)
			return TRUE;


		$values = array();


		foreach($results as $result)
		{

			$values[] = array( 'min_qty' => $result->min_qty,  'price' => $result->price );

		}

		$this->set_discounts_by_product($to_product_id, $values);

		return TRUE;
	}

	

}