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

include_once( dirname(__FILE__) . '/' . 'products_admin_controller.php');

class Product extends Products_admin_Controller 
{

	protected $section = 'products';
	

	public function __construct() 
	{
		parent::__construct();

		//
		// Do not allow users to edit products
		//
		role_or_die('shop', 'admin_products');		

		// Create the data object
		$this->data = new stdClass();

	}




	public function index() 
	{
		return NULL;	
	}	





	/**
	 * Create a new Product
	 * 
	 */
	public function create() 
	{

		// Prepare for postback
		// Setup extra validation rules not applied to the main set
		$this->form_validation->set_rules($this->_validation_rules);
		$this->form_validation->set_rules('slug', 'lang:slug', 'trim|max_length[100]|required|is_unique[shop_products.slug]');

		// If postback validate the form
		if ($this->form_validation->run()) 
		{

			$input = $this->input->post();


			// 
			// sanitize prepares the fields for saving
			// It also processes the keywords 
			// 
			$this->sanitize_fields($input, 'create');

		  
			// create enables the creating of a product with basic param, after created
			// we can use edit to assign images ect.
			if ($product_id = $this->products_admin_m->create($input)) 
			{
							
				Events::trigger('evt_product_created', $product_id);	
				$this->session->set_flashdata('success', lang('success'));
				redirect('admin/shop/product/edit/'.$product_id);
			} 
			else 
			{
				$this->session->set_flashdata('error', lang('create_product_error') ); //
				redirect('admin/shop/product/create');
			}
		}
		

		//default settings so it will be quicker to create items 
		$this->data->price = '00.00';
		$this->data->price_base = '00.00';
		$this->data->rrp = '00.00';
		
		// Reset Values from user input if validation failed
		foreach ($this->item_validation_rules AS $rule)
			$this->data->{$rule['field']} = $this->input->post($rule['field']);

		
		// Build the Template
		$this->template->title($this->module_details['name'], lang('shop:common:create'))
				->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				->append_js('module::admin/product.js')
				->build('admin/products/create', $this->data);
	}


	
	/**
	 * Edit a product
	 *
	 *
	 */
	public function edit( $id = 0 ) 
	{


		//
		// Determine whether to get by id or slug
		//
		$method = (is_numeric($id))  ? 'id' : 'slug' ;

		

		//
		// Get the product and all its goodness
		//
		$data = $this->products_admin_m->get($id, $method);



		if(!$data )
		{
			//$this->session->set_flashdata('error',lang('shop:messages:no_product_found') );
			$this->session->set_flashdata('notice',lang('shop:messages:no_product_found') );
			redirect('admin/shop/products/');
		}


		//
		// Run validation if postback
		//
		if ( $this->_validate_product() ) //$this->form_validation->run()
		{
			
			$input = $this->input->post();



			//upload url images
			$this->upload_url_images($input,$data->id);

			//upload files
			$this->upload_files($data->id);

			//upload images
			$this->upload($data->id);



			// 
			// sanitize prepares the fields for saving
			// It also processes the keywords 
			// 
			$this->sanitize_fields($input, $data, 'edit');
			
		
			// save
			if ($this->products_admin_m->edit($data->id, $input)) 
			{	

				Events::trigger('evt_product_changed', $data->id);
				
				$this->session->set_flashdata('success', lang('success'));
				
			} 
			else 
			{
				$this->session->set_flashdata('error', lang('error'));
			}
			

			if(isset($input['btnAction']))
			{
				if($input['btnAction'] == 'save_exit')	redirect('admin/shop/products/');
			}
			
			
			redirect('admin/shop/product/edit/' . $data->id);

			
		}
		


		// Build Template
		$this->template->title($this->module_details['name'], lang('shop:common:edit'))
				->append_metadata($this->load->view('fragments/wysiwyg', $data, TRUE))
				->append_js('jquery/jquery.tagsinput.js')
				->append_js('module::admin/product.js')
				->append_css('jquery/jquery.tagsinput.css')
				->build('admin/products/form', $data);

	}
	
	
	
	


