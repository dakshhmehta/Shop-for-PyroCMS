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
class Manage extends Admin_Controller 
{
	// Set the section in the UI - Selected Menu
	protected $section = 'manage';

	public function __construct() 
	{
		parent::__construct();

		$this->template->append_css('module::admin.css');
	}

	/**
	 * List all items:load the dashboard
	 */
	public function index() 
	{

		role_or_die('shop', 'admin_setup');
		

		if( $this->input->post() )
		{
			if( $this->input->post('btnAction') )
			{
				$this->save($this->input->post(), $this->input->post('btnAction')  );
			}

		}		


		$folder_drop_down_settings = explode(',',  'shop_upload_file_product,shop_upload_file_orders'  );
		foreach($folder_drop_down_settings as $set_name)
		{
			$data->$set_name = $this->folders( Settings::get($set_name) ,$set_name);
		}

		
		
		$data->shop_admin_login_location = $this->shop_admin_login_location('shop_admin_login_location');



		// Build the view with shop/views/admin/items.php
		//$data->items = & $items;
		$this->template->title($this->module_details['name'])
				->build('admin/manage/main', $data);
				
	}



	private function save($input, $_action ='save')
	{	

		//this must be set
		
		$input = $this->input->post();

		unset($input['btnAction']);



		foreach($input as $key => $value)
		{
			Settings::set($key,$value);
		}


		if($_action =='save_exit')
		{
			redirect('admin/shop');
		}

	}


	private function folders($folder_id,$field_name='folder_id')
	{


		// Load Files Module
		$this->load->library('files/files');
		$this->load->model('files/file_folders_m');
		
		// Set up the Dropdown Array for edit and create
		$folders = array(0 => lang('global:select-pick'));
		
		// Get All folders
		$tree = $this->file_folders_m->order_by('parent_id', 'ASC')->order_by('id', 'ASC')->get_all();
		
		// Build the Folder Tree
		foreach ($tree as $folder) 
		{
			$id = $folder->id;
			if ($folder->parent_id != 0) 
			{
				$folders[$id] =  $folders[$folder->parent_id] . ' &raquo; ' . $folder->name;
			} 
			else
			{
				$folders[$id] = $folder->name;
			}
		}
				

		return form_dropdown($field_name, $folders, $folder_id );

	}

	private function shop_admin_login_location($field_name='shop_admin_login_location')
	{
		return form_dropdown($field_name, 
							array('0'=>'Default','1'=>'Shop Dashboard','2'=>'Shop Products','3'=>'Shop Orders') , 
							Settings::get($field_name) );
	}


}
