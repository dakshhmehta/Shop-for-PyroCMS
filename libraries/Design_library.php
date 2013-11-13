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
class Design_library 
{




	// Private variables.  Do not change!
	private $CI;
	

	public function __construct($params = array())
	{
	
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();

		log_message('debug', "Design Library Class Initialized");
		
	}


	public function build_list_select($def_theme, $params=array()) 
	{
		
		$this->CI->load->model('theme_m');
		$t = $this->CI->theme_m->get($def_theme);


		$_path = FCPATH . $t->path; //'addons/shared_addons/themes/tldonline'


		$themeFiles = scandir($_path . "/views/modules/shop/custom");

		$add_to_list = array();

		//$add_to_list[] = $_path;

		foreach($themeFiles as $file)
		{
			

			if($file == '.' || $file == '..')
			{

			}
			else
			{

				if( substr( $file , 0,16 ) == "products_single_")
				{
					$basename = basename($file, ".php");

					$file_to_add = substr($file,16);

					$add_to_list[] = basename($file_to_add , ".php");
				}
				
				
			}


		}



		$params = array_merge(array('current_id' => 0), $params);
		
		extract($params);
		
		
		$html = '';

			
		foreach ($add_to_list as $item) 
		{
			if($current_id === 0 )
			{
				$html .= '<option value="' . $item . '">'. $item .'</option>';
			}			
			elseif($current_id === $item )
			{
				$html .= '<option value="' . $item . '" selected="selected">'. $item .'</option>';
			}
			else
			{
				$html .= '<option value="' . $item . '">'. $item .'</option>';
			}

		}
			
		
		
		return $html;
	}	


	public function get_custom_path()
	{

		$this->CI->load->model('theme_m');
		$t = $this->CI->theme_m->get($def_theme);

		$root = FCPATH . $t->path; //'addons/shared_addons/themes/tldonline'

		$path = $root . "/views/modules/shop/custom";

		return $path;
	}



}
// END Cart Class
