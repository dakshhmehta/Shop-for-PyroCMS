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
require_once('products_m.php');

class Products_admin_m extends Products_m
{

	

	public function __construct() 
	{
		parent::__construct();

	}

	/**
	 * Get all public and non deleted products
	 * 
	 * @return Array Products Array
	 */
	public function get_all($mode = 'public') 
	{
		return parent::get_all($mode);
	}



	/**
	 * Create a new product, only some fields are required, the rest uses the default fields, 
	 * when creating a new product, you must first enter the first few req values, save-> then edit the newly created product.
	 *
	 *
	 * @param Array $input Input fields from user, they should be prepped before coming here.
	 */	 
	public function create($input, $user_id) 
	{
		$_name = strip_tags($input['name']);

		$slug = sf_clean_slug($input['slug']);
		
		$new_slug = $this->get_unique_slug($slug,-1,$_name);


		$to_insert = array(
				'name' => $_name,
				'meta_desc' => strip_tags($input['meta_desc']),
				'description' =>  strip_tags($input['description'], $this->_description_tags),
				'related' =>  '', //strip_tags($input['related']),
				'user_data' => '',
				'slug' => $new_slug,
				'keywords' => '',
				'price' => $input['price'] ,
				'price_bt' =>  $input['price'], /*price_bt is deprecated*/ 
				'price_at' => $input['price'] , /*price_at is deprecated*/ 
				'price_base' => $input['price_base'], // $input['price_base'],
				'rrp' => $input['price'], 
				'tax_id' => $input['tax_id'],
				'tax_dir' => $input['tax_dir'],
				 //'cover_id' => $input['cover_id'],
				'pgroup_id' => NULL,
				'status' => 0,
				'category_id' => 0,
				'brand_id' => NULL,
				'package_id' => NULL,			
				'created_by' => $user_id,
				'inventory_low_qty' => 5,
				'inventory_on_hand' => 0,
				'inventory_type' => 0, 
				'featured' => 0,
				'searchable' => 1,
				'public' => 0, 
				//'deleted' => 0, 
				'date_created' => date("Y-m-d H:i:s"),
				'date_updated' => date("Y-m-d H:i:s"),
				'code' =>  '',
		);
	
		$id =  $this->insert($to_insert); 

		if($id)
		{ 
			$this->add_to_search($id, $_name, strip_tags($input['description']) );
		}
	

		return $id;
		
	}




	/** 
	 * Store/Edit existing product to db
	 *
	 * @param INT $id
	 * @param Array $input
	 */
	public function edit($id, $input) 
	{
		
		//var_dump($input);die;

		// Start the transaction
		$this->trans_begin();


		//clean
		//d0n0tr3m0v3th1sf13ld
		if(isset($input['related']) )
		{
			foreach ($input['related'] as $key => $value) 
			{
				if($value == 'd0n0tr3m0v3th1sf13ld')
				{
					unset($input['related'][$key]) ;
				}
			}
		}



		$update_record = array();

		foreach($input as $key => $value)
		{
			$out_value = null;
		

			// we need to check for each field as they need to be handled
			if($this->check_field_req($key,$value, $out_value, $id))
			{
				$update_record[$key] = $out_value;
			}
			 
		}

		//always do this
		//$update_record['featured'] = (isset($input['featured']))?1:0;	
		//$update_record['searchable'] = (isset($input['searchable']))?1:0;						
		$update_record['date_updated'] = date("Y-m-d H:i:s");

				
			
		$result =  $this->update($id, $update_record); 
		
		
		if ($result) 
		{
			// Create Discount qty items
			$this->product_prices_m->set_discounts_by_product($id,$input['discounts']);
						
		}
		
		
		if ($this->trans_status() === FALSE)
		{
			$this->trans_rollback();
			return FALSE;
		}
		
		// Commit actions in TXN
		$this->db->trans_commit();
		
		// Return value
		return $result;

	}




	/**
	 * 
	 * @param unknown_type $id The ID of the original product to duplicate
	 * Should we create duplicate price records ?? or letthe admin create new ones ?
	 */
	public function duplicate($id) 
	{


		//
		// Get the original product
		//
		$product = $this->get($id);

		
		//
		// Get the count of items with similar name
		//
		
		//prep of escape char
		$product_name   =   '$product->name';


 		$suffix = $this->db->like('name',$product_name)->get('shop_products')->num_rows();


		$slug = sf_clean_slug($product->slug.$suffix);
		$new_slug = $this->get_unique_slug($slug);


		//
		// Adjust the suffix to something more ledgibale and contextual
		//
        $suffix = ' - '.$suffix .'';

		if ($product==NULL) return FALSE;
		
		$to_insert = array(
				'name' => $product->name.$suffix,
				'meta_desc' => $product->meta_desc,
				'description' => $product->description,				
				'related' => $product->related,
				'user_data' => $product->user_data,
				'slug' => $new_slug,
				'keywords' => $product->keywords,
				'price' => $product->price,
				'price_bt' => $product->price_bt,
				'price_at' => $product->price_at, 			
				'price_base' => $product->price_base,
				'tax_id' => $product->tax_id,
				'rrp' => $product->rrp,
				'tax_dir' => $product->tax_dir,
				'pgroup_id' => $product->pgroup_id,


				'cover_id' => $product->cover_id,
				'status' => $product->status,
				'category_id' => $product->category_id,
				'brand_id' => $product->brand_id,

				//shipping
				'package_id' => $product->package_id,
				'height' => $product->height,
				'width' => $product->width,
				'depth' => $product->depth,
				'weight' => $product->weight,


				'inventory_low_qty' => $product->inventory_low_qty,
				'inventory_on_hand' => $product->inventory_on_hand,
				'inventory_type' => $product->inventory_type,
				'public' =>  0, 
				'featured' => $product->featured,
				'searchable' => $product->searchable,
				'date_created' => date("Y-m-d H:i:s"),
				'date_updated' => date("Y-m-d H:i:s"),
				'code' => $product->code,
		);
		
		
		$new_id =  $this->insert($to_insert); //returns id


		if($new_id)
		{ 
			$this->add_to_search($new_id, $product->name.$suffix, strip_tags($product->description) );
		}


		$this->options_product_m->duplicate_product_options( $id, $new_id );

		$this->product_prices_m->duplicate_discounts( $id, $new_id);

		$this->product_attributes_m->duplicate_attributes($id, $new_id);


		return $new_id;
		
	}



	

