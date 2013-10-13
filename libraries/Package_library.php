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

require_once('Core_library.php');

class Package_library extends Core_library
{


	public $version = 2.1;
	
	
	/**  
	 * @var Boolean: if true, allows multiple of the module to be installed
	 */
	public $nc_multiple = TRUE;
	
	
	/** fs_path
	 * Example: c:\wwwroot\pyro\addons\shared_addons\modules\shop\libraries\
	 *
	 * @var String: Directory location to module install path + '/libraries/gateways'
	 */
	public $fs_path = '';



	
	/**
	 * www_path
	 * 
	 * Example: www.domain.com/addons/shared_addons/modules/shop/libraries/
	 * @var string Same as fs_path but this will present the public URI of the ocation
	 */
	public $www_path = '';
	
	
	
	/** db_table
	 * 
	 * @var String The Database Table associated with the library
	 */
	protected $db_table = 'shop_packages'; //this must be set by the inheriting class
	protected $db_orders = 'shop_orders';
	protected $module_name = 'packages';
	protected $class_prefix = '';
	protected $class_suffix = '_Package'; //used for geting the class object
	protected $title = '';
	
	//by default always true
	public $feature_enable = TRUE;
	
	
	public function __construct() 
	{
		
		$this->load->helper('directory');


		$this->set_path('packages');

	}
	
	
	/**
	 *
	 * @param unknown_type $var
	 */
	public function __get($var) 
	{
		if (isset(get_instance()->$var)) 
		{
			return get_instance()->$var;
		}
	}
	
	
	/**
	 * Sets the path to the directory 
	 * @param unknown_type $string_dir_name The name of the directory
	 * 
	 */
	protected function set_path($string_dir_name) 
	{
	
		$this->module_name = $string_dir_name;
		$this->db_module = $string_dir_name;
		
		//Path to gateways for FileSystem
		$this->fs_path =  dirname(__FILE__) . '/'.$this->module_name.'/';

		//Path to gateways for www access
		$this->www_path = base_url() . $this->module_details['path'].'/libraries/' . $this->module_name .'/';
		
	}	
	

	/**
	 * 
	 * @see http://ellislab.com/codeigniter/user-guide/helpers/directory_helper.html  - Directory_Helper
	 *
	 * @return Array: returns the array of Object Instance that are not installed
	 */
	public function get_uninstalled() 
	{
			
		//only map 1 depth - level of directories
		$map = directory_map($this->fs_path, 1);
	
	
		$uninstalled_objects = array();

		//shop/gateways/'
		foreach ($map as $key => $folder) 
		{
			
			//echo $folder;
	
			//echo $folder;
			if (!is_dir($this->fs_path . $folder))  
			{
					
				//remove ALL directory listings
				unset($map[$key]);
	
			}
			else {
					
				$lib_object = $this->get_lib_object( $folder );
	
				# If Not FALSE
				if (  $lib_object  ) 
				{
					
					# Add to list of acceptable gateways
					$uninstalled_objects[] = $lib_object;
				}
	
			}
		}

		return $uninstalled_objects;
	}	
	
	
	/** install($slug) - install('paypal')
	 *
	 * Installed a gateway by inserting it into the DB
	 *
	 * @param String $slug : String value for the gateway
	 * @return boolean : If it was installed successfully
	 */
	public function install($slug) 
	{
		//check if already installed
		if(!$this->nc_multiple)
		{
			$allo = $this->db->where('slug',$slug)->get($this->db_table)->num_rows();
			if($allo >= 1) return TRUE;
		}

		
		$lib_object = $this->get_lib_object($slug);
	
		if ( $lib_object ) 
		{
	
			//prepare array
			$insert = array(
					'title' => $lib_object->title,
					'module' => $this->module_name,
					'slug' => sf_clean_slug($slug),
					'desc' => $lib_object->desc,
					'enabled' => 0, /*disabled by default*/
					'options' => '',
					'price1' => 0, 
					'price2' => 0, 
					'price3' => 0, 
					'core' => 0, 
			);
	
	
			//install to db
			if ($this->db->insert($this->db_table, $insert) )
			{
				return TRUE;
			}

		}
	
		// Something went wrong
		return FALSE;
	
	}
	
	
	/** uninstall($id)
	 *
	 * We are not allowing uninstall of items that have references.
	 *
	 * @param INT $id The id of the payment method/gateway
	 * @return boolean
	 */
	public function uninstall($id, $check_field_on_order = "") 
	{
	
		
		//if there is a field to check on the order do so, if there are results that contain the field
		//then we cant delete just disable
		//This is in place so we can always reference an old pluginmodule shipping or payment gateway
		if ($check_field_on_order != "")
		{
	
				# check if ANY orders in past have used this method
				$results = $this->db->where($check_field_on_order,$id)->get($this->db_orders);
			
				if (count($results)) 
				{
					//just disable if there are orders
					if ($results->num_rows > 0)
					{		
						$this->disable($id);

						return FALSE;
					}
			
				}
				
		}
		

		//uninstall now
		$this->db->where('id', $id);
		if ($this->db->delete($this->db_table))
		{
			return TRUE;
		}
	
			
		//Something went wrong to get here	
		return FALSE;
	
	
	}	
	


	
	/**
	 * This will get an installed object from the database
	 *
	 *
	 * @param Mixed <INT>  Ether the Gateway ID 
	 *
	 * @return Object <Gateway>
	 */
	public function get($id) 
	{
	
		// Get the gateway from the DB
		$item = $this->fetch_by_id($id);

		//var_dump($id);die;
	
		// Get Gateway Object
		$lib_object = $this->get_lib_object( $item->slug );
		
		//merge db record with object
		return $this->merge_object($lib_object, $item);

	}	



