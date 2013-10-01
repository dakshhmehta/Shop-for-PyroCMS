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
 
/**
 * NITRO CART	An explosive e-commerce solution for PyroCMS - ......and 'Open Source'
 *
 * @author		Guido Grazioli
 * @version		0.90.0.000
 * @website		http://www.inspiredgroup.com.au/
 * @package		Brands Admin Contoller for NITRO-CART
 * @system		PyroCMS 2.1.x
 *
 */
class Options extends Admin_Controller 
{


	//
	// Define section for admin cp
	//
	protected $section = 'options';
	
	
	//
	// URIs
	//
	protected $uri_options_list = 'admin/shop/options/';
	protected $uri_options_edit = 'admin/shop/options/edit/';
	
	

	public function __construct() 
	{
		parent::__construct();

		//check if has access
		role_or_die('shop', 'options');		
		
		//module path
		$this->mod_path = base_url() . $this->module_details['path'];

		// Load all the required classes
		$this->load->model('options_m');
		$this->load->model('options_product_m');
		$this->load->library('form_validation');
				
		$this->template
					->append_js('module::admin/admin.js')	
					->append_js('module::admin/options.js')			
					->append_css('module::admin.css')
					->append_css('module::admin_options.css')
					->append_css('module::admin_options.css')
					->append_metadata('<script type="text/javascript">' .
                                         "\n  var MOD_PATH = '" . $this->mod_path . "';" .
                                         "\n</script>");
		
	}
	
	/**
	 * List all items
	 * @access public
	 */
	public function index() 
	{
	
		//
		// Check for multi delete
		//
		if($this->input->post('action_to'))
		{
			$this->delete(NULL);
		}
		
		//
		// Otherwise display list
		//
		$data->options = $this->options_m->get_all();
		
		$this->template
				->title($this->module_details['name'])
				->build('admin/options/list', $data);
				
	}

	
	/** duplicate
	 *  
	 * @access public
	 */	
	public function duplicate($id = 0) 
	{
	
		// Set the default redirect page
		$redir = $this->uri_options_list;
		
	
		if (is_numeric($id))
		{

			$option_id = $this->options_m->duplicate($id);
			
			if ($option_id) 
			{
				$this->session->set_flashdata('success', lang('success'));
				$redir = $this->uri_options_edit.$option_id;
			} 
			else 
			{
				$this->session->set_flashdata('error', lang('error'));
			}
			
		}
		
		redirect($redir);
		
	}
	
	
	/**
	 * Create a new Brand
	 */
	public function create() 
	{
	
		// Get the validation rules
		$this->_validation_rules = $this->options_m->get_validation_rules();
		
		
		// Check for post data
		$this->form_validation->set_rules( $this->_validation_rules );
		
		
		if( $this->input->post() )
		{
		
		
			// Get the input data
			$input = $this->input->post();
			
			
			// if postback-validate
			if ($this->form_validation->run()) 
			{
				
				//
				// Create the option record
				//
				$this->options_m->create($input);
				
				
				//
				// fire an event to clear options cache 
				//
				Events::trigger('evt_options_changed', array() );
				
				
				
				// Return status message
				$this->session->set_flashdata('success', lang('success'));
				
				
				
				//redirect to main list
				redirect($this->uri_options_list);
				
				
			} 
			else 
			{
		
				// Return status message
				$this->session->set_flashdata('error', lang('error'));
				
			}
			
		}
		
		

		// init all values or return enetered values
		foreach ($this->_validation_rules as $key => $value) 
		{
			$data->{$value['field']} = '';
		}
		
		
		//
		// Get the drop down array
		//
		$data->option_types = $this->options_m->build_option_types_dropdown();
		

		// Build page
		$this->template
			->title($this->module_details['name'])
			->enable_parser(TRUE)
			->enable_minify(TRUE)
			->set_layout(FALSE)					
			->build('admin/options/create', $data);
					
	}
	
	
	

	 
	/** This function will add option values to the option set
	 *
	 *
	 *
	 * @return Ajax View - Will not load theme layout
	 * @param INT $id This must be set, if creating a new options we must first save it before adding option values
	 * @parem String $redir (list|edit) which screen to redirect to
	 * @access public
	 */
	public function edit($id)
	{
	
		//
		//  First we will prepare for postback check, get the validation rules to be applied for postbacks/edits
		//
		$this->_validation_rules = $this->options_m->get_validation_rules('edit');
		
		
		
		
		//
		// Set the validation rules
		//
		$this->form_validation->set_rules($this->_validation_rules);
		
		
		
		
		//
		// On postback formvalidation will fire, if the validation
		// succeeds then we enter the next block of code below to continue
		// editing and saving the changes to the options
		//
		if ($this->form_validation->run()) 
		{
		
		
		
			//
			// Get the input data from the postback
			//
			$input = $this->input->post();

			
			
			//
			// Save the edits to the option record
			//
			$this->options_m->edit($id, $input);
			
			

			
			//
			// fire an event to clear options cache 
			//
			Events::trigger('evt_options_changed', array() );
	
	
	
			//
			// Return status message to user
			//
			$this->session->set_flashdata('success', lang('success'));
			
			
			
			//
			// redirect to list view
			//
			redirect($this->uri_options_list);
			
		}

		
		

		


		
		//
		// prepare for the view :: Get the option
		//
		$data = $this->options_m->get($id);
	
	
		//
		// Check to see if the option exist, if the option does not exist we must redirect
		// we can also inform admin about the error
		//
		if (!$data) 
		{
		
			//TODO: create or use "option not found variable" or "an error occured with editing this option"
			$this->session->set_flashdata('error', lang('product_not_found'));
			
			
			// redirect to list view
			redirect($this->uri_options_list);
			
			
		}
		
		
		
		//
		// Get a list of option operaters
		//
		$data->option_operators = $this->options_m->get_option_operators();
		
		
		//
		// Get the drop down array
		//
		$data->option_types = $this->options_m->build_option_types_dropdown( $data->type , RWMode::ReadOnly );
		
		
		//
		// Display the add form 
		//
		$this->template	
				->title($this->module_details['name'])
				->append_js('module::admin/options.js')
				->build('admin/options/edit', $data);

	
	}

	
	
