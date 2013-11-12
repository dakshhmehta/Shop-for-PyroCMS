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
class Details_library  
{


	public function __construct() 
	{
		

	}


	public function info($and_get_menu = NULL)
	{
	 
		$info =  array(
			'name' => array(
				'en' => 'SHOP',
			),
			'description' => array(
				'en' => 'A full featured shopping cart system for PyroCMS!',
			),
			'skip_xss' => FALSE,
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => FALSE, 
			'author' => 'Salvatore Bordonaro',
            'roles' => array(
            	      	 
	            	'admin_products', 
	            	'admin_product_seo', 
	            	'admin_dailydeals', 

	            	'admin_options',
	            	'admin_brands', 	            	
	            	'admin_categories',

	            	'admin_orders', 
	            	'admin_analytics',

	            	'admin_pgroups', 
	            	'admin_tax', 
	            	'admin_checkout', /*Shiping and Gateways & Checkout*/

	            	'admin_blacklist',
					'admin_setup', /*manager area*/

            	 ),


			'sections' => array(
				'dashboard' => array(
					'name' => 'shop:admin:dashboard', 
					'uri' => 'admin/shop',
					'shortcuts' => array()  
				),
				'orders' => array(
					'name' => 'shop:admin:orders', 
					'uri' => 'admin/shop/orders',
					'shortcuts' => array()
				),			  
				'products' => array(
					'name' => 'shop:admin:products', 
					'uri' => 'admin/shop/products',
					'shortcuts' => array()
				),

			)
		);



		

        // Support for sub 2.2.0 menus
        if ( CMS_VERSION < '2.2.0' ) {
            $info['is_backend'] = TRUE;
            $info['menu']       = 'SHOP';
        }

		if (function_exists('group_has_role'))
		{
			//so we dont have to check again
		}
		else
		{
			return $info;
		}




		if($and_get_menu == 'dailydeals')
		{


			if(group_has_role('shop', 'admin_dailydeals'))
			{
				$info['sections']['dailydeals'] = array(
				
					'name' => 'shop:admin:dailydeals', 
					'uri' => 'admin/shop/dailydeals',
					'shortcuts' => array()
				 	
				);

			}

		}




		if($and_get_menu == 'categories')
		{


			if(group_has_role('shop', 'admin_categories'))
			{
				$info['sections']['categories'] = array(
				
					'name' => 'shop:admin:categories', 
					'uri' => 'admin/shop/categories',
					'shortcuts' => array()
				 	
				);

			}

		}



		if($and_get_menu == 'brands')
		{

			if(Settings::get('ss_enable_brands'))
			{	
				if(group_has_role('shop', 'admin_brands'))
				{
					$info['sections']['brands'] = array(
					
						'name' => 'shop:admin:brands', 
						'uri' => 'admin/shop/brands',
						'shortcuts' => array()
					 	
					);

				}
			}

		}


		if($and_get_menu == 'options')
		{


			if(group_has_role('shop', 'admin_options'))
			{
				$info['sections']['options'] = array(
				
					'name' => 'shop:admin:options', 
					'uri' => 'admin/shop/options',
					'shortcuts' => array()
				 	
				);

			}
		}


		if($and_get_menu == 'packages')
		{

			if(group_has_role('shop', 'admin_checkout'))
			{
				$info['sections']['packages'] = array(
				
					'name' => 'shop:admin:packages', 
					'uri' => 'admin/shop/packages',
					'shortcuts' => array()
				 	
				);

			}
		}


		if($and_get_menu == 'pgroups')
		{

			if(group_has_role('shop', 'admin_pgroups'))
			{
				$info['sections']['pgroups'] = array(
	
					'name' => 'shop:admin:pgroups', 
					'uri' => 'admin/shop/pgroups',
					'shortcuts' => array()
				 	
				);

			}
		}


		if($and_get_menu == 'blacklist')
		{

			if(group_has_role('shop', 'admin_blacklist'))
			{
				$info['sections']['blacklist'] = array(
				
					'name' => 'shop:admin:blacklist', 
					'uri' => 'admin/shop/blacklist',
					'shortcuts' => array()
				 	
				);

			}
		}


		if($and_get_menu == 'shipping')
		{

			if(group_has_role('shop', 'admin_checkout'))
			{
				$info['sections']['shipping'] = array(
				
					'name' => 'shop:admin:shipping', 
					'uri' => 'admin/shop/shipping',
					'shortcuts' => array()
				 	
				);

			}
		}


		if($and_get_menu == 'gateways')
		{
			if(group_has_role('shop', 'admin_checkout'))
			{
				$info['sections']['gateways'] = array(
		
					'name' => 'shop:admin:gateways', 
					'uri' => 'admin/shop/gateways',
					'shortcuts' => array()
				 	
				);
			}
		}


		if($and_get_menu == 'tax')
		{
			if(group_has_role('shop', 'admin_tax'))
			{
				$info['sections']['tax'] = array(
				
					'name' => 'shop:admin:tax', 
					'uri' => 'admin/shop/tax',
					'shortcuts' => array()
				 	
				);

			}
		}

		if($and_get_menu == 'admin_setup')
		{


			if(group_has_role('shop', 'admin_setup'))
			{
					 $info['sections']['manage'] = array(
						'name' => 'shop:admin:manage', 
						'uri' => 'admin/shop/manage',
						'shortcuts' => array()
					);	

			}
		}
		
		if($and_get_menu == 'analytics')
		{

		
			$info['sections']['analytics'] = array(

				'name' => 'shop:admin:analytics', 
				'uri' => 'admin/shop/analytics',
				'shortcuts' => array()

			);


			
		}		
	

		if($and_get_menu == 'manage')
		{

			if(group_has_role('shop', 'admin_manage'))
			{
				$info['sections']['manage'] = array(
				
					'name' => 'shop:admin:manage', 
					'uri' => 'admin/shop/manage',
					'shortcuts' => array()
				 	
				);

			}
		}
		

		return $info;

	}


