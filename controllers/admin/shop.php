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
class Shop extends Admin_Controller 
{
	// Set the section in the UI - Selected Menu
	protected $section = 'dashboard';

	public function __construct() 
	{
		parent::__construct();

		// Load all the Required classes
		$this->load->model('orders_m');

		$this->template
				->append_js('module::maps_bing.js')
				->append_css('module::admin.css');
	}

	/**
	 * List all items:load the dashboard
	 */
	public function index() 
	{

		
		// Load required Classes
		$this->load->model('products_admin_m');
		$this->load->model('categories_m');
		$this->load->model('brands_m');
		$this->load->model('statistics_m');

		
		// No pagination on dashboard for **recent orders**. On orders page we will have them
		$max = Settings::get('nc_total_recent_orders');
		
		// bing maps api - we need to pass the api key
		$data->MapAPIKey =Settings::get('shop_maps_api_key');
		
		// Could do withy some caching here
		$data->shop_products_count = $this->statistics_m->get_catalogue_data();
		
		// Collect all orders
		$data->order_items = $this->orders_m->order_by('order_date','desc')->limit($max)->get_all();
		
		// Product Notifications		
		$data->stock_products_data = $this->statistics_m->get_inventory_notifications();
		
		
		$data->order_messages = $this->orders_m->get_messages_by_status('read');
	
		
		//TODO: Use better chart api, also improve the data
		$rows = $this->db->query("select order_date, count(id) as `Val` from ".$this->db->dbprefix('shop_orders')." group by DATE(FROM_UNIXTIME(order_date)) LIMIT 4");
		$data->SalesRecords = $rows->result();
		

		// Build the view with shop/views/admin/items.php
		//$data->items = & $items;
		$this->template->title($this->module_details['name'])
				->append_metadata('<script src="http://www.google.com/jsapi"></script>')
				->append_js('module::admin/dashboard.js')
				->append_js('jquery/jquery.flot.js')
				->build('admin/dashboard/dashboard', $data);
				
	}


	public function status($id, $status) 
	{
		$this->orders_m->update($id, array('status' => $status));
		redirect('admin/shop');
	}

    public function stats($days = 5) 
    {
    	$this->load->model('shop/statistics_m');

        if ($this->input->is_ajax_request()) 
        {
            $data = $this->statistics_m->get_period($days, 'orders');

            echo json_encode($data);

        } 
    }	




    public function cache($option = 'products')
    {


    	if ( ($option == 'products') || ($option == 'all' ) )
    	{
			$this->pyrocache->delete_all('products_m');
			$this->pyrocache->delete_all('products_admin_m');
			$this->pyrocache->delete_all('products_front_m');
		}


    	if ( ($option == 'categories') || ($option == 'all' ) )
    	{
			$this->pyrocache->delete_all('categories_m');
		}    		


    	if ( ($option == 'brands') || ($option == 'all' ) )
    	{
			$this->pyrocache->delete_all('brands_m');
		}  
				

    	if ( ($option == 'options') || ($option == 'all' ) )
    	{
			$this->pyrocache->delete_all('options_m');    
		}  
				 		

		echo "Complete..";die;
		//echo json_encode(array('status' => 'complete')) ;die;
    }


    public function run_lang()
    {

    	$this->load->library('shop/core_library');
    	$data->lang_data = build_lang();

		$this->load->library('shop/core_basiks/core_debug_library');

		$this->core_debug_library->write_lang($data->lang_data);


		echo "program completed";die;

    }


    public function run_re_index()
    {

    	$this->load->library('shop/core_library');
		$this->load->library('shop/core_basiks/core_debug_library');

		$count = $this->core_debug_library->re_index_search();


		echo "Indexed " . $count . ' products';die;

    }

    public function export($table='products', $format ='csv' )
    {

		$this->load->helper('download');
		$this->load->library('format');


		switch ($table) 
		{
			case 'products':
			case 'orders':
				break;
			default:
				return FALSE;
				break;
		}


    	$this->load->model('shop_model');

    	$this->shop_model->export($table, $format);
    }
    
	

}
