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
class Widget_Shop_Wishlist extends Widgets 
{

	public $title = array(
		'en' => 'Shop - Wishlist',
	);
	public $description = array(
		'en' => 'Display the Current Users Wishlist',
	);
	public $author = 'Salvatore Bordonaro';
	public $website = 'http://inspiredgroup.com.au';
	public $version = '1.1';
	public $fields = array(
		array(
			'field' => 'limit',
			'label' => 'Limit',
			'rules' => 'required'
		)
	);

	public function run($options) 
	{

		//
		// If the user is not logged in then we can not have a wishlist for them!
		//
		if (!$this->current_user) 
		{
			return FALSE;
		}

		$this->load->model('shop/wishlist_m');
		

		//
		// if the value is not set then just send 2 items
		//
		$limit = isset($options['limit'])? $options['limit'] : 2 ;


		//
		// Get the items from the db
		//
		$items = $this->wishlist_m->order_by('date_added', 'desc')->limit($limit)->get_many_by('shop_wishlist.user_id', $this->current_user->id);

		//
		// return in expected array format
		//
		return array(
			'items' => $items,
			'options' => $options,
		);

	}

}