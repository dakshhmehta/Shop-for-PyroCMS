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

class Twoducks_ShippingMethod extends Twoducks_base
{

	public $name = 'Two Ducks Custom Shipping'; 
	public $title =  'Two Ducks Custom Shipping'; 
	public $desc = 'Australia wide - Shipping';
	public $author = 'inspiredgroup.com.au';
	public $website = 'http://inspiredgroup.com.au';
	public $version = '1.0';
	public $image = '';

	public $_shipping = 0;
	public $_handling = 0;
	public $_discount = 0;


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
	
	
	public function __construct() {		}

	
	public function form($options) { return $options; }

	public function run($options)  { return $options; }



	public function calc($options, $packages, $from_address = array(), $to_address = array() )
	{

		$options['shipping_min'];
		$options['shipping_max'];

		$cost = 0;
		$handling = $options['handling'];
		$discount = 0;



		foreach ($packages as $package)
		{	


			//
			// Remove any unnessesary items from package,
			// items that do not require shipping
			//
			$this->prepare_package($package);




			//var_dump($package);
			//default calculation method
			$func = 'calc_cards';

			switch ($package->title) 
			{


				case 'cards':
					$func = 'calc_cards';
					break;


				case 'invitations':
					$func = 'calc_invitations';
					break;	


				case 'invitation-pack':
					$func = 'calc_invitation_pack';
					break;	


				case 'tags':
					$func = 'calc_tags';
					break;



				case 'birth':
					$func = 'calc_birth';
					break;

					
				case 'name-charts':
					$func = 'calc_name_charts';
					break;


				case 'posters':
					$func = 'calc_posters';
					break;


				case 'flash-cards':
					$func = 'calc_flash_cards';
					break;


				case 'prints':
					$func = 'calc_prints';
					break;

				case 'free-shipping':
				default:
					$func = 'calc_default';
					break;

			}


			//now we have the calc method, go there and calc
			$cost += $this->$func($package);

		}




		//
		// trim shipping does 1 of 2 things.
		// It will round up if shipping is too low,
		// or round down if shipping is too high
		//
		$cost = $this->trim_shipping($cost);

		//echo $cost;die;


		return array($this->id,$this->title,$this->desc, $cost, $handling, $discount); // == $0 total

	}



	/**
	 * 
	 * Remove items that do not require shipping
	 *
	 *
	 * 
	 * @param  [type] $package [description]
	 * @return [type]          [description]
	 */
	private function prepare_package(&$package)
	{



		foreach($package->items as $key => $val)
		{

			if(isset($package->items[$key]['options']['delivery-type-inv']))
			{

				if($package->items[$key]['options']['delivery-type-inv']['value'] == 'digital')
				{
					// Remove from package
					unset($package->items[$key]);
					
				}
			}

			if(isset($package->items[$key]['options']['delivery-type-birth']))
			{
				

				if($package->items[$key]['options']['delivery-type-birth']['value'] == 'digital')
				{
					// Remove from package
					unset($package->items[$key]);
					
				}
			}




		}

		return $package;
	}






	/**
	 * Trims shipping cost - only call after your shipping calcs
	 * 
	 * @param  [type] $cost [description]
	 * @return [type]       [description]
	 */
	private function trim_shipping($cost)
	{

		$min_shipping = 2.00;
		$max_shipping = 15.00;

		//check min
		$cost = ($cost < $min_shipping)?  $min_shipping : $cost ;

		//check max
		$cost =  ($cost > $max_shipping)?  $max_shipping : $cost ;


		return $cost;

	}

	
}
