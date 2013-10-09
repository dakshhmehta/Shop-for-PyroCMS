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
class Products_util extends Admin_Controller 
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
				'rules' => 'trim|numeric'
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

		$this->mod_path = base_url() . $this->module_details['path'];
		
		// For all pages on products associate the fllowing files/settings
		$this->template
					->append_js('module::admin/util.js')
					->append_js('module::admin/admin.js')
					->append_css('module::admin.css')
					->append_metadata('<script></script>')
					->append_metadata('<script type="text/javascript">' . "\n  var MOD_PATH = '" . $this->mod_path . "';" . "\n</script>")
					->set('folders', $folders);

	}



	/*manage product properties*/
	public function ajax_find_product()
	{

		$this->load->model('products_admin_m');

		$response['status'] = JSONStatus::Error;
		$response['results'] = array();



		if( $term = $this->input->post('term') ) 
		{

			$response['status'] = JSONStatus::Success;
			$response['results'] = $this->products_admin_m->find_related($term);

		}

		//
		// Send the info back to JS/Client
		//
		echo json_encode($response);
	}
	
	/**
	 *
	 * @return Array of images for gallery selection
	 */
	protected function get_folders() 
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
	 * 
	 * @param unknown_type $input 
	 * 
	 * @revision 1.1 Initial
	 * @version  1.2 Check to see if field exist, as now we have partial field edits.
	 */
	protected function _prep_prices($input = array()) 
	{

		// bt and at are calculated from price so we only need to make sure the below is correct	
		if(isset($input['price']))
		{
			$input['price'] = sf_string_to_decimal($input['price']);

			$input['price_at'] = $input['price'];
			$input['price_bt'] = $input['price'];		
		}

		if(isset($input['price_base']))
			$input['price_base'] = sf_string_to_decimal($input['price_base']);

		if(isset($input['rrp']))
			$input['rrp'] = sf_string_to_decimal($input['rrp']);



		
		return $input;
	}
	
	
	/**
	 * @param Object $data
	 * @param Array $input
	 * @access private
	 */
	protected function _check_price_changes( $input, $data )
	{
	
			if(isset($input['price']))
			{
				if(isset($input['tax_dir']))
				{
					// Check if price has chanegd
					if (($data->price == $input['price']) && ($data->tax_dir == $input['tax_dir']))
					{
						$input['create_price_record'] = FALSE;			
					}
				}

			}

		
		return $input;
	
	}
	
	

}
