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
class Twoducks_debug
{
	protected $buffer;
	protected $evt_count;

	public function __construct()
	{
		$this->buffer = "";

	}

	public function add($str)
	{
		$this->evt_count++;
		$this->buffer .= "(".$this->evt_count.") -". $str . "<br />";
		
	}

	public function show()
	{	
		$t = "<pre style='background-color:#000;color:#fff'>";
		$t .= $this->buffer;
		$t .= "</pre>";

		return $t;
	}	

}

class Twoducks_base extends Twoducks_debug
{

	public function __construct() 
	{
		parent::__construct();
	}


	/** The basic/default calculation method
	 *
	 * 
	 * @param  INT 	$qty  The quantity of items to calc
	 * 
	 * @return Float      Returns ZERO
	 */
	protected function calc_default($item)
	{
		$qty = $package->item_count;
		
		return 0;
	}



	/** Cards
	 *
	 * 1-4 		: cards $2 flat rate 
	 * 5-10 	: cards $5 flat rate
	 * 11- 25 	: cards $10 flat rate
	 * 26+ 		: cards $15 flat rate
	 *
	 * @param  INT $qty 	The quantity of items to calc
	 * @return Float      	Returns the cost of shipping for the qty given
	 */
	protected function calc_cards($package)
	{
		
		$qty = $package['count'];


		if($qty <= 4) return 2.00;

		if($qty <= 10) return 5.00;

		if($qty <= 25) return 10.00;
		

		//26 and larger
		return 15.00;

	}

	protected function calc_calandar($package)
	{

		$qty = $package['count'];

		return ($qty * 2.00);

	}



	/**
	 * Custom invitations
	 * 10 flat rate
	 * @param  [type] $qty [description]
	 * @return [type]      [description]
	 */
	protected function calc_invitations($package)
	{

		$qty = $package['count'];
		
		return 10;
	}


	protected function calc_invitation_pack($package)
	{
		$qty = $package['count'];

		return $this->_price_step($qty, 5.00, 2);			
	}



	/**
	 * Tags
	 * 1-5 pack of tags $2 flat rate
	 * 
	 * @param  [type] $qty [description]
	 * @return [type]      [description]
	 */
	protected function calc_tags($package)
	{
		$qty = $package['count'];

		return $this->_price_step($qty, 2.00, 5);		

	}




	/**
	 * Birth announcements : $10 flat rate
	 */
	protected function calc_birth($package)
	{
		$qty = $package['count'];
		
		return 10;
	}
	


	/**
	 * 
	 * If there exist to be a printed xmas-post card the rate is $10 flat rate for 1 or many - not based on qty
	 * 
	 * @param  [type] $package [description]
	 * @return [type]          [description]
	 */
	protected function calc_pxmascards($package)
	{
		$qty = $package['count'];
		$found = FALSE;
		
		foreach($package['items'] as $item)
		{

			foreach( $item['options'] as $option_key => $selected_option_value)
			{
	
				$_user_data = trim($selected_option_value['user_data']);

				switch ( $_user_data ) 
				{
					case 'digital':
						break;
					case 'printed':				
					default:
						$found = TRUE;
						break;
				}

			}

		}

		if($found)	
		{
			return 10.00;
		}

		//not found implies digital only
		return 0.00;
	}




	protected function calc_name_charts($package)
	{

		$cost = 0;
		$count_print_1 = 0;
		$count_print_2 = 0;		

		$qty = $package['count'];


		foreach($package['items'] as $item)
		{

			foreach( $item['options'] as $option_key => $selected_option_value)
			{

				$_user_data = trim($selected_option_value['user_data']);

				switch ( $_user_data ) 
				{
					case 'print_1':
						$count_print_1 += $item['qty'];
						break;
					case 'print_2':
						$count_print_2 += $item['qty'];
						break;
					case 'framed':					
					default:
						break;
				}

			}

		}			

 
		$cost += $this->calc_name_charts_unframed_8_10_and_8_12($count_print_1);
 
		$cost += $this->calc_name_charts_unframed_10_14($count_print_2);
 

		return $cost;
	}


	protected function calc_framed_name_charts($package)
	{

		$cost = 0;
		$count_print_1 = 0;
		$count_print_2 = 0;		
		$count_framed = 0;

		$qty = $package['count'];

		foreach($package['items'] as $item)
		{

			foreach( $item['options'] as $option_key => $selected_option_value)
			{

				$_user_data = trim($selected_option_value['user_data']);

				switch ( $_user_data ) 
				{
					case 'framed':					
						$count_framed += $item['qty'];
						break;
					default:
						break;					
				}

			}

		}			

  
		$cost += $this->calc_name_charts_framed($count_framed);


		return $cost;
	}



	/**
	 * Posters
     * 
     * 1-5 posters $10 flat rate
     * 
	 * @return [type] [description]
	 */
	protected function calc_posters($package)
	{
		$qty = $package['count'];
		
		return $this->_price_step($qty, 10, 5);		
	}



	protected function calc_flash_cards($package)
	{
		$qty = $package['count'];
		
		return $this->_price_step($qty, 2, 2);		
	}

	protected function calc_prints($package)
	{
		$qty = $package['count'];

		$a3_qty = 0;
		$a4_qty = 0;

		$slug ='prints-sizes';

		$cost = 0;

	
		foreach($package['items'] as $item)
		{

			foreach( $item['options'] as $option_key => $selected_option_value)
			{

				$_user_data = trim($selected_option_value['user_data']);
		 
				switch ( $_user_data ) 
				{
					case 'a3':
						$a3_qty += $item['qty'];
						break;
					case 'a4':
						$a4_qty += $item['qty'];						
						break;
					default: break;
				}

			}

		}			


		//
		// A3
		$cost += $this->_price_step($a3_qty, 10, 5);

		//
		// A4
		$cost += $this->_price_step($a4_qty, 5, 5);
			
			
		return $cost;
	}


	
	/**
	 * $2 for 1-5
	 * 
	 * @param  [type] $package [description]
	 * @return [type]          [description]
	 */
	protected function calc_gift_wrap($package)
	{
		$qty = $package['count'];
		
		return $this->_price_step($qty, 2, 5);		
	}





	protected function calc_name_charts_unframed_8_10_and_8_12($qty)
	{
		if($qty == 0)
			return 0.00;

		return $this->_price_step($qty, 10.00, 5);		
	}

	protected function calc_name_charts_unframed_10_14($qty)
	{
		if($qty == 0)
			return 0.00;

		return $this->_price_step($qty, 10.00, 5);
	}


	protected function calc_name_charts_framed($qty)
	{
		if($qty == 0)
			return 0.00;
		
		$cost = 0;


		//add the 25
		if($qty >= 1) $cost = 25.00;


		if($qty > 1) 
		{
			$nqty = $qty - 1;

			$cost += ($nqty * 10.00);
		}

		return $cost;
	
	}	


	protected function _price_step($qty, $step_cost, $max_in_group)
	{

		$_COST = $step_cost;
		$_MAX = $max_in_group;


		if($qty <= 0)
			return 0;

		$multiplier = ($qty / $_MAX);


		$multiplier = ceil($multiplier);

		$postage = ($multiplier * $_COST);

		return $postage;

	}	


	
}
