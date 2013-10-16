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
class Pgroups_m extends MY_Model 
{

	public $_table = 'shop_pgroups';

	public function __construct() 
	{
		parent::__construct();
		$this->load->model('shop/pgroups_prices_m');
		
	}

	public function get($id,$admin=FALSE)
	{
		

		$pgroup = parent::get($id);

		//get all or get for shop
		if($admin)
		{
			$pgroup->prices = $this->pgroups_prices_m->get_by_pgroup_admin($id);
		}
		else
		{
			$pgroup->prices = $this->pgroups_prices_m->get_by_pgroup($id);
		}

		return $pgroup;
	}

	// Create a new item
	public function create($input) 
	{

		$this->db->trans_start();
		$to_insert = array(
			'name' => $input['name'],
			'description' => strip_tags($input['description']),
		);

		$input['id'] = $this->insert($to_insert);
		$this->db->trans_complete();
		return ($this->db->trans_status() === FALSE) ? FALSE : $input['id'];
	}



	public function edit($id, $input) 
	{
		
		$this->db->trans_start();
		
		$update_array = array(
				'name' => $input['name'],
				'description' => strip_tags($input['description']),
		);
				
		$result = $this->update($id, $update_array);
		
   
		$this->db->trans_complete();
	
		
		if ($result) 
		{
			
			if(!(isset($input['prices'])) )
			{
				$input['prices'] = array();
			}

			// Create Discount qty items
			$this->pgroups_prices_m->create($id,$input['prices']);			

			return TRUE;
						
		}

		return FALSE;

	}


	
	
	public function build_list_select($params) 
	{
		
		$params = array_merge(array('current_id' => 0), $params);
		extract($params);
		
		if ($brands = $this->db->order_by('name')->select('id, name')->get($this->_table)->result()) 
		{
			$html = '';
			foreach ($brands as $item)
			{
				$html .= '<option value="' . $item->id . '"';
				$html .= $current_id == $item->id ? ' selected="selected">' : '>';
				$html .= $item->name . '</option>';
			}
			return $html;
		}
		return '';
	}







}