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
class Images_library 
{


	// Private variables.  Do not change!
	private $CI;
	

	public function __construct($params = array())
	{
	
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();

		log_message('debug', "Images Library Class Initialized");
		
	}


	public function migrate1() 
	{
		
		$this->CI->load->model('shop/images_m');

		$images = $this->CI->images_m->get_all();



		foreach($images as $image)
		{
			$image->src = '{{url:site}}files/large/'.$image->file_id; //'/'.$image->height.'/'.$image->height;
			$image->alt ='';

			$this->CI->images_m->save($image);

		}

		return TRUE;


		//$_path = FCPATH . $t->path; //'addons/shared_addons/themes/tldonline'


	}	

	/**
	 * Migrate the cover images over to the shop_images table
	 * @return [type] [description]
	 */
	public function migrate2() 
	{
		
		$this->CI->load->model('shop/images_m');
		$this->CI->load->model('shop/products_admin_m');

		$prodcts = $this->CI->products_admin_m->get_all();

		foreach($prodcts as $product)
		{
			if(!$product->cover_id == "")
			{
				$this->CI->images_m->add_local_image($product->cover_id, $product->id, 1);
			}
			
		}

		return TRUE;

	}	

}
// END Cart Class
