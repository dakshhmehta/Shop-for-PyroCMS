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
class FlatratePerOrder_ShippingMethod {

	public $name = 'Flat Rate Per Order'; 
	public $title = 'Flat Rate Per Order'; 
	public $desc = 'Flat Rate Per Order';
	public $author = 'inspiredgroup.com.au';
	public $website = 'http://inspiredgroup.com.au';
	public $version = '1.0';
	public $image = '';

	public $_shipping = 0;
	public $_handling = 0;
	public $_discount = 0;


	public $fields = array(
		array(
			'field' => 'options[amount]',
			'label' => 'Shipping Charge Per Order',
			'rules' => 'trim|max_length[5]|is_numeric|required'
		),
	);
	
	
	public function __construct() {		}

	public function form($options) { return $options; }

	public function run($options)  { return $options; }

	public function calc($options, $packages, $from_address = array(), $to_address = array() )
	{
		
		$cost = 0;

		$shippable_item_count = 0; //if no shiipable items - return free shpping
		
		foreach ($packages as $package)
		{	

			//
			// Remove any unnessesary items from package,
			// items that do not require shipping
			//
			$this->prepare_package($package);


			//
			// If no items left in package - do not send it (do not calc)
			//
			if(!$package->item_count)
			{
				continue;
			}

			
			$shippable_item_count += $package->item_count;


		}			


		$this->trim_shipping($cost, $options, $shippable_item_count);



		return $cost;

	}
	


	private function prepare_package(&$package)
	{

		foreach($package->items as $key => $val)
		{

			if( ($val['ignor_shipping']==1) OR ($val['ignor_shipping']=='1') )
			{

				$package->item_count = ($package->item_count - 1);
				unset($package->items[$key]);
				continue;
				
			}
		
		}
	
	}



	/**
	 * Trims shipping cost - only call after your shipping calcs
	 * 
	 * @param  [type] $cost [description]
	 * @return [type]       [description]
	 */
	private function trim_shipping(&$cost, $options, $items_count=0)
	{

		if($items_count == 0)
		{
			$cost = 0;
		}
		else
		{

			$cost = floatval($options['amount']);

		}

	}


	
}