	/**
	 * Delete the Item -set delete flag to 0 
	 * @param INT $id
	 */
	public function delete($id = 0)
	{

		if (is_numeric($id)) 
		{
			$result = $this->products_admin_m->delete($id);
			if ($result)
				Events::trigger('evt_product_deleted', $id);

		}

		redirect('admin/shop/products');
	}
	

	
	
	
	/**
	 * This is used to duplicate an existing item in the products database to make selling online faster and easier
	 * Once the product has been duplicated - It will automaticly set itself to "Invisible"
	 * It will require the admin to manually set this to visible. This is a safeguard so that we dont just
	 * duplicate an item and its available online straight away..
	 *
	 *
	 * @param INT $id The ID of the product to duplicate
	 * @access public
	 */
	public function duplicate( $id = 0 ) 
	{
		// Set the default redirect page
		$redir = 'admin/shop/products';
	
		if (is_numeric($id))
		{

			$product_id = $this->products_admin_m->duplicate($id);
			
			if ($product_id) 
			{
				Events::trigger('evt_product_created', $product_id);
				
				$this->session->set_flashdata('success', lang('success'));
				
				$redir = 'admin/shop/product/edit/'.$product_id;
				
			} 
			else 
			{
				$this->session->set_flashdata('error', lang('error'));
			}
			
		}
		
		redirect($redir);
		
	}
	
	

	public function load( $id, $panel = '' ) 
	{

		//get the data for the product
		$data =  $this->products_admin_m->get($id);
		$data->keywords 			= Keywords::get_string($data->keywords); //prepare keywords

		
		if($panel =='product')
		{
			$data->category_select 	= $this->categories_m->build_dropdown( array( 'field_property_id' => 'category_id', 'current_id' => $data->category_id ) );
			$data->brand_select 	= $this->brands_m->build_dropdown($data->brand_id);
		}	
			
		if($panel =='images')
		{
			$this->load->model('images_m');
			$data->images 			= $this->images_m->get_images($data->id);  
			$data->folders = $this->get_folders();
		}

	
		if($panel =='attributes')
		{
			$this->load->model('product_attributes_m');
			$data->properties_array = $this->product_attributes_m->get_by_product($data->id);  
		}

		if($panel == 'options')
		{
			$this->load->model('shop/options_m');
			$this->load->model('shop/options_product_m');
			$data->prod_options		= $this->options_product_m->get_prod_options($data->id);

			//var_dump($data->prod_options);
			foreach($data->prod_options as $key=>$value)
			{
				$op = $this->options_m->get($data->prod_options[$key]->option_id);
				$data->prod_options[$key]->name = $op->name;
			}


			$data->all_options = $this->options_m->build_dropdown();
		}

		if($panel == 'price')
		{
			//$data->folders = $this->get_folders();
			$data->tax_groups 		= $this->tax_m->get_all();
			$data->group_select 	= $this->pgroups_m->build_dropdown( $data->pgroup_id );	
		}

		if($panel == 'related')
		{
			//get related
			$data->related = json_decode($data->related);
			$data->category_select 	= $this->categories_m->build_dropdown( array( 'field_property_id' => 'related_products_category_filter' )   );

			$data->rel_names = array();
			
			foreach($data->related as $related_product)
			{
				$data->rel_names[] = $this->products_admin_m->get($related_product);

			}			
		}

		if($panel == 'shipping')
		{		
			$this->load->library('products_library');
			$data->req_shipping_select = $this->products_library->build_requires_shipping_select(array('current_id' => $data->req_shipping));
		}	

		if($panel == 'files')
		{
			$this->load->model('shop_files_m');
			$data->digital_files = $this->shop_files_m->get_files($data->id);
		}	

		if($panel == 'design')
		{
			$this->load->library('design_library');

			$_path = Settings::get('default_theme');

			$data->design_select 	= $this->design_library->build_list_select( $_path , array('current_id' => $data->page_design_layout) );			
		}	


		$this->load->view('admin/products/partials/'.$panel, $data); 


	}

	public function delete_file($file_id)
	{
		$this->load->model('shop_files_m');

		$status = $this->shop_files_m->delete_file($file_id);


		if($status)
		{
			echo json_encode(array('status' => 'success'));die;
		}
		else
		{
			echo json_encode(array('status' => 'error'));die;
		}

	}

