<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');


class Widget_Shop_Recent_sales extends Widgets
{
	public $title		= array(
		'en' => 'Shop - Recent Sales',
	);
	public $description	= array(
		'en' => 'List the top most recent orders with a link to open and view the order',
	);
	public $author		= 'Salvatore Bordonaro';
	public $website		= 'http://inspiredgroup.com.au/';
	public $version		= '1.1';
	
	public function run($options)
	{

		$this->load->model('shop/orders_m');

		$data['recent_shop_order'] = $this->orders_m->order_by('id','desc')->get_last(5);
		
		return $data;

	}

}
