<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		PyroCMS
 * @subpackage 		Shop Home Widget
 * @author			Eko Muhammad Isa
 * 
 * Show shop home in your site
 */

class Widget_Shop_home extends Widgets
{
	public $title		= array(
		'en' => 'Shop - Home'
	);
	public $description	= array(
		'en' => 'Display list of products dinamic by featured, new products and best sellers'
	);
	public $author		= 'Eko Muhammad Isa';
	public $website		= 'http://www.enotes.web.id/; http://www.jagita.com';
	public $version		= '0.1';
	
	public $fields = array(
		array(
			'field' => 'show_products',
			'label' => 'Display recent products',
		),
		array(
			'field' => 'limit_products',
			'label' => 'Number of recent products every page',
		),
		array(
			'field' => 'show_featured',
			'label' => 'Display featured products',
		),
		array(
			'field' => 'limit_featured',
			'label' => 'Number of featured products',
		),
		array(
			'field' => 'show_bestsellers',
			'label' => 'Display best sellers products',
		),
		array(
			'field' => 'limit_bestsellers',
			'label' => 'Number of best sellers products',
		),
		array(
			'field' => 'widget_theme',
			'label' => 'Widget theme',
		),
		array(
			'field' => 'page_url',
			'label' => 'URL Pages<br/>(%s = position of page number)<br/> Example: http://www.domain.com/your-page/%s',
		)
	);

	public function form($options)
	{
		!empty($options['show_products']) OR $options['show_products'] = 'yes';
		!empty($options['limit_products']) OR $options['limit_products'] = 5;
		!empty($options['show_featured']) OR $options['show_featured'] = 'yes';
		!empty($options['limit_featured']) OR $options['limit_featured'] = 5;
		!empty($options['show_bestsellers']) OR $options['show_bestsellers'] = 'yes';
		!empty($options['limit_bestsellers']) OR $options['limit_bestsellers'] = 5;
		!empty($options['widget_theme']) OR $options['widget_theme'] = 'default';
		!empty($options['page_url']) OR $options['page_url'] = site_url('shop/home/%s');

		return array(
			'options' => $options,
			'fields' => $this->fields
		);
	}
	
	public function run($options)
	{
		
		 if(strpos(__FILE__, 'shared_addons') !== false){
		     $module_path = site_url('addons/shared_addons/modules/shop').'/';
		 }else{
		     $module_path = site_url('addons/'.SITE_REF.'/modules/shop').'/';
		 }
		//$module_path = site_url('assets/modules/shop/');
		
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
		
		if(!isset($options['page_url'])){ $options['page_url'] = ''; }
		if(!isset($options['limit_products'])){ $options['limit_products'] = 5; }
		if(!isset($options['limit_featured'])){ $options['limit_featured'] = 5; }
		if(!isset($options['limit_bestsellers'])){ $options['limit_bestsellers'] = 5; }
		
		$recent = $this->products_library->get_products(array('public'=>1), true, $options['page_url'], $options['limit_products'], $page);
		$featured = $this->products_library->get_products(array('public'=>1, 'featured'=>1), true, $options['page_url'], $options['limit_featured'], 1);
		$bestsellers = $this->products_library->get_products(array('public'=>1, 'bestsellers'=>1), true, $options['page_url'], $options['limit_bestsellers'], 1);
        
		Asset::add_path('shoppath', $module_path);
		$no_image = $module_path.'img/default/no_img_trans_128.gif';
        $this->template->append_css('shoppath::'.$options['widget_theme'].'/shop.css');
				
		return array(
			'recent' => $recent,
			'featured' => $featured,
			'bestsellers' => $bestsellers,
			'no_image' => $no_image,
			'module_path' => $module_path
		);
	}
	
}
