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
class Options_product_m extends MY_Model
{


	//
	// Default database table for options
	//
	public $_table = 'shop_prod_options';
	
	
	
	
	
	public function __construct() 
	{
		parent::__construct();

	}
	
	
	
	
	/**
	 * Create a prod_option record
	 * 
	 *
	 */
	public function create($product_id, $option_id) 
	{


		$order = $this->_get_next_order();

		// Prep the new record
		$to_insert = array(
			'prod_id' => $product_id,
			'option_id' => $option_id,
			'order' => $order,
		);
		
		// Insert
		return $this->insert($to_insert); 			

	}


	private function _get_next_order()
	{

		//first count the records, this will be the order id.
		$result = $this->order_by('order','desc')->limit(1)->get_all();

		if($result)
		{

			$order = $result[0]->order + 1;

		}
		else
		{
			$order = 0;
		}	

		return $order;
	}
	
	
	
	
	public function delete($option_id) 
	{

		// Insert
		return parent::delete($option_id); 			

	}
	
	
	
	public function duplicate_product_options($from_prod_id, $to_prod_id)
	{

		$options = $this->get_prod_options($from_prod_id);

		foreach($options as $option)
		{
			$this->create( $to_prod_id , $option->option_id);
		}


		return TRUE;
	}


	/**
	 * Get by product
	 * 
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function get_prod_options($id) 
	{
	
		//
		// init the return array of optoins
		//
		$options_array = array();
		

		// 
		// get all the option id's assigned to the product
		//
		//$items = $this->db->order_by('order','asc')->where('prod_id',$id)->get('shop_prod_options')->result(); 			
		$items = $this->order_by('order','asc')->where('prod_id',$id)->get_all(); 			
		
		
		//
		//return pairs
		//
		return $items;

	
	}
	
	
	
	//
	// Esssentially a swap
	//
	public function move( $option_id, $dir = 'up' )
	{
	
	
		$selection = ($dir == 'up')? 'order <' : 'order >' ;
		$orderby = ($dir == 'up')? 'desc' : 'asc' ;
		
		
		//
		// Start trans
		//
		$this->db->trans_start();
		
		
		//
		// Get me
		//
		$me = $this->get($option_id);
		
		

		$items = $this->where( 'id !=', $me->id )->where('prod_id', $me->prod_id)->where( $selection , $me->order )->order_by('order', $orderby )->limit(1)->get_all();
		
		
		
		$tmp = 0;
		$po = 0;
		
		
		if($items)
		{
		
			//save to temp
			$tmp = $items[0]->order;
			$po = $me->order;
			

			if($po == $tmp)
				$tmp = $this->_get_next_order();
	
			
			if($this->update($items[0]->id, array('order' => $po)))
			{
				if( $result = $this->update($me->id, array('order' => $tmp) ) )
				{
				
				
				}
				else
				{
					$this->db->trans_rollback();
				}
				
			}
			else
			{
				return FALSE;
			
			}

		}
		else
		{
			return FALSE;
		}
		

	   
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE) 
		{ 
			
			//$this->db->trans_rollback();
			return FALSE;
		}
		else
		{ 
			//return an array of items changed and their order values
			return array( 0 => $me->id, 1 => $items[0]->id );
		}
			
	
	}

	
	
}


