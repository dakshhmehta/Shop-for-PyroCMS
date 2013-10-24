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
class Orders_m extends MY_Model 
{
    public $_table = 'shop_orders';
	
	
	public function __construct() 
	{
		parent::__construct();
	}
	

	/**
	 * This is where the order is recorded, The order info  is passed along side the cart and the session ID
	 *
	 *
	 * @param 	Array 	$inputs 	Input from confirm order, includes user id, session, total amounts etc..
	 * @param 	SFCart 	$cart 		The shopping cart Object
	 * @return	INT					If successfull - The Order ID
	 */
	public function create($inputs, $cart)
	{
	
		$this->db->insert('shop_orders', array(
				'user_id' => $inputs['user_id'],
				'cost_items' => $inputs['cost_items'], 
				'cost_shipping' => $inputs['cost_shipping'], 
				'cost_total' => ($inputs['cost_items'] + $inputs['cost_shipping']), 
				'shipping_id' => $inputs['shipping_id'],
				'gateway_id' => $inputs['gateway_method_id'],
				'billing_address_id' => $inputs['billing_address_id'],
				'shipping_address_id' => $inputs['shipping_address_id'],
				'session_id' => $inputs['session_id'], 
				'ip_address' => $inputs['ip_address'],	
				'trust_score' => $inputs['trust_score'],			
				'order_date' => time(),
		));
	
		// Get the ID of the record for the order Items table
		$order_id = $this->db->insert_id();
	
		$contents = array();
	
		foreach ($cart as $item) 
		{
	
			$contents[] = array(
					'order_id' => $order_id,
					'product_id' => $item['id'],
					'options' => json_encode($item['options']),
					'title' => $item['name'],
					'qty' => $item['qty'],
					'cost_item' => $item['price'],
					'cost_sub' => ($item['price'] * $item['qty']),
					'cost_base' => ($item['base']) /*always only 1 base price per item*/
			);
		}
	
		$this->db->insert_batch('shop_order_items', $contents);
		
		
	
		return $order_id;
	}


	public function set_payment_parm($id, $data_array)
	{
		//prepare the data
		$data = json_encode($data_array);

		$update_info = array(
				'data' => $data
		);
			
		$result = $this->update($id, $update_info);
		
		return $result;
	}
	

	/**
	 * Creates a note on a order - This is only visible to admins, do not getthis confused with messages
	 *
	 *
	 */
	public function create_note($order_id,$user_id, $message)
	{

		$contents = array(
			'order_id' => $order_id,
			'user_id' => $user_id,
			'message' => $message,
			'date' => time()
		);
   
		$this->db->insert('shop_order_notes', $contents);
		 
		return $order_id;
	}
	
	public function get_notes_by_order($order_id)
	{
	
		return $this->db->where('order_id',$order_id)->order_by('id desc')->get('shop_order_notes')->result();

	}
	
	/**
	 * By defgault it should get only unread messages, chnage read_tatus to 'all'
	 *
	 */
	public function get_messages_by_order($order_id, $read_status = 'unread')
	{
		if ($read_status=='unread') 
		{
			$this->db->where('status',1);
		}
		
		return $this->db->where('order_id',$order_id)->order_by('id desc')->get('shop_order_messages')->result();

	}
	
	/**
	 * Get all messages by status
	 *
	 */
	public function get_messages_by_status($read_status = 'unread')
	{
	
		if ($read_status=='unread') 
		{
			$this->db->where('status',1);
		}
		
		return $this->db->get('shop_order_messages')->result();

	}
	
	/**
	 *
	 *@deprecated - use addresses_m set_address
	 */
	public function set_address($input) 
	{
		$data = array(
				'user_id' => $input['user_id'],
				'email' => $input['email'],
				'first_name' => $input['first_name'],
				'last_name' => $input['last_name'],
				'company' => $input['company'],
				'address1' => $input['address1'],
				'address2' => $input['address2'],
				'city' => $input['city'],
				'state' => $input['state'],
				'country' => $input['country'],
				'zip' => $input['zip'],
				'phone' => $input['phone'],
		);
	
		if (isset($input['id'])) 
		{
			$this->db->where('id', $input['id']);
			$this->db->update('shop_addresses', $data);
			return $input['id'];
		} 
		else 
		{
			$this->db->insert('shop_addresses', $data);
			return $this->db->insert_id();
		}
	}
		

	
	public function set_status($id,$status) 
	{
	
		$update_info = array(
				'status' => $status
		);
			
		$result = $this->update($id, $update_info);
		
		return $result;
	
	}
	
