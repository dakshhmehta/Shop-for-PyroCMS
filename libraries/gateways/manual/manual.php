<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');


class Manual_Gateway {


	public $title = 'Manual - Bank Deposit';
	public $short_title = 'Manual'; //short title is used for transaction line items - much better than storing full nae
	public $desc = 'Bank Deposit';
	public $author = 'Sal Bordonaro';
	public $website = 'http://inspiredgroup.com.au';
	public $version = '1.0';
	public $image = '';
	
	

	public $fields = array(
			array(
				'field' => 'desc',
				'label' => 'Description',
				'rules' => 'trim|max_length[1000]|'
			)

		);

	
	public function __construct() {		}

	


	public function get_params($order) 
	{
		     
		return array();
		   
	}



	public function prepare_settings($settings) 
	{
		   
 
		return $settings;
		   
	}
	

	public function callback($response) 
	{ 
		

		return NULL;
		
	}
	
	
	
}
