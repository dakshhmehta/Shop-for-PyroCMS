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
class Charts extends Admin_Controller 
{
	// Set the section in the UI - Selected Menu
	protected $section = 'charts';

	public function __construct() 
	{
		parent::__construct();

		$this->data = new stdClass();

		// Load all the Required classes
		$this->load->model('orders_m');

		Events::trigger('evt_admin_load_assests');

	}



	/**
	 * List all items:load the dashboard
	 */
	public function index($chart_scrope ='orders') 
	{

		
		// Load required Classes
		$this->load->model('products_admin_m');
		$this->load->model('categories_m');
		$this->load->model('brands_m');
		$this->load->model('statistics_m');


		// No pagination on dashboard for **recent orders**. On orders page we will have them
		$max = Settings::get('nc_total_recent_orders');
		

		
		// Could do withy some caching here
		$this->data->shop_products_count = $this->statistics_m->get_catalogue_data();
		
		// Collect all orders
		$this->data->order_items = $this->orders_m->order_by('order_date','desc')->limit($max)->get_all();
		
		// Product Notifications		
		$this->data->stock_products_data = $this->statistics_m->get_inventory_notifications();
		
		
		$this->data->order_messages = $this->orders_m->get_messages_by_status('read');
	
		
		//TODO: Use better chart api, also improve the data
		$rows = $this->db->query("select order_date, count(id) as `Val` from ".$this->db->dbprefix('shop_orders')." group by DATE(FROM_UNIXTIME(order_date)) LIMIT 4");
		$this->data->SalesRecords = $rows->result();
		


		$page_to_load = 'admin/charts/' . $chart_scrope; 
		
		$this->template->append_metadata('<script type="text/javascript">' . "\n  var CHART_SCOPE = '" . $chart_scrope . "';" . "\n</script>");
					


		$charts_js = 'module::admin/charts/charts_'.$chart_scrope.'.js';


		// Build the view with shop/views/admin/items.php
		//$data->items = & $items;
		$this->template->title($this->module_details['name'])	
				->append_js('module::lib/flot/jquery.flot.js')	
				->append_js('module::lib/flot/jquery.flot.time.js')	
				->append_js('module::lib/flot/jquery.flot.categories.js')
				->append_js($charts_js)								
				->build($page_to_load, $this->data);
				
	}

	public function orders() 	{		$this->index('orders');	}
	public function users() 	{		$this->index('users');	}	
	public function unpaid() 	{		$this->index('unpaid');	}	
	public function best() 		
	{		
		//$this->template->append_js('module::lib/flot/jquery.flot.categories.js');	

		$this->index('best');	
	}	

	/**
	 * Chart is orders|users
	 * 
	 * @param  string  $chart [description]
	 * @param  integer $days  [description]
	 * @return [type]         [description]
	 */
    public function stats($chart='orders', $days = 7) 
    {

    	$this->load->model('shop/statistics_m');

        if ($this->input->is_ajax_request()) 
        {
        	//for best sellers, days is actually the # of products
            $data = $this->statistics_m->get_period($days, $chart );
        	
            echo json_encode($data);

        } 	    	

    	
    }	



}
