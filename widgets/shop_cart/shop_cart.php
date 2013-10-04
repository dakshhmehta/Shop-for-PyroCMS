<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');



class Widget_Shop_Cart extends Widgets
{
	public $title		= array(
		'en' => 'Shop - Shopping Cart',
	);
	public $description	= array(
		'en' => 'Display a list of items user added to cart',
	);
	public $author		= 'Inspired Technology Dev Team';
	public $website		= 'http://inspiredgroup.com.au';
	public $version		= '1.2';
	
	public function run($options)
	{
	
		return array(
			'cart' => $this->sfcart->contents(),
			'total_items' => $this->sfcart->total_items(),
			'total_cost' => $this->sfcart->total()
		);

	}	
}