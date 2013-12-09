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
class Maintenance extends Admin_Controller 
{
	// Set the section in the UI - Selected Menu
	protected $section = 'manage';
	private $data;

	public function __construct() 
	{
		parent::__construct();

		$this->data = new stdClass();

		$this->template
			->append_css('module::admin.css');
	}

	/**
	 * List all items:load the dashboard
	 */
	public function index() 
	{
			
	}

    public function run_lang()
    {
    	$this->load->library('shop/core_library');
    	$this->data->lang_data = build_lang();

		$this->load->library('shop/core_basiks/core_debug_library');

		$this->core_debug_library->write_lang($this->data->lang_data);

		die("program completed");
    }

    public function run_trustdata()
    {
		$this->ci->load->library('shop/Core_data_library');

		$this->data = $this->ci->core_data_library->get_all();	
		$this->core_data_library->write($this->data);

		die("program completed"); 	

    }

    public function install_trustdata()
    {
		$this->ci->load->library('shop/core_data_library');
		$this->data = $this->ci->core_data_library->get_all();	

		$t_data = array();
		foreach($this->data as $key => $value)
		{
			$t_data[] = array(
				'score' => $value['score'],
				'category' => $value['category'],
				'word' => $value['word'],
				'count' => 0,
				'enabled' => 1,
			);
		}

		$this->db->insert_batch('shop_trust_data', $t_data);		

		die("program completed"); 	
    }

    public function run_re_index($input=array())
    {
    	$this->load->library('shop/core_library');
		$this->load->library('shop/core_basiks/core_debug_library');

		$count = $this->core_debug_library->re_index_search();

		die('Indexed ' . $count . ' products');
    }

    public function export($table='products', $format ='csv')
    {
		$this->load->helper('download');
		$this->load->library('format');

		switch ($table) 
		{
			case 'products':
			case 'orders':
				break;
			default:
				return FALSE;
				break;
		}

    	$this->load->model('shop_model');

    	$this->shop_model->export($table, $format);
    }
}