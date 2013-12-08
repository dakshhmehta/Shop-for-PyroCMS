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
class Images_m extends MY_Model {


	public $_table = 'shop_images';

	public function __construct() 
	{
		parent::__construct();

	}



	public function save($image) 
	{
	
		$update_record = array(
			'src' => $image->src,
			'alt' => $image->alt,	
		);
		
		return $this->update($image->id, $update_record); 

	}


	/**`
	 * Add image to gallery`
	 */
	public function add_local_image($image_id, $product_id)
	{
		
		$to_insert = array(
				'src' => 'files/thumb/'.$image_id,
				'alt' => $image_id,
				'product_id' => $product_id,
				'width' => 0,
				'height' => 0,
				'order' => 10, //will implement the ordering in later version
				'cover' => 0,
				'local' => 1,
				'file_id' => $image_id,

		);


		$i_id = $this->insert($to_insert); //returns id


		if($i_id)
		{

			$this->db->where('id', $product_id);
			$this->db->update('shop_products', array('date_updated' => date("Y-m-d H:i:s") )  ); 

			return $i_id;
		}
	
	}	


	public function add_url_image($url, $product_id)
	{
		
		$to_insert = array(
				'src' => $url,
				'alt' => '',
				'product_id' => $product_id,
				'width' => 0,
				'height' => 0,
				'order' => 10, //will implement the ordering in later version
				'cover' => 0,
				'local' => 0,
				'file_id' => '',				

		);
		
		$i_id = $this->insert($to_insert); //returns id


		if($i_id)
		{

			$this->db->where('id', $product_id);
			$this->db->update('shop_products', array('date_updated' => date("Y-m-d H:i:s") )  ); 

			return $i_id;
		}
	
	}	



	/**
	 * 
	 * @param  [type]  $image_id   [description]
	 * @param  integer $product_id The product_id is optional if you want to see if the image exist and is linked to a product
	 * @return [type]              [description]
	 */
	public function image_exist( $image_id , $product_id = 0, $local = TRUE) 
	{
		
		// Do we rtest using check by local image - this will attempt to check by the
		if( $local )
		{

			$result = $this->limit(1)->where('file_id',$image_id)->get_all(); 

			if (count($result))
				return TRUE;
			
			return FALSE; 

		}

		return FALSE;

	}	


	
	/**
	 * Shared
	 * @param INT $id Product ID
	 * @return unknown
	 */
	public function get_images($product_id) 
	{
		return $this->where('product_id',$product_id)->get_all(); 
	}	
	
}
