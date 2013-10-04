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
		$this->shop_title = Settings::get('nc_name');		//Get the shop name
		$this->shopsubtitle = Settings::get('nc_slogan');		//Get the shop subtitle
		
		// Load required classes
		$this->load->model('brands_m');

		
		// NC Markup theme
		$this->nc_page_layout = Settings::get('nc_markup_theme'); /*standard or legacy*/
		$this->nc_page_layout_path = 'brands/'.$this->nc_page_layout.'/brands';		
		

		// Apply default CSS if required
		if ($this->use_css) _setCSS($this->template);
		
	}

	
	/**
	 * http://stackoverflow.com/questions/14165895/how-to-load-a-controller-from-another-controller-in-codeigniter
	 */
	public function index($offset = 0, $limit = 5) 
	{
		  
		$data->brands = $this->brands_m->get_all();

		$total_rows =  count( $data->brands );
		
		$pagination = create_pagination('shop/brands/', $total_rows, $limit, 3); /*$limit replaced by qty */
		
		//
		// Pass the layout name as views may require it for includes
		//
		$data->nc_layout =  $this->nc_page_layout;

		
		$this->template
			->set_breadcrumb('Brands')
			->title($this->module_details['name'])
			->set('pagination',$pagination)
			->build($this->nc_page_layout_path, $data);
	}


   /**
	* List all products by a category
	*
	*
	*/
	public function brand( $brand = 0, $offset = 0, $limit = 6 ) 
	{
	


		if (!(is_numeric($brand) ) )
		{
			$brand = $this->pyrocache->model('brands_m', 'get_by', array('slug',$brand));
		}
		else
		{
			$brand = $this->pyrocache->model('brands_m', 'get', $brand);
		}
	



		$filter['brand_id'] = $brand->id;

		$this->index($offset, $limit, $filter , "brand/".$brand->slug);



		//
		// Set up the (override) filters - this must be set for front end
		//
		$filter['shop_products.public'] = 1;
		$filter['shop_products.deleted'] = 0;




		// Count the items
		$total_items = $this->products_front_m->count_by($filter);




		//Get the items for the display
		$data->items = $this->products_front_m->shop_filter($filter, $limit, $offset);		



		/*
		 Using CI pagination library until the Pyro one is fixed
		 */
		$this->load->library('pagination');
		$config['base_url'] = base_url() . 'shop/brand/'. $brand->slug ;
		$config['total_rows'] = $total_items;

		$config['uri_segment'] = 4;
		$config['num_links'] = 5;
		//$config['use_page_numbers'] = FALSE;
		//$config['page_query_string'] = FALSE;
		$config['per_page'] = $limit;


		$this->pagination->initialize($config);
		$data->pagination2 = $this->pagination->create_links();





		//
		// Create pagination link data
		//
		//$data->pagination = create_pagination( 'shop/products/', $total_items, $limit, 3, TRUE);  



		//
		// Pass the layout name as views may require it for includes
		//
		$data->nc_layout =  $this->nc_page_layout;
		
		
		//
		// 
		//
		$this->template
			->title($this->module_details['name'].' |' .lang('products'))
			->set_breadcrumb($this->shop_title)
			->build('products/'.$this->nc_page_layout.'/products', $data);

	}	
	
  
}