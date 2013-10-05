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
class Wishlist_m extends MY_Model 
{

	/**
	 * @access public
	 */	
	public function __construct() 
	{
		parent::__construct();
		$this->_table = 'shop_wishlist';
		$this->primary_key = 'product_id';
	}

	
	/**
	 * @param $product
	 * @param $user_id
	 * @access public
	 */	
	public function add($user_id, $product) 
	{
		$input['user_id'] = $user_id;
		$input['product_id'] = $product->id;
		$input['price_or'] = $product->price_at;
		$input['date_added'] = date("Y-m-d H:i:s");
		$input['user_notified'] = 0;
		
		return $this->insert($input);
	}
	
	
	/**
	 * @param $product
	 * @param $user_id
	 * @access public
	 */
	public function delete($user_id, $product_id) 
	{
	
		$data = array('user_id' => $user_id, 'product_id' => $product_id);
		
		if ($this->delete_by($data)) 
		{
			return TRUE;
		} 
		
		return FALSE;
		
	}
	
	/**
	 *
	 * @param
	 * @param
	 * @access public
	 */
	public function get_all() 
	{
		$this->db->select('shop_products.*,shop_wishlist.price_or AS price_or');
		$this->db->select('shop_categories.name as category_name, shop_categories.slug as category_slug');
		$this->db->join('shop_products', 'shop_products.id = shop_wishlist.product_id', 'inner');
		$this->db->join('shop_categories', 'shop_products.category_id = shop_categories.id', 'left');
		return parent::get_all();
	}
	
	
	/**
	 * Checks wheather the item is already in the customers wishlist
	 *
	 * @param
	 * @param
	 * @access public
	 */
	public function item_exist($user_id = 0, $product_id = 0)
	{
	
		$data = array('user_id' => $user_id, 'product_id' => $product_id);

		if ($this->wishlist_m->get_by($data)) 
		{
			// item already in wishlist
			return TRUE;
		} 

		return FALSE;

	}

}