	/**
	 * This will get an installed object from the database
	 *
	 *
	 * @param Mixed <INT>  Ether the Gateway ID 
	 * @deprecated 
	 * @see get($id)
	 * @return Object <Gateway>
	 */
	public function get_object($id) 
	{
	
		return $this->get($id);

	}	

	
	/**
	 * 
	 * @param unknown_type $lib_object : This is from the core files
	 * @param unknown_type $item : This is the value from the database
	 * @return unknown
	 */
	protected function merge_object($lib_object, $item) 
	{
				
		$lib_object->id = $item->id;
		$lib_object->title = $item->title;
		
		//handle serialized data
		$lib_object->options = unserialize($item->options);
		
		return $lib_object;
		
	}
	
	
	/**
	 * @bug Fetch by slug causes an issue if you install the same object more than 1 time. need to create  unique on the fly slugs for this feature to work.
	 * @param Mixed <String,INT> $unknown_value - Either Text(Slug) or INT (id) value of the Gateway
	 *
	 * @return Mixed <Null|LibraryObject>
	 */
	public function fetch_by_id($id) 
	{
	
		$item = $this->db->where('id',  $id )->get($this->db_table)->result();
		
		// There should only be 1 item, if not we still ONLy return the first
		if ( count($item) )	return $item[0];

		# Failed to find LibraryObject
		return NULL;
	
	}
	
	/**
	 *
	 * @param String $slug
	 * @return < Object Gateway | NULL>
	 */
	protected function get_lib_object($slug)
	{
	
		$slug = trim($slug);
		
		# Get gateway path location
		$lib_plugin_path = $this->get_object_path($slug);
		
	
		# check
		if (is_file($lib_plugin_path))
		{
			
			#include the full path to file
			include_once $lib_plugin_path;
	

			$LibraryObjectClass = $this->get_object_name($slug);
	
			//echo $LibraryObjectClass;die;
			if (class_exists($LibraryObjectClass)) 
			{
	

				#create
				$lib_object = new $LibraryObjectClass;
	
	
				# Slug
				$lib_object->slug = $slug;
	
	
				# Set Image
				$lib_object->image =  $this->get_object_image($slug);
	
				# Admin View
				$lib_object->form = $this->fs_path . $slug . '/views/form.php';
	
				# Client View
				$lib_object->display = $this->fs_path . $slug . '/views/display.php';

				#return
				return $lib_object;
	
			}
	
		}
	
		#oops
		return NULL;
		
	}
	

	/** get_object_path(String)
	 *
	 * Simple helper function to retrieve the location of the Library Object file.
	 *
	 * @param String $slug
	 * @return String The path is returned: c:\wwwroot\pyro\addons\shared_addons\modules\shop\libraries\gateways\paypal\paypal.php
	 *
	 */
	protected function get_object_path($slug)
	{
		return $this->fs_path . $slug . '/' . $slug . '.php';
	}
	
	
	
