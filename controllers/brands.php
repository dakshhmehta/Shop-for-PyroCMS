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
		$this->use_css =  Settings::get('nc_css');
		$this->shop_title = Settings::get('ss_name');		//Get the shop name
		$this->shopsubtitle = Settings::get('ss_slogan');		//Get the shop subtitle
		
		// Load required classes
		$this->load->model('brands_m');

		
		// NC Markup theme
		$this->nc_page_layout = Settings::get('nc_markup_theme'); /*standard or legacy*/
		$this->nc_page_layout_path = 'brands/'.$this->nc_page_layout.'/brands';		
		

		// Apply default CSS if required
		if ($this->use_css) _setCSS($this->template);
		
	}

	
	/**
	 */
	public function index($offset = 0, $limit = 5) 
	{
		  
		$data->brands = $this->brands_m->get_all();

		$total_rows =  $this->brands_m->count_all();
		
		$data->pagination = create_pagination('shop/brands/', $total_rows, $limit, 3); /*$limit replaced by qty */

		//
		// Pass the layout name as views may require it for includes
		//
		$data->nc_layout =  $this->nc_page_layout;

		
		$this->template
			->set_breadcrumb('Brands')
			->title($this->module_details['name'])
			->build($this->nc_page_layout_path, $data);
	}


   /**
	* List all products by a brand
	*
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
	


		$data->nc_layout =  $this->nc_page_layout;
		
		
		//
		// 
		//
		$this->template
			->title($this->module_details['name'].' |' .lang('products'))
			->set_breadcrumb($this->shop_title)
			->build('brands/'.$this->nc_page_layout.'/brand', $data);

	}	
	
	
 
}