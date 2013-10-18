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
class Widget_Shop_My_Cart extends Widgets
{
	public $title		= array(
		'en' => 'Shop - My Cart',
	);
	public $description	= array(
		'en' => 'Display a list of items user added to cart',
	);
	public $author		= '';
	public $website		= '';
	public $version		= '1.2';


	public $fields = array();

	public function run($options)
	{

		$count = $this->sfcart->total_items();

		if($count==NULL)
			$count = 0;

		return array(
				'total' => $this->sfcart->total_cost_contents(),
				'items_count' => $count,
				'contents' => $this->sfcart->contents(),

		);
	}	
}
