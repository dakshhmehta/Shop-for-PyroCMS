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


	public function get($parm, $method = 'id') 
	{
		
		$product = parent::get($parm,$method); 

		if(!$product)
			return FALSE;

		return $product;
	}


	/**
	 * Get all public and non deleted products
	 * 
	 * @return Array Products Array
	 */
	public function get_all($mode = 'admin') 
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
	public function create($input) 
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
				'price_base' => $input['price_base'], // $input['price_base'],
				'rrp' => 0.00, 
				'tax_id' => $input['tax_id'],
				'tax_dir' => $input['tax_dir'],
				'pgroup_id' => NULL,
				'status' => 0,
				'category_id' => 0,
				'brand_id' => NULL,			
				'created_by' => $this->current_user->id,
				'inventory_low_qty' => 5,
				'inventory_on_hand' => 0,
				'inventory_type' => 0, 
				'featured' => 0,
				'searchable' => 1,
				'public' => 0, 
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


        $suffix = '-'.$suffix .'';

		$new_slug = $this->get_unique_slug(  sf_clean_slug($product->slug.$suffix)  );



		if ($product==NULL) return FALSE;
		
		$to_insert = array(
				'name' => $product->name,
				'meta_desc' => $product->meta_desc,
				'description' => $product->description,				
				'related' => $product->related,
				'user_data' => $product->user_data,
				'slug' => $new_slug,
				'keywords' => $product->keywords,
				'price' => $product->price,			
				'price_base' => $product->price_base,
				'tax_id' => $product->tax_id,
				'rrp' => $product->rrp,
				'tax_dir' => $product->tax_dir,
				'pgroup_id' => $product->pgroup_id,

				'status' => $product->status,
				'category_id' => $product->category_id,
				'brand_id' => $product->brand_id,

				//shipping
				'height' => $product->height,
				'width' => $product->width,
				'depth' => $product->depth,
				'weight' => $product->weight,
				'req_shipping' => $product->req_shipping,
				'page_design_layout' => $product->page_design_layout,
				'user_data' => $product->user_data,


				'inventory_low_qty' => $product->inventory_low_qty,
				'inventory_on_hand' => $product->inventory_on_hand,
				'inventory_type' => $product->inventory_type,
				'public' =>  0, 
				'views' =>  0, 
				'featured' => $product->featured,
				'searchable' => $product->searchable,
				'date_created' => date("Y-m-d H:i:s"),
				'date_updated' => date("Y-m-d H:i:s"),
				'code' => $product->code,

				'created_by' => $this->current_user->id,
		);
		
		
		$new_id =  $this->insert($to_insert); //returns id


		if($new_id)
		{ 
			$this->add_to_search($new_id, $product->name, strip_tags($product->description) );
		}


		$this->options_product_m->duplicate_product_options( $id, $new_id );


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
	 * This is used in the shop/admin/manage/ to reset the view counter. 
	 * @return [type] [description]
	 */
	public function reset_views()
	{
		$data = array('views' => 0);
		$this->db->update('shop_products', $data); 
		return true;
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


			case 'page_design_layout':
			case 'req_shipping':
			case 'inventory_on_hand':
			case 'inventory_low_qty':
			case 'inventory_type':	
			case 'status':		
			case 'category_id':
			case 'featured':
			case 'searchable':
			case 'name':
			case 'price':		
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


	
	
	protected function filter_category_list($filter = array())
	{
		$this->reset_query();
		$categories = array();	

		//
		// Get all products in sub categories
		//
		if(isset($filter['category_id']))
		{

			$this->load->model('categories_m');

			$cat_id = $filter['category_id'];

			$categories = $this->categories_m->get_children($cat_id);

			//dont forget the parent
			$categories[] =  $this->categories_m->get($cat_id);

		}

		$this->reset_query();	

		return $categories;

	}
	

	protected function _prepare_filter($filter = array()) 
	{

		$new_filter = array();


		if (array_key_exists('visibility', $filter)) 
		{
			$operator = ($filter['visibility'] == 1)? 1 : 0;
			$new_filter['public'] = $operator ;
		}


		//if (array_key_exists('category_id', $filter)) 
		//{
		//	$this->where('category_id', $filter['category_id']);
		//	$new_filter['category_id'] = $filter['category_id'] ;
		//}



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
		$categories = $this->filter_category_list($filter);
		$new_filter = $this->_prepare_filter($filter);
		$this->reset_query();



		foreach ($categories as $category) 
		{
			$this->or_where('category_id',$category->id);
		}


		// Get the count
		
		foreach ($new_filter as $key => $value) 
		{
			$this->where($key,$value);
		}

		if(trim($filter['search']) != "")
		{
			$this->like('name', trim($filter['search'])); 
		}

		$this->where('date_archived', NULL);

		$this->from($this->_table);


		return $this->count_all_results();
		//return $this->count_by($new_filter);
	}

	
	public function filter($filter = array() , $limit, $offset = 0) 
	{

		$this->reset_query();	
		$categories = $this->filter_category_list($filter);
		$new_filter = $this->_prepare_filter($filter);
		$this->reset_query();		

		

		foreach ($categories as $category) 
		{
			$this->or_where('category_id',$category->id);
		}


		
		foreach ($new_filter as $key => $value) 
		{
			$this->where($key,$value);
		}	

		if(trim($filter['search']) != "")
		{
			$this->like('name', trim($filter['search'])); 
		}


		$this->where('date_archived',NULL);					
		$this->order_by($filter['order_by'],$filter['order_by_order']);
		$this->limit( $limit , $offset );

		return $this->get_all();
	}

	/**
	 * This is only used to help admins find a related product to assign to another product.
	 * 
	 * @param  [type] $term     [description]
	 * @param  [type] $category [description]
	 * @return [type]           [description]
	 */
	public function filter_minimal($term,$category=NULL)
	{


		$this->db->select('shop_products.id, shop_products.name, shop_products.category_id')
				->where('shop_products.date_archived', NULL)	
				->where('shop_products.searchable',1);

				if((  $category != NULL) && (is_numeric($category)) && ($category > 0)  )
				{

					$this->db->where('shop_products.category_id',$category);
						
				}

	   $this->db->like('shop_products.name', $term)
				->like('shop_products.slug', $term)
				->or_like('shop_products.meta_desc',$term)
				->or_like('shop_products.code',$term);


				// we max out at 15, if not in list then they should do a better search
				return $this->db->limit(15)->get('shop_products')->result();	
						

	}

}