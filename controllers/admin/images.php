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
class Images extends Admin_Controller
 {

	protected $section = 'images';

	public function __construct() 
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model('products_admin_m');

	}
	
	/**
	 * This will be an ajax post from the image gallery
	 *
	 *
	 */
	public function get_folder_contents() 
	{
		$response = array();
		
		if ( $this->input->post() ) 
		{
	
			$input = $this->input->post();
			$folder_id = intval( $input['folder_id'] );
			

			$this->load->library('files/files');
			$folder_data = $this->files->folder_contents($folder_id);
			$content = $folder_data['data'];
			
			
			//prepare the array for javascript
			$ret_objects = array();
			
			foreach ($content['file'] as $file)
			{
				//
				// We should also check for TYPE " i " = image and only 
				// get the image type. - Perhaps make 2 functions 1 for images, 1 for all files.
				//
				
				//image array
				$image_object = array();


				$image_object['id'] = $file->id;	
				$image_object['name'] = $file->name;	

				//$ret_objects[] = $file->id;	
				$ret_objects[] = $image_object;	

			}
			
			$response['url'] = site_url();
			$response['content'] = $ret_objects;
			$response['length'] = sizeof($ret_objects);
			$response['ststus'] = "success";
			$response['message'] = "Found : ". $response['length'] . " Files";

		} 
		else
		{
			$response['ststus'] = "failed";
			$response['content'] =  '';
			$response['message'] =  lang('oops');
		}
		
		echo json_encode($response);die;

	}


	public function admin_view($file_id)
	{
		echo "<img src='files/thumb/".$file_id."/400'>";die;
	}
	
}
