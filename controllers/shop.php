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

	/*just for play/testing in future builds*/
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

		//$this->template->set_theme('shop_theme');
		$this->load->library('shop/products_library');
		$this->lang->load('shop/shop_front');
		
		$uri1 = $this->uri->segment(1);
		$uri2 = $this->uri->segment(2);
		if(!empty($uri1) and empty($uri2)){
			$page = $uri1;
		}elseif(!empty($uri2)){
			$page = $uri2;
		}else{
			$page = 1;
		}
		
		$options = array();
		if(!isset($options['page_url'])){ $options['page_url'] = ''; }
		if(!isset($options['limit_products'])){ $options['limit_products'] = 5; }
		if(!isset($options['limit_featured'])){ $options['limit_featured'] = 5; }
		if(!isset($options['limit_bestsellers'])){ $options['limit_bestsellers'] = 5; }
		
		$this->data->recent = $this->products_library->get_products(array('public'=>1), true, $options['page_url'], $options['limit_products'], $page);
		$this->data->featured = $this->products_library->get_products(array('public'=>1, 'featured'=>1), true, $options['page_url'], $options['limit_featured'], 1);
		$this->data->bestsellers = $this->products_library->get_products(array('public'=>1, 'bestsellers'=>1), true, $options['page_url'], $options['limit_bestsellers'], 1);
        
		$this->data->no_image = $this->module_details['path'].'/img/default/no_img_trans_128.gif';
		
		$this->template
			->append_css('module::default/shop.css')
			->append_js('module::shop_cart.js')
			->set('options', $options)
			->build('special/shop_home', $this->data);
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