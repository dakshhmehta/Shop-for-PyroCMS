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

include_once('Admin_Products_base_Controller.php');

class Product extends Admin_Products_base_Controller 
{

	protected $section = 'products';
	

	public function __construct() 
	{
		parent::__construct();

	}




	public function index() 
	{
		return null;	
	}	





	/**
	 * Create a new Product
	 * 
	 */
	public function create() 
	{

		role_or_die('shop', 'admin_create_products');

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
			if ($product_id = $this->products_admin_m->create($input, $this->current_user->id)) 
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
		//$data->tax_id = NULL;
		//$data->tax_dir = 0;
		$data->price = '00.00';
		$data->price_base = '00.00';
		$data->rrp = '00.00';
		
		// Reset Values from user input if validation failed
		foreach ($this->item_validation_rules AS $rule)
			$data->{$rule['field']} = $this->input->post($rule['field']);

		
		// Build the Template
		$this->template->title($this->module_details['name'], lang('create'))
				->append_metadata($this->load->view('fragments/wysiwyg', $data, TRUE))
				->append_js('module::admin/product.js')
				->build('admin/products/create', $data);
	}


	
	/**
	 * Edit a product
	 *
	 *
	 */
	public function edit( $id = 0 ) 
	{

		//
		// Do not allow users to edit products
		//
		role_or_die('shop', 'admin_edit_products');

		// 
		// First get the product
		//
		$data =  $this->products_admin_m->get_product($id);


		if(!(isset($data)) )
		{
			redirect('admin/products/');
		}


		//
		// Run validation if postback
		//
		if ( $this->_validate_product() ) //$this->form_validation->run()
		{
			
			$input = $this->input->post();





			// 
			// sanitize prepares the fields for saving
			// It also processes the keywords 
			// 
			$this->sanitize_fields($input, $data, 'edit');
			
		
			//
			// save
			//
			if ($this->products_admin_m->edit($id, $input)) 
			{	

				Events::trigger('evt_product_changed', $id);
				
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
			
			
			redirect('admin/shop/product/edit/' . $id);

			
		}
		

		

		// Build Template
		$this->template->title($this->module_details['name'], lang('edit'))
				->append_metadata($this->load->view('fragments/wysiwyg', $data, TRUE))
				->append_js('jquery/jquery.tagsinput.js')
				->append_js('module::admin/product.js')
				->append_css('jquery/jquery.tagsinput.css')
				->append_css('module::admin_products.css')
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
	
	

	/**
	 * View as customer:same as the public handler, just gets data even if hidden
	 */	 
	public function view($id = 0) 
	{
		
		//Always get by id here
		$data->product = $this->pyrocache->model('products_admin_m', 'get', $id);  

		// redirect if not found
		if (count($data->product)==0) { echo "Unable to find"; die;};
		

		$data->display_views = $this->show_views;
		
		
		// Collect info about the product
		$data->product->category = $this->pyrocache->model('categories_m', 'get', $data->product->category_id);  
		$data->images = $this->pyrocache->model('products_admin_m', 'get_images', $data->product->id);  
		$data->product->keywords = Keywords::get_array($data->product->keywords);

		$data->product->properties = $this->products_admin_m->get_product_attributes($data->product->id); 
		$data->product->options = $this->options_m->get_options($data->product->id); 


		
		// set brand name (string)
		$branddata = $this->pyrocache->model('brands_m', 'get', $data->product->brand_id);  
		$data->product->brand_name = ($branddata)?$branddata->name : NULL;

		

		// Display the product
		$this->template	
				->enable_parser(TRUE)
				->enable_minify(TRUE)
				->set_layout(FALSE)
				//->set_layout('default')
				//->set_theme($this->settings->default_theme)	
				->build('products/single', $data);

	}
	



	public function load( $id, $panel = '' ) 
	{


		//get the data for the product
		$data =  $this->products_admin_m->get_product($id);

		
		if($panel =='product')
		{
			$data->category_select 	= $this->categories_m->build_tree_select(array('current_parent' => $data->category_id ));
			$data->brand_select 	= $this->brands_m->build_dropdown($data->brand_id);
			
			$data->package_select 	= $this->package_library->build_list_select(array('current_id' => $data->package_id));			
		}	
			
		if($panel =='images')
		{
			$data->folders = $this->get_folders();
		}

		if($panel =='options')
		{
			//$data->folders = $this->get_folders();
			$data->all_options = $this->options_m->build_dropdown();
		}

		if($panel =='price')
		{
			//$data->folders = $this->get_folders();
			$data->tax_groups 		= $this->tax_m->get_all();
			$data->group_select 	= $this->pgroups_m->build_list_select(array('current_id' => $data->pgroup_id));	
		}

		if($panel =='related')
		{
			$data->rel_names = array();
			foreach($data->related as $related_product)
			{
				$data->rel_names[] = $this->products_admin_m->get_minimal($related_product);

			}			
		}

		










		$this->load->view('admin/products/partials/'.$panel, $data); 



	}

	protected function _validate_product()
	{

		//
		// Prepare Postback & Validation
		//
		if( ! $this->input->post() )
		{
			return FALSE; //do not allow to enter the saveing of data section
		}


		//
		// Lets get the data from the post headers
		// 
		$input = $this->input->post();

		//var_dump($input);die;

		foreach($this->_validation_rules as $key => $field_to_check)
		{


			$_field = $field_to_check['field'];
		
			
			//
			// only process is exist
			//
			if(isset($input[$_field]))
			{

			}
			else
			{
				//remove for now as we do not require them
				unset($this->_validation_rules[$key]);
			}
		}


		//
		// Now set the rules
		//
		$this->form_validation->set_rules($this->_validation_rules);


		//We have to check if there are any rules to check, as if there isnt it will return false when run
		if($this->form_validation->_validation_rules == NULL)
			return TRUE;


		//
		// Test and return
		//
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


	
}
