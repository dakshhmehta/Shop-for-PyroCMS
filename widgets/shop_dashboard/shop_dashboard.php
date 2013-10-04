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

/**
 * 
 */

class Widget_Shop_Dashboard extends Widgets
{
	public $title		= array(
		'en' => 'Shop - Dashboard',
	);
	public $description	= array(
		'en' => 'Creates a Dashboard widget with recent orders',
	);
	public $author		= 'Salvatore Bordonaro';
	public $website		= 'http://inspiredgroup.com.au/';
	public $version		= '1.1';
	
	public function run($options)
	{
		$this->load->model('shop/orders_m');

		//$this->template->append_js('module::admin/dashboard.js')
		//$this->template->append_js('jquery/jquery.flot.js')

		//only get active 'open' orders
		$data['recent_shop_order'] = $this->orders_m->order_by('id','desc')->get_last(5);
		
		return $data;

	}

}