	protected function _validate_product()
	{

		// Prepare Postback & Validation
		if( ! $this->input->post() )
		{
			return FALSE; //do not allow to enter the saveing of data section
		}


		// Lets get the data from the post headers
		$input = $this->input->post();

		foreach($this->_validation_rules as $key => $field_to_check)
		{

			$_field = $field_to_check['field'];
		
			// only process is exist
			if(!(isset($input[$_field])) )
			{
				//remove for now as we do not require them
				unset($this->_validation_rules[$key]);
			}

		}


		// Now set the rules
		$this->form_validation->set_rules($this->_validation_rules);


		//We have to check if there are any rules to check, as if there isnt it will return false when run
		if($this->form_validation->_validation_rules == NULL)
			return TRUE;


		// Test and return
		return $this->form_validation->run();

	
	}


	/**
	 * 
	 * @param  [type] $input          [description]
	 * @param  [type] $product_object [The object from the DB before any changes, this is used to compare some fields with the newly edited fields]
	 * @return [type]                 [description]
	 */
	protected function sanitize_fields(&$input, $product_object = NULL, $mode = 'create')
	{



			if(isset($product_object))
			{
				// Checks to see if there are changes in price
				$input = $this->_check_price_changes( $input, $product_object );
			}



			$input = $this->_prep_prices($input);



			// we have to check if another field on the same page is loaded
			if(!(isset($input['slug'])) )
			{
				set_if_not( $input['featured'] , $product_object->featured);
				set_if_not( $input['searchable'] , $product_object->searchable);
			}



			//keywords
			if($mode == 'edit')
			{
				//keyword hash - edit
				$keywords_hash = (trim($product_object->keywords) != '') ? $product_object->keywords : NULL;
				$input['keywords'] = Keywords::process($input['keywords'], $keywords_hash);

			}
			else
			{
				//create
				$input['keywords'] = Keywords::process($input['keywords']);			


			}


	}



	/**
	 * Upload files from the FILES tab to link to a product
	 * 
	 * @return [INT] [ID of the image uploaded]
	 */
	public function upload_files($product_id)
	{

		$this->load->model('shop_files_m');

		foreach($_FILES as $key => $_file)
		{

			if( in_array($key, array("digital_downloads_1") )) 
			{
				$data = array();
				$data['product_id'] = $product_id;
				$data['filename'] = $_file['name'];
				$data['data'] = file_get_contents ( $_file['tmp_name'] );
				$data['filesize'] = $_file['size'];

				$this->shop_files_m->add_file($data);
	    	}	

		}

	}	




	/**
	 * Upload images from the images tab
	 * 
	 * @return [INT] [ID of the image uploaded]
	 */
	public function upload($product_id)
	{

		$this->load->library('files/files');



		if($this->input->post('upload_folder_id'))
		{
			$folder_id = $this->input->post('upload_folder_id');
		}
		else
		{
			$folder_id = NULL; 
		}


		//counter
		$_files_to_upload = 0;

		foreach($_FILES as $key => $_file)
		{
			//only process image upload fields here
			if( ! in_array($key, array("fileupload_1","fileupload_2","fileupload_3","fileupload_4") )) 
			{
				continue;
			}


			//check to see if tried to upload file
			if($folder_id==NULL) 
			{
				if($_file['name'] != NULL)
				{
					$_files_to_upload++;
				}

				continue;
			}
			else
			{
				$upload = Files::upload($folder_id, $_file['name'], $key);

		    	$image_id = $upload['data']['id'];	

		    	$this->_upload_assign($image_id, $product_id);	
	    	}	


		}

		if($_files_to_upload > 0)
		{
			return $this->session->set_flashdata('error', lang('shop:products:no_upload_folder_set'));
		}


	}	

	private function _upload_assign($image_id, $product_id)
	{
		$this->load->model('images_m');
				
		if($image_id =="")
			return FALSE;

		return $this->images_m->add_local_image($image_id,$product_id);
	}
}
