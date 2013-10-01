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
class Twoducks_ShippingMethod 
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


	public $fields = array(	);
	
	
	public function __construct() {		}

	
	public function form($options) { return $options; }

	public function run($options)  { return $options; }



	public function calc($options, $packages, $from_address = array(), $to_address = array() )
	{


		$cost = 0;
		$handling = 0;
		$discount = 0;



		foreach ($packages as $package)
		{	


			//
			// Remove any unnessesary items from package,
			// items that do not require shipping
			//
			$this->clean_package($package);




			//var_dump($package);
			//default calculation method
			$func = 'calc_cards';

			switch ($package->title) 
			{

				case 'invitation':
					$func = 'calc_invitations';

					break;
				case 'posters':
					$func = 'calc_posters';
					break;
				case 'cards':
				default:
					$func = 'calc_cards';
					break;

			}

			//var_dump($package->item_count);

			//now we have the calc method, go there and calc
			$cost += $this->$func($package->item_count);

		}

		//
		// trim shipping does 1 of 2 things.
		// It will round up if shipping is too low,
		// or round down if shipping is too high
		//
		$cost = $this->trim_shipping($cost);

		//echo $cost;die;


		return array($this->id,'Shipping','Australia Wide Shipping', $cost, $handling, $discount); // == $0 total

	}

	/**
	 * Remove items that do not require shipping
	 * @param  [type] $package [description]
	 * @return [type]          [description]
	 */
	private function clean_package(&$package)
	{


		foreach($package->items as $key => $val)
		{
			if(isset($package->items[$key]['options']['delivery-type-inv']))
			{
				if($package->items[$key]['options']['delivery-type-inv']['value'] == 'digital_file')
				{
					// Remove from package
					unset($package->items[$key]);
					
				}
			}
		}

		return $package;
	}




	/**
	 *
	 * 
	 * 1-4 cards $2 flat rate (so if they bought: one card for $5 + $2 postage would be $7 or if they bought  four cards for $16 + $2 postage would be $18)
	 * 5-10 cards $5 flat rate
	 * 11- 25 cards $10 flat rate
	 * 26+ cards $15 flat rate
	 *
	 * @param  [type] $qty [description]
	 * @return [type]      [description]
	 */
	private function calc_cards($qty)
	{
		if($qty <= 4) return 2.00;

		if($qty <= 10) return 5.00;

		if($qty <= 25) return 10.00;

		//
		//26 and larger
		//
		return 15.00;

	}


	/**
	 * Posters
     * 
     * 1-5 posters $10 flat rate
     * 
	 * @return [type] [description]
	 */
	private function calc_posters($qty)
	{

		$max = 5;

		if($qty < 5)
		{
			return 10.00;
		}


		$val = ceil($qty / 5);

		return $val;

	}



	private function calc_invitations($qty)
	{
		return 15;
	}

	/**
	 * Trims shipping cost - only call after your shipping calcs
	 * 
	 * @param  [type] $cost [description]
	 * @return [type]       [description]
	 */
	private function trim_shipping($cost)
	{

		$min_shipping = 0.00;

		return ($cost < $min_shipping)?  $min_shipping : $cost ;

	}

	
}
