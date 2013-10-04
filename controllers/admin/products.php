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
class Products extends Admin_Controller 
{

	protected $section = 'products';
	

	public function __construct() 
	{
		parent::__construct();


		//check if has access
		role_or_die('shop', 'products');


		// Load all the required classes
		//$this->load->model('products_admin_m');
		$this->load->model('products_admin_m');
		$this->load->model('options_m');
		$this->load->model('categories_m');
		$this->load->model('pgroups_m');
		$this->load->model('brands_m');
		$this->load->model('tax_m');
		$this->load->helper('url');
		$this->load->library('session'); 

		$this->load->library('form_validation');
		$this->load->library('keywords/keywords');
		
		//Load Core Libraries
		$this->load->library('package_library');
		

		// Set the validation rules
		$this->_validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'lang:name',
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'slug',
				'label' => 'lang:slug',
				'rules' => 'trim|required'
			),				
			array(
				'field' => 'category_id',
				'label' => 'lang:category',
				'rules' => 'trim|numeric|is_natural_no_zero|required'
			),
			array(
				'field' => 'brand_id',
				'label' => 'lang:brand',
				'rules' => 'trim|numeric'
			),
			array(
				'field' => 'price',
				'label' => 'lang:price',
				'rules' => 'trim|numeric'
			),	  			 
			array(
				'field' => 'tax_dir',
				'label' => 'lang:tax_dir',
				'rules' => 'trim|numeric'
			),				 		
			array(
				'field' => 'meta_desc',
				'label' => 'lang:meta_desc',
				'rules' => 'trim'
			),
			array(
				'field' => 'status',
				'label' => 'lang:status',
				'rules' => 'trim'
			),

		);

		//Load Files Module
		$this->load->library('files/files');
		$this->load->model('files/file_folders_m');

		// Set up the Dropdown Array for edit and create
		$folders = $this->get_folders();
		
		// For all pages on products associate the fllowing files/settings
		$this->template
					->append_js('module::admin/util.js')
					->append_js('module::admin/admin.js')
					->append_css('module::admin.css')
					->append_metadata('<script></script>')
					->set('folders', $folders);
	}


	public function index($offset = 0) 
	{

		

		$data->quick_search = $this->_get_filter_setting( 'f_keyword_search', 'display_search_filter' , ''); //blank for default
		$data->category = $this->_get_filter_setting( 'f_category', 'display_category_filter' , 0); //0 is ALL
		$data->visibility = $this->_get_filter_setting( 'f_visibility', 'display_visibility_filter', 0); //0 is ALL
		$data->order_by = $this->_get_filter_setting( 'f_order_by', 'display_order_filter' , 0);
		$data->limit = $this->_get_filter_setting( 'f_items_per_page', 'display_qty_filter' , 5);


		if( ! ($this->input->is_ajax_request() ))
		{
			//since this is a full page built
			$data->price_ranges = array(0 => lang('global:select-all'),1=>lang('range_0_50'), 2=>lang('range_25_75'), 3=>lang('range_100_0') );
			$data->categories = $this->categories_m->build_tree_select();

		}


		//
		// Only add these to the filter when the value is not ZERO 0
		//
		if ($data->visibility != 0) 	
		{
			$filter['visibility'] 	= $data->visibility;
		}


		if ($data->category != 0) 
		{
			$filter['category_id'] = $data->category;
		}

		//
		// Always add these to the filter
		//
		$filter['search'] = trim($data->quick_search);
		$filter['order_by'] = orderby_helper($data->order_by); 
		

		
		// 
		// Get the count of items
		// 
		$total_items = $this->products_admin_m->admin_filter_count($filter);


		//
		// Create Pagination
		//
		$data->pagination = create_pagination('admin/shop/products/callback', $total_items, $data->limit, 5);  



		//
		// Get the results
		//
		$data->products =  $this->products_admin_m->admin_filter_get($filter , $data->pagination['limit'] , $data->pagination['offset']);




		// Build the view with shop/views/admin/products.php
		$this->template->title($this->module_details['name'])
				->append_js('admin/filter.js')
				->append_js('module::admin/products.js')
				->build('admin/products/products', $data);
	


	}	



	public function callback($offset = 0) 
	{



		$data->quick_search = $this->_get_filter_setting( 'f_keyword_search', 'display_search_filter' , '',TRUE); //blank for default
		$data->category = $this->_get_filter_setting( 'f_category', 'display_category_filter' , 0,TRUE); //0 is ALL
		$data->visibility = $this->_get_filter_setting( 'f_visibility', 'display_visibility_filter' , 0,TRUE); //0 is ALL
		$data->order_by = $this->_get_filter_setting( 'f_order_by', 'display_order_filter' , 0,TRUE); // 0 is ID
		$data->limit = $this->_get_filter_setting( 'f_items_per_page', 'display_qty_filter' , 5,TRUE);

		

		//
		// Only add these to the filter when the value is not ZERO 0
		//
		if ($data->visibility != 0) 	
		{
			$filter['visibility'] 	= $data->visibility;
		}



		if ($data->category != 0) 
		{
			$filter['category_id'] = $data->category;
		}


		//
		// Always add these to the filter
		//
		$filter['search'] = trim($data->quick_search);
		$filter['order_by'] = orderby_helper($data->order_by); 
		


		// 
		// Get the count of items
		// 
		$total_items = $this->products_admin_m->admin_filter_count($filter);


		//
		// Create Pagination
		//
		$data->pagination = create_pagination('admin/shop/products/callback/', $total_items, $data->limit, 5);  



		//
		// Get the results
		//
		$data->products =  $this->products_admin_m->admin_filter_get($filter , $data->pagination['limit'] , $data->pagination['offset']);

				
	

		// set the layout to FALSE and load the view
		$this->template
				->set_layout(FALSE)
				->build('admin/products/line_item',$data);	

	}
	




	/**
	 * Gets or sets the filter value for products searching/filtering.
	 *
	 * $this->_get_filter_setting( 'f_items_per_page', 'display_qty_filter' , 5) 
	 * 
	 * @param  string  $f_filter_name       [description]
	 * @param  [type]  $filter_session_name [description]
	 * @param  integer $def_val             [description]
	 * @return [type]                       [description]
	 */
	private function _get_filter_setting( $f_filter_name = '', $filter_session_name, $def_val = 0 , $pre_save=FALSE) 
	{

		if($pre_save)
		{

			$filter_value = $this->input->post($f_filter_name);
			$this->session->set_userdata($filter_session_name, $filter_value );
			return $filter_value;

		}


		//
		if( $this->input->post($f_filter_name) )
		{
			$def_val = $this->input->post($f_filter_name);

			if($this->session->userdata($filter_session_name) != $this->input->post($f_filter_name))
			{
				//save for use later
				$this->session->set_userdata($filter_session_name, $def_val );
			}
		}
		else
		{
			$def_val = ($this->session->userdata($filter_session_name))? $this->session->userdata($filter_session_name) : $def_val ;
		}

		return $def_val;
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
		$this->form_validation->set_rules($this->item_validation_rules);
		//$this->form_validation->set_rules('code', 'Product Code', 'trim|is_unique[shop_products.code]');
		$this->form_validation->set_rules('slug', 'lang:slug', 'trim|max_length[100]|required|is_unique[shop_products.slug]');
		
		// If postback validate the form
		if ($this->form_validation->run()) 
		{
			
			$input = $this->input->post();
			$input['keywords'] = Keywords::process($input['keywords']);

			// Calcuates based on user params
			$input = $this->_prep_prices($input);			
			
			// Calcuates based on user params		
			$input = $this->tax_m->calc_price($input);
		  
			// create enables the creating of a product with basic param, after created
			// we can use edit to assign images ect.
			if ($product_id = $this->products_admin_m->create($input, $this->current_user->id)) 
			{
							
				Events::trigger('evt_product_created', $product_id);	
				$this->session->set_flashdata('success', lang('success'));
				redirect('admin/shop/products/edit/'.$product_id);
			} 
			else 
			{
				$this->session->set_flashdata('error', lang('create_product_error') ); //
				redirect('admin/shop/products/create');
			}
		}
		


		// Prepare for View

		// Get Tax Groups
		$data->tax_groups = $this->tax_m->get_all();
  
		// Get Categories and Build List
		$data->category_select = $this->categories_m->build_tree_select(array('current_parent' => set_value('category_id', 0)));
		
		// Get Brands and Build list
		$data->brand_select = $this->brands_m->build_dropdown();
		
		// Get Packages and Build List
		$data->package_select = $this->package_library->build_list_select(array('current_id' => set_value('package_id', 0)));
		

		//default settings so it will be quicker to create items 
		$data->tax_id = NULL;
		$data->tax_dir = 0;
		$data->price = '00.00';
		

		// Reset Values from user input if validation failed
		foreach ($this->item_validation_rules AS $rule)
			$data->{$rule['field']} = $this->input->post($rule['field']);

		
		// Build the Template
		$this->template->title($this->module_details['name'], lang('create'))
				->append_metadata($this->load->view('fragments/wysiwyg', $data, TRUE))
				->append_js('module::admin/product.js')
				->append_js('jquery/jquery.tagsinput.js')
				->append_css('jquery/jquery.tagsinput.css')		
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



		//
		// Prepare Postback & Validation
		//
		$this->form_validation->set_rules($this->_validation_rules);
		
		
		
		//
		// Run validation if postback
		//
		if ($this->form_validation->run()) 
		{
			
			$input = $this->input->post();
			
			
			// Checks to see if there are changes in price
			$input = $this->_check_price_changes( $input,$data );
	
			// Converts strings to decimals
			$input = $this->_prep_prices($input);

			// Calcuates based on user params
			$input = $this->tax_m->calc_price($input);


			//prepare keywords
			// Get Keyword Hash
			$keywords_hash = (trim($data->keywords) != '') ? $data->keywords : NULL;
			$input['keywords'] = Keywords::process($input['keywords'], $keywords_hash);
			

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
			
			
			redirect('admin/shop/products/edit/' . $id);

			
		}
		
		
		
		
		//
		// Get the Values/Dropdown options for edit
		//
		$data->tax_groups 		= $this->tax_m->get_all();
		$data->category_select 	= $this->categories_m->build_tree_select(array('current_parent' => $data->category_id ));
		$data->brand_select 	= $this->brands_m->build_dropdown($data->brand_id);
		$data->group_select 	= $this->pgroups_m->build_list_select(array('current_id' => $data->pgroup_id));	
		$data->package_select 	= $this->package_library->build_list_select(array('current_id' => $data->package_id));
		$data->all_options = $this->options_m->build_dropdown();
		
		
		
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
				
				$redir = 'admin/shop/products/edit/'.$product_id;
				
			} 
			else 
			{
				$this->session->set_flashdata('error', lang('error'));
			}
			
		}
		
		redirect($redir);
		
	}
	
	
	public function visibility() 
	{

		// Get the post from the client
		$input = $this->input->post();

		$id = $input['id'];
		$current_state = $input['action'];
		$input['message'] = '';



		switch( $current_state ) 
		{
			case ProductVisibility::Invisible:
				$status	= 'Stop';
				$input['changeto'] = ProductVisibility::Visible;
				break;
			
			case ProductVisibility::Visible:
				$status	= 'Sell';
				$input['changeto'] = ProductVisibility::Invisible;
				break;
		}



		
		if(  $this->products_admin_m->update_property( $id , 'public', intval( $input['changeto'] ) ) )	
		{
			$input['status'] = $status;
		}
		else
		{
			$input['status'] = JSONStatus::Error;
		}

		
		Events::trigger('evt_product_changed', $id ); 
		
		
		echo json_encode($input);die;
	
	}	



	/*manage product properties*/
	public function ajax_product_attributes()
	{

		$this->load->model('product_attributes_m');

		$response['status'] = JSONStatus::Error;



		if( ($this->input->post('id') && $this->input->post('action')) ) 
		{

			switch($this->input->post('action'))
			{

				case PostAction::Delete:

					$this->product_attributes_m->delete( $this->input->post('id') );
					$response['status'] = JSONStatus::Success;
					break;	



				//default action is add
				case PostAction::Add:
				default:

					//Name and value are required
					if( ($this->input->post('name') && $this->input->post('value')) )
					{
						//send the full post
						if( $id = $this->product_attributes_m->create( $this->input->post() ) )
						{
							$response['id'] = $id;
							$response['status'] = JSONStatus::Success;
						}
					}
					break;

			}

		}

		//
		// Send the info back to JS/Client
		//
		echo json_encode($response);
	}
	
	/**
	 * Set or clear the cover image on a product
	 * 
	 * @return [type] [description]
	 */
	public function cover_image() 
	{	

		$this->load->library('products_library');


		$this->products_library->cover_image();
		
	}


	/**
	 * as an enhacement, we can assign cover if no images in gallery and no cover
	 *
	 * Can use the audit_db table for testing
	 * Events::trigger('evt_audit', array('Admin_Products_Controller','assign_image()' , 'image:'.$image  ));
	 */
	public function gallery_add()
	{
		
		$success_add = array();
	
		//
		// Check if it was posted
		//
		if ( $this->input->post() )
		{
			$input = $this->input->post();
	
			// Get the data from jQuery
			$images_array = $input['images'];
			$product_id = $input['product_id'];
						
			foreach ($images_array as $image) 
			{

				// Check if already exist
				if (!$this->products_admin_m->image_exist($image,$product_id))
				{	

					// if not, then we add
					if ($this->products_admin_m->add_image($image,$product_id))
					{
					
						//
						// Add the image ID to the array
						// to let jQuery know we have added it OK
						$success_add[] = $image;
						
					}
				} 

			}
			
			
			// Fire event to let system know that product has been changed
			// No need to do this for every inmage - reduce the workload.
			Events::trigger('evt_product_changed', $product_id);
			
			// Complete the respnse array
			$response['url'] = site_url();
			$response['added']= $success_add;
			$response['added_total']= count($success_add);

		}
		
		
		//
		// Send the array back to jQuery
		//
		echo json_encode($response);die;
		
	}
	
	
	public function gallery_remove()
	{
		$response['status'] = JSONStatus::Error;
			
		if ($input =  $this->input->post() )
		{
	
			// Get the data from jQuery
			$image = $input['image'];
			$product_id = $input['product_id'];
						
			
			if ($this->products_admin_m->remove_image($image, $product_id))
			{
				Events::trigger('evt_product_changed', $product_id);
				$response['status'] =  JSONStatus::Success;
			}
			
		}
		
		echo json_encode($response);die;
	}
	



	/**
	 * Expects the input array from the edit/create postback
	 * @param unknown_type $input
	 */
	private function _prep_prices($input = array()) 
	{
		// bt and at are calculated from price so we only need to make sure the below is correct	
		$input['price'] = sf_string_to_decimal($input['price']);
		$input['price_base'] = sf_string_to_decimal($input['price_base']);
		$input['rrp'] = sf_string_to_decimal($input['rrp']);
		
		return $input;
	}
	
	
	/**
	 * @param Object $data
	 * @param Array $input
	 * @access private
	 */
	private function _check_price_changes( $input, $data )
	{
	
		// Check if price has chanegd
		if (($data->price == $input['price']) && ($data->tax_dir == $input['tax_dir']))
		{
			$input['create_price_record'] = FALSE;			
		}
		
		return $input;
	
	}
	
	
	/**
	 *
	 * @return Array of images for gallery selection
	 */
	private function get_folders() 
	{
		
		// Load Files Module
		$this->load->library('files/files');
		$this->load->model('files/file_folders_m');
		
		// Set up the Dropdown Array for edit and create
		$folders = array(0 => lang('global:select-pick'));
		
		// Get All folders
		$tree = $this->file_folders_m->order_by('parent_id', 'ASC')->order_by('id', 'ASC')->get_all();
		
		// Build the Folder Tree
		foreach ($tree as $folder) 
		{
			$id = $folder->id;
			if ($folder->parent_id != 0) 
			{
				$folders[$id] =  $folders[$folder->parent_id] . ' &raquo; ' . $folder->name;
			} 
			else
			{
				$folders[$id] = $folder->name;
			}
		}
		
		return $folders;
	}
	
	
}
