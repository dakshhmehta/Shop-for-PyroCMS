<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

use Pyro\Module\Addons\AbstractModule;

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
 * @system		PyroCMS 2.3.x
 *
 */
class Module_Shop extends AbstractModule 
{

	/**
	 * New dev version uses YMD as the final decimal format.
	 * Only for dev builds
	 * 
	 * @var string
	 */
	public $version = '1.0.0.143';  

	/**
	 * PDO database object
	 *
	 * @var Object
	 */
	private $pdb = null;

	/**
	 * Laravel schema object
	 *
	 * @var Object
	 */
	private $schema = null;


	public function __construct()
	{
		$this->ci = get_instance();
		$this->ci->load->library('shop/details_library');
		$this->ci->load->library('shop/enums');
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
		// @todo I don't know why I commented out loading of settings_m.
		//$this->ci->load->model('settings_m');

		$get_menu_addon = $this->ci->uri->segment(3);	
		
		return  $this->ci->details_library->info($get_menu_addon);

	}
  


    public function admin_menu(&$menu)
    {
	
		// Get the admin menu for pyro 2.2
		$this->ci->details_library->admin_menu($menu);
		
		// Place menu on position #
		add_admin_menu_place('lang:shop:admin:shop', 1);

		add_admin_menu_place('lang:shop:admin:shop_admin', 2);
		
		
	}
	


	public function install($pdb, $schema) 
	{
		$this->pdb = $pdb;
		$this->schema = $schema;

		if( $this->installTables() )
		{
			$this->init_templates();
			$this->init_settings();
			$this->insertDefaultData();
			return TRUE;
		}

		$this->uninstall($this->pdb, $this->schema);
		return FALSE;

	}

	private function installTables()
	{
		$this->schema->dropIfExists('shop_products');
		$this->schema->create('shop_products', function($table){
			$table->increments('id');
			$table->string('slug')->unique();
			$table->string('name');
			$table->string('code')->default('');
			$table->integer('pgroup')->unsigned()->nullable();
			$table->integer('category_id')->unsigned()->nullable();
			$table->integer('brand_id')->unsigned()->nullable();
			$table->text('description')->nullable();

			$table->string('keywords')->nullable()->default('');
			$table->string('meta_desc')->nullable()->default('');
			$table->text('related')->nullable()->default('');
			$table->text('user_data')->nullable()->default('');
			$table->string('page_design_layout')->nullable()->default('products_single');
			$table->integer('req_shipping')->unsigned()->nullable()->default(1);
			$table->integer('height')->unsigned()->nullable()->default(0);
			$table->integer('width')->unsigned()->nullable()->default(0);
			$table->integer('depth')->unsigned()->nullable()->default(0);
			$table->integer('weight')->unsigned()->nullable()->default(0);

			$table->decimal('price', 10, 2)->default(0);
			$table->decimal('price_base', 10, 2)->default(0);
			$table->decimal('rrp', 10, 2)->default(0);
			$table->integer('tax_id')->unsigned()->nullable();
			$table->integer('tax_dir')->unsigned()->nullable();

			$table->boolean('digital')->nullable()->default(0);
			$table->boolean('featured')->nullable()->default(0);
			$table->boolean('searchable')->nullable()->default(0);
			$table->boolean('public')->nullable()->default(0);
			$table->integer('min_qty')->unsigned()->nullable()->default(1);
			$table->integer('max_qty')->unsigned()->nullable();
			$table->integer('views')->unsigned()->nullable()->default(0);
			$table->integer('inventory_on_hand')->unsigned()->nullable()->default(0);
			$table->integer('inventory_low_qty')->unsigned()->nullable()->default(0);
			$table->boolean('inventory_type')->nullable()->default(0);
			$table->enum('status', array('discontinued', 'in_stock', 'soon_available', 'out_of_stock'))->nullable()->default('in_stock');

			$table->integer('created_by')->unsigned()->nullable();

			$table->timestamps();
			$table->softDeletes();
		});

		$this->schema->dropIfExists('shop_dailydeals');
		$this->schema->create('shop_dailydeals', function($table){
			$table->increments('id');
			$table->integer('prod_id')->unsigned()->nullable();
			$table->enum('status', array(
				'completed',
				'pending',
				'active',
				'forcestop',
				'alert'
			))->default('pending');
			$table->enum('mode', array(
				'untilsold', 
				'endofday', 
				'letmedecide'
			))->default('endofday');
			$table->integer('likes')->unsigned()->nullable()->default(0);
			$table->integer('shares')->unsigned()->nullable()->default(0);
			$table->integer('time_online')->unsigned()->nullable()->default(0);
			$table->date('date_start')->nullable();
			$table->date('date_end')->nullable();
		});

		$this->schema->dropIfExists('shop_group_prices');
		$this->schema->create('shop_group_prices', function($table){
			$table->increments('id');
			$table->integer('pgroup_id')->unsigned();
			$table->integer('ugroup_id')->unsigned();
			$table->integer('min_qty')->unsigned()->nullable()->default(0);
			$table->decimal('price', 10, 2)->unsigned()->nullable()->default(0);
		});

		$this->schema->dropIfExists('shop_attributes');
		$this->schema->create('shop_attributes', function($table){
			$table->increments('id');
			$table->integer('prod_id')->unsigned()->nullable();
			$table->string('type')->nullable()->default('text');
			$table->string('name')->default('Title');
			$table->text('value')->nullable();
		});
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
		$this->pdb->table('shop_categories')->insert($data);
					
		/*Add default TAX rate of 0 */
		$data = array(
				'name' => 'NOTAX' ,
				'rate' => 0 ,
				'rate_local' => 0,
				'rate_state' => 0,
				'rate_fed' => 0
		);
		$this->pdb->table('shop_tax')->insert($data);



		$data = array();


		foreach($this->ci->details_library->_countryList as $key => $value)
		{
			$data[] = array(
					'name' => $value,
					'code2' => $key,
					'code3' => '',
					'enabled' => 0,
					);
		}

		$this->pdb->table('shop_countries')->insert($data);	



		return TRUE;	

	}	

	
	/**
	 * uninstall($pdb, $schema)
	 * 1. Removes/drops database tables
	 * 2. Deletes settings
	 * 3. Deletes Email Templates
	 */
	public function uninstall($pdb, $schema) 
	{
		$this->pdb = $pdb;
		$this->schema = $schema;
		//Cache
		$cache_list = $this->ci->details_library->get_cache_list();


		$this->_delete_cache($cache_list);

		$tables = $this->ci->details_library->get_tables();
		$this->_uninstall_tables($tables);

				
		// Remove All settings for this module
		$this->pdb->delete('settings', array('module' => 'shop'));
		
		// Remove all email templartes installed by this module
		$this->pdb->delete('email_templates', array('module' => 'shop'));


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

			case '1.0.0.142':				
				$this->dbforge->drop_table('shop_discounts');
				return TRUE;
			case '1.0.0.140':	
 				$this->_create_settings('ss_closed_reason');
 				return TRUE;
			case '1.0.0.139':					
			//case '1.0.0.138':		//this was never a dev-release number			
			case '1.0.0.137':					
			case '1.0.0.136':
				//image field - cover_id migration
				$this->ci->load->library('shop/images_library');
				if($this->images_library->migrate2())
				{
					$this->_remove_table_col('shop_products','cover_id');
					return TRUE;
				}
				return FALSE;
			case '1.0.0.135':
				$this->ci->load->library('shop/images_library');

				$this->_remove_table_col('shop_images','restrain_size');
				$this->_remove_table_col('shop_images','scope');
				$this->_remove_table_col('shop_images','display');
				$this->_install_table_col('shop_images','src');
				$this->_install_table_col('shop_images','alt');
				$this->_install_table_col('shop_images','local');


				//only remove the col once the migration was successfull
				if($this->images_library->migrate1())
				{
					return TRUE;
				}

				return FALSE;
			
				break;				
			case '1.0.0.133':	
				//$this->_remove_table_col('shop_orders','tracking_code');
				$this->_install_table_col('shop_orders','pin');
				$this->_install_table('shop_product_files');
				$this->_install_table('shop_downloads');
				$this->_install_table_col('shop_products','req_shipping');
				break;

			default:
				break;
		}