	/**
	 * Admin function
	 * @param  [type] $product_id [description]
	 * @return [type]             [description]
	 */
	public function delete($product_id)
	{	
	
		return $this->update($product_id, array('date_archived' => date("Y-m-d H:i:s") ) );
	
		
	}
	



	/**
	 * [check_field_req description]
	 * @param  [type] $key   [description]
	 * @param  [type] $value [description]
	 * @param  [type] $out   [description]
	 * @param  [type] $id    [The Id is needed to check for existing records for slug field that do not match the same ID]
	 * @return [type]        [description]
	 */
	private function check_field_req($key, $value, &$out, $id)
	{
		$pass = FALSE;	

		switch ($key) 
		{
			case 'weight':			
			case 'height':
			case 'width':	
			case 'depth':				
				$out = floatval($value);
				$pass = TRUE;
				break;	

			case 'related':
			case 'related[]':	
				$out = json_encode($value);
				$pass = TRUE;
				break;	
			case 'user_data':
			case 'meta_desc':
				$out = strip_tags($value);
				$pass = TRUE;
				break;		


			case 'description':		
				$out = strip_tags($value, $this->_description_tags);
				$pass = TRUE;
				break;	

			case 'slug':
				$slug = sf_clean_slug($value);
				$out = $this->get_unique_slug($slug, $id);
				$pass = TRUE;
				break;

			case 'inventory_on_hand':
			case 'inventory_low_qty':
			case 'inventory_type':	
			case 'status':		
			case 'category_id':
			case 'featured':
			case 'searchable':
			case 'name':
			case 'price':		
			case 'price_bt':
			case 'price_at':
			case 'price_base':
			case 'rrp':
			case 'tax_id':
			case 'tax_dir':			
			case 'keywords':
			case 'code':		
				$out = $value;
				$pass = TRUE;
				break;

			case 'brand_id':
			case 'package_id':
			case 'pgroup_id':
				$out = ($value=='')?NULL:$value;
				$pass = TRUE;	
				break;

			default:
				$pass = FALSE;	
				break;

		}

		return $pass;

		
	}



	/**
	 * Admin function
	 * @param  [type] $file_id    [description]
	 * @param  [type] $product_id [description]
	 * @return [type]             [description]
	 */
	public function remove_image($file_id,$product_id) 
	{

		$this->update($product_id, array('date_updated' => date("Y-m-d H:i:s") ) );
		

		return $this->db->where('file_id',$file_id)->where('product_id',$product_id)->delete('shop_images');
	}
	
	
	/**
	 * Shared
	 * @param INT $id Product ID
	 * @return unknown
	 */
	public function get_images($id) 
	{
		return $this->db->where('product_id',$id)->get('shop_images')->result(); 
	}
	

	
	/**`
	 * Add image to gallery`
	 */
	public function add_image($image_id, $product_id)
	{
		
		$to_insert = array(
				'file_id' => $image_id,
				'product_id' => $product_id,
				'restrain_size' => 2,
				'width' => 0,
				'height' => 0,
				'display' => 1,
				'order' => 10, //will implement the ordering in later version
				'cover' => 0,

		);
	
		$this->update($product_id, array('date_updated' => date("Y-m-d H:i:s") ) );

		return $this->db->insert('shop_images',$to_insert); //returns id
	
	}
	

	

	

	protected function _prepare_filter($filter = array()) 
	{

		$new_filter = array();


		if (array_key_exists('visibility', $filter)) 
		{
			$operator = ($filter['visibility'] == 1)? 1 : 0;
			$new_filter['public'] = $operator ;
		}


		if (array_key_exists('category_id', $filter)) 
		{
			$this->where('category_id', $filter['category_id']);
			$new_filter['category_id'] = $filter['category_id'] ;
		}


		//$new_filter['deleted'] = 0 ;


		return $new_filter;
		
	}




	/**
	 * Admin Count Filter
	 * 
	 * @param  array  $filter [description]
	 * @return [type]         [description]
	 */
	public function filter_count($filter = array()) 
	{

		$this->reset_query();	

		//Prepare countBy filter
		$new_filter = $this->_prepare_filter($filter);

		// Get the count
		$this->like('name', trim($filter['search']));

		foreach ($new_filter as $key => $value) 
		{
			$this->where($key,$value);
		}

		$this->where('date_archived', NULL);

		return $this->count_by($new_filter);
		
	}

	
	public function filter($filter = array() , $limit, $offset = 0) 
	{

		$this->reset_query();	

		//Prepare countBy filter
		$new_filter = $this->_prepare_filter($filter);

		
		// Get the paged results
		$this->reset_query();		
		$this->like('name', trim($filter['search']));
		
		foreach ($new_filter as $key => $value) 
		{
			$this->where($key,$value);
		}		
		
		$this->where('date_archived', NULL);

		$this->db->order_by($filter['order_by']);
		$this->db->limit( $limit , $offset );

		return $this->get_all();

		
	}



}