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
class Options_values_m extends MY_Model
{


	//
	// Default database table for options
	//
	public $_table = 'shop_option_values';
	
	
	
	
	
	public function __construct() 
	{
		parent::__construct();

	}
	
	
	

	/**
	 * Get a single option by its id
	 * 
	 */
	//public function get($id) 

	
	/**
	 *
	 * @param INT $id The option id that is the option group for all the values
	 *
	 *
	 */
	public function get_all_options($id)
	{
	
		return $this->where('shop_options_id',$id)->order_by('order','asc')->get_all();
	
	}
	

	

	/**
	 *
	 * Sets a option value
	 *
	 * @param INT $id
	 * @param Array $values
	 * @access public
	 */
	public function create_simple($id, $value) 
	{
		
		$order = $this->_get_next_order();

		$insert_array = array(
			'shop_options_id' => $id,
			'label' => $value,
			'value' => $value,
			'max_qty' => 0,
			'ignor_shipping' => 0,
			'operator' => '',
			'operator_value' => 0,
			'default' => 0,
			'order' => $order,
		);

		return $this->insert($insert_array); 
	

	}
	
	
	/**
	 *
	 * Sets a option value
	 *
	 * @param INT $id
	 * @param Array $values
	 * @access public
	 */
	public function create($id, $value) 
	{
		
		$this->db->trans_start();
		
		$order = $this->_get_next_order();

		$insert_array = array(
			'shop_options_id' => $id,
			'label' => $value['label'],
			'value' => $value['value'],
			'user_data' => $value['user_data'],
			'max_qty' => $value['max_qty'],
			'ignor_shipping' => ((isset($value['ignor_shipping']))? 1 : 0 ),	
			'operator' => $value['operator'],
			'operator_value' => $value['operator_value'],
			'default' => ((isset($value['default']))? 1 : 0 ),
			'order' => $order,
		);

		$result = $this->insert($insert_array); 
	
		
		if (!$result)
			return FALSE;
	   
		$this->db->trans_complete();

		return ($this->db->trans_status() === FALSE) ? FALSE : $result;
		
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

	
	/**
	 *
	 * Sets a option value
	 *
	 * @param INT $id
	 * @param Array $values
	 * @access public
	 */
	public function edit($id, $value) 
	{
		
		$this->db->trans_start();
		

		$update_array = array(
			//'shop_options_id' => $id, //cant update this value
			'label' => $value['label'],
			'value' => $value['value'],
			'user_data' => $value['user_data'],
			'max_qty' => $value['max_qty'],
			'ignor_shipping' => ((isset($value['ignor_shipping']))? 1 : 0 ),			
			'operator' => $value['operator'],
			'operator_value' => $value['operator_value'],
			'default' => ((isset($value['default']))? 1 : 0 ),
			'order' => $value['order'],
		);

		$result = $this->update($id, $update_array); 
	
		
		if (!$result)
			return FALSE;
	   
		$this->db->trans_complete();

		return ($this->db->trans_status() === FALSE) ? FALSE : $result;
		
	}
	
	/**
	 * Delete a specific option value
	 *
	 * @param INT $id
	 * @access public
	 */
	public function delete($id)
	{
	
		$this->db->trans_start();


		$result = parent::delete($id); 
	

		if (!$result)
			return FALSE;
	   

		$this->db->trans_complete();

		
		return ($this->db->trans_status() === FALSE) ? FALSE : $result;
		

	}


	
	

	/**
	 *
	 *
	 *
	 */
	public function match( $option_id, $value )
	{
	
		return $this->get($value);
		
	}
	
	public function match2( $option_id, $value )
	{
	
		return $this->where('value',$value)->where('shop_options_id',$option_id)->get();
	
	}
		

	
	
	 
	/**
	 *
	 * option_value_id = ID
	 * option_id = parent option ID
	 */
	public function move( $option_value_id , $dir ='up' )
	{
	
	
		$selection = ($dir == 'up')? 'order <=' : 'order >=' ;
		$orderby = ($dir == 'up')? 'desc' : 'asc' ;
		
		$this->db->trans_start();
		
		
		//get me
		$me = $this->get($option_value_id);

		
		//get * from list where option = option_id && order < myorder (order by order desc limit 1)
		$items = $this
					->where('id !=', $me->id ) //make sure we dont select myself
					->where('shop_options_id', $me->shop_options_id ) //make sure it is the same parent option group
					->where( $selection , $me->order )
					->order_by('order', $orderby )
					->limit(1)
					->get_all();
		
		$tmp = 0;
		$po = 0;

		if($items)
		{
		
			//save to temp
			$tmp = $items[0]->order;
			$po = $me->order;
			
			//if for some reason they have the same order number
			//create a new number
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
					return FALSE;
				}
				
			}
			else
			{
				
				return FALSE;
			
			}

		}
		

	   
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE) 
		{ 
			
			return FALSE;
		}
		else
		{ 
			//return an array of items changed and their order values
			return array( 0 => $me->id, 1 => $items[0]->id );
		}
			
	
	}	
}