		return TRUE;

	}
	
	/*
	Removing this to utilize the schema builder	
	private function _install_table($table)
	{
		// drop already existing table
		$this->dbforge->drop_table($table);

 		$table_to_install = $this->ci->details_library->get_tables($table);


 		$table_to_install = array( $table => $table_to_install[$table] );


		return $this->install_tables( $table_to_install );
	}
	*/


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
		//$this->dbforge->drop_column($table_name, $col_name);

 		$_table = $this->ci->details_library->get_tables($table_name);

 		$fields = $_table[$table_name][$col_name];
		$fields = array( $col_name => $fields );
		
		return $this->dbforge->add_column($table_name, $fields);
		
	}

	private function _remove_table_col($table_name,$col_name)
	{	
		$this->dbforge->drop_column($table_name, $col_name);
		return TRUE;
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

		 $em_tmp = $this->ci->details_library->get_email_templates();

		 foreach ($em_tmp as $email_array_data) 
		 {
		 	$this->pdb->table('email_templates')->insert($email_array_data);
		 }

		 return TRUE;

	}




	/**
	 * Install a single setting when upgrading
	 * 
	 * @param  [type] $sett_name [The key / slug of the settings in the main list]
	 * @return BOOL            [description]
	 */
	private function _create_settings($sett_name)
	{
		$settings = $this->ci->details_library->get_settings($sett_name);

		//set the settings name
		$settings['slug'] = $sett_name;

		return $this->db->insert('settings', $settings);

	}



	private function init_settings() 
	{

		$settings = $this->ci->details_library->get_settings();

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
			$this->ci->pyrocache->delete_all($cache_name);
		}

		return TRUE;

	}

	private function _remove_field($table,$field)
	{
		return $this->dbforge->drop_column($table, $field);
	}


				


}
/* End of file details.php */