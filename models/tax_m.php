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
class Tax_m extends MY_Model {


	public $_table = 'shop_tax';

	public function __construct() 
	{
		parent::__construct();

	}

	public function create($input) 
	{

		$to_insert = array(
			'name' => $input['name'],
			'rate' => $input['rate'],
		);

		return $this->insert($to_insert); 
	   
	}

	public function edit($id, $input) 
	{
	
		$update_record = array(
			'name' => $input['name'],
			'rate' => $input['rate'],	
		);
		
		return $this->update($id, $update_record); 

	}
	
	

	/**
	 * Calculates the price based on
	 *
	 * @param Array Input
	 * @return The modifed array that contains the calculated values
	 */
	public function calc_price($input) 
	{

		//var_dump($input);die;

		$price = $input['price'];
		$direction = $input['tax_dir'];
		$tax_id = $input['tax_id'];
		 


		// Get the tax value from our db
		$taxobj = $this->get($tax_id);
		

		$tax_rate = $taxobj->rate;
		

		//
		// Calc for tax inc/excl
		//
		switch( $direction )
		{ 

			case TaxMode::Inclusive:
				$val 					=  $price / (1 + ($tax_rate/100));
				//$input['price_at'] 		=  round($price ,2);
				//$input['price_bt'] 		=  round($val ,2);
				break;
			case TaxMode::Exclusive:
			default:
				$val 					=  ( $tax_rate * $price / 100) +  $price;
				//$input['price_bt'] 		=  round($price ,2);
				//$input['price_at'] 		=  round($val ,2);
				break;

		}


		return $input;
	}

	
}
