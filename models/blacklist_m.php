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
class Blacklist_m extends MY_Model 
{

	private $_description_tags = '<b><div><strong><em><i><u><ul><ol><li><p><span><a><br><br />';
    public $_table = 'shop_blacklist';



    public $_validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'lang:brand_name',
				'rules' => 'trim|required|max_length[100]'
			),
			array(
				'field' => 'value',
				'label' => 'Value',
				'rules' => 'trim|max_length[200]|required'
			),	
			array(
				'field' => 'enabled',
				'label' => 'Enabled',
				'rules' => 'trim'
			),							
			
		);



	
	public function __construct() 
	{
		parent::__construct();
	}






	
	public function create($input)
	{

		$row = array(
			'name' => $input['name'],
			'method' => $input['method'],
			'value' =>  $input['value'],
			'enabled' => (isset($input['enabled']))?1:0,
		);		

		return $this->insert($row);

	}



	public function edit($id, $input) 
	{
		// Prepare
		$row = array(
			'name' => $input['name'],
			'method' => $input['method'],
			'value' =>  $input['value'],
			'enabled' => (isset($input['enabled']))?1:0,
		);	
		
		return $this->update($id, $row);
	}


	

	

	
	public function build_method_dropdown($current_id = -1) 
	{

		$items = array();
		$items[0]  = 'None';
		$items[1]  = 'IP Address';
		$items[2]  = 'Email';
		$items[3]  = 'Country';


		// Create the drop down
        $drop = form_dropdown('method', $items, $current_id );

        // Return it
        return $drop;	
	}



}