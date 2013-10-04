<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
/*
 * NITRO-CART Developer Preview
 * 
 *
 *
 * Copyright (c) 2013, Salvatore Bordonaro
 * All rights reserved.
 *
 * Author: Salvatore Bordonaro
 * Version: 0.90.0.000
 *
 * Credits: - Salvatore Bordonaro (DB, Development, JavaScript)
 *
 * 			- Guido Grazioli (DB and Development)
 *
 *          - Alison McDonald (Usability, Language and Testing)
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */

/**
 * NITRO CART	An explosive e-commerce solution for PyroCMS - ......and 'Open Source'
 *
 * @author		Salvatore Bordonaro
 * @version		0.90.0.000
 * @website		http://www.inspiredgroup.com.au/
 * @package		Transactions Model Contoller for NITRO-CART
 * @system		PyroCMS 2.1.x
 *
 */
class Transactions_m extends MY_Model 
{


    public $_table = 'shop_transactions';
	
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function create($input) 
	{

		$input['timestamp'] = time();
	
		return $this->insert($input); 

	}	
	
	
	public function log_new_order($id) 
	{
		return $this->log($id, 0,  0 ,'CUSTOMER', 'Order Placed', 2);
	}

	public function log_trust_data($id, $score,  $events = array()) 
	{
		return $this->log($id, 0,  0 , 'Trust-Score' , 'Trust score awarded:' . $score , 2, $events ) ;
	}


	/**
	 * log($id, $credit,  $refund ,$user = 'SYSTEM', $message = '',$status=2) 
	 *
	 *
	 * @param INT $id Order ID
	 * @param DEC $credit Amount to credit the Shop
	 * @param DEC $refund Amount to refund to customer
	 * @param String $user User name - not the Actual usename but the scope - SYSTEM/ADMIN or CUSTOMER - Could also be a Payment Gateway
	 * @param String $message Message to record in System
	 * @param INT $status Status Level to record (Pending, Refected or Accepted) 0/1/2
	 *
	 * @return INT The ID of the record created
	 *
	 */
	public function log($id, $credit,  $refund ,$user = 'SYSTEM', $message = '',$status=2, $data =array()) 
	{
	
		$to_insert = array(
				'order_id' => $id,
				'txn_id' => '',
				'status' => $status,
				'reason' => $message,
				'refund' => $refund,
				'amount' => $credit,
				'gateway' => 0,
				'user' => $user,
				'data' => json_encode($data),
		);
	
		return $this->create($to_insert); //returns id
	}
   

}
