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
class Products_m extends MY_Model
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





	/*
 	 * Core get function, used for both admin and front side
	 *
	public function get($id) 
	{

		$this->db->select('shop_products.*');
		return parent::get_by('shop_products.id', $id);

		$this->db->select('shop_products.*, shop_categories.name as category_name, shop_categories.slug as category_slug, shop_categories.id as category_id');
		$this->db->join('shop_categories', 'shop_products.category_id = shop_categories.id', 'left');
		$this->db->join('shop_brands', 'shop_products.brand_id = shop_brands.id', 'left');
		return parent::get_by('shop_products.id', $id);
	}
*/


	/**
	 *  
	 * @param  string $mode [public|admin]
	 * @return [Array]       [of products]
	 */
	public function get_all($mode = 'public') 
	{
		

		$this->load->model('categories_m');

		$this->db->select('shop_products.*,');

		if($mode=='public')
		{
			$this->db->where('shop_products.public',1);
		}


		//we do not want this even in admin, at least not in this current version. Deleted is deleted.
		//We only keep for referencing
		$this->db->where('shop_products.date_archived',NULL);
		$products = parent::get_all();


		//bug if the product has no category we get some errors
		foreach( $products as $product )
		{
			$category					= $this->categories_m->get( $product->category_id ); 
			$product->category 			= $category;

			$product->related 			= json_decode($product->related );

		}

		return $products;
	}








	
	/**
	 * 	same as get but this gets al data, images, attributes, options wheras get just gets the core info about a product 
	 * 	
	 * @param  [type]  $parm   [ID or the slug to get]
	 * @param  string  $method  
	 * @param  boolean $simple [TRUE or FALSE, true will only get the product row from DB, FALSE will get all data]
	 * @return [type]          [description]
	 */
	public function get_product($parm, $method='id', $simple = FALSE) 
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


		$product->related = json_decode($product->related );

		if($simple) return $product;



		//have we found it ?

		$product->images 			= $this->get_images($product->id);  
		$product->properties_array 	= $this->product_attributes_m->get_product_attributes($product->id); 	
		$product->prod_options		= $this->options_product_m->get_prod_options($product->id); 
		$product->discounts 		= $this->product_prices_m->get_discounts_by_product($product->id);
		$product->keywords 			= Keywords::get_string($product->keywords); //prepare keywords
		$product->group				= $this->pgroups_m->get($product->pgroup_id);


		foreach($product->images as $image)
		{
			$afile = $this->files->get_file($image->file_id);
				
			$image->name = $afile['data']->name;
		}



		if( Settings::get('ss_enable_brands') )
		{
			$product->brand 		= $this->brands_m->get($product->brand_id); 
		}
	

		return $product;

		/*
		$this->load->model('categories_m');
		$category					= $this->categories_m->get( $product->category_id ); 
		if($category)
		{
			$product->category_name		= $category->name; 
			$product->category_slug		= $category->slug; 
			$product->category_id		= $category->id;
			$product->category_user_data= $category->user_data;	
			$product->category = $category;			
		}
		else
		{
			$product->category_name		= ''; 
			$product->category_slug		= ''; 
			$product->category_id		= 0;
			$product->category_user_data= '';	
			$product->category = array();		
		}

		return $product;
		*/

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
	


	
	/**
	 * Updates a single property of the product
	 * -Used for changing to private/public
	 * -updating cover id
	 * -archiving/deleting a product etc..
	 */
	public function update_property($product_id, $property, $value ) 
	{		
		return $this->update($product_id, array($property => $value ) ); 		
	}






	protected function filter() { }
	
	protected function filter_count() { }
	

}