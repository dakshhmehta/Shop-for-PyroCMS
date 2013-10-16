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
class Brands extends Public_Controller 
{

	public function __construct() 
	{
	
		parent::__construct();

		// Retrieve some core settings
		//$this->use_css =  Settings::get('nc_css');
		$this->shop_title = Settings::get('ss_name');		//Get the shop name
		$this->shopsubtitle = Settings::get('ss_slogan');		//Get the shop subtitle
		
		// Load required classes
		$this->load->model('brands_m');
		

		// Apply default CSS if required
		//if ($this->use_css) _setCSS($this->template);
		
	}

	
	/**
	 */
	public function index($offset = 0, $limit = 5) 
	{

		$limit = (isset(Settings::get('ss_qty_perpage_limit_front')))? Settings::get('ss_qty_perpage_limit_front') :$limit;
		  
		$data->brands = $this->brands_m->get_all();

		$total_rows =  $this->brands_m->count_all();
		
		$data->pagination = create_pagination('shop/brands/', $total_rows, $limit, 3); /*$limit replaced by qty */
		
		$this->template
			->set_breadcrumb('Brands')
			->title($this->module_details['name'])
			->build('brands/brands', $data);
	}


   /**
	* List all products by a brand
	* This will open up a page to display data about the brand 
	* TODO:Need to link to the products filter to list all products by brand
	*
	*/
	public function brand( $brand = 0 ) 
	{
	
		if (is_numeric($brand) )
		{
			$data->brand = $this->pyrocache->model('brands_m', 'get', $brand);
		}
		else
		{
			$data->brand = $this->pyrocache->model('brands_m', 'get_by', array('slug',$brand));
		}
	
		
		$this->template
			->title($this->module_details['name'].' |' .lang('products'))
			->set_breadcrumb($this->shop_title)
			->build('brands/brand', $data);

	}	
	
 
}