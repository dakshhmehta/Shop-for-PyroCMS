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
class Shop_files_m extends MY_Model 
{
    public $_table = 'shop_product_files';
	
	
	public function __construct() 
	{
		parent::__construct();
	}



	public function get_download_count($order_id, $product_id, $file_id)
	{
		$result = $this->db->where('order_id', $order_id)->where('product_id', $product_id)->where('file_id', $file_id)->get('shop_downloads')->result();

		if($result)
		{
			var_dump($result);die;
		}
		die;
		return -1;
	}


	/**
	 * re->pass = Boolean
	 * re->file = File
	 * re->download_count = INT
	 *
	 * 
	 * @param  [type] $file_id  [description]
	 * @param  [type] $order_id [description]
	 * @return [type]           [description]
	 */
	public function do_download($file_id, $order_id)
	{
		$returnFile = new stdClass();


		// First get the file
		$returnFile->file = $this->get($file_id);
		$returnFile->pass = ($returnFile->file)? TRUE : FALSE;
		$returnFile->download_count = 0;
		$returnFile->message = 'not initialized';



		//See if a record exist for this customer
		if($this->key_exist($order_id, $returnFile->file->product_id, $file_id))
		{

			$record = $this->db->where('order_id', $order_id)->where('product_id', $returnFile->file->product_id)->where('file_id', $file_id)->limit(1)->get('shop_downloads')->result();

			$record = $record[0];

			if($record->attempts >= $record->max_attempts)
			{
				$returnFile->pass = FALSE;
				$returnFile->message = 'You have reached the maximum number of downloads for this file.';
			}
		
			$to_update = array(
					'ip_addresss' => $this->input->ip_address(), 
					'user_agent' => $this->agent->agent_string(), 
					'attempts' => ($record->attempts + 1),
			);

	    	$this->db->where('order_id', $order_id)->where('product_id', $returnFile->file->product_id)->where('file_id', $file_id);
			$this->db->update('shop_downloads', $to_update );
		}
		else //if not create a record for tracking
		{

			$to_insert = array(
					'order_id' => $order_id,
					'product_id' => $returnFile->file->product_id,
					'file_id' => $file_id,
					'ip_addresss' => $this->input->ip_address(), 
					'user_agent' => $this->agent->agent_string(), 
					'attempts' => 1,
					'max_attempts' => 3,
					'pin' => substr(md5('AE'.rand(1,999)),1,6),
			);

			$this->db->insert('shop_downloads', $to_insert );
			
		}

		//otherwise we fail and do not allow to download
		return $returnFile;
	}
	
	/**
	 * Check to see if the key values exist
	 * 
	 * @param  [type] $order_id   [description]
	 * @param  [type] $product_id [description]
	 * @param  [type] $file_id    [description]
	 * @return [type]             [description]
	 */
	private function key_exist($order_id, $product_id, $file_id)
	{

	    $this->db->where('order_id', $order_id)->where('product_id', $product_id)->where('file_id', $file_id);

	    $query = $this->db->get('shop_downloads');

	    if ($query->num_rows() > 0)
	    {
	        return TRUE;
	    }

	    return FALSE;
	}



	/**
	 * This creates a file in the DB
	 * 
	 * @param  [type] $input [description]
	 * @return [type]        [description]
	 */
	public function add_file($input)
	{

		$to_insert = array(
				'product_id' => $input['product_id'],
				'filename' => $input['filename'], 
				'type' => $input['type'], 
				'ext' => $input['ext'],
				'filesize' => $input['filesize'],
				'data' => $input['data'],
				'date_added' => date("Y-m-d H:i:s"),
		);

		$this->db->insert('shop_product_files', $to_insert );
	
	}	

	public function delete_file($file_id)
	{
		$this->db->where('id', $file_id);
		return $this->db->delete('shop_product_files'); 		
	}


	public function get_files($product_id)
	{
		return $this->db->select('id,product_id,filename,ext,type')->where('product_id',$product_id)->get('shop_product_files')->result(); 
	}
	


	/**
	 * First get all product by this order
	 * Then get each file and return in the right format for the plugin
	 * 
	 * @param  [type] $order_id [description]
	 * @return [type]           [description]
	 */
	public function get_files_by_order($order_id)
	{
		$products = $this->db->select('product_id,order_id')->where('order_id',$order_id)->get('shop_order_items')->result(); 

		$files = array();
		foreach($products as $product)
		{
			$f = $this->db->select('id,product_id,filename,ext,type')->where('product_id',$product->product_id)->get('shop_product_files')->result(); 	

			foreach ($f as  $value) 
			{
				$files[] = $value;
			}
		}	

		return $files;
		
	}	

	
}
