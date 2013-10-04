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
class Special extends Public_Controller 
{

	public function __construct() 
	{
		parent::__construct();

	}

	public function index($param = '') 	{}
	public function closed() 			{ $this->template->build('special/closed');}	
	public function sample() 			{ $this->template->build('special/sample');}
	public function notfound() 			{ $this->template->build('special/notfound');}
	
}