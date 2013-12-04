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
class Dashboard extends Public_Controller 
{

	public function __construct() 
	{
   	
		parent::__construct();
		
		// If User Not logged in
		if (!$this->current_user) 
		{
			$this->session->set_flashdata('notice', lang('shop:my:user_not_authenticated'));
			
			// Send User to login then Redirect back after login
			$this->session->set_userdata('redirect_to', 'shop/my');
			redirect('users/login');
		}
	
		// Define the top level breadcrumb
		$this->template->set_breadcrumb(lang('shop'), 'shop');
		
	}
	
	
	/**
	 * 
	 * @url site.com/shop/my
	 * 
	 * Show the main dashboard menu and also display some usefull summary information about
	 * their transactions ect.
	 */
	public function index() 
	{
				
		$this->load->model('orders_m');
		$this->load->model('wishlist_m');
		
		$data->total_wish = $this->wishlist_m->where('user_id',$this->current_user->id)->count_all();
			 	
		$this->template
				->set_breadcrumb(lang('my'))
				->title($this->module_details['name'].' | '.lang('dashboard'))
				->build('my/dashboard',$data);
	}




}