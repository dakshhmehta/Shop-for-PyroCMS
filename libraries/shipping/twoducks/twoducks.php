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

include_once( dirname(__FILE__) . '/'. 'twoducks_base.php');
include_once( dirname(__FILE__) . '/'. 'twoducks_packages.php');

class Twoducks_ShippingMethod extends Twoducks_base
{

	public $name =  'Two Ducks Custom Shipping'; 
	public $desc = 'Australia wide - Shipping';
	public $author = 'inspiredgroup.com.au';
	public $website = 'http://inspiredgroup.com.au';
	public $version = '1.0';
	public $image = '';


	public $fields = array(	
		array(
			'field' => 'title',
			'label' => 'Title',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'options[shipping_min]',
			'label' => 'Shipping Charge Per Order',
			'rules' => 'trim|max_length[5]|is_numeric|required'
		),
		array(
			'field' => 'options[shipping_max]',
			'label' => 'Handling',
			'rules' => 'trim|max_length[5]|is_numeric|required'
		),
		array(
			'field' => 'options[handling]',
			'label' => 'Handling',
			'rules' => 'trim|max_length[5]|is_numeric|required'
		)				
	);
	
	
	public function __construct() 
	{
		parent::__construct();

	}

	
	public function form($options) { return $options; }

	public function run($options)  { return $options; }



	public function calc($options, $items, $from_address = array(), $to_address = array() )
	{

		//var_dump($items);die;


		$this->package_list = new twoducks_packages();

		$cost = 0;

		$shippable_item_count = 0; //if no shiipable items - return free shpping

		foreach ($items as $item)
		{	

			$shippable_item_count++;


			if( ($item['ignor_shipping']==1) OR ($item['ignor_shipping']=='1') )
			{
				continue;
			}


			//default calculation method
			$func = 'calc_cards';

			switch ($item['user_data']) 
			{

				case 'cards':
					$this->package_list->add($item, 'cards' , 'calc_cards');
					break;

				case 'invitations':
					$this->package_list->add($item, 'invitations' , 'calc_invitations');
					break;	


				case 'invitation-pack':
					$this->package_list->add($item, 'invitations' , 'calc_invitation_pack');	
					break;	


				case 'tags':
					$this->package_list->add($item, 'tags' , 'calc_tags');					
					break;


				case 'birth':
					$this->package_list->add($item, 'birth' , 'calc_birth');		
					break;

				case 'personalized-xmas-postcards':
					$this->package_list->add($item, 'personalized-xmas-postcards' , 'calc_pxmascards');							
					break;
					
				case 'name-charts':
					$this->package_list->add($item, 'name-charts' , 'calc_name_charts');						
					break;


				case 'posters':
					$this->package_list->add($item, 'posters' , 'calc_posters');
					break;


				case 'flash-cards':
					$this->package_list->add($item, 'flash-cards' , 'calc_flash_cards');
					break;


				case 'calandar':
					$this->package_list->add($item, 'calandar' , 'calc_calandar');
					break;

				case 'prints':
					$this->package_list->add($item, 'prints' , 'calc_prints');					
					break;

				case 'gift-wrap':
					$this->package_list->add($item, 'gift-wrap' , 'calc_gift_wrap');						
					break;

				case 'framed-name-charts':
					$this->package_list->add($item, 'framed-name-charts' , 'calc_framed_name_charts', 'post');						
					break;

				default:
					break;

			}

			
		}


		//Do some Pre calc on the packages + items
		$cost += $this->calc_package($this->package_list->packages, 'pre');


		// trim shipping does 1 of 2 things. It will round up if shipping is too low,or round down if shipping is too high
		$this->trim_shipping($cost, $options, $shippable_item_count);


		// Now do some POST calc for items that MUST be calc after trimming
		$cost += $this->calc_package($this->package_list->packages, 'post');
		

		//add handling
		$this->add_handling_charge($cost,$options);


	 	//return the cost
		return $cost; 

	}


	private function calc_package($packages, $mode = 'pre')
	{
		$cost = 0;

		foreach($packages as $package)
		{
			if($package['calc-mode'] == $mode)
			{
				//get the function name
				$func = $package['function'];

				//now we have the calc method, go there and calc
				$cost += $this->$func($package);	
				
			}		
		}	

		return $cost;

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

			$handling = $options['handling'];
			$min_shipping = $options['shipping_min'];
			$max_shipping = $options['shipping_max'];


			//check min
			$cost = ($cost < $min_shipping)?  $min_shipping : $cost ;

			if($max_shipping > 0)
			{
				//check max
				$cost =  ($cost > $max_shipping)?  $max_shipping : $cost ; 
			}


		}

	}

	private function add_handling_charge(&$cost,$options)
	{
		$handling = $options['handling'];

		if($cost > 25.00)
		{
			return;
		}
	
		$cost += $handling;
	
	}
	
}
