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

class Dailydeals extends Admin_Controller 
{

	protected $section = 'dailydeals';
	

	public function __construct() 
	{
		parent::__construct();
		$this->load->model('dailydeals_m');		
		$this->load->model('products_admin_m');		
		Events::trigger('evt_admin_load_assests');

	}


	public function index($offset = 0) 
	{

		$data->products = $this->dailydeals_m->get_all_admin();
		

		$this->template->title($this->module_details['name'])
				->build('admin/dailydeals/list', $data);
	

	}	



	public function add($id = 0) 
	{
		$data = new stdClass();

		$data->products = array();




		if($this->dailydeals_m->create($id))
		{
			$this->session->set_flashdata('success', shop_lang('shop:dailydeals:product_added'));
		}

		// Build the view with shop/views/admin/products.php
		$this->template->title($this->module_details['name'])
				->build('admin/dailydeals/list', $data);
	

	}


	public function start($id=0)
	{


		if($this->dailydeals_m->start($id))
		{
			$this->session->set_flashdata('success', shop_lang('shop:dailydeals:deal_commenced'));
		}


		redirect('shop/admin/dailydeals');
	}



	public function stop($id=0)
	{
		if($this->dailydeals_m->stop($id))
		{
			$this->session->set_flashdata('success', shop_lang('shop:dailydeals:deal_stopped'));
		}

		redirect('shop/admin/dailydeals');
	}


	public function activate($id=0)
	{
		if($this->dailydeals_m->activate($id))
		{
			$this->session->set_flashdata('success', shop_lang('shop:dailydeals:deal_activated'));
		}

		redirect('shop/admin/dailydeals');
	}


	/*remove from the list , and stop if active, still have data for reporting*/
	public function archive($id=0)
	{
		if($this->dailydeals_m->archive($id))
		{
			$this->session->set_flashdata('success', shop_lang('shop:dailydeals:deal_archived'));
		}


		redirect('shop/admin/dailydeals');
	}



	/**
	 * mnitor looks through the list and starts or stops 
	 * any deals that require it. This is triged usually by a change of status by another action
	 *
	 */
	private function monitor()
	{

	}






}