    public function admin_menu(&$menu)
    {
		
		$menu['lang:shop:admin:shop'] = array(
            'lang:shop:admin:dashboard' 	=> 'admin/shop/',			
			'lang:shop:admin:orders' 	=> 'admin/shop/orders',            
			'lang:shop:admin:products' 	=> 'admin/shop/products',
			'lang:shop:admin:view_shop' 	=> 'shop/',					
		);


		//
		//populate menu with items
		//
		$menu['lang:shop:admin:shop_admin'] = array();
		




		if (function_exists('group_has_role'))
		{


		}
		else
		{
			return;
		}


			//
			// Check if brands is enabled
			//
			if(Settings::get('ss_enable_brands'))
			{	
				if(group_has_role('shop', 'admin_brands'))
				{
					if ( Settings::get('ss_enable_brands') == SettingMode::Enabled) 
					{ 
						$menu['lang:shop:admin:shop_admin']['lang:shop:admin:brands'] = 'admin/shop/brands';
					}
				}	
				
			}
		

			//
			// Add the rest of the items
			//
			if(group_has_role('shop', 'admin_dailydeals'))
			{
				$menu['lang:shop:admin:shop_admin']['lang:shop:admin:dailydeals'] = 'admin/shop/dailydeals';
			}				
			if(group_has_role('shop', 'admin_categories'))
			{
				$menu['lang:shop:admin:shop_admin']['lang:shop:admin:categories'] = 'admin/shop/categories';
			}	
			if(group_has_role('shop', 'admin_options'))
			{
				$menu['lang:shop:admin:shop_admin']['lang:shop:admin:options'] = 'admin/shop/options';
			}		
			if(group_has_role('shop', 'admin_blacklist'))
			{
				$menu['lang:shop:admin:shop_admin']['lang:shop:admin:blacklist'] = 'admin/shop/blacklist';
			}
			if(group_has_role('shop', 'admin_checkout'))
			{
				$menu['lang:shop:admin:shop_admin']['lang:shop:admin:packages'] = 'admin/shop/packages';
			}
			if(group_has_role('shop', 'admin_checkout'))
			{
				$menu['lang:shop:admin:shop_admin']['lang:shop:admin:shipping'] = 'admin/shop/shipping';
			}
			if(group_has_role('shop', 'admin_checkout'))
			{
				$menu['lang:shop:admin:shop_admin']['lang:shop:admin:gateways'] = 'admin/shop/gateways';
			}				
			if(group_has_role('shop', 'admin_pgroups'))
			{
				$menu['lang:shop:admin:shop_admin']['lang:shop:admin:pgroups'] = 'admin/shop/pgroups';
			}				
			if(group_has_role('shop', 'admin_tax'))
			{
				$menu['lang:shop:admin:shop_admin']['lang:shop:admin:tax'] = 'admin/shop/tax';
			}
			if(group_has_role('shop', 'admin_setup'))
			{
				$menu['lang:shop:admin:shop_admin']['lang:shop:admin:manage'] = 'admin/shop/manage';
			}			
			$menu['lang:shop:admin:shop_admin']['lang:shop:admin:analytics'] = 'admin/shop/analytics';

	

	}	


