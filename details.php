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


/*
 * 1.0.0.0510 - initial release
 * 1.0.0.0511 - updated setting names, removed unused settings - moved more views to LEX tags, removed redundant widget (cart), fixed minor bugs
 * 1.0.0.0512 - fixed bug with enable brands menu item, fixed bug with displaying brand data, fixed option issue #6
 *
 *
 * 1.0.1.0000 - Target release for patch 
 * 
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
class Module_Shop extends Module 
{

	public $version = '1.0.0.080';  
	private $language_file = 'shop/shop';
	private $setting_en_brands = 0; //default to off;


	public function __construct()
	{

		$this->load->library('shop/details_library');
		$this->load->library('shop/enums');


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

		return  $this->details_library->info();

	}
  


    public function admin_menu(&$menu)
    {
	
		// Get the admin menu for pyro 2.2
		$this->details_library->admin_menu($menu);
		
		// Place menu on position #
		add_admin_menu_place('lang:nc:admin:nitro', 2);
		
		
	}
	


	public function install() 
	{
 
 		$success = TRUE;

		
		//$this->uninstall();
		
		# Install Product Tables
		$tbl_products = $this->install_tables( $this->details_library->get_install_tables_1() );


		$tbl_orders = $this->install_tables( $this->details_library->get_install_tables_2() );


		$tbl_sys = $this->install_tables( $this->details_library->get_install_tables_3() );


		if( $tbl_products && $tbl_orders && $tbl_sys )
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


		$data = array();

		foreach($this->details_library->get_array('trust_score') as $key => $value)
		{
			$data[] = array(
					'score' => $value['score'],
					'category' => $value['category'],
					'word' => $value['word'],
					'count' => 0,
					'enabled' => 1,
					);
		}

		$this->db->insert_batch('shop_trust_data', $data);		


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


		// Delete / Drop all tables  
		$tables = $this->details_library->uninstall_tables();


		foreach($tables as $table_name)
		{
			$this->dbforge->drop_table($table_name);
		}

				
		// Remove All settings for this module
		$this->db->delete('settings', array('module' => 'shop'));
		
		// Remove all email templartes installed by this module
		$this->db->delete('email_templates', array('module' => 'shop'));
		{
			return TRUE;
		}
	}
	

	public function upgrade($old_version) 
	{
		
		

		switch ($old_version) 
		{
			
			case '1.0.0.079': break;
			case '1.0.0.076': break;
			case '1.0.0.073': break;
			case '1.0.0.072': break;
			case '1.0.0.071': 
			case '1.0.0.070': 	
				break;
			case '1.0.0.069':


				//remove short_desc
				$table = 'shop_products';


				//$field = 'deleted';
				//$this->_remove_field($table,$field);
				
				//$field = 'product_type';
				//$this->_remove_field($table,$field);
				

				//$field = 'short_desc';
				//$this->_remove_field($table,$field);
				
				//$this->_delete_setting('nc_markup_theme');

				break;

			case '1.0.0.051':
				//
				// tmp install lang table
				//
				$tbls = $this->install_tables( 

					array('shop_lang' => array(
						'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
						'module' =>   array('type' => 'VARCHAR', 'constraint' => '80', 'default' => ''), /*product group */
						'area' => array('type' => 'VARCHAR', 'constraint' => '80', 'default' => ''), /*product group */
						'key' => array('type' => 'VARCHAR', 'constraint' => '80', 'default' => ''), /*product group */
						'value' => array('type' => 'VARCHAR', 'constraint' => '80', 'default' => ''), /*product group */
					)) 

				);
				
				//
				// removed un-used settings
				//
				$this->_delete_setting('nc_currency_api_key');
				$this->_delete_setting('sf_profiler');
				$this->_delete_setting('nc_enable_wishlist');
				$this->_delete_setting('nc_support_email');

				//
				// rename old settings to new name
				//
				$this->_rename_setting('nc_name','ss_name');
				$this->_rename_setting('nc_slogan','ss_slogan');
				$this->_rename_setting('nc_currency_code'			,'ss_currency_code'		);
				$this->_rename_setting('nc_currency_symbol'			,'ss_currency_symbol'	);
				$this->_rename_setting('nc_currency_layout'			,'ss_currency_layout'	);
				$this->_rename_setting('nc_currency_thousand_sep'	,'ss_currency_thousand_sep');
				$this->_rename_setting('nc_currency_decimal_sep'	,'ss_currency_decimal_sep');
				$this->_rename_setting('nc_dist_loc'				,'ss_distribution_loc');
				$this->_rename_setting('nc_enable_brands'			,'ss_enable_brands');
				$this->_rename_setting('nc_qty_perpage_limit'		,'ss_qty_perpage_limit');
				$this->_rename_setting('nc_require_login'			,'ss_require_login');
				$this->_rename_setting('nc_ssl_required'			,'ss_ssl_required');



				break;
			case '1.0.0.050':
				break;
			default:
				break;
		}


		//below here you can run a script that updates for all versions



		return TRUE;

	}
	

	public function help()
	{
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}


	private function init_templates() 
	{

		$this->db->insert('email_templates', array(
			'slug' => 'sf_admin_blacklist',
			'name' => 'Shop: An attempt to place order was blocked',
			'description' => 'This email will be sent to Administrators when an attempt to place an order for a user or group that has been blacklisted',
			'subject' => 'An attempt to place order was blocked',
			'body' => '<h1>Details</h1>
				<b>Date:</b> {{ date }}<br />
				<b>User Email:</b> {{ email }}<br />
				<b>IP Address:</b> {{ ip_address }}<br /><br />
				<p><b>Order Total:</b>{{ cost_total }}</p><br />		
				<p><b>Shipping Address:</b>{{ shipping_address }}</p><br />		
				',
			'lang' => 'en',
			'is_default' => 1,
			'module' => 'shop'
		));




		$this->db->insert('email_templates', array(
			'slug' => 'sf_user_order_notification',
			'name' => 'shop: User Lodged Order',
			'description' => 'Email sent to user when order is submitted',
			'subject' => '{{ settings:ss_name }} - Order has been submitted',
			'body' => '<h1>You have successfully created an order with {{ settings:ss_name }}</h1>

				<b>Order ID:</b> {{ order_id }}<br />
				<b>Order Date:</b> {{ order_date }}<br />
				<b>Order Total:</b> {{ cost_total }}<br />
				<p><a href="{{ url:site }}shop/my/">Login to your online account</a> to </p>
				<p><a href="{{ url:site }}shop/my/orders/order/{{ order_id }}">view your full order.</a></p>',
				
			'lang' => 'en',
			'is_default' => 1,
			'module' => 'shop'
		));

		$this->db->insert('email_templates', array(
			'slug' => 'sf_admin_order_notification',
			'name' => 'Shop: New order has been submitted',
			'description' => 'This email will be sent to Administrators when new orders are submitted',
			'subject' => 'A new order has been submitted',
			'body' => '<h1>An order has just been submitted on your online shop</h1>
				<b>Order ID:</b> {{ order_id }}<br />
				<b>Order Date:</b> {{ order_date }}<br />
				<b>IP Address:</b> {{ customer_ip }}<br /><br />
				<p><b>Order Total:</b>{{ cost_total }}</p><br />		
				<p><a href="{{ url:site }}admin/shop/orders/order/{{ order_id }}">view full order details online</a></p>
				<p>{{ order_contents }}</p>
				',
			'lang' => 'en',
			'is_default' => 1,
			'module' => 'shop'
		));

		return TRUE;
	}

	/*
	 *
	 * TODO:Change all setttings to the sf_ prefix
	 *	  Take care with this as setting are referenced through out the code
	 */
	private function init_settings() 
	{

		$settings = $this->details_library->get_settings();

		foreach ($settings as $slug => $setting) 
		{

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

	private function _create_setting($slug, $title, $description, $type ='text', $default = '', $value ='' ,$options ='', $is_required = TRUE, $is_gui = TRUE, $order = 900)
	{

		 $setting = array( 
			'slug' => $slug,
			'title' => $title, 
			'description' => $description,
			'type' => $type, 
			'default' => $default, 
			'value' => $value, 
			'options' => $options, 
			'is_required' => $is_required,
			'is_gui' => $is_gui, 
			'module' => 'shop', 
			'order' => $order		);	


		if($this->db->insert('settings', $setting))	
		{
			return TRUE;
		}	

		return FALSE;

	}

	private function _copy_setting($old_setting, $new_setting)
	{

		//$old =  $this->db->get('settings', array('slug' => $old_setting) );
		$this->load->model('settings_m');

		$old = $this->settings_m->get_by(array('slug' => $old_setting, 'module'=>'shop'));

		//if exist then we create
		if($old)
		{
			return $this->_create_setting($new_setting, $old->title, $old->description, $old->type, $old->default, $old->value,$old->options, $old->is_required, $old->is_gui, $old->order);
		}

		return FALSE;


	}


	private function _rename_setting($old_setting, $new_setting)
	{
		if($this->_copy_setting($old_setting, $new_setting))
		{
			//only if we find the setting to we add the new one
			return $this->_delete_setting($old_setting);
		}

		return FALSE;
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