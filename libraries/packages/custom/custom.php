<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_Package 
{
	
	//author details
	public $author = 'inspiredgroup.com.au';
	public $website = 'http://inspiredgroup.com.au';
	public $version = '1.0';
	
	
	//Name info
	public $title =  'Custom';  /* This can be changed by user*/
	public $type = 'Custom';

	
	//product details
	public $desc = 'Custom';



	//HxW in mm
	public $height 		= 102;	
	public $width 		= 310;
	public $depth 		= 225;
	public $max_weight 	= 10000; 	//grams

	
	
	//This is not a const
	public $weight		= 0 ; //this will be dined by system at runtime
	
	
	//image handling
	public $image = ''; //image for list
	public $prev_image = ''; //preview image for info
	
	//You can specify a maximum number of items for free
	public $fields = array(
			
			array(
					'field' => 'options[max_units]',
					'label' => 'Maximum Units',
					'rules' => 'trim|max_length[5]|required|numeric'
			),
			array(
					'field' => 'options[ignor_shipping]',
					'label' => 'Ignor Shipping',
					'rules' => 'trim|required|numeric'
			),
			array(
					'field' => 'options[height]',
					'label' => 'Height',
					'rules' => 'trim|numeric'
			),
	);
	
	
	public function __construct() 
	{	
		
		
	}

		
	public function form($options) 
	{

		return $options;
 
	}


	
	public function run($options) 
	{
			
		return $options;
		   
	}

	public function get_printed_qty_only($package)
	{
		return 5;
		//return $package->qty;
	}

	


	
}
