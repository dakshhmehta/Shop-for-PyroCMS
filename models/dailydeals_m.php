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
//require_once('products_m.php');

class Dailydeals_m extends MY_model
{

	
	public $_table = 'shop_dailydeals';


	public function __construct() 
	{
		parent::__construct();

	}

	public function get_all()
	{

		$this->db->select('shop_dailydeals.*');
		$this->db->select('prod.cover_id as cover_id');	
		$this->db->select('prod.name as name');	
		$this->db->select('prod.slug as slug');	
		$this->db->select('prod.price as price');	
		$this->db->select('prod.inventory_on_hand as on_hand');	
		$this->db->select('prod.status as stock_status');	

		$this->db->join('shop_products prod', 'shop_dailydeals.prod_id = prod.id', 'left');

		
		return parent::get_all();
	}

	public function get_all_admin()
	{
		$this->where('shop_dailydeals.status !=','completed');		
		return $this->get_all();
	}


	public function get_current()
	{	

		$deals = $this->where('shop_dailydeals.status' ,'active')->limit(1)->get_all();

	
		$this->load->model('products_front_m');
		foreach($deals as $deal)
		{
			//get($parm, $method = 'id', $simple = FALSE)
			return $this->products_front_m->get($deal->prod_id,'id',TRUE);
		}

		return FALSE;
	}

	public function get_next()
	{
		return TRUE;
	}

 
	public function create($prod_id) 
	{

		$to_insert = array(
				'prod_id' => $prod_id,
				'status' => 'pending',
				'mode' => 'endofday',
				'likes' =>  0, 
				'shares' =>  0, 
				'time_online' =>  0, 
				'date_start' => NULL ,
				'date_end' => NULL,
				
		);

	
		$id =  $this->insert($to_insert); 


		return $id;
		
	}


	public function start($id)
	{

		$this->stop_all_active();

		$data = array('status' => 'active');
		return $this->update($id, $data); 

	}


	public function activate($id)
	{

		$data = array('status' => 'pending');
		return $this->update($id, $data); 

	}

	/**
	 * Admin function
	 * @param  [type] $product_id [description]
	 * @return [type]             [description]
	 */
	public function stop($id)
	{	
	
		return $this->update($id, array('status' => 'forcestop' ) );
	
	}


	public function archive($id)
	{


		$data = array('status' => 'completed');
		return $this->update($id, $data); 

	}


	public function stop_all_active()
	{	
	
		$data = array('status' => 'forcestop');
		$this->db->where('status','active')->update('shop_dailydeals', $data); 
	
	}




}