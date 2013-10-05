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
class Statistics_m extends MY_Model
{


	public $_table = 'shop_products';
	
	//
	// All tags that are ok for description fields
	//
	private $_description_tags = '<b><div><strong><em><i><u><ul><ol><li><p><span><a><br><br />';

	
	

	
	public function __construct() 
	{
		parent::__construct();

		$this->load->model('shop/tax_m');
		$this->load->model('shop/pgroups_m');
		$this->load->library('shop/package_library');
		$this->load->library('shop/options_library');
		$this->load->model('shop/options_product_m');	
		$this->load->model('shop/categories_m');	
	}





	/**
	 * get_inventory_notifications()
	 *
	 * Will return an assoc array containing products that are either Out of stock
	 * or nearly out of stock. This data is usufull for the dashboard and reporting.
	 * 
	 * It will only retieve values if the product is public.
	 *
	 * 		$products['lowstock'][] - low stock but still has 1 or more items
	 * 		$products['outofstock'][] - completely out of stock
	 *
	 * @return multitype: Product
	 */
	public function get_inventory_notifications($limit = 5) 
	{
		 
		// Get low stock products
		$stok_products['lowstock'] = 
				$this->where('inventory_on_hand < inventory_low_qty')
					 ->where('inventory_on_hand > 0')
					 ->where('public = 1')
					 ->where('deleted = 0')
					 ->where('inventory_type != 1')
					 ->limit($limit)
					 ->get_all();
		
		// Get out of stock products
		$stok_products['outofstock'] = $this->where('inventory_on_hand <= 0')
											->where('public = 1')
											->where('deleted = 0')
											->where('inventory_type != 1')
											->limit($limit)
											->get_all();						 
		return $stok_products;
	}
	



	public function get_catalogue_data()
	{
		$data['total_products'] = $this->products_admin_m->count_all();
		$data['total_live_products'] = $this->db->where('public = 1')->get('shop_products')->num_rows;
		$data['total_offline_products'] = $this->db->where('public = 0')->get('shop_products')->num_rows;
		$data['total_categories'] = $this->categories_m->count_all();
		$data['total_brands'] = $this->brands_m->count_all();
		
		return $data;
	}

            
    public function get_period($days = 5, $limit = 'all') 
    {
        $stats = array();

        $limit = 'orders';
        
       $orders = $this->_get_orders($days);;
        
        switch ($limit) {
            case 'income':
            case 'orders':
                $stats[] = array('label' => 'Orders', 'data' => $orders);
                break;
            case 'all':
            default:
                break;
        }
        return $stats;
    }	

    private function _get_orders($days = 5) 
    {
    	//$days = 7;
        $dates = array();
        
        $day_seconds = 86400;
        $period = $days * $day_seconds;
        
        $this->db->select('COUNT(*) AS total', FALSE);
        $this->db->select("FROM_UNIXTIME(`order_date`, '%Y-%m-%d') AS date", FALSE);
        $this->db->where('order_date >', time()-$period);
        $this->db->group_by('date', FALSE);
        $result = $this->db->get('shop_orders')->result();
        
        $stats = array();
        
        for ($index = 0; $index < $days; $index++)
         {
            $timestamp = date('Y-m-d', time() - ($index * $day_seconds));
            $dates[$timestamp] = 0;
        }
        
        foreach ($result as $item) 
        {
            $dates[$item->date] = $item->total;
        }

        $dates = array_reverse($dates);
        
        foreach ($dates as $key => $value) 
        {
            $stats[] = array(strtotime($key)*1000, $value);
        }

        return $stats;
    }

}