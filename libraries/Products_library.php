<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
/*
 * NITRO-CART Developer Preview
 * 
 *
 *
 * Copyright (c) 2013, Salvatore Bordonaro
 * All rights reserved.
 *
 * Author: Salvatore Bordonaro
 * Version: 0.90.0.000
 *
 * Credits: - Salvatore Bordonaro (DB, Development, JavaScript)
 *
 * 			- Guido Grazioli (DB and Development)
 *
 *          - Alison McDonald (Usability, Language and Testing)
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */
class Products_library 
{




	// Private variables.  Do not change!
	private $CI;
	

	public function __construct($params = array())
	{
	
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();

		log_message('debug', "Products Library Class Initialized");
		
	}

	
	
	/**
	 * Set/clear cover image on product
	 * 
	 * @return [type] [description]
	 */
	public function cover_image() 
	{	

		$this->CI->load->model('products_admin_m');


		$response['status'] = JSONStatus::Error;


		if($this->CI->input->post('id') ) 
		{


			$id = intval( $this->CI->input->post('id'));
			

			$file_id =  $this->CI->input->post('file_id') ;
			

			$resp = site_url().'files/thumb/'.$file_id.'/100/100';


			if ($this->CI->products_admin_m->update_property($id, 'cover_id', $file_id ) ) 
			{	
				$response['status'] = JSONStatus::Success;
				$response['src'] = $resp;
				
				Events::trigger('evt_product_changed', $id);
			} 


		}

		echo json_encode($response);die;

	}


}
// END Cart Class
