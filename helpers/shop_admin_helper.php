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
if (!function_exists('fraud_method')) 
{
	function fraud_method($method = -1) 
	{
		$items = array();
		$items[0]  = 'None';
		$items[1]  = 'IP Address';
		$items[2]  = 'Email';
		$items[3]  = 'Country';

		return $items[$method];
	}

}

if (!function_exists('hlp_product_cover')) 
{
	function hlp_product_cover($product_id = -1) 
	{

		$ci =& get_instance();
		
		$ci->load->model('shop/images_m');

		$img = $ci->images_m->where('cover',1)->where('product_id',$product_id)->limit(1)->get_all();
		
		if(count($img))
			return $img[0];	

		return NULL;
	}

}


if (!function_exists('orderby_helper')) 
{
  	//move to helpers
	function orderby_helper($option) 
	{
		$order = 'asc'; 
		$field = 'id';

		switch($option) 
		{
			case 0:
				$field = 'id';
				break;	
			case 1:
				$field = 'name';
				break;
			case 2:
				$field = 'category_id';
				break;
			case 3:
				$field = 'id';
				$order = 'DESC'; 
				break;			
			case 4:
				$field =  'name';
				$order = 'DESC'; 
				break;					
		}


		return array('field' => $field, 'order'=>$order);
	}
}
	


/*
function makeMyUrlFriendly($url){
    $output = preg_replace("/\s+/" , "_" , trim($url));
    $output = preg_replace("/\W+/" , "" , $output);
    $output = preg_replace("/_/" , "-" , $output);
    return strtolower($output);
}
*/
if (!function_exists('sf_generate_slug')) 
{
	
	/**
	 * 
	 * Adopted from http://cubiq.org/the-perfect-php-clean-url-generator
	 * 
	 * echo toAscii("Mess'd up --text-- just (to) stress /test/ ?our! `little` \\clean\\ url fun.ction!?-->");
	 *
	 *	echo toAscii("Custom`delimiter*example", array('*', '`'));
	 *	returns: custom-delimiter-example
	 *
	 *	echo toAscii("T�nk efter nu � f�rr'n vi f�ser dig bort"); // Swedish
	 *	returns: tank-efter-nu-forrn-vi-foser-dig-bort
	 *
	 *
	 * @param unknown_type $str
	 * @param unknown_type $replace
	 * @param unknown_type $delimiter
	 * @return mixed
	 */
	function sf_generate_slug($str, $replace=array(), $delimiter='-') 
	{

		setlocale(LC_ALL, 'en_US.UTF8');
		
		if ( !empty($replace) ) 
		{
			$str = str_replace((array)$replace, ' ', $str);
		}
	
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	
		return $clean;
	}
}  


if (!function_exists('sf_clean_slug')) 
{
	
	//make sure the slug is valid
	function sf_clean_slug($slug) 
	{
		
		$slug = strtolower($slug);
			
		$slug = preg_replace('/\s+/', '-', $slug);
		

		return $slug;
	}
}


if (!function_exists('ss_category_name')) 
{
	
	//make sure the slug is valid
	function ss_category_name($id) 
	{

		$ci =& get_instance();
		
		$ci->load->model('shop/categories_m');

		
		$cat = $ci->categories_m->get($id);
		
		return $cat->name;	

	}
}