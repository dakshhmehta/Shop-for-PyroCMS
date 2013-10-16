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
class Pgroups_prices_m extends MY_Model 
{

	public $_table = 'shop_group_prices';

	public function __construct() 
	{
		parent::__construct();
		
	}

	public function get_by_pgroup($id)
	{

		$user_group = $this->_get_user_group();
			
		// First get all the results that may fit the part
		$this->where('ugroup_id',$user_group);


		return $this->where('pgroup_id',$id)->get_all();
	}


	public function get_by_pgroup_admin($id)
	{


		return $this->where('pgroup_id',$id)->order_by('ugroup_id','asc')->order_by('min_qty','asc')->get_all();
	}


	// Create a new item
	public function create($id, $input = array()) 
	{


		$this->db->trans_start();


		//
		// Delete all existing
		//
		$this->db->delete('shop_group_prices', array('pgroup_id' => $id));


		foreach($input as $item)
		{


			$to_insert = array(
				'pgroup_id' => $id,
				'ugroup_id' =>  $item['ugroup_id'],
				'min_qty' => $item['min_qty'],
				'price' => $item['price'],
			);

			$this->insert($to_insert);

		}


		$this->db->trans_complete();


		return ($this->db->trans_status() === FALSE) ? FALSE : TRUE;

	}


	/**
	 * Shop will expect a group called user
	 * 
	 * @param  [type] $pg_id     [description]
	 * @param  [type] $qty       [description]
	 * @param  [type] $def_price [description]
	 * @return [type]            [description]
	 */
	public function get_discounted_price($pg_id, $qty, $def_price)
	{
	

		$user_group = $this->_get_user_group();
			

		

		// First get all the results that may fit the part
		$this->db->where('ugroup_id',$user_group);
		$this->db->where('pgroup_id',$pg_id);
		$this->db->where('min_qty <= ',intval($qty) );
		$this->db->order_by('min_qty desc');
		$this->db->limit(1);
		$results = $this->db->get('shop_group_prices')->result();
	 
		// No matching records - return default
		if (!$results)
			return $def_price;
		
		return  $results[0]->price;
	}	


	/**
	 * 
	 * @return [INT] [The group ID associated with the price]
	 *
	 * Non logged in users will receive the users price.
	 */
	private function _get_user_group()
	{
		$this->load->model('shop/user_groups_m');

		$group = $this->user_groups_m->get_group_by_name('user');


		if($this->current_user)
		{
			return $this->current_user->group_id;
			
		}


		return $group->id;
		
	}


	
	




}