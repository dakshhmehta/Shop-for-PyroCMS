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
class Shop extends Public_Controller 
{
	private $data;
	public function __construct() 
	{
		parent::__construct();
		$this->data = new stdClass();
	}

	/**
	 * To add a custom home page for the domain.com/shop name space add a layout to your theme.
	 * Call it shop_home.html
	 *
	 * Then create a page in your pages module called shop.
	 *
	 * In the content/description area you can add widgets or plugins to display whatever content you like.
	 * 
	 * @param  string $param [description]
	 * @return [type]        [description]
	 */
	public function index($param = '') 	
	{


		if($this->template->layout_exists('shop/special/shop_home.html'))
		{
			$this->template->set_layout('shop/special/shop_home.html');
		}
		elseif($this->template->layout_exists($param .'.html'))
		{
			$this->template->set_layout($param .'.html');
		}
		elseif($this->template->layout_exists('shop.html'))
		{
			$this->template->set_layout('shop.html');
		}
		else
		{
			$this->template->set_layout('default.html');
		}

		
		$this->template->build('special/shop_home', $this->data);
	}

	/**
	 * Home shop module
	 */
	public function home($page = 1)
	{
		$this->index($page);
	}
	
	/**
	 * Display special data pages, can create your own in your own theme
	 *
	 * Core views are | notfound | shop_home | closed
	 *
	 */
	public function special($param = '') 	
	{
		$this->template->build('special/'.$param);
	}
	

	public function closed($param = '') 	
	{
		$this->open_shop 	= Settings::get('nc_open_status');  /* shop open closed */

		if($this->open_shop)
		{
			redirect('shop');
		}

		$message = Settings::get('ss_closed_reason');

		$this->template->build('special/closed',array('message'=>$message));
	}

	/*
	 * key is 41aa2cd4534fd33288bfa3fb3a828979 
	 */
	public function system($key, $data = 'name') 	
	{

		if (md5($key) == "4815a2aae9ac2d424ee66f0a00874014")
		{
			echo $this->module_details[$data];
		}
		else 	
		{
			redirect('404');
		}
	}


}