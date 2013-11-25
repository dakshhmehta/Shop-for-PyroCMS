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
if (!function_exists('lang')) 
{

	/**
	 * [url_domain description]
	 * @param  boolean $show_protocol [description]
	 * @param  string  $protocol      [description]
	 * @return [type]                 [description]
	 */
	function lang( $string='', $trim_from_value = null ) 
	{

		

		$test = lang($string);

		if(trim($test) != "" )
			return $test;

		$result = explode(':', $string );



		if(sizeof($result) >= 3 )
		{		

			$area  = strtolower(trim($result[1]) ); 
			$value  = $result[2];


			$module ='shop';
			//key
			$key = strtolower(trim($value));
			$value = ucfirst( $key );


			if(sizeof($result) > 3 )
			{	
				$value = $result[3];
			}

			//fix value
			$value = ucfirst( $value );

			//trim a value from the value text if requested
			if($trim_from_value != null)
			{
				$value = ucfirst( str_replace(strtolower($trim_from_value), '', strtolower($value)) );
			}

			$value = str_replace('_', ' ', $value);


			$record = array(
				'module' => $module, 
				'area' => $area,
				'key' => $key, 
				'value' => $value, 			
			);

			$ci = & get_instance();

			$exist = $ci->db
				->where('module',$module)
				->where('area',$area)
				->where('key',$key)
				->get('lang')->num_rows() ;

			if($exist)
			{

			}
			else
			{
				$ci->db->insert('lang', $record);
			}

			return $value;

		}

		return lang($string);

	}
}

if (!function_exists('build_lang')) 
{

	/**
	 * [url_domain description]
	 * @param  boolean $show_protocol [description]
	 * @param  string  $protocol      [description]
	 * @return [type]                 [description]
	 */
	function build_lang() 
	{

			$ci = & get_instance();
		return $ci->db->order_by('module', 'asc')->order_by('area', 'asc')->order_by('key', 'asc')->get('lang')->result();

	}

}

if (!function_exists('sf_dump')) 
{
	
	# we do this because ''$dump = print_r($variable, true);'' doesnt work for objects
	function sf_dump($yourarray) 
	{
		ob_start();
		var_dump($yourarray);
		return ob_get_clean();
	}
}


/*
if (!function_exists('nc_pagination')) 
{

	function nc_pagination($uri, $total_items, $limit, $uri_segment = 4)
	{


		$ci =& get_instance();
		$ci->load->library('pagination');

		$config['base_url'] = $uri;
		$config['total_rows'] = $total_items;
		$config['per_page'] = $limit;


		$config['uri_segment'] = $uri_segment;
		//$config['num_links'] = 5;
		$config['use_page_numbers'] = FALSE;
		//$config['page_query_string'] = FALSE;



		$ci->pagination->initialize($config);

		return $ci->pagination->create_links();

	}
}
*/