	/** get_object_image($slug)
	 *
	 * This will check to see if the FileSystem image exist, then return the public www location of that image
	 *
	 *
	 * @param String $slug - Name/Slug of the gateway we want the image of
	 *
	 * @return Mixed <NULL, String> - Either String of path or  Null if cant find image
	 */
	protected function get_object_image($slug) 
	{
	
		$fs_file = $this->fs_path.$slug.'/'.$slug.'.png'; //local
		$www_file = $this->www_path.$slug.'/'.$slug.'.png'; //public
	
		return (file_exists($fs_file)) ?  $www_file :  null ;
	
	}
	
	

	/** get_object_name(String)
	 *
	 * 
	 * Expects to return the Name of the class for the given gateway
	 * For input of:
	 *			-> paypal
	 * A return of :
	 *			-> Paypal_Gateway
	 *
	 * @param String $name
	 * @return String : formatted Capital_Gateway
	 */
	protected function get_object_name($name) 
	{
	
		return ucfirst(   strtolower(  trim($name)  )	) . $this->class_suffix  ;
	
	}
	
	

	/** edit($input)
	 * We verrid because we obnly want to save the options
	 */
	public function edit($input) 
	{

		$edit = array(
				'title' => $input['title'],
				'options' => serialize($input['options']),
		);
	
		$this->db->where('id',  $input['id']);
	
		return $this->db->update($this->db_table, $edit);		
			
	}
	
	
	public function build_list_select($params) 
	{
		 
		$params = array_merge(array('current_id' => 0), $params);
		
		extract($params);
		
		
		$html = '';
		if ($packages = $this->db->order_by('title')->get($this->db_table)->result()) 
		{
			
			foreach ($packages as $item) {
				
				//dont use slug
				$item = $this->get_object($item->id);
				
				$html .= '<option value="' . $item->id . '"';
				$html .= $current_id == $item->id ? ' selected="selected">' : '>';
				$html .= $item->title . '</option>';
			}
			
		}
		
		return $html;
	}	



	//we have to handle packages deleted from system.
	//The package ID to search and retriecve the max value
	public function get_max_units_by_package_id($package_id)
	{
		
		$package = $this->get_package($package_id);
		
		//var_dump($package->options);die;
		//echo $package->options['max_units'];die;
		return $package->options['max_units'];
	}
	



	

	
	/**
	 *
	 * @param unknown_type $id
	 * @return boolean
	 */
	public function enable($id)
	{
	
		$edit['enabled'] = 1;
	
		$this->db->where('id',  $id );
		return $this->db->update($this->db_table, $edit);
			
	}

	
	public function disable($id) 
	{
	
		$edit['enabled'] = 0;
	
		$this->db->where('id',  $id );
		return $this->db->update($this->db_table, $edit);
	
	}
	

	/** get_enabled()
	 *
	 * @return Array <Gateway> Array of enabled Gateways from DB
	 */
	public function get_enabled() 
	{

		// Get from DB
		$items = $this->db->where('enabled',1)->get($this->db_table)->result();
	
		//Set image
		foreach ($items as $item)   $item->image = $this->get_object_image($item->slug);
	
		// At last
		return $items;
	
	}
	

	/**
	 * Gets all installed from DB Only
	 * @return unknown
	 */
	public function get_all() 
	{
	
	
		$items = $this->db->get($this->db_table)->result();
	
		//Set image
		foreach ($items as $item)$item->image = $this->get_object_image($item->slug);	
	
		return $items;
	
	}
	

	
	/**
	 * Gets all installed and merges data
	 * @return unknown : 
	 */
	public function get_all_merge() 
	{
	
		$items = $this->db->get($this->db_table)->result();
	
		$ret = array(); 
		foreach ($items as &$item)   
		{
			$o = $this->get_object( $item->id );
			
			$ret[] = $o; 
		}

		return $ret;
	
	}	
	
	/**
	 * Only retrieves db objects, no merging with files
	 * @return unknown : Slow 
	 */
	public function get_all_installed() 
	{
		$items = $this->db->get($this->db_table)->result();
		return $items;
	}		
	
}
	
