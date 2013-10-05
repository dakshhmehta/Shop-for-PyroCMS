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
class Audit_m extends MY_Model {


	public $_table = 'shop_audit';

	public function __construct() 
	{
		parent::__construct();

	}

	/**
	 * Requires a simple array of 3 fields, key 0, and key 1 both must be string fields, key 0 is the area, key 1 is the description
	 */
	public function create($input) 
	{
		
		$to_insert = array(
			'area' => $input[0],
			'function' => $input[1],
			'description' => $input[2],
		);

		return $this->insert($to_insert); 
	   
	}

	
}
