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

class Products_front_m extends Products_m
{


	public function __construct() 
	{
		parent::__construct();

	}



	/**
	 * Also it adds to the view count.
	 * 
	 * @param  [type] $parm   [description]
	 * @param  string $method [description]
	 * @return [type]         [description]
	 */
	public function get($parm, $method = 'id', $simple = FALSE) 
	{
		
		$product = $this->get_product($parm,$method,$simple); 

		if(!$product)
			return FALSE;

		//
		// Make sure product is NOT deleted and is visible to public
		//
		if (($product->date_archived != NULL) || ($product->public === ProductVisibility::Invisible ))
		{
			return NULL;
		}
			
		//
		// Add the view count
		//
		$this->viewed($product->id);

		return $product;
	}
	
	
	/**
	 * Get all public and non deleted products
	 * 
	 * @return Array Products Array
	 */
	public function get_all()
	{
		return parent::get_all('public');
	}




	/**
	 * Add view counter
	 * 
	 * @param  [type] $product_id [description]
	 * @return [type]             [description]
	 */
	public function viewed($product_id) 
	{

		
		$this->db->select('shop_products.id, shop_products.views');
		
		$item = parent::get_by('shop_products.id', $product_id);

		return $this->update_property($product_id, 'views' , intval( $item->views + 1) ) ;


	}
	

	/**
	 * 
	 * @param  [type] $id   [description]
	 * @param  [type] $sold [description]
	 * @return [type]       [description]
	 */
	public function update_inventory( $id , $sold ) 
	{
	
		/**
		 * First get the product item
		 * @var [type]
		 */
		$item = self::get($id);
		

		/**
		 * Check if it is unlimited
		 * @var [type]
		 */
		if( $item->inventory_type == InventoryType::Unlimited )
		{
			return TRUE; 
		}
		

		$new_qty = $item->inventory_on_hand - $sold;

		
		$data = array('inventory_on_hand' => $new_qty);
		

		// Update status //only change if current status was in stock, do not change for dscontinued or coming soon.
		if ($new_qty <= 0) 
		{
			if( $item->status == InventoryStatus::InStock ) 
			{
				$data['status'] = InventoryStatus::OutOfStock;		
			}
		}
		
		if ($new_qty <= $item->inventory_low_qty) 
		{
			// Let system know that products are getting low
			Events::trigger('evt_product_stock_low', $id);	
		}
		

		$this->db->where('id', $id);

		$result = $this->db->update('shop_products', $data); 

		//
		// this will clear only the products DB
		//
		Events::trigger('evt_inventory_updated', $id);	

		return $result;
	
	}	

	

	




	/**
	 * This privides a basic search over the products table
	 *
	 * @param String $search_param The text to search the db by
	 */
	public function shop_search_products($search_term_array = array() ) 
	{
		
		$r_results = array();

		foreach($search_term_array as $term)
		{
			$results = $this->db->select('shop_products.*')
							->where('shop_products.public',1) 	//important
							->where('shop_products.deleted',0)	
							->where('shop_products.searchable',1)

							//important
							->like('shop_products.name', $term)
							->or_like('shop_products.description',$term,'after')
							->or_like('shop_products.meta_desc',$term)
							->or_like('shop_products.code',$term)
							->or_like('shop_products.id',$term)
							->get('shop_products')->result();	
							
			//merge
			$r_results = array_merge( $r_results , $results ); 

		}	


		return $r_results;
	}




	/**
	 * @description This is used for the front end shop, do not use products_m->filter() at the Public site
	 *
	 * @param unknown_type $data
	 * @param unknown_type $limit
	 * @param unknown_type $offset
	 */
	public function filter( $filter, $limit, $offset ) 
	{
		 
		$this->load->model('categories_m');


		if( isset($filter['category_id']) )
		{

			$cat_id = $filter['category_id'];

			$categories = $this->categories_m->get_children($cat_id);

		}



		// 
		// Start filtering now
		// 
		$this->db->reset_query();


		//
		// Only publicly visible and not deleted - do not remove this line
		// 
		if( isset($filter['category_id']) )
		{
			
			// Get by category or sub categories
			$this->where('category_id', $cat_id )
				->where('public', ProductVisibility::Visible )
				->where('date_archived', NULL )
				->where('searchable', 1 ); 


			foreach($categories as $category)
			{
				$this
					->or_where('category_id', $category->id )
					->where('public', ProductVisibility::Visible )
					->where('date_archived', NULL )
					->where('searchable', 1 );

			}

		}


		//
		// Get the filtered Count
		//
		$items = $this->where('public', ProductVisibility::Visible )
					->where('date_archived', NULL )
					->where('searchable', 1 )
					->order_by('id' , 'desc')
					->limit( $limit , $offset )
					->get_all();


		return $items;

	}




	/*count by that counts al products within subcategories as well*/
	public function filter_count($filter = array() )
	{

		
		//
		//
		// add to the existing filter the settings for all front end items
		//  - Must be visible
		//  - must be NOT deleted
		//  - must be searchabe
		//
		//
		$filter['public'] = ProductVisibility::Visible;
		//$filter['deleted'] = ProductStatus::Active;
		$filter['searchable'] = 1;


		//
		// Initialize fields
		//
		$count = 0;
		$categories = array();





		//
		// Get all products in sub categories
		//
		if(isset($filter['category_id']))
		{

			$this->load->model('categories_m');

			$cat_id = $filter['category_id'];

			$categories = $this->categories_m->get_children($cat_id);

		}


		//
		//	we need to do this as we have now collected the categories
		//
		$this->db->reset_query();	


		$this->where('date_archived', NULL );

		//count all products by first category and standard fields
		$count = $this->count_by($filter);


		foreach($categories as $category)
		{

			$this->db->reset_query();	

			$filter['category_id'] = $category->id ;

			$count += $this->where('date_archived', NULL )->count_by($filter);

		}		



		return $count;
	}


}