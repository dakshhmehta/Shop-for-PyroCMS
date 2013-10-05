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
class Messages_m extends MY_Model 
{


    public $_table = 'shop_order_messages';

	
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	/**
	 * 
	 * @param Int $id The message id to mark as read
	 */
	public function markAsRead($id) 
	{

		$update_info = array(
			'status' => 1,	
		);
		
		return $this->db->update($this->_table, $update_info);
	}

	/**
	 * Message from customer
	 * 
	 * @param unknown_type $id
	 * @param unknown_type $message
	 */
	public function send($id, $message, $from_user = true) 
	{
		
		$data = array(
				'status' => 0,
				'order_id' => $id,
				'user_id' =>  $this->current_user->id,
				'subject' => strip_tags($message['subject']),
				'message' => strip_tags($message['message']),
				'date_sent' => time(),
				'user_name' => $message['user_name'],
				'replyto_id' => 0,
				'type' => 'user',
		);
		
		
		//$user_email = array();
		//$user_email['to'] = '';
		//$user_email['from'] = '';
		//$user_email['message'] = 'You have received a message from {{settings::site_name}}, please login to check your messages';
	
		// Send notification email
		// Events::trigger('email', $user_email, 'array');
		return $this->insert($data);
	}

}