	public function get_tables($table = 'all')
	{

		$tables = array(
			'shop_products' => array(
				'id' => 			array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'slug' => 			array('type' => 'VARCHAR', 'constraint' => '100', 'unique' => TRUE),
				'name' => 			array('type' => 'VARCHAR', 'constraint' => '100'),
				'code' => 			array('type' => 'VARCHAR', 'constraint' => '100', 'default' => ''), /* product code  */

				'pgroup_id' => 		array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL), /*which associated product group*/
				'category_id' => 	array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE),
				'cover_id' => 		array('type' => 'CHAR', 'constraint' => 15, 'null' => TRUE, 'default' => NULL),
				
				'brand_id' => 		array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL),
				'package_id' => 	array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL),
				
				'description' => 	array('type' => 'TEXT', 'null' => TRUE, 'default' => NULL),
				//'short_desc' => 	array('type' => 'VARCHAR', 'constraint' => '255', 'default' => NULL), /*new*/
				'keywords' => 		array('type' => 'VARCHAR', 'constraint' => '32', 'null' => TRUE, 'default' => NULL),
				'meta_desc' => 		array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE, 'default' => NULL), /*seo short description*/
				'related' => 		array('type' => 'TEXT', 'null' => TRUE, 'default' => NULL),
				'user_data' => 		array('type' => 'TEXT', 'null' => TRUE, 'default' => NULL),
				//'product_type' => 	array('type' => "VARCHAR", 'constraint' => '50', 'default' => ''),
				
				
				# default package ing data - not required but if enetered it is used.
				'height' => array('type' => 'INT', 'constraint' => '5'	, 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL), /* KG - 100g = 0.001 */
				'width' => array('type' => 'INT', 'constraint' => '5'	, 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL), /* KG - 100g = 0.001 */
				'depth' => array('type' => 'INT', 'constraint' => '5'	, 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL), /* KG - 100g = 0.001 */
				'weight' => array('type' => 'INT', 'constraint' => '5'	, 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL), /* KG - 100g = 0.001 */

				# Prices
				'price' => 			array('type' => 'DECIMAL(10,2)', 'default' => 0), /* indexed at price for quick display */
				'price_bt' => 		array('type' => 'DECIMAL(10,2)', 'default' => 0),
				'price_at' => 		array('type' => 'DECIMAL(10,2)', 'default' => 0),
				'price_base' => 	array('type' => 'DECIMAL(10,2)', 'null' => TRUE,  'default' => 0), /*for every aditional item added to cart*/
				'rrp' => 			array('type' => 'DECIMAL(10,2)', 'null' => TRUE,  'default' => 0), /*always with tax, no need without - only for front end display, if price_at < rrp then show to custoemr */
				'tax_id' => 		array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL),	/*gst,nogst ect..*/
				'tax_dir' => 		array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL),	/* direction 1=inc : 0 excl */
				
				'digital' => 		array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'null' => TRUE, 'default' => 0),				
				'featured' => 		array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'null' => TRUE, 'default' => 0),  /* 1 is featured */
				'searchable' => 	array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'null' => TRUE, 'default' => 1),  /* 1 is featured */
				'public' => 		array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'null' => TRUE, 'default' => 0),  /* 1 is featured */	/* on off is the product available to be sold regardless of inventory is more than 0  */
				'min_qty' => 		array('type' => 'INT', 'constraint' => '5', 'unsigned' => TRUE, 'null' => TRUE, 'default' => 1), /* default is 1 */
				'max_qty' => 		array('type' => 'INT', 'constraint' => '5', 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL),	
				'views' => 			array('type' => 'INT', 'constraint' => '5', 'unsigned' => TRUE, 'default' => 0),
				'inventory_on_hand'=>array('type' => "INT", 'constraint' => '5', 'unsigned' => FALSE, 'default' => 0),
				'inventory_low_qty'=>array('type' => "INT", 'constraint' => '5', 'unsigned' => TRUE, 'default' => 5),
				'inventory_type' => array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'null' => TRUE, 'default' => 0), /*0=standard,1 unlimited*/ /*can this be moved to the status i.e unlimited-instack*/
				'status' => 		array('type' => "SET('discontinued',  'in_stock', 'soon_available', 'out_of_stock')", 'default' => 'in_stock'),

				//admin user id
				'created_by' => 	array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL),
				
				'date_created' => 		array('type' => 'DATETIME', 'null' => TRUE, 'default' => NULL), 	  
				'date_updated' => 		array('type' => 'DATETIME', 'null' => TRUE, 'default' => NULL), 
				'date_archived' => 		array('type' => 'DATETIME', 'null' => TRUE, 'default' => NULL), 
				
			),  
			'shop_dailydeals' => array(
				'id' => 		array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'prod_id' => 	array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL),
				'status' => 	array('type' => "SET('completed', 'pending', 'active', 'forcestop','alert')", 'default' => 'pending'),
				'mode' => 		array('type' => "SET('untilsold', 'endofday', 'letmedecide')", 'default' => 'endofday'),
				'likes' => 		array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'default' => 0), /*count the number of likes for this deal*/
				'shares' => 	array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'default' => 0), /*count the number of shared links for this deal*/
				'time_online'=> array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL),
				'date_start' => array('type' => 'DATE', 'null' => TRUE, 'default' => NULL), 
				'date_end' => 	array('type' => 'DATE', 'null' => TRUE, 'default' => NULL), 
			),		
			'shop_discounts' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'prod_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL),
				'min_qty' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'default' => 0),
				'price' => array('type' => 'DECIMAL(10,2)', 'null' => TRUE, 'default' => 0), /*only the at value*/
				'date_start' => array('type' => 'DATE', 'null' => TRUE, 'default' => NULL), /* this is deleted products*/  
				'date_end' => array('type' => 'DATE', 'null' => TRUE, 'default' => NULL), /* this is deleted products*/  
			),			
			'shop_group_prices' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'pgroup_id' => array('type' => 'VARCHAR', 'constraint' => '150'), /*product group */
				'ugroup_id' => array('type' => 'VARCHAR', 'constraint' => '2'),  /*user group*/
				'min_qty' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'default' => 0),  
				'price' => array('type' => 'DECIMAL(10,2)', 'null' => TRUE, 'default' => 0),
			), 
			/*attributes*/
			'shop_attributes' => array( 
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'prod_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE),
				'type' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE, 'default' => NULL ), /*null|select|checkbox|text|radio*/
				'name' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE, 'default' => NULL ),
				'value' => array('type' => 'TEXT', 'null' => TRUE, 'default' => NULL),	  
			),
			
			'shop_options' => array( 
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'name' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE, 'default' => NULL ),
				'title' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE, 'default' => NULL ),
				'description' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE, 'default' => NULL ),
				'slug' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE, 'default' => NULL ), 
				'type' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE, 'default' => NULL ), /*null|select|checkbox|text|radio*/
				'show_title' => array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'default' => 1 ),
			),
			
			'shop_option_values' => array( 
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'shop_options_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE),
				'label' => array('type' => 'TEXT', 'null' => TRUE, 'default' => NULL),	 
				'value' => array('type' => 'TEXT', 'null' => TRUE, 'default' => NULL),	  		
				'user_data' => array('type' => 'TEXT', 'null' => TRUE, 'default' => NULL),	  	
				'max_qty' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'default' => 0 ),
				'operator' => array('type' => 'VARCHAR', 'constraint' => '2', 'null' => TRUE, 'default' => NULL ),
				'operator_value' => array('type' => 'DECIMAL(10,2)', 'null' => TRUE, 'default' => 0),
				'default' => array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'default' => 0 ), /*is this a default or checked option*/
				'ignor_shipping' => array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'default' => 0 ), 
				'order' => array('type' => 'INT', 'constraint' => '4', 'unsigned' => TRUE, 'default' => 0 ), /*is this a default or checked option*/
			),
			
			'shop_prod_options' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'prod_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'key' => TRUE),
				'option_id' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE, 'default' => NULL ), 
				'order' => array('type' => 'INT', 'constraint' => '4', 'unsigned' => TRUE, 'default' => 0 ), /*is this a default or checked option*/				 
			),
			
			'shop_images' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'file_id' => array('type' => 'CHAR', 'constraint' => 15),
				'product_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE),
				'restrain_size' => array('type' => "ENUM('no', 'yes_both','yes_height','yes_width')", 'default' => 'yes_width'),
				'width' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL),
				'height' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL),
				'display' => array('type' => "ENUM('no', 'yes')", 'default' => 'yes'),
				'order' => array('type' => 'INT', 'constraint' => '4', 'unsigned' => TRUE, 'null' => TRUE, 'default' => 0), /* order todisplay - not needed for v1 */
				'cover' => array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'null' => TRUE, 'default' => 0), /*is this the cover image */
				'scope' => array('type' => 'TEXT', 'null' => TRUE, 'default' => NULL), /* Products/Category/Brands*/
			),
			'shop_transactions' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'order_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE),
				'txn_id' => array('type' => 'VARCHAR', 'constraint' => '255'),
				'status' => array('type' => "ENUM('pending','accepted','rejected')", 'default' => 'pending'),
				'reason' => array('type' => 'TEXT',),
				'amount' => array('type' => 'DECIMAL(10,2)'),	/*credit to shop*/		  
				'refund' => array('type' => 'DECIMAL(10,2)'),	/*debit from shop*/
				'gateway' => array('type' => 'VARCHAR', 'constraint' => '100'),
				'user' => array('type' => 'VARCHAR', 'constraint' => '50'), /*SYSTEM/ADMIN/CUSTOMER*/
				'data' => array('type' => 'TEXT',),
				'timestamp' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE),
			),			
			'shop_orders' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'user_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,),
				'pmt_status' => array('type' => "ENUM('unpaid', 'paid')", 'default' => 'unpaid'),							
				'status' => array('type' => "ENUM('placed', 'pending', 'paid','processing', 'complete', 'shipped', 'returned', 'cancelled','closed','reopen')", 'default' => 'pending'),				
				'cost_items' => array('type' => 'DECIMAL(8,2)', 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL),
				'cost_shipping' => array('type' => 'DECIMAL(8,2)', 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL),	
				'cost_total' => array('type' => 'DECIMAL(8,2)', 'unsigned' => TRUE, 'null' => TRUE, 'default' => NULL),
				'shipping_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,),
				'gateway_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,),
				'billing_address_id' => array('type' => "INT", 'constraint' => '11', 'unsigned' => TRUE, 'default' => 0),
				'shipping_address_id' => array('type' => "INT", 'constraint' => '11', 'unsigned' => TRUE, 'default' => 0),
				'session_id' => array('type' => 'VARCHAR', 'constraint' => '40', 'default' => '',),
				'ip_address' => array('type' => 'VARCHAR', 'constraint' => '40', 'default' => '',),
				'tracking_code' => array('type' => 'VARCHAR', 'constraint' => '110', 'default' => '',),
				'data' => array('type' => 'VARCHAR', 'constraint' => '500', 'default' => '',),
				'trust_core' => array('type' => 'INT', 'constraint' => '11'),
				'order_date' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,),
			),
			'shop_order_items' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'order_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,),
				'product_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,),
				'options' => array('type' => 'TEXT', 'null' => TRUE, 'default' => NULL),
				'title' => array('type' => 'VARCHAR', 'constraint' => '100', 'default' => '',),
				'qty' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE),
				'cost_item' => array('type' => 'DECIMAL(10,2)', 'unsigned' => TRUE),
				'cost_sub' => array('type' => 'DECIMAL(10,2)', 'unsigned' => TRUE),
				'cost_base' => array('type' => 'DECIMAL(10,2)', 'unsigned' => TRUE),
				
			),
			/*preparing for the digital delivery*/
			'shop_downloads' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'order_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,),
				'product_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,),
				'download_at' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,), /*download attempts*/
				'ip_addresss' => array('type' => 'VARCHAR', 'constraint' => '15', 'null' => TRUE, 'default' => NULL,),
				'user_agent' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE, 'default' => NULL,),
				'key' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => TRUE, 'default' => NULL,),
				'attempts' => array('type' => 'INT', 'constraint' => '5', 'unsigned' => TRUE, 'default' => 0,),
			),			
			'shop_order_messages' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'order_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,),
				'user_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,),
				'replyto_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE, 'default' => 0),
				'subject' => array('type' => 'TEXT', 'null' => TRUE),
				'message' => array('type' => 'TEXT', 'null' => TRUE),
				'type' => array('type' => "ENUM('system', 'user')", 'default' => 'user'),
				'date_sent' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,),
				'user_name' => array('type' => 'TEXT'),
				'status' => array('type' => 'INT', 'constraint' => '1', 'default' => 0),
			),	   
			'shop_order_notes' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'order_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,),
				'user_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,),
				'message' => array('type' => 'TEXT', 'null' => TRUE),
				'date' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,),
			),	
			'shop_blacklist' => array(
				'id' => 			array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'name' => 			array('type' => 'VARCHAR', 'constraint' => '200'),
				'method' => 		array('type' => 'INT', 'constraint' => '4', 'default' => 2), 
				'value' => 			array('type' => 'VARCHAR', 'constraint' => '300', 'default' => ''), 
				'enabled' => 		array('type' => 'INT', 'constraint' => '1', 'default' => 1), 
			),
			'shop_categories' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'name' => array('type' => 'VARCHAR', 'constraint' => '100'),
				'slug' => array('type' => 'VARCHAR', 'constraint' => '100', 'unique' => TRUE, 'key' => true),
				'description' => array('type' => 'TEXT'),
				'image_id' => array('type' => 'CHAR', 'constraint' => 15, 'null' => TRUE, 'default' => NULL),
				'parent_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'default' => 0), /*structure for heirachial but not by default*/
				'order' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'default' => 0),  
				'user_data' => array('type' => 'TEXT'),
			),		
			'shop_brands' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'name' => array('type' => 'VARCHAR', 'constraint' => '100'),
				'slug' => array('type' => 'VARCHAR', 'constraint' => '100', 'unique' => TRUE, 'key' => true),				
				'notes' => array('type' => 'TEXT', 'null' => TRUE, 'default' => NULL),			
				'image_id' => array('type' => 'CHAR', 'constraint' => 15, 'null' => TRUE, 'default' => NULL),
				'date_changed' => array('type' => 'TIMESTAMP'),	 
			),		
			'shop_pgroups' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'name' => array('type' => 'VARCHAR', 'constraint' => '100'),				
				'description' => array('type' => 'TEXT', 'null' => TRUE, 'default' => NULL),	
				'base_cost' => array('type' => 'DECIMAL(10,2)', 'null' => TRUE,  'default' => 0),				
				'date_changed' => array('type' => 'TIMESTAMP'),	 
			),	
			/*shipping,packages,gateways*/
			'shop_gateways' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'title' => array('type' => 'VARCHAR', 'constraint' => '100'),
				'slug' => array('type' => 'VARCHAR', 'constraint' => '100'), 
				'desc' => array('type' => 'TEXT'),
				'enabled' => array('type' => 'INT', 'constraint' => '1', 'default' => 0),
				'options' => array('type' => 'TEXT'),
			),	
			/*shipping,packages,gateways*/
			'shop_shipping' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'title' => array('type' => 'VARCHAR', 'constraint' => '100'),
				'slug' => array('type' => 'VARCHAR', 'constraint' => '100'), 
				'desc' => array('type' => 'TEXT'),
				'enabled' => array('type' => 'INT', 'constraint' => '1', 'default' => 0),
				'options' => array('type' => 'TEXT'),
			),	
			/*shipping,packages,gateways*/
			'shop_packages' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'title' => array('type' => 'VARCHAR', 'constraint' => '100'),
				'slug' => array('type' => 'VARCHAR', 'constraint' => '100'), 
				'desc' => array('type' => 'TEXT'),
				'enabled' => array('type' => 'INT', 'constraint' => '1', 'default' => 0),
				'options' => array('type' => 'TEXT'),
			),										
			'shop_addresses' => array( 
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'user_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE,),
				'email' => array('type' => 'VARCHAR', 'constraint' => '100'),
				'first_name' => array('type' => 'VARCHAR', 'constraint' => '100'),
				'last_name' => array('type' => 'VARCHAR', 'constraint' => '100'),
				'company' => array('type' => 'VARCHAR', 'constraint' => '100'),
				'address1' => array('type' => 'VARCHAR', 'constraint' => '100'),
				'address2' => array('type' => 'VARCHAR', 'constraint' => '100'),
				'city' => array('type' => 'VARCHAR', 'constraint' => '80'),
				'state' => array('type' => 'VARCHAR', 'constraint' => '80'),
				'country' => array('type' => 'VARCHAR', 'constraint' => '80'),
				'zip' => array('type' => 'VARCHAR', 'constraint' => '10'),
				'phone' => array('type' => 'VARCHAR', 'constraint' => '15'),
				'deleted' => array('type' => 'INT', 'constraint' => '1', 'default' => 0),
			),	
			/*shipping,packages,gateways*/
			'shop_countries' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'name' => array('type' => 'VARCHAR', 'constraint' => '150'),
				'code2' => array('type' => 'VARCHAR', 'constraint' => '2'), 
				'code3' => array('type' => 'VARCHAR', 'constraint' => '3', 'default' => ''), /*not used in this ver*/
				'enabled' => array('type' => 'INT', 'constraint' => '1', 'default' => 0),
			),							  
			'shop_wishlist' => array(
				'user_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'key' => TRUE),
				'product_id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'key' => TRUE),				
				'price_or' => array('type' => 'DECIMAL(10,2)', 'default' => 0), /*price at time of adding*/
				'user_notified' => array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE), /*has the user been notified about the price decrease*/
				'date_added' => array('type' => 'TIMESTAMP'),
			),		  
			'shop_tax' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'name' => array('type' => 'VARCHAR', 'constraint' => '100'),
				'rate' => array('type' => 'DECIMAL(4,2)'),
				'rate_local' => array('type' => 'DECIMAL(4,2)', 'default' => 0),	 /*not used now */
				'rate_state' => array('type' => 'DECIMAL(4,2)', 'default' => 0),	
				'rate_fed' => array('type' => 'DECIMAL(4,2)', 'default' => 0),  	  
			),
			'shop_trust_data' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'score' =>  array('type' => 'INT', 'constraint' => '1', 'default' => 1), /*product group */
				'category' => array('type' => 'VARCHAR', 'constraint' => '50', 'default' => ''),   /*user group*/
				'word' => array('type' => 'VARCHAR', 'constraint' => '200', 'default' => ''), /*product group */
				'count' => array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'default' => 1),  /*times used*/
				'enabled' => array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'default' => 1),  
			),
			'shop_lang' => array(
				'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
				'module' =>   array('type' => 'VARCHAR', 'constraint' => '80', 'default' => ''), 
				'area' => array('type' => 'VARCHAR', 'constraint' => '80', 'default' => ''), 
				'key' => array('type' => 'VARCHAR', 'constraint' => '80', 'default' => ''), 
				'value' => array('type' => 'VARCHAR', 'constraint' => '80', 'default' => ''), 
			),		
			);	


		if($table == 'all')
		{
			return $tables;
		}
		else
		{
			return array($table=>$tables[$table]);
		}
		
	}


	public function get_cache_list()
 	{

		return array(
				'products_m',
				'products_admin_m',
				'products_front_m',
				'categories_m',
				'brands_m',
				'options_m'
				);

	}


	/**
	 * Settings
	 *
	 * ss_distribution_loc
	 *
	 * 
	 * @return [type] [description]
	 */
	public function get_settings($get = 'all')
	{
		$settings = array(
			'ss_distribution_loc' => array( /*distribution location ISO 2 letter country code*//*http://www.iso.org/iso/country_codes.htm*/
				'title' => 'Distribution Country', 
				'description' => 'Set your ISO 3166-1 alpha-2 code of your distribution center. This is important for shipping',
				'type' => 'text', 
				'default' => 'AU', 
				'value' => 'AU', 
				'options' => '', 
				'is_required' => TRUE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 960
			),		  
			'ss_name' => array(
				'title' => 'Shop Name', 
				'description' => 'Give your online shop a name - This will be used on title pages and general places around the Shop',
				'type' => 'text', 
				'default' => 'My Online Shop', 
				'value' => 'My Online Shop', 
				'options' => '', 
				'is_required' => TRUE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 950
			),	  
			'ss_slogan' => array(
				'title' => 'Shop Slogan', 
				'description' => 'The slogan will be used in the Shops title pages. You may also use the plugin { Shop:slogan }',
				'type' => 'text', 
				'default' => '', 
				'value' => '', 
				'options' => '', 
				'is_required' => FALSE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 940
			),				  
			'ss_currency_code' => array(
				'title' => 'Shop Currency', 
				'description' => 'Currency Code you will accept (ISO-4217 format, ex. AUD)',
				'type' => 'text', 
				'default' => 'AUD', 
				'value' => 'AUD', 
				'options' => '', 
				'is_required' => FALSE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 890
			),
			'ss_currency_symbol' => array(
				'title' => 'Currency Symbol', 
				'description' => 'Select which currency symbol your store will use',
				'type' => 'select', 
				'default' => '2', 
				'value' => '2', 
				'options' => '0=None Required|1=L|2=&#36;|3=&#163;|4=&#165;|5=Rp|6=&#128;', 
				'is_required' => FALSE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 888
			),		  
			'ss_currency_layout' => array(
				'title' => 'Show currency symbol before value', 
				'description' => '$ XX.XX or XX.XX $',
				'type' => 'radio',			  
				'default' => 1, 
				'value' => '', 
				'options' => '1=Before|0=After',
				'is_required' => TRUE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 887
			),	  
			'ss_currency_thousand_sep' => array(
				'title' => 'Thousands seperator', 
				'description' => 'Thousands Separator Formatting',
				'type' => 'radio',			  
				'default' => 0, 
				'value' => '0', 
				'options' => '0=Comma |1=Decimal|2=Single Space',
				'is_required' => TRUE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 886
			),	  
			'ss_currency_decimal_sep' => array(
				'title' => 'Decimal seperator', 
				'description' => 'Decimal Separator Formatting',
				'type' => 'radio',			  
				'default' => 1, 
				'value' => '1', 
				'options' => '0=Comma |1=Decimal|2=Single Space',
				'is_required' => TRUE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 885
			),			    
			'ss_enable_brands' => array(
				'title' => 'Enable Product Brands',
				'description' => 'Enable this if your products have ',
				'type' => 'radio',
				'default' => '0',
				'value' => '0',
				'options' => '1=Yes| 0=No',
				'is_required' => TRUE,
				'is_gui' => TRUE,
				'module' => 'shop',
				'order' => 860
			),			 
				
			'ss_qty_perpage_limit' => array(
				'title' => 'Products per page',
				'description' => 'How many products show in category view (0 - general pagination settings will be used)',
				'type' => 'text', 
				'default' => 20, 
				'value' => '', 
				'options' => '', 
				'is_required' => TRUE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 820
			),
			'ss_qty_perpage_limit_front' => array(
				'title' => 'Products per page',
				'description' => 'How many products show in list view (front end only)',
				'type' => 'text', 
				'default' => 10, 
				'value' => '', 
				'options' => '', 
				'is_required' => TRUE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 820
			),			
			'ss_require_login' => array(
				'title' => 'Require login to use shop', 
				'description' => 'Will you require your users to have an account to shop online..',
				'type' => 'radio', 
				'default' => 0, 
				'value' => '', 
				'options' => '1=Yes|0=No', 
				'is_required' => FALSE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 800
			),
			'ss_ssl_required' => array(
				'title' => 'Enable Secure SSL Payment', 
				'description' => 'Require to proccess order and payment through SSL',
				'type' => 'radio', 
				'default' => 0, 
				'value' => '', 
				'options' => '1=Yes|0=No', 
				'is_required' => FALSE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 790
			),  
			'nc_open_status' => array(
				'title' => 'Shop Open Status', 
				'description' => 'Use this option to the user-facing part of the Shop. Useful when you want to take the Shop offline without shutting down the whole site',
				'type' => 'radio', 
				'default' => 1, 
				'value' => '',  /* On install its  off */
				'options' => '1=Yes|0=No', 
				'is_required' => TRUE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 760
			),	 
			'nc_menu_style' => array(
				'title' => 'Admin Menu', 
				'description' => 'Chose a view (Lite or Advanced)',
				'type' => 'radio', 
				'default' => 0, 
				'value' => '', 
				'options' => '1=Lite|0=Advanced', 
				'is_required' => FALSE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 750
			),   		
			'nc_jq' => array(
				'title' => 'Include jQuery for Checkout page',
				'description' => 'The default checkout page requires jQuery - If you have it in your sites template you do not need to re-ad this library. Otherwise please leave it on.',
				'type' => 'radio',
				'default' => 1,
				'value' => '',
				'options' => '1=On|0=Off',
				'is_required' => FALSE,
				'is_gui' => TRUE,
				'module' => 'shop',
				'order' => 740
				),		
			'shop_maps_api_key' => array(
				'title' => 'Maps API Key', 
				'description' => 'Your Bing Maps API key',
				'type' => 'text', 
				'default' => 'AgpF1qzvcp1FMroCizh3eQByhhOcefLhjqqbuwUAPmE5QYy6Joy338fImFPm34Kv', /* TODO:Remove my bing key */
				'value' => '', 
				'options' => '', 
				'is_required' => FALSE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 720
			),
			'nc_date_format' => array(
				'title' => 'Date Format', 
				'description' => 'For both frontend and backend  - (Samples are showing the 28th April 2013)',
				'type' => 'select', 
				'default' => '1', 
				'value' =>  '1', 
				'options' => '0=28-4-2013|1=28/4/2013|2=4-28-2013|3=4/28/2013',
				'is_required' => FALSE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 700
			),
			'nc_total_recent_orders' => array(
				'title' => 'Max Recent Orders in Dashboard', 
				'description' => 'Display the maximum results of recent orders to display in dashboard view)',
				'type' => 'select', 
				'default' => '1', 
				'value' =>  '0', 
				'options' => '5=5|10=10|20=20|25=25|50=50|100=100',
				'is_required' => TRUE,
				'is_gui' => TRUE, 
				'module' => 'shop', 
				'order' => 680
			),		
			'shop_admin_login_location' => array(
				'title' => 'Default screen for admin', 
				'description' => 'When an admin logs in, which screen should they see by default',
				'type' => 'select', 
				'default' => '0', 
				'value' =>  '0', 
				'options' => '0=Default|1=Shop Dashboard|2=Shop Products|3=Shop Orders',
				'is_required' => TRUE,
				'is_gui' => FALSE, 
				'module' => 'shop', 
				'order' => 680
			),			
			'shop_upload_file_orders' => array(
				'title' => 'Upload Directory : customer attatchments', 
				'description' => 'This is only used for customers that want to add a file attatchment',
				'type' => 'text', 
				'default' => '0', 
				'value' =>  '0', 
				'options' => '',
				'is_required' => TRUE,
				'is_gui' => FALSE, 
				'module' => 'shop', 
				'order' => 680
			),	
			'shop_upload_file_product' => array(
				'title' => 'Upload directory : product Images ', 
				'description' => 'This is only used for admins to assign an upload folder for product images.',
				'type' => 'text', 
				'default' => '0', 
				'value' =>  '0', 
				'options' => '',
				'is_required' => TRUE,
				'is_gui' => FALSE, 
				'module' => 'shop', 
				'order' => 680
			),						

		);

		if($get != 'all')
		{
			return $settings[$get];
		}

		return $settings;
	}



	public function get_email_templates()
	{

		return array(
			 array(
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
			),
			array(
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
			),
			array(
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
			)
		);


	}




	public function get_array($name = 'trust_score')
	{
		$_untrusted_words = array();

		//
		// Commerce scores can vary based on the value as the shop is a commerce system
		//
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'As seen on' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'Buying judgments' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'Order status' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'buy' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'clearance' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'order shipped by' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'buy direct' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'clearance' );

		//
		// Persoinals get a high risk score
		//
		$_untrusted_words[] = array('score'=> 2, 'category' => 'personal', 'word' => 'Dig up dirt on friends' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'personal', 'word' => 'Meet singles' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'personal', 'word' => 'Score with babes' );

		//
		// Employment 
		//
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment ', 'word' => 'Additional Income' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'Be your own boss' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'Compete for your business' );		
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment ', 'word' => 'Double your');
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'earn $' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'Earn extra cash' );	
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'Earn per week' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'expect to earn' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'extra income ' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'employment', 'word' => 'home based' );		
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'homebased business' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'employment', 'word' => 'homebased' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'opportunity' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'work from home' );		


		//
		// Financial
		//
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'bargain' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'beneficiary' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'affordable' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'cash' );	
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'credit' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'free' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'f r e e' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'only' );	
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'o n l y' );	
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'save' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'us dollars' );	
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'why pay more' );		
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'investment' );		


		//
		// General
		//
		$_untrusted_words[] = array('score'=> 3, 'category' => 'general', 'word' => 'nigeria' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'general', 'word' => 'ukraine' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'general', 'word' => 'india' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'general', 'word' => 'china' );		
		$_untrusted_words[] = array('score'=> 1, 'category' => 'general', 'word' => 'us' );	

		return $_untrusted_words;			
	}




	public $_countryList = array(
				'AF' => 'Afghanistan',
				'AL' => 'Albania',
				'DZ' => 'Algeria',
				'AS' => 'American Samoa',
				'AD' => 'Andorra',
				'AO' => 'Angola',
				'AI' => 'Anguilla',
				'AQ' => 'Antarctica',
				'AG' => 'Antigua and Barbuda',
				'AR' => 'Argentina',
				'AM' => 'Armenia',
				'AW' => 'Aruba',
				'AU' => 'Australia',
				'AT' => 'Austria',
				'AZ' => 'Azerbaijan',
				'BS' => 'Bahamas',
				'BH' => 'Bahrain',
				'BD' => 'Bangladesh',
				'BB' => 'Barbados',
				'BY' => 'Belarus',
				'BE' => 'Belgium',
				'BZ' => 'Belize',
				'BJ' => 'Benin',
				'BM' => 'Bermuda',
				'BT' => 'Bhutan',
				'BO' => 'Bolivia',
				'BA' => 'Bosnia and Herzegovina',
				'BW' => 'Botswana',
				'BV' => 'Bouvet Island',
				'BR' => 'Brazil',
				'BQ' => 'British Antarctic Territory',
				'IO' => 'British Indian Ocean Territory',
				'VG' => 'British Virgin Islands',
				'BN' => 'Brunei',
				'BG' => 'Bulgaria',
				'BF' => 'Burkina Faso',
				'BI' => 'Burundi',
				'KH' => 'Cambodia',
				'CM' => 'Cameroon',
				'CA' => 'Canada',
				'CT' => 'Canton and Enderbury Islands',
				'CV' => 'Cape Verde',
				'KY' => 'Cayman Islands',
				'CF' => 'Central African Republic',
				'TD' => 'Chad',
				'CL' => 'Chile',
				'CN' => 'China',
				'CX' => 'Christmas Island',
				'CC' => 'Cocos [Keeling] Islands',
				'CO' => 'Colombia',
				'KM' => 'Comoros',
				'CG' => 'Congo - Brazzaville',
				'CD' => 'Congo - Kinshasa',
				'CK' => 'Cook Islands',
				'CR' => 'Costa Rica',
				'HR' => 'Croatia',
				'CU' => 'Cuba',
				'CY' => 'Cyprus',
				'CZ' => 'Czech Republic',
				'CI' => 'Cote d Ivoire',
				'DK' => 'Denmark',
				'DJ' => 'Djibouti',
				'DM' => 'Dominica',
				'DO' => 'Dominican Republic',
				'NQ' => 'Dronning Maud Land',
				'DD' => 'East Germany',
				'EC' => 'Ecuador',
				'EG' => 'Egypt',
				'SV' => 'El Salvador',
				'GQ' => 'Equatorial Guinea',
				'ER' => 'Eritrea',
				'EE' => 'Estonia',
				'ET' => 'Ethiopia',
				'FK' => 'Falkland Islands',
				'FO' => 'Faroe Islands',
				'FJ' => 'Fiji',
				'FI' => 'Finland',
				'FR' => 'France',
				'GF' => 'French Guiana',
				'PF' => 'French Polynesia',
				'TF' => 'French Southern Territories',
				'FQ' => 'French Southern and Antarctic Territories',
				'GA' => 'Gabon',
				'GM' => 'Gambia',
				'GE' => 'Georgia',
				'DE' => 'Germany',
				'GH' => 'Ghana',
				'GI' => 'Gibraltar',
				'GR' => 'Greece',
				'GL' => 'Greenland',
				'GD' => 'Grenada',
				'GP' => 'Guadeloupe',
				'GU' => 'Guam',
				'GT' => 'Guatemala',
				'GG' => 'Guernsey',
				'GN' => 'Guinea',
				'GW' => 'Guinea-Bissau',
				'GY' => 'Guyana',
				'HT' => 'Haiti',
				'HM' => 'Heard Island and McDonald Islands',
				'HN' => 'Honduras',
				'HK' => 'Hong Kong SAR China',
				'HU' => 'Hungary',
				'IS' => 'Iceland',
				'IN' => 'India',
				'ID' => 'Indonesia',
				'IR' => 'Iran',
				'IQ' => 'Iraq',
				'IE' => 'Ireland',
				'IM' => 'Isle of Man',
				'IL' => 'Israel',
				'IT' => 'Italy',
				'JM' => 'Jamaica',
				'JP' => 'Japan',
				'JE' => 'Jersey',
				'JT' => 'Johnston Island',
				'JO' => 'Jordan',
				'KZ' => 'Kazakhstan',
				'KE' => 'Kenya',
				'KI' => 'Kiribati',
				'KW' => 'Kuwait',
				'KG' => 'Kyrgyzstan',
				'LA' => 'Laos',
				'LV' => 'Latvia',
				'LB' => 'Lebanon',
				'LS' => 'Lesotho',
				'LR' => 'Liberia',
				'LY' => 'Libya',
				'LI' => 'Liechtenstein',
				'LT' => 'Lithuania',
				'LU' => 'Luxembourg',
				'MO' => 'Macau SAR China',
				'MK' => 'Macedonia',
				'MG' => 'Madagascar',
				'MW' => 'Malawi',
				'MY' => 'Malaysia',
				'MV' => 'Maldives',
				'ML' => 'Mali',
				'MT' => 'Malta',
				'MH' => 'Marshall Islands',
				'MQ' => 'Martinique',
				'MR' => 'Mauritania',
				'MU' => 'Mauritius',
				'YT' => 'Mayotte',
				'FX' => 'Metropolitan France',
				'MX' => 'Mexico',
				'FM' => 'Micronesia',
				'MI' => 'Midway Islands',
				'MD' => 'Moldova',
				'MC' => 'Monaco',
				'MN' => 'Mongolia',
				'ME' => 'Montenegro',
				'MS' => 'Montserrat',
				'MA' => 'Morocco',
				'MZ' => 'Mozambique',
				'MM' => 'Myanmar [Burma]',
				'NA' => 'Namibia',
				'NR' => 'Nauru',
				'NP' => 'Nepal',
				'NL' => 'Netherlands',
				'AN' => 'Netherlands Antilles',
				'NT' => 'Neutral Zone',
				'NC' => 'New Caledonia',
				'NZ' => 'New Zealand',
				'NI' => 'Nicaragua',
				'NE' => 'Niger',
				'NG' => 'Nigeria',
				'NU' => 'Niue',
				'NF' => 'Norfolk Island',
				'KP' => 'North Korea',
				'VD' => 'North Vietnam',
				'MP' => 'Northern Mariana Islands',
				'NO' => 'Norway',
				'OM' => 'Oman',
				'PC' => 'Pacific Islands Trust Territory',
				'PK' => 'Pakistan',
				'PW' => 'Palau',
				'PS' => 'Palestinian Territories',
				'PA' => 'Panama',
				'PZ' => 'Panama Canal Zone',
				'PG' => 'Papua New Guinea',
				'PY' => 'Paraguay',
				'YD' => 'Peoples Democratic Republic of Yemen',
				'PE' => 'Peru',
				'PH' => 'Philippines',
				'PN' => 'Pitcairn Islands',
				'PL' => 'Poland',
				'PT' => 'Portugal',
				'PR' => 'Puerto Rico',
				'QA' => 'Qatar',
				'RO' => 'Romania',
				'RU' => 'Russia',
				'RW' => 'Rwanda',
				'RE' => 'Reunion',
				'BL' => 'Saint Barthelemy',
				'SH' => 'Saint Helena',
				'KN' => 'Saint Kitts and Nevis',
				'LC' => 'Saint Lucia',
				'MF' => 'Saint Martin',
				'PM' => 'Saint Pierre and Miquelon',
				'VC' => 'Saint Vincent and the Grenadines',
				'WS' => 'Samoa',
				'SM' => 'San Marino',
				'SA' => 'Saudi Arabia',
				'SN' => 'Senegal',
				'RS' => 'Serbia',
				'CS' => 'Serbia and Montenegro',
				'SC' => 'Seychelles',
				'SL' => 'Sierra Leone',
				'SG' => 'Singapore',
				'SK' => 'Slovakia',
				'SI' => 'Slovenia',
				'SB' => 'Solomon Islands',
				'SO' => 'Somalia',
				'ZA' => 'South Africa',
				'GS' => 'South Georgia and the South Sandwich Islands',
				'KR' => 'South Korea',
				'ES' => 'Spain',
				'LK' => 'Sri Lanka',
				'SD' => 'Sudan',
				'SR' => 'Suriname',
				'SJ' => 'Svalbard and Jan Mayen',
				'SZ' => 'Swaziland',
				'SE' => 'Sweden',
				'CH' => 'Switzerland',
				'SY' => 'Syria',
				'ST' => 'Sao Tome and Principe',
				'TW' => 'Taiwan',
				'TJ' => 'Tajikistan',
				'TZ' => 'Tanzania',
				'TH' => 'Thailand',
				'TL' => 'Timor-Leste',
				'TG' => 'Togo',
				'TK' => 'Tokelau',
				'TO' => 'Tonga',
				'TT' => 'Trinidad and Tobago',
				'TN' => 'Tunisia',
				'TR' => 'Turkey',
				'TM' => 'Turkmenistan',
				'TC' => 'Turks and Caicos Islands',
				'TV' => 'Tuvalu',
				'UM' => 'U.S. Minor Outlying Islands',
				'PU' => 'U.S. Miscellaneous Pacific Islands',
				'VI' => 'U.S. Virgin Islands',
				'UG' => 'Uganda',
				'UA' => 'Ukraine',
				'SU' => 'Union of Soviet Socialist Republics',
				'AE' => 'United Arab Emirates',
				'GB' => 'United Kingdom',
				'US' => 'United States',
				'ZZ' => 'Unknown or Invalid Region',
				'UY' => 'Uruguay',
				'UZ' => 'Uzbekistan',
				'VU' => 'Vanuatu',
				'VA' => 'Vatican City',
				'VE' => 'Venezuela',
				'VN' => 'Vietnam',
				'WK' => 'Wake Island',
				'WF' => 'Wallis and Futuna',
				'EH' => 'Western Sahara',
				'YE' => 'Yemen',
				'ZM' => 'Zambia',
				'ZW' => 'Zimbabwe',
				'AX' => 'Aland Islands',
			);


	

}
