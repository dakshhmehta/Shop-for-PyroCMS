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
 * @package		Audit Model Contoller for NITRO-CART
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
