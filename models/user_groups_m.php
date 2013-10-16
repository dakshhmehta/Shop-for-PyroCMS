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
class User_groups_m extends MY_Model 
{
	
	
	public $_table = '';//$this->db->dbprefix('groups');
		
		
	public function __construct() 
	{
	
		parent::__construct();


		$this->_table = $this->db->dbprefix('groups');
		
	}


	public function get_group_by_name($name)
	{

		$data = parent::get_by(array('name' =>$name) );

		if($data)
		{
			return $data;
		}

		return FALSE;

	}
	
	
	
	
}





























