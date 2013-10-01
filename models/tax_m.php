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
 * @package		Tax Model Contoller for NITRO-CART
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
				$input['price_at'] 		=  round($price ,2);
				$input['price_bt'] 		=  round($val ,2);
				break;
			case TaxMode::Exclusive:
			default:
				$val 					=  ( $tax_rate * $price / 100) +  $price;
				$input['price_bt'] 		=  round($price ,2);
				$input['price_at'] 		=  round($val ,2);
				break;

		}


		return $input;
	}

	
}
