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
 * @system		PyroCMS 2.2.x
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
	public $version		= '1.2';
	
	/**
	 * Fixed bug to show 1 day by default
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	public function run($options)
	{

	}

}
