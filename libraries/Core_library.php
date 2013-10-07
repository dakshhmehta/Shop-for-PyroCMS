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
class Core_library  
{

	/**
	 * Full Path to the 'core basiks directory' 
	 * 
	 * @var [type]
	 */
	protected $core_basiks_path;
	protected $lib_path;

	public function __construct() 
	{

		log_message('debug', "Class Initialized");

		$this->lib_path =  dirname(__FILE__); //path to lib
		$this->core_basiks_path =  dirname(__FILE__) . '/core_basiks/';		
	}


	/**
	 * Get the CI instance into this object
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
	 * This is designed to return the 'Core Basiks Library' library object requested
	 *
	 * Core basiks is the future of shop library managment. We will setup individual library for tasks 
	 * to help management of the code
	 *
	 * Usage: $this->load_core('trust')
	 * 
	 * @param  [type] $library [description]
	 * @return Object          CoreBasiks Library object.
	 */
	public function loadlib($library)
	{

		$prefix = 'Core_';
		$suffix = '_library';
		$ext = '.php';

		$className = $prefix . $library . $suffix; // full is Core_trust_library

		//get the path to file
		$class_path = $this->core_basiks_path . $className . $ext; //full is ../../path.../core_basiks/Core_trust_library.php



		if (is_file($class_path))
		{

			//php include in mem
			include_once $class_path;


			//check if exist
			if (class_exists($className)) 
			{
				// instantiate
				$library_as_object = new $className;

				return $library_as_object;

			}


		}

		return FALSE;

	}


}
