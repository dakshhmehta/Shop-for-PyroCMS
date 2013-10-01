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
class Widget_Shop_Simple_Cart extends Widgets
{
	public $title		= array(
		'en' => 'Shop - Simple Cart',
	);
	public $description	= array(
		'en' => 'Display a list of items user added to cart',
	);
	public $author		= '';
	public $website		= '';
	public $version		= '1.0';


	public $fields = array(
		array(
			'field' => 'total_cost_label',
			'label' => 'Total Cost Label',
			'rules' => 'trim' /*need to be boolean*/
		),
		array(
			'total_items_label' => 'total_items_label',
			'label' => 'Total Items Label',
			'rules' => 'trim'
		),
		array(
			'total_items_suffix' => 'total_items_suffix',
			'label' => 'Total Items Suffix',
			'rules' => 'trim'
		),		
		array(
			'field' => 'ul_css_class',
			'label' => 'Css Class for List',
			'rules' => 'trim' /*need to be boolean*/
		)
	);
	public function run($options)
	{

		return array(
				'ul_css_class' => $options['ul_css_class'],
				'total_cost_label' => $options['total_cost_label'],
				'total_items_label' => $options['total_items_label'],
				'total_items_suffix' => $options['total_items_suffix'],
				'total_cost' => $this->sfcart->total(),
				'total_items' => $this->sfcart->total_items(),
				'items_total' => $this->sfcart->items_total()
		);
	}	
}
