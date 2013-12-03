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
class Shop_files_m extends MY_Model 
{
    public $_table = 'shop_product_files';
	
	
	public function __construct() 
	{
		parent::__construct();
	}
	

	/**
	 * This creates a file in the DB
	 * 
	 * @param  [type] $input [description]
	 * @return [type]        [description]
	 */
	public function add_file($input)
	{

		$to_insert = array(
				'product_id' => $input['product_id'],
				'filename' => $input['filename'], 
				'type' => $input['type'], 
				'ext' => $input['ext'],
				'data' => $input['data'],
		);

		$this->db->insert('shop_product_files', $to_insert );
	
	}	

	public function delete_file($file_id)
	{
		$this->db->where('id', $file_id);
		return $this->db->delete('shop_product_files'); 		
	}


	public function get_files($product_id)
	{
		return $this->db->select('id,product_id,filename,ext,type')->where('product_id',$product_id)->get('shop_product_files')->result(); 
	}
	


	/**
	 * First get all product by this order
	 * Then get each file and return in the right format for the plugin
	 * 
	 * @param  [type] $order_id [description]
	 * @return [type]           [description]
	 */
	public function get_files_by_order($order_id)
	{
		$products = $this->db->select('product_id,order_id')->where('order_id',$order_id)->get('shop_order_items')->result(); 

		$files = array();
		foreach($products as $product)
		{
			$f = $this->db->select('id,product_id,filename,ext,type')->where('product_id',$product->product_id)->get('shop_product_files')->result(); 	

			foreach ($f as $key => $value) 
			{
				$files[$key] = $value;
			}
		}	

		return $files;
		
	}	

	
}
