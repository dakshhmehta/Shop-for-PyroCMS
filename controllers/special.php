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
 * NITRO CART	An explosive e-commerce solution for PyroCMS - ......and 'Open Source'
 *
 * @author		Salvatore Bordonaro
 * @version		0.90.0.000
 * @website		http://www.inspiredgroup.com.au/
 * @package		Special Pages Public Contoller for NITRO-CART
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