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
	 * 
	 * 
	 * @param  [type]  $parm      [description]
	 * @param  string  $method    [description]
	 * @param  boolean $incr_view [description]
	 * @return [type]             [description]
	 */
	public function get($parm, $method = 'id', $incr_view = FALSE ) 
	{
		
		$product = parent::get($parm,$method); 

		if(!$product)
			return FALSE;


		if(group_has_role('shop', 'admin_products'))
		{

		}
		else
		{

			//
			// Make sure product is NOT deleted and is visible to public
			//
			if (($product->date_archived != NULL) || ($product->public == ProductVisibility::Invisible ))
			{
				return FALSE;
			}
		}


		//
		// Add the view count
		//
		if($incr_view)
		{
			$this->viewed($product->id);
		}
		
		return $product;
	}
	
	
	/**
	 * Get all public and non deleted products
	 * 
	 * @return Array Products Array
	 */
	public function get_all($mode = 'public')
	{
		
		if($mode!='public')
		{
			return array();
		}

		return parent::get_all('public');
	}


	/**
	 * Get count of products
	 * 
	 * @return Array Products Array
	 */
	public function count_custom($mode = 'public', $params = array())
	{
		$this->_table = 'shop_products';
		if($mode!='public')
		{
			return array();
		}
		
		$id_bestsellers = false;
		if (isset($params['bestsellers']))
		{
			$id_bestsellers = $this->__get_best_sellers_info();
			if(!empty($id_bestsellers)){
				$this->db->where_in($this->_table.'.id', $id_bestsellers);
			}else{
				return array();
			}
		}
		
		if (!empty($params['category']))
		{
			$this->db->where($this->_table.'.id', $params['category']);
		}

		if (isset($params['public']))
		{
			$this->db->where($this->_table.'.public', $params['public']);
		}
		
		if (isset($params['featured']))
		{
			$this->db->where($this->_table.'.featured', $params['featured']);
		}
		
		if (array_key_exists('keywords', $params))
		{
			$matches = array();
			if (strstr($params['keywords'], '%'))
			{
				preg_match_all('/%.*?%/i', $params['keywords'], $matches);
			}

			if (!empty($matches[0]))
			{
				foreach ($matches[0] as $match)
				{
					$phrases[] = str_replace('%', '', $match);
				}
			}
			else
			{
				$temp_phrases = explode(' ', $params['keywords']);
				foreach ($temp_phrases as $phrase)
				{
					$phrases[] = str_replace('%', '', $phrase);
				}
			}

			$counter = 0;
			foreach ($phrases as $phrase)
			{
				if ($counter == 0)
				{
					$this->db->like($this->_table.'.name', $phrase);
					$this->db->or_like($this->_table.'.keywords', $phrase);
				}
				else
				{
					$this->db->or_like($this->_table.'.name', $phrase);
					$this->db->or_like($this->_table.'.keywords', $phrase);
				}
				$counter++;
			}
		}

		// Limit the results based on 1 number or 2 (2nd is offset)
		if (isset($params['limit']) && is_array($params['limit']))
			$this->db->limit($params['limit'][0], $params['limit'][1]);
		elseif (isset($params['limit']))
			$this->db->limit($params['limit']);
		
		
		//if (!empty($params['related_content']))
		//{
		//	$caseQuery = ' CASE ';
		//	if(!empty($params['related_content']['category'])){
		//		$caseQuery .= ' WHEN '.$this->db->dbprefix($this->_table).'.category_id = '.$params['related_content']['category'].' THEN 1';
		//	}
		//	$caseQuery .= ' ELSE 4 END ';
		//	$this->db->order_by($caseQuery, null, false);
		//}
	
		if (isset($params['show_available']) and $params['show_available'])
		{
			$ftbl = $this->db->dbprefix($this->_table);
			$this->db->where("(".$ftbl.".status = 'in_stock' OR ".$ftbl.".inventory_on_hand > ".$ftbl.".inventory_low_qty OR ".$ftbl.".inventory_type = 1 )");
		}
		
	    $this->db->select('count('.$this->db->dbprefix($this->_table).'.id) AS totalrow')
			->join('shop_categories', 'shop_products.category_id = shop_categories.id', 'left');

		//$this->db->join('profiles', "profiles.user_id = ".$tblp.".author_id", 'left');
		$results = $this->db->get($this->_table)->row();
	    return $results->totalrow;
	}

	
	/**
	 * Get many public and non deleted products
	 * 
	 * @return Array Products Array
	 */
	public function get_many_custom($mode = 'public', $params = array())
	{
		$this->_table = 'shop_products';
		if($mode!='public')
		{
			return array();
		}
		
		$id_bestsellers = false;
		if (isset($params['bestsellers']))
		{
			$id_bestsellers = $this->__get_best_sellers_info();
			if(!empty($id_bestsellers)){
				$this->db->where_in($this->_table.'.id', $id_bestsellers);
			}else{
				return array();
			}
		}
		
		if (!empty($params['category']))
		{
			$this->db->where($this->_table.'.id', $params['category']);
		}

		if (isset($params['public']))
		{
			$this->db->where($this->_table.'.public', $params['public']);
		}
		
		if (isset($params['featured']))
		{
			$this->db->where($this->_table.'.featured', $params['featured']);
		}
		
		if (array_key_exists('keywords', $params))
		{
			$matches = array();
			if (strstr($params['keywords'], '%'))
			{
				preg_match_all('/%.*?%/i', $params['keywords'], $matches);
			}

			if (!empty($matches[0]))
			{
				foreach ($matches[0] as $match)
				{
					$phrases[] = str_replace('%', '', $match);
				}
			}
			else
			{
				$temp_phrases = explode(' ', $params['keywords']);
				foreach ($temp_phrases as $phrase)
				{
					$phrases[] = str_replace('%', '', $phrase);
				}
			}

			$counter = 0;
			foreach ($phrases as $phrase)
			{
				if ($counter == 0)
				{
					$this->db->like($this->_table.'.name', $phrase);
					$this->db->or_like($this->_table.'.keywords', $phrase);
				}
				else
				{
					$this->db->or_like($this->_table.'.name', $phrase);
					$this->db->or_like($this->_table.'.keywords', $phrase);
				}
				$counter++;
			}
		}

		// Limit the results based on 1 number or 2 (2nd is offset)
		if (isset($params['limit']) && is_array($params['limit']))
			$this->db->limit($params['limit'][0], $params['limit'][1]);
		elseif (isset($params['limit']))
			$this->db->limit($params['limit']);
		
		
		//if (!empty($params['related_content']))
		//{
		//	$caseQuery = ' CASE ';
		//	if(!empty($params['related_content']['category'])){
		//		$caseQuery .= ' WHEN '.$this->db->dbprefix($this->_table).'.category_id = '.$params['related_content']['category'].' THEN 1';
		//	}
		//	$caseQuery .= ' ELSE 4 END ';
		//	$this->db->order_by($caseQuery, null, false);
		//}
		
		if (isset($params['show_available']) and $params['show_available'])
		{
			$ftbl = $this->db->dbprefix($this->_table);
			$this->db->where("(".$ftbl.".status = 'in_stock' OR ".$ftbl.".inventory_on_hand > ".$ftbl.".inventory_low_qty OR ".$ftbl.".inventory_type = 1 )");
		}
		
		$tblp = $this->_table;
		if(!empty($params['details'])){
			$select_products = $tblp.".`id`, ".$tblp.".`slug`, ".$tblp.".`name`, ".$tblp.".`code`, ".$tblp.".`pgroup_id`, ".$tblp.".`category_id`, ".$tblp.".`cover_id`, ".$tblp.".`brand_id`,  ".$tblp.".`description`, ".$tblp.".`keywords`, ".$tblp.".`meta_desc`, ".$tblp.".`user_data`, ".$tblp.".`height`, ".$tblp.".`width`, ".$tblp.".`depth`, ".$tblp.".`weight`, ".$tblp.".`price`, ".$tblp.".`price_base`, ".$tblp.".`rrp`, ".$tblp.".`tax_id`, ".$tblp.".`tax_dir`, ".$tblp.".`featured`, ".$tblp.".`public`, ".$tblp.".`min_qty`, ".$tblp.".`max_qty`, ".$tblp.".`views`, ".$tblp.".`status`, ".$tblp.".`date_updated`, ".$tblp.".`page_design_layout`";
	    }else{
			$select_products = $tblp.".`id`, ".$tblp.".`slug`, ".$tblp.".`name`, ".$tblp.".`code`, ".$tblp.".`pgroup_id`, ".$tblp.".`category_id`, ".$tblp.".`cover_id`, ".$tblp.".`brand_id`,  ".$tblp.".`description`, ".$tblp.".`keywords`, ".$tblp.".`meta_desc`, ".$tblp.".`related`, ".$tblp.".`user_data`, ".$tblp.".`height`, ".$tblp.".`width`, ".$tblp.".`depth`, ".$tblp.".`weight`, ".$tblp.".`price`, ".$tblp.".`price_base`, ".$tblp.".`rrp`, ".$tblp.".`tax_id`, ".$tblp.".`tax_dir`, ".$tblp.".`digital`, ".$tblp.".`featured`, ".$tblp.".`searchable`, ".$tblp.".`public`, ".$tblp.".`min_qty`, ".$tblp.".`max_qty`, ".$tblp.".`views`, ".$tblp.".`inventory_on_hand`, ".$tblp.".`inventory_low_qty`, ".$tblp.".`inventory_type`, ".$tblp.".`status`, ".$tblp.".`created_by`, ".$tblp.".`date_created`, ".$tblp.".`date_updated`, ".$tblp.".`date_archived`, ".$tblp.".`page_design_layout`";
	    }
	
	    $this->db->select($select_products.', shop_categories.name AS category_name, shop_categories.slug AS category_slug')
			->join('shop_categories', $tblp.'.category_id = shop_categories.id', 'left');

		//$this->db->join('profiles', "profiles.user_id = ".$tblp.".author_id", 'left');
	    $this->db->order_by($tblp.".`date_created`", "DESC");

	    return $this->db->get($this->_table)->result();
		//return parent::get_all('public');
	}

	private function __get_best_sellers_info()
	{
		
		$tblp = 'shop_transactions';
	    $this->db->select('shop_order_items.`product_id`')
			->join('shop_order_items', $tblp.'.order_id = shop_order_items.order_id');

	    $this->db->where($tblp.".`status`", "accepted");
	    $this->db->group_by("shop_order_items.`product_id`");
	    $this->db->order_by("count(".$this->db->dbprefix('shop_order_items').".`product_id`)", "DESC");

	    $results = $this->db->get($tblp)->result();
		if(!empty($results)){
			$id_list = array();
			foreach($results as $row){
				$id_list[] = $row->product_id;
			}
			return $id_list;
		}
		
		return false;
	}

	public function get_product_options_info($product_id = 0)
	{
		if(empty($product_id)){
			return false;
		}
		$tblp = 'shop_prod_options';
	    $this->db->select($tblp.'.`prod_id`,'.$tblp.'.`option_id`,'.$tblp.'.`order`, shop_options.`name`, shop_options.`title`, shop_options.`description`, shop_options.`slug`, shop_options.`type`, shop_options.`show_title`')
			->join('shop_options', $tblp.'.option_id = shop_options.id');

	    $this->db->where($tblp.".`prod_id`", $product_id);
	    $this->db->order_by($tblp.".`order`", "ASC");

	    $results = $this->db->get($tblp)->result();
		if(!empty($results)){
			
			foreach($results as $key => $row){
				if(!isset($results[$key]->option_values)){
					$results[$key]->option_values = array();
				}
				$results[$key]->option_values = $this->get_product_options_value($row->option_id);
			}
			return $results;
		}
		
		return false;
	}
	
	
	public function get_product_options_value($option_id = 0)
	{
		if(empty($option_id)){
			return false;
		}
	    $this->db->select('shop_option_values.`id`, shop_option_values.`label`, shop_option_values.`value` as option_value, shop_option_values.`user_data`, shop_option_values.`max_qty`, shop_option_values.`operator`, shop_option_values.`operator_value`, shop_option_values.`default`, shop_option_values.`ignor_shipping` as ignore, shop_option_values.`order` as order_option_val');

	    $this->db->where("shop_option_values.`shop_options_id`", $option_id);
	    $this->db->order_by("shop_option_values.`order`", "ASC");

	    $results = $this->db->get('shop_option_values')->result();
		if(!empty($results)){
			return $results;
		}
		
		return false;
	}

	/**
	 * Add view counter
	 * 
	 * @param  [type] $product_id [description]
	 * @return [type]             [description]
	 */
	private function viewed($product_id) 
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
		
		
		if ($new_qty <= $item->inventory_low_qty) 
		{
			// Let system know that products are getting low
			Events::trigger('evt_product_stock_low', $id);	


			// Update status //only change if current status was in stock, do not change for dscontinued or coming soon.
			if ($new_qty <= 0) 
			{
				if( $item->status == InventoryStatus::InStock ) 
				{
					$data['status'] = InventoryStatus::OutOfStock;		
				}
			}

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
	 * @description This is used for the front end shop, do not use products_m->filter() at the Public site
	 *
	 * @param unknown_type $data
	 * @param unknown_type $limit
	 * @param unknown_type $offset
	 */
	public function filter( $filter, $limit, $offset = 0 ) 
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
		//
		if(isset($filter['brand_id']))
		{
			$this->where('brand_id' , $filter['brand_id'] );
		}	


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

		//
		//
		if(isset($filter['brand_id']))
		{
			$this->where('brand_id' , $filter['brand_id'] );
		}		


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