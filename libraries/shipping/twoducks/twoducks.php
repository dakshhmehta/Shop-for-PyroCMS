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
	
	
	public function __construct() 
	{
		parent::__construct();
	}

	
	public function form($options) { return $options; }

	public function run($options)  { return $options; }



	public function calc($options, $packages, $from_address = array(), $to_address = array() )
	{


		$this->add('Start calc for:' . $this->title);

		$cost = 0;
		$handling = 0;
		$discount = 0;

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
		$this->trim_shipping($cost, $options, $shippable_item_count);


		//now we add on the framed charts as they do not reuire trimming
		foreach ($packages as $package)
		{	
			$cost += $this->calc_framed_name_charts($package);
		}


		$this->add('shippable count: ' .$shippable_item_count);
		//echo $this->show();
		//die;


	 

		return array($this->id,$this->title,$this->desc, $cost, 0, 0); // == $0 total

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


		//$count = 0;
		foreach($package->items as $key => $val)
		{
			//$count++;

			
			//var_dump($val);

			
			//if($count >= 2)
			

	
			if( ($val['ignor_shipping']==1) OR ($val['ignor_shipping']=='1') )
			{


				$package->item_count = ($package->item_count - 1);
				unset($package->items[$key]);
				continue;
				
			}
		

			/*
			if(isset($package->items[$key]['options']['delivery-type-inv']))
			{

				if($package->items[$key]['options']['delivery-type-inv']['value'] == 'digital')
				{
					// Remove from package
					unset($package->items[$key]);
					continue;
					
				}
			}

			if(isset($package->items[$key]['options']['delivery-type-birth']))
			{
				

				if($package->items[$key]['options']['delivery-type-birth']['value'] == 'digital')
				{
					// Remove from package
					unset($package->items[$key]);
					continue;
					
				}
			}
			*/


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

			$handling = $options['handling'];
			$min_shipping = $options['shipping_min'];
			$max_shipping = $options['shipping_max'];


			$this->add( "Before Trim:" . $cost   );

			//
			// Add handling
			//
			$cost += $handling;

			//check min
			$cost = ($cost < $min_shipping)?  $min_shipping : $cost ;

			if($max_shipping > 0)
			{
				//check max
				$cost =  ($cost > $max_shipping)?  $max_shipping : $cost ; 
			}

			$this->add( "After Trim:" . $cost   );

		}

	}

	
}
