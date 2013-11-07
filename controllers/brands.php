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

		$this->limit = Settings::get('ss_qty_perpage_limit_front');
		
		
	}

	
	/**
	 */
	public function index($offset = 0) 
	{
		  
		$data->brands = $this->brands_m->limit($this->limit,$offset)->get_all();

		$total_rows =  $this->brands_m->count_all();
		
		$data->pagination = create_pagination('shop/brands/', $total_rows, $this->limit, 3); /*$limit replaced by qty */
		
		$this->template
			->set_breadcrumb('Brands')
			->title($this->module_details['name'])
			->build('common/brands_list', $data);
	}


   /**
	* List all products by a brand
	* This will open up a page to display data about the brand 
	* TODO:Need to link to the products filter to list all products by brand
	*
	*/
	public function brand( $brand = 0, $offset =0 ) 
	{

		$this->load->model('products_front_m');
	
		if (is_numeric($brand) )
		{
			$brand = $this->brands_m->get($brand);
		}
		else
		{
			$brand = $this->brands_m->get_by('slug',$brand);
		}

		if(!$brand)
		{
			redirect('404');
		}

		//var_dump($brand);


		$filter['brand_id'] = $brand->id;
	


		// 
		//  Count total items by the given filter
		// 
		$total_items = $this->products_front_m->filter_count($filter);


		// 
		//  Build pagination for these items
		// 
		$data->pagination = create_pagination( 'shop/brands/brand/'.$brand->slug .'/', $total_items, $this->limit, 4);



		// 
		//  Filter and select only a subset of the items based on input data
		// 
		$data->products =  $this->products_front_m->filter($filter , $data->pagination['limit'] , $data->pagination['offset']);
		

		//
		// finally
		//
		$this->template
			->title($this->module_details['name'])
			->set_breadcrumb($this->shop_title)
			->build('common/products_list', $data);

	}	
	
 
}