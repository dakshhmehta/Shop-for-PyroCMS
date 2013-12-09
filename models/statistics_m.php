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
					 ->where('date_archived', NULL)
					 ->where('inventory_type != 1')
					 ->limit($limit)
					 ->get_all();
		
		// Get out of stock products
		$stok_products['outofstock'] = $this->where('inventory_on_hand <= 0')
											->where('public = 1')
											->where('date_archived', NULL)
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

            
    /**
     * 
     * @param  integer $days  [description]
     * @param  string  $chart [order|users|income]
     * @return [type]         [description]
     */
    public function get_period($days = 5, $chart = 'orders') 
    {

       $stats = array();
       
        switch ($chart) 
        {
            
            case 'activity':
                $activity = $this->_get_recent_activity($days);
                $stats[] = array('label' => 'Session', 'data' => $activity);
                break;
            case 'income':
            case 'orders':     
            	$orders = $this->_get_orders($days);
                $stats[] = array('label' => 'Orders', 'data' => $orders);
                break;
            case 'unpaid':
            	$orders = $this->_get_unpaid_orders($days);
                $stats[] = array('label' => 'Orders', 'data' => $orders);
                break;                
            case 'users':
            	$users = $this->_get_new_users($days);
                $stats[] = array('label' => 'Users', 'data' => $users);   
                break;   
            case 'best':
                //days is actually # of products to get
                $best = $this->_get_best_sellers($days);
                $stats[] = array('label' => 'Sales', 'data' => $best);   
                break; 
            case 'views':
                //days is actually # of products to get
                
                /*
                $best = $this->_get_best_sellers($days);
                $stats[] = array('label' => 'Sales', 'data' => $best);  


                $views = $this->_get_most_viewed($days);
                $stats[] = array('label' => 'Views', 'data' => $views);   

                return $stats;
                */


                $views = $this->_get_most_viewed($days);
                $stats[] = array('label' => 'Views', 'data' => $views);   
                break;  
            case 'topclients':
                $top = $this->_get_top_clients($days);
                $stats[] = array('label' => 'Revenue', 'data' => $top);   
                break;                                                          
            default:
                break;
        }

        return $stats;
    }	

    private function _get_orders($days = 7) 
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

    private function _get_unpaid_orders($days = 7) 
    {
    	//$days = 7;
        $dates = array();
        
        $day_seconds = 86400;
        $period = $days * $day_seconds;
        
        $this->db->select('COUNT(*) AS total', FALSE);
        $this->db->select("FROM_UNIXTIME(`order_date`, '%Y-%m-%d') AS date", FALSE);
        $this->db->where('order_date >', time()-$period);
		$this->db->where('pmt_status ', 'unpaid');

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

    private function _get_top_clients($clients = 7) 
    {
        $this->db->select('user_id, sum(cost_items) as total');
        $this->db->group_by('user_id', FALSE);
        $this->db->order_by('total desc', FALSE);        
        $this->db->limit($clients);

        $result = $this->db->get('shop_orders')->result();

        $stats = array();
        
        foreach ($result as $item) 
        {
            $user = $this->db->get_where('profiles',array('user_id' =>$item->user_id))->result();

            $stats[] =  array($user[0]->first_name,$item->total);
        }

        return $stats;
    }



    private function _get_new_users($days = 7) 
    {
    	//$days = 7;
        $dates = array();
        
        $day_seconds = 86400;
        $period = $days * $day_seconds;
        
        $this->db->select('COUNT(*) AS total', FALSE);
        $this->db->select("FROM_UNIXTIME(`created_on`, '%Y-%m-%d') AS date", FALSE);
        $this->db->where('created_on >', time()-$period);
        $this->db->group_by('date', FALSE);
        $result = $this->db->get('users')->result();
        
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

    /**
     * 
     * SELECT TOP(5) ProductID, SUM(Quantity) AS TotalQuantity
     * FROM order_items
     * GROUP BY ProductID
     * ORDER BY SUM(Quantity) DESC;
     * 
     * @param  integer $product_count [description]
     * @return [type]                 [description]
     */
    private function _get_best_sellers($product_count = 5) 
    {
        
        $this->db->select('title, product_id,sum(qty) as total_qty');
        $this->db->group_by('product_id', FALSE);
        $this->db->order_by('sum(qty) desc', FALSE);        
        $this->db->limit($product_count);
        $result = $this->db->get('shop_order_items')->result();

        //var_dump($result);die;


        $stats = array();
        
        foreach ($result as $item) 
        {
            $stats[] =  array($item->title,$item->total_qty);
        }

        return $stats;
    }

    private function _get_most_viewed($product_count = 5) 
    {
        
        $this->db->select('name, id, views');
        $this->db->group_by('id', FALSE);
        $this->db->order_by('views desc', FALSE);        
        $this->db->limit($product_count);
        $result = $this->db->get('shop_products')->result();

        //var_dump($result);die;


        $stats = array();
        
        foreach ($result as $item) 
        {
            $stats[] =  array($item->name,$item->views);
        }

        return $stats;
    }    



    private function _get_recent_activity($days = 7) 
    {
        //$days = 7;
        $dates = array();
        
        $day_seconds = 86400;
        $period = $days * $day_seconds;
        
        $this->db->select('COUNT(*) AS total', FALSE);
        $this->db->select("FROM_UNIXTIME(`last_activity`, '%Y-%m-%d') AS date", FALSE);
        $this->db->where('last_activity >', time()-$period);

        $this->db->group_by('date', FALSE);
        $this->db->group_by('ip_address', FALSE);
        
        $result = $this->db->get('ci_sessions')->result();
        
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