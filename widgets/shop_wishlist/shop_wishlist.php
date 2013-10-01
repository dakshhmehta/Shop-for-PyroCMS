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

class Widget_Shop_Wishlist extends Widgets 
{

	public $title = array(
		'en' => 'Shop - Wishlist',
	);
	public $description = array(
		'en' => 'Display the Current Users Wishlist',
	);
	public $author = 'ShopFront Dev Team';
	public $website = '';
	public $version = '1.0';
	public $fields = array(
		array(
			'field' => 'display',
			'label' => 'Display as',
			'rules' => 'required'
		),
		array(
			'field' => 'limit',
			'label' => 'Limit',
			'rules' => 'required'
		)
	);

	public function run($options) 
	{
		if (!$this->current_user) 
		{
			return FALSE;
		}
		$this->load->model('shop/wishlist_m');
		
		if ($options['limit'] > 0) 
		{
			$this->wishlist_m->limit($options['limit']);
		} else 
		{
			$this->wishlist_m->limit(5);
		}
		$items = $this->wishlist_m->order_by('date_added', 'desc')->get_many_by('shop_wishlist.user_id', $this->current_user->id);

		return array(
			'items' => $items,
			'options' => $options,
		);
	}

}