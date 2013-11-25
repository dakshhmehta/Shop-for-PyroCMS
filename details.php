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
class Module_Shop extends Module 
{

	public $version = '1.0.0.127';  



	public function __construct()
	{

		$this->load->library('shop/details_library');
		$this->load->library('shop/enums');
		$this->ci = get_instance();


	}
	
	/**
	 * info() 
	 * @description: Creates 2 arrays to diplay for the module naviagtion
	 *			   One array is returned based on the user selection in the settings
	 *
	 */
	public function info() 
	{
 
		// load the model
		$this->load->model('settings_m');

		$get_menu_addon = $this->ci->uri->segment(3);	
		
		return  $this->details_library->info($get_menu_addon);

	}
  


    public function admin_menu(&$menu)
    {
	
		// Get the admin menu for pyro 2.2
		$this->details_library->admin_menu($menu);
		
		// Place menu on position #
		add_admin_menu_place('lang:shop:admin:shop', 1);

		add_admin_menu_place('lang:shop:admin:shop_admin', 2);
		
		
	}
	


	public function install() 
	{

 		//$tables = $this->details_library->get_tables();
		//$this->_uninstall_tables($tables);
		//return true;
		# Install Product Tables
		$tables = $this->install_tables( $this->details_library->get_tables() );



		if( $tables  )
		{
			$this->init_templates();
			$this->init_settings();
			$this->insertDefaultData();
			return TRUE;
		}

		$this->uninstall();
		return FALSE;

	}


	# Insert default data to tables
	public function insertDefaultData() 
	{

		
		$data = array(
			array(
				'name' => 'General' ,
				'description' => 'Default category' ,
				'slug' => 'general',
				'image_id' => '0',
				'parent_id' => '0',
				'user_data' => '',
				)			  
		);
		$this->db->insert_batch('shop_categories', $data);
					
		/*Add default TAX rate of 0 */
		$data = array(
				'name' => 'NOTAX' ,
				'rate' => 0 ,
				'rate_local' => 0,
				'rate_state' => 0,
				'rate_fed' => 0
		);
		$this->db->insert('shop_tax', $data);



		$data = array();


		foreach($this->details_library->_countryList as $key => $value)
		{
			$data[] = array(
					'name' => $value,
					'code2' => $key,
					'code3' => '',
					'enabled' => 0,
					);
		}

		$this->db->insert_batch('shop_countries', $data);	



		return TRUE;	

	}	

	
	/**
	 * uninstall()
	 * 1. Removes/drops database tables
	 * 2. Deletes settings
	 * 3. Deletes Email Templates
	 */
	public function uninstall() 
	{
	
		//Cache
		$cache_list = $this->details_library->get_cache_list();


		$this->_delete_cache($cache_list);

		$tables = $this->details_library->get_tables();
		$this->_uninstall_tables($tables);

				
		// Remove All settings for this module
		$this->db->delete('settings', array('module' => 'shop'));
		
		// Remove all email templartes installed by this module
		$this->db->delete('email_templates', array('module' => 'shop'));


		return TRUE;

	}


	private function _uninstall_tables($tables)
	{
		
		foreach($tables as $table_name => $table_fields)
		{
			$this->dbforge->drop_table($table_name);
		}

	}
	

	/*
	 * add user data to categories
	 * add user data to products 
	 */
	public function upgrade($old_version) 
	{
		 
	
		switch ($old_version) 
		{
			case '1.0.0.126':
				//changes to cart controller - no db changes
				$this->_install_table_col('shop_products','product_type');
				break;
			case '1.0.0.110':
				$this->_install_settings('shop_trust_score_threshold');
				$this->_install_table_col('shop_products','page_design_layout');

				$this->dbforge->drop_table('shop_dailydeals'); //important
				$this->_install_table('shop_dailydeals');
				break;
			case '1.0.0.109':
				//$this->_install_table_col('shop_orders','pmt_status');
				//$this->_install_table_col('shop_categories','user_data');
			 	//$this->_upgrade_orders();
				//$this->_install_settings('shop_upload_file_product');
				//$this->_install_settings('shop_upload_file_orders');
				break;
			default:
				break;
		}

		return TRUE;

	}


				


	private function _install_table($table)
	{
 		$table_to_install = $this->details_library->get_tables($table);


 		$table_to_install = array( $table => $table_to_install[$table] );


		return $this->install_tables( $table_to_install );
	}


	/**
	 * Installs a column on a table
	 * 
	 * @param  [type] $table [description]
	 * @param  [type] $row   [description]
	 * @return [type]        [description]
	 */
	private function _install_table_col($table_name,$col_name)
	{
		
		//first drop the col if exist
		$this->dbforge->drop_column($table_name, $col_name);

 		$_table = $this->details_library->get_tables($table_name);

 		$fields = $_table[$table_name][$col_name];
		$fields = array( $col_name => $fields );
		
		return $this->dbforge->add_column($table_name, $fields);
		
	}


	/**
	 * Upgrades 103 -> 104
	 * 
	 * @return [type] [description]
	 */
	private function _upgrade_orders()
	{

		$fields = array(
				'status' => array(
		                 'type' => "ENUM('placed', 'pending', 'paid','processing', 'complete', 'shipped', 'returned', 'cancelled','closed','reopen')",
		                 'default' => 'pending'
		        ),
		);
		$this->dbforge->modify_column('shop_orders', $fields);

	}

	

	public function help()
	{
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}



	private function init_templates() 
	{

		 $em_tmp = $this->details_library->get_email_templates();

		 foreach ($em_tmp as $email_array_data) 
		 {
		 	$this->db->insert('email_templates', $email_array_data );
		 }

		 return TRUE;

	}




	/**
	 * Install a single setting when upgrading
	 * 
	 * @param  [type] $sett_name [The key / slug of the settings in the main list]
	 * @return BOOL            [description]
	 */
	private function _install_settings($sett_name)
	{
		$settings = $this->details_library->get_settings($sett_name);

		//set the settings name
		$settings['slug'] = $sett_name;

		return $this->db->insert('settings', $settings);

	}



	private function init_settings() 
	{

		$settings = $this->details_library->get_settings();

		foreach ($settings as $slug => $setting) 
		{
			//set the settings name
			$setting['slug'] = $slug;

			if (!$this->db->insert('settings', $setting)) 
			{
				return FALSE;
			}
		}

		return TRUE;
	}


	/*
	 * some helpful function to deal with upgrading settings
	 * as this is a new product many of the fields change names
	 * 
	 */
	private function _delete_setting($slug)
	{

		$where = array('module' => 'shop', 'slug' => $slug);
		return $this->db->delete('settings', $where );

	}




	private function _delete_cache($cache_name_array = array() )
	{

		foreach ($cache_name_array as $cache_name ) 
		{
			// Clear Cache
			$this->pyrocache->delete_all($cache_name);
		}

		return TRUE;

	}

	private function _remove_field($table,$field)
	{
		return $this->dbforge->drop_column($table, $field);
	}


				


}
/* End of file details.php */