	/**
	 * Simple delete, will need to work on validation and return messages
	 * @param unknown_type $id
	 */
	public function delete( $id = null ) 
	{
		$fire_event = FALSE;
		

		//
		// if btnAction === "delete"
		//
		if( $this->input->post('btnAction') === PostAction::Delete )
		{
			$options = $this->input->post('action_to');
			
			foreach($options as $key =>$id)
			{

				if( $this->options_m->delete($id) )
				{
					$fire_event = TRUE;
				}
				
			}
			
		}
		else
		{
		
			if( $this->options_m->delete($id) )
			{
				$fire_event = TRUE;
			}

		}
		
		
		//
		// Fire an event to clear options cache 
		//
		if( $fire_event )
		{
			Events::trigger('evt_options_changed', array() );
		}
		
		
		
		// Redirect after done
		redirect('admin/shop/options');
		
	}
	
	

	
	/** 
     *
	 */
	public function ajax_add_values()
	{
	

		if( $this->input->post('id') )
		{
		
			$input = $this->input->post();
		
			$id = $input['id'];
		
			//basic cleanup from input

			//remove these from the input
			unset($input['id']);
			unset($input['save']);
		
			//do not add null empty values
			foreach($input as $data)
			{
				if(trim($data) == "") continue;
				$this->options_values_m->create_simple($id, $data); //create simple just adds name/value not other optins
			}

		
			redirect('admin/shop/options/edit/'.$id );
		}
		
		redirect('admin/shop/options/');
			

	}

	
	/** 
     *
	 */
	public function ajax_edit_value()
	{
	

		$response['status'] = JSONStatus::Error;
		$response['message'] = 'Something went wrong';

		
		
		// if postback-validate
		if ($this->input->post()) 
		{
		
			//
			//  First we will prepare for postback check, get the validation rules to be applied for postbacks/edits
			//
			$this->_validation_rules = $this->options_m->get_value_validation_rules();




			//
			// Set the validation rules
			//
			$this->form_validation->set_rules($this->_validation_rules);


				
			if( $this->form_validation->run() )
			{
		

				
				$input = $this->input->post();
				
				
				
				// Save the edits to the option record
				//$this->options_m->edit_option_value($input['id'], $input);
				$this->options_values_m->edit($input['id'], $input);
				
				$response['id'] = $input['id'];
				$response['value']= $input['value'];
				$response['operator']= $input['operator'];
				
				
				//
				// fire an event to clear options cache 
				//
				Events::trigger('evt_options_changed', array() );
		
		
		
				// Return status message - we can let them know using jQuery
				//$this->session->set_flashdata('success', lang('success'));
				$response['status'] = JSONStatus::Success;
				$response['message'] = 'All done';
				
				
			}
			else
			{
			
				$response['status'] = JSONStatus::Error;
				$response['message'] = 'Something went wrong, please check your data'; //$this->form_validation->error_as_array();
			}
			
		}
		
		echo json_encode($response);
	
	}


	
	/** remove_option
	 *
	 * This should be called using ajax, no view is displayed.
	 *
	 * @param INT $id 		- The value ID to remove from the list
	 * @param INT $value_id	- 
	 * @access public
	 */
	public function ajax_delete_value( $id = NULL )
	{
		
		// json return status initialize
		$ret_status = JSONStatus::Error;
		$message = '';
		
		
		// ovid (Option value id)
		if( $this->input->post('ovid') )
		{
		
			// Get the id from the post
			$id = $this->input->post('ovid');
			
			
			// Delete the option from te DB
			//$this->options_m->del_option_value($id);
			$this->$this->options_values_m->delete($id);
			
			
			// Set the status
			$ret_status = JSONStatus::Success;
			
			$message = $id;
			

			// fire an event to clear options cache 
			Events::trigger('evt_options_changed', array() );
		
		}

		
		// Send status back to browser
		echo json_encode( array('status' => $ret_status, 'message'=> $message) );
		
	}
	
	
	

	
	
	


	
	public function addoption($id) 
	{

		//
		//we need to bind the new option with the curreent object (id)
		//
		$data->id = $id;
		
		//
		// Get a list of option operaters
		//
		$data->option_operators = $this->options_m->get_option_operators();
		
		
		//
		// Get the drop down array
		//
		$data->option_types = $this->options_m->build_option_types_dropdown();
		
		
		
		//
		// return the view
		//
		return $this->load->view('admin/options/addmultipleoption',$data); die;
		

	}
	
	

