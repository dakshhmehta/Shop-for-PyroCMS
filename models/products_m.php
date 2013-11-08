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

class Products_m extends Shop_model
{

	//
	// Table name
	//
	public $_table = 'shop_products';
	
	//
	// All tags that are ok for description fields
	//
	protected $_description_tags = '<b><div><strong><em><i><u><ul><ol><li><p><span><a><br><br />';

	
	
	public function __construct() 
	{
		parent::__construct();

		$this->load->model('shop/tax_m');
		$this->load->model('shop/pgroups_m');
		$this->load->library('shop/package_library');
		$this->load->library('shop/options_library');
		$this->load->model('shop/options_product_m');	
		$this->load->model('shop/categories_m');	
		$this->load->model('shop/product_prices_m');	
		$this->load->model('shop/product_attributes_m');	
		// load options_m
		$this->load->model('shop/options_m');
		$this->load->model('shop/options_values_m');
		$this->load->model('shop/brands_m');
		$this->load->library('keywords/keywords');		


	}






	/**
	 *  
	 * @param  string $mode [public|admin]
	 * @return [Array]       [of products]
	 */
	public function get_all($mode = 'public') 
	{
		

		$this->db->select('shop_products.*');

		if($mode=='public')
		{
			$this->db->where('shop_products.public',1);
		}

		//we do not want this even in admin, at least not in this current version. Deleted is deleted.
		//We only keep for referencing
		$this->db->where('shop_products.date_archived',NULL);
		$products = parent::get_all();

		return $products;

	}





	
	/**
	 * 	same as get but this gets al data, images, attributes, options wheras get just gets the core info about a product 
	 * 	
	 * @param  [type]  $parm   [ID or the slug to get]
	 * @param  string  $method  
	 * @return [type]          [description]
	 */
	public function get($parm, $method='id') 
	{	

		$this->load->library('files/files');


		if($method=='slug')
		{
			$product = parent::get_by(array('slug' => $parm) );
		}
		else
		{
			$product = parent::get($parm); 
		}

		if(!$product)
			return FALSE;	

		return $product;

	}





	public function image_exist( $file_id, $product_id ) 
	{
		
		$result = $this->db
						->limit(1)
						->where('file_id',$file_id)
						->where('product_id',$product_id)
						->get('shop_images')->row(); 
		
		if (count($result) > 0)
				return TRUE;
		
		return FALSE;

	}

	
	/**
	 *
	 * @param INT $id Product ID
	 * @return unknown
	 */
	public function get_images($id) 
	{
		return $this->db->where('product_id',$id)->get('shop_images')->result(); 
	}
	



	public function filter($filter = array() , $limit, $offset = 0) {}
	
	public function filter_count($filter = array()) {}





	/**
	 * Create a list of products by category id;
	 * 
	 * @param  [type] $cat_id [description]
	 * @return [type]         [description]
	 */
	public function build_dropdown($cat_id)
	{

		$options =array();
		$options['field_property_id'] = 'product_id';

		$products = $this->db->where('category_id', $cat_id )->order_by('name')->select('id, name')->get($this->_table)->result();
		return $this->_build_dropdown( $categories , $options );

	}
	

}