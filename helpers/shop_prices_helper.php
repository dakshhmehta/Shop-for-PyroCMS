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
if (!function_exists('hlp_get_price')) 
{

	/**
	 * This is used to get the right price for the cart
	 *
	 * At time of display in the shop/product page, prices may come from
	 * either the product itself, a product MID price table or pgroup_prices MID
	 *
	 * So adding to the cart we need to get the right price.
	 *
	 *
	 *
	 *
	 * There is also a heirachy as a product may have all or some of the prices added in these fields so  it
	 * is important to know how the heirachy works.
	 *
	 * 1: Product Price
	 * 2: Qty Discount Price (tier levels)
	 * 3: MultipleItems Discount (MID) (tier levels)
	 * 
	 */
	function hlp_get_price(&$product, $product_qty, $new_qty) 
	{

		$ci =& get_instance();
		
		$ci->load->model('shop/product_prices_m');
		$ci->load->model('shop/pgroups_m');
		$ci->load->model('shop/pgroups_prices_m');



		//
		// We arerequesting the MID price by passing the new_qty and the price it already has
		//
		$price_level_1 = $ci->product_prices_m->get_discounted_price($product->id, $product_qty, $product->price_at);    


		if($product->pgroup_id > 0)
		{
			$price_level_1 = $ci->pgroups_prices_m->get_discounted_price($product->pgroup_id, $new_qty, $price_level_1);    
		}

		$product->price_at = $price_level_1;
 

	}


}