	public function mark_as_paid($id) 
	{
	
		$update_info = array(
				'pmt_status' => 'paid'
		);
			
		$result = $this->update($id, $update_info);
		
		return $result;
	
	}



	public function admin_filter_count($filter) 
	{
		


		$this->db->reset_query();
		$this->_prepare_filter($filter);


		return $this->count_all();
		

	}

	public function admin_filter($filter,$limit,$offset) 
	{
		
		$this->db->reset_query();
		$this->_prepare_filter($filter);
		
		return $this->limit($limit)->offset($offset)->order_by('order_date','desc')->get_all();
		
	}
	
	/*pmt_status = pending|unpaid|partial_paid|paid|refunded*/
	
	private function _prepare_filter($filter) 
	{
	
		
		if (array_key_exists('order_status', $filter)) 
		{
			
			if ($filter['order_status'] =='all_open') 
			{
				$this->where('status', 'pending' );
				$this->or_where('status', 'processing' );	
				$this->or_where('status', 'complete' );				
				$this->or_where('status', 'placed' );
				$this->or_where('status', 'paid' );
				$this->or_where('status', 'shipped' );
				$this->or_where('status', 'returned' );
			}
			else if ($filter['order_status'] =='all_closed') 
			{
				$this->where('status', 'cancelled' );
				$this->or_where('status', 'closed' );
			}		
			else if ($filter['order_status'] =='all') 
			{
				/* ignor the flitering*/
			}				
			else 
			{
				$this->where('status', $filter['order_status'] );
			}

		}

	}
	
	/**
	 */
	public function get_all() 
	{
		$this->db->select('shop_orders.*, addr.email as customer_email');
		$this->db->select('CONCAT(addr.first_name, " ", addr.last_name) as customer_name', FALSE);
		$this->db->select('addr.city AS city', FALSE);
		$this->db->join('shop_addresses addr', 'shop_orders.billing_address_id = addr.id', 'left');
		$this->db->group_by('shop_orders.id');
		
		return parent::get_all();
	}
	
	
	/**
	 */
	public function get_all_by_user($user_id) 
	{
	
		$this->db->select('shop_orders.*, addr.email as customer_email');
		$this->db->where('shop_orders.user_id',$user_id);
		$this->db->select('CONCAT(addr.first_name, " ", addr.last_name) as customer_name', FALSE); /* TODO:Lets not concat, pass the array values and just print manually*/
		$this->db->select('CONCAT(addr.address1, " ", addr.address2, " ", addr.city , " ", addr.country, " ", addr.zip) as billing_address', FALSE);
		$this->db->select('addr.city AS city', FALSE);
		$this->db->join('shop_addresses addr', 'shop_orders.billing_address_id = addr.id', 'left');
		$this->db->group_by('shop_orders.id');
	
		return parent::get_all();
	}
	
	
	public function get_last($limit = 5) 
	{
		return $this->limit($limit)->get_all();
	}
	
	public function count_all($inc_complete = FALSE)
	{
	
		$this->db->from('shop_orders');
		if ($inc_complete) 
			return $this->db->count_all_results();
		else 
		{
			return $this->db->count_all_results();
		}
	}
	

	/**
	 * 
	 * @param INT $id The ID of the Address to retrieve. (Pass either billing address ID or Shipping Address ID)
	 * @return An array of containing the address  fields
	 */
	public function get_address($id) {  return $this->db->where('id', $id)->get('shop_addresses')->row();   }
	
	
	/**
	 * Get Shipping Method
	 * @param INT - $id Shipping Method ID
	 */
	public function get_shipping($id) {  return $this->db->where('id', $id)->get('shop_shipping')->row();  }
	
	
	/**
	 * Get Payment Gateway Details
	 * @param INT $id
	 */
	public function get_payment($id) {  return $this->db->where('id', $id)->get('shop_gateways')->row();  }
	
	
	/**
	 * Get All items in Order
	 * @param INT $id Order ID
	 */
	public function get_order_items($id) 
	{
		return $this->db
			->select('shop_products.*, shop_order_items.*')
			->join('shop_products', 'shop_order_items.product_id = shop_products.id')
			->where('order_id', $id)->get('shop_order_items')->result();
	}
	
	/**
	 * If a product exist in table then return TRUE
	 * @param INT $id Order ID
	 */
	public function has_item($id)  
	{		
		$items =  $this->db->select('product_id')->where('product_id', $id)->limit(1)->get('shop_order_items')->row();
		return (count($items) > 0)? TRUE : FALSE ;
	}
	
	public function get_user_data($user_id) 
	{
		return $this->db->where('user_id', $user_id)->get('profiles')->row();
		
	}
}
