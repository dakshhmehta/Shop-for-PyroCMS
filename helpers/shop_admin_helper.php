<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

/*
 * 
 *
 *
 *
 *
 *
 *
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

if (!function_exists('orderby_helper')) 
{
  	//move to helpers
	function orderby_helper($option) 
	{
		switch($option) 
		{
			case 0:
				return 'id';
				break;	
			case 1:
				return 'name';
				break;
			case 2:
				return 'category_id';
				break;
			case 3:
				return 'id desc';
				break;			
			case 4:
				return 'name desc';
				break;					
			default:
				return 'id';
				break;
		}
	}
}
	

if (!function_exists('get_prod_option_name')) 
{
	/**
	 * Pass the prod_option id - to get the product option name
	 *
	 */
	function get_option_name($id) 
	{


		$ci =& get_instance();
		
		$ci->load->model('shop/options_m');

		
		$option = $ci->options_m->get($id);
		
		return $option->name;
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
	 *	echo toAscii("Tänk efter nu – förr'n vi föser dig bort"); // Swedish
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