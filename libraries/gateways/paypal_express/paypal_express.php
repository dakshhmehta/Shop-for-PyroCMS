<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');


class Paypal_express_Gateway {


	public $title = 'Paypal Express GateWay';
	public $short_title = 'PayPal'; //short title is used for transaction line items - much better than storing full nae
	public $desc = 'Process Payments via Paypal';
	public $author = 'Sal Bordonaro';
	public $website = 'http://inspiredgroup.com.au';
	public $version = '1.0';
	public $image = '';
	
	

	public $fields = array(
		array(
			'field' => 'options[username]',
			'label' => 'Username',
			'rules' => 'trim|max_length[200]|required'
		),
		array(
			'field' => 'options[password]',
			'label' => 'Password',
			'rules' => 'trim|max_length[100]|required'
		),
		array(
			'field' => 'options[signature]',
			'label' => 'API Signature',
			'rules' => 'trim|max_length[200]|required'
		),		
		array(
			'field' => 'options[test_mode]',
			'label' => 'Test Mode',
			'rules' => 'trim|max_length[100]|numeric'
		),		
		array(
			'field' => 'options[auto]',
			'label' => 'Self submit',
			'rules' => 'trim|max_length[100]|numeric'
		),
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
