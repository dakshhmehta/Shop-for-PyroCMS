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
class Module_Shop extends Module 
{

	public $version = '0.1.8';  
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
		$tables = $this->details_library->clear_cache();

		// Clear Cache
		$this->pyrocache->delete_all('products_m');
		$this->pyrocache->delete_all('products_admin_m');
		$this->pyrocache->delete_all('products_front_m');
		$this->pyrocache->delete_all('categories_m');
		$this->pyrocache->delete_all('brands_m');
		$this->pyrocache->delete_all('options_m');



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
			case '0.1.7':


				$tbls = $this->install_tables( 

					array('shop_trust_data' => array(
						'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
						'score' =>  array('type' => 'INT', 'constraint' => '1', 'default' => 1), /*product group */
						'category' => array('type' => 'VARCHAR', 'constraint' => '50', 'default' => ''),   /*user group*/
						'word' => array('type' => 'VARCHAR', 'constraint' => '200', 'default' => ''), /*product group */
						'count' => array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'default' => 1),  /*times used*/
						'enabled' => array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'default' => 1),  
					)) 

				);
			


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


				break;
			case '0.1.6':
				$tbls = $this->install_tables( 

					array('shop_group_prices' => array(
						'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
						'pgroup_id' => array('type' => 'VARCHAR', 'constraint' => '150'), /*product group */
						'ugroup_id' => array('type' => 'VARCHAR', 'constraint' => '2'),  /*user group*/
						'min_qty' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'default' => 0),  
						'price' => array('type' => 'DECIMAL(10,2)', 'null' => TRUE, 'default' => 0),
					)) 

				);
				break;
			case '0.1.5':

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
				break;

			case '0.1.4':

				$data = array();

				foreach($this->countryList as $key => $value)
				{
					$data[] = array(
							'name' => $value,
							'code2' => $key,
							'code3' => '',
							'enabled' => 0,
							);
				}

				$this->db->insert_batch('shop_countries', $data);
				break;


			case '0.1.3':
				$tbls = $this->install_tables( 

				
					array('shop_countries' => array(
						'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
						'name' => array('type' => 'VARCHAR', 'constraint' => '150'),
						'code2' => array('type' => 'VARCHAR', 'constraint' => '2'), 
						'code3' => array('type' => 'VARCHAR', 'constraint' => '3', 'default' => ''), /*not used in this ver*/
						'enabled' => array('type' => 'INT', 'constraint' => '1', 'default' => 0),
					)) 

				);
				break;


			case '0.1.2':
				$tbls = $this->install_tables( 

				
					array('shop_blacklist' => array(
						'id' => 			array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
						'name' => 			array('type' => 'VARCHAR', 'constraint' => '200'),
						'method' => 		array('type' => 'INT', 'constraint' => '4', 'default' => 2), 
						'value' => 			array('type' => 'VARCHAR', 'constraint' => '300', 'default' => ''), 
						'enabled' => 		array('type' => 'INT', 'constraint' => '1', 'default' => 1), 
					)) );

				break;
			case '0.1.1':
				break;
			default:
				//nothing to upgrade
				return TRUE;
				break;
		}





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
			'subject' => '{{ settings:nc_name }} - Order has been submitted',
			'body' => '<h1>You have successfully created an order with {{ settings:nc_name }}</h1>

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



}
/* End of file details.php */