	/**
	 * 
	 *
	 * @param INT $id The ID of the option value
	 * @return View of the edit option value loaded via ajax
	 *
	 * @access public
	 */
	public function editoption($id) 
	{

	
		
		//
		// Get the option value to edit
		//
		//$data = $this->options_m->get_option_value($id);
		$data =  $this->options_values_m->get($id);
		
		
		
		//
		// Get a list of option operaters
		//
		$data->option_operators = $this->options_m->get_option_operators();
		
		
		//
		// Get the drop down array
		//
		$data->option_types = $this->options_m->build_option_types_dropdown();
		
		
		
		//
		// return the view
		//
		return $this->load->view('admin/options/editoption',$data);
		

	}	
	
	

	
	
	/**
	 * Moves /reorders the option value from n to n+1
	 *
	 * p = Product ID 	: Required : Required only for add (Action)
	 * o = Option ID 	: Required : INT [The prod_option ID]
	 * a = Action 		: Required : String [add|delete] 
	 */
	public function product_option()
	{


		// Get the option id from the post
		$option_id = $this->input->post('o');
		$action = $this->input->post('a');
		


		//
		// Enums help make the code cleaner and easier to read, it also enforces that
		// we use these strict rules for the whole project i.e 'del' and 'delete'
		//
		switch($action)
		{

			case PostAction::Add:

				$product_id = $this->input->post('p');
				$result = $this->options_product_m->create( $product_id, $option_id );	
				break;

			case PostAction::Delete:

				$result = $this->options_product_m->delete( $option_id );
				break;

		}


		//
		// Return the JSON Object
		//
		echo json_encode( array('status' => 'success','assign_id' => $result) );die;
		
	}



	

	
	
	/**
	 * Moves the product ption up or down based 
	 * on its param that are posted using ajax
	 *
	 *
	 */
	public function move_product_option()
	{
		//
		// Load the model
		//
		$this->load->model('options_product_m');
		
		
		//
		// Initialize jsonObject array
		//
		$jsonObject['status'] = 'error';

		
		
		//
		// Test for required data
		//
		if(!( $this->input->post('o')))
		{
			echo json_encode($jsonObject); die;	
		}

		
		
		//
		// Collect data
		//
		$option_id = $this->input->post('o');
		$dir = $this->input->post('dir');
		
		
		//
		// Do the move
		//
		$result = $this->options_product_m->move( $option_id, $dir );
		
		
		//var_dump($result);
		
		//
		// Return the result
		//

		if($result != FALSE)
		{
			$jsonObject['status'] = 'success';
			$jsonObject['items'] = $result;
		}

		
		echo json_encode($jsonObject); die;
	}
	
	
	
	
	
	
	
	/**
	 * Moves /reorders the option value from n to n-1
	 *
	 *
	 */
	public function move_item_up()
	{
		//
		// Initialize jsonObject array
		//
		$jsonObject['status'] = JSONStatus::Error;

		
		
		//
		// Test for required data
		//
		if(!( $this->input->post('v') ))
		{
			echo json_encode($jsonObject); die;	
		}

		
		//
		// Collect data
		//
		//$option_id = $this->input->post('o');
		$option_value_id = $this->input->post('v');

		

		//
		// Do stuff
		//
		$result =  $this->options_values_m->move($option_value_id, 'up');
		
		
		
		//
		// Return message
		//
		if($result != FALSE)
		{
			$jsonObject['status'] = JSONStatus::Success;
			$jsonObject['items'] = $result;
		}

		
		echo json_encode($jsonObject); die;

		
	}
	
	
	/**
	 * Moves /reorders the option value from n to n+1
	 *
	 *
	 */
	public function move_item_down()
	{
		
		//
		// Initialize jsonObject array
		//
		$jsonObject['status'] = JSONStatus::Error;
		
		
		//
		// Test for required data
		//
		if(!( $this->input->post('v') ))
		{
			echo json_encode($jsonObject); die;	
		}

		
		//
		// Collect data
		//
		//$option_id = $this->input->post('o');
		$option_value_id = $this->input->post('v');

		

		//
		// Do stuff
		//
		$result =  $this->options_values_m->move($option_value_id, 'down');
		
		
		
		//
		// Return message
		//
		if($result != FALSE)
		{
			$jsonObject['status'] = JSONStatus::Success;
			$jsonObject['items'] = $result;
		}

		
		echo json_encode($jsonObject); die;

		
	}


}