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
class Cart extends Public_Controller 
{

	//
	// List of messages (error|success) for return
	//
	private $_MESSAGES = array();


	public function __construct() 
	{
		parent::__construct();
		
		$this->load->helper('shop/shop_prices');

		// Retrieve some core settings
		//$this->use_css =  Settings::get('nc_css');
		$this->shop_title = Settings::get('ss_name');		//Get the shop name
		$this->shopsubtitle = Settings::get('ss_slogan');		//Get the shop subtitle
		$this->login_required = Settings::get('ss_require_login');
		$this->has_logged_in_user =  ($this->current_user)? TRUE : FALSE ;


		$this->_init_messages();
		
				
		// Load required classes
		$this->load->model('products_front_m');
		$this->load->model('product_prices_m');


		//change the next few lines
		if ( $this->login_required && !$this->has_logged_in_user) 
		{
			$message = $this->_MESSAGES[210];
			if($this->input->is_ajax_request())
			{
				$sys_message['status'] = JSONStatus::Error;
				$sys_message['message'] = $message;
			}
			else
			{
				$this->session->set_flashdata('error', $message);
				redirect('users/login');
			}			

		}
		
	}


	private function _init_messages()
	{

		// Success add message
		$this->_MESSAGES[101] = lang('shop:cart:item_added'); 

		// Failed to add messagea
		$this->_MESSAGES[200] = lang('shop:cart:item_not_added'); 
		$this->_MESSAGES[201] = lang('shop:cart:id_qty_not_set');
		$this->_MESSAGES[202] = lang('shop:cart:product_not_found');
		$this->_MESSAGES[203] = lang('shop:cart:product_not_available');
		$this->_MESSAGES[204] = lang('shop:cart:product_out_of_stock');
		$this->_MESSAGES[210] = lang('shop:cart:you_must_login_before_shopping');


		// Item removed messages
		$this->_MESSAGES[300] = lang('shop:cart:item_removed1'); 
		$this->_MESSAGES[301] = lang('shop:cart:item_removed2');		
		$this->_MESSAGES[302] = lang('shop:cart:not_in_cart');	

	}



	/**
	 * Display Cart
	 */
	public function index() 
	{

		$this->template->title($this->module_details['name'])
				->build('common/cart');

	}

	/**
	 * Redirect after success
	 *
	 * @param INT $id
	 * @param INT $qty
	 *
	 * @access public
	 */
	public function add($id = 0, $qty = 1) 
	{
		//
		// Message handling for ajax
		//
		$sys_message = array();
		$sys_message['status'] = JSONStatus::Error;
		$sys_message['message'] = 'Unknown';
		$sys_message['cost'] = 0.00;
		$sys_message['qty'] = 0;
	
	
		$url_redir = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'shop/cart';
		


		// 
		// Check the post header to see if the item come from a post or a direct link
		//
		if( $this->input->post('id') ) 
		{
		
			// Get the product ID
			$id = $this->input->post('id');
			
			// The POST must contain the QTY
			$qty = intval( $this->input->post('quantity') );

			if(!$qty)
			{
				// Accept either qty or quantity
				$qty = intval( $this->input->post('qty') );

				//final check, if not set then set as 1 as the qty
				$qty = ($qty)?$qty:1;
				
			}
			
		}
		
		
		
		//
		// pre-Add checks
		//
		$product = $this->_add($id, $qty);

		if( is_object($product) == FALSE )
		{

			$message =  $this->_MESSAGES[$product];

			if($this->input->is_ajax_request())
			{
				$sys_message['message'] = $message;
				echo json_encode($sys_message);die;
			}
			else
			{
				// if the product/ request faled to validate just redirect now
				$this->session->set_flashdata( JSONStatus::Error , $message );
				redirect($url_redir);
			}
		}




		// 
		// get the options that may have been passed up
		// 
		$options_tmp = $this->_get_option_fields($product->id);


		$product->ignor_shipping = $options_tmp[0]; //dont think this is needed anymore
		$options = $options_tmp[1]; 
	  
		

		//$items['id'] = $product->id;
		//$items['options'] = $options;
		

		//
		// Pre generate the rowid 
		// This is not assigned to the item, its just used to get
		//		
		//$rowid = $this->sfcart->generate_rowid($items); //this is not asssigning a rowid just wfor checking if the item has already been added, therefore we can re-calc the prices better in the cart, this is for multiple item discounts.
		

		//
		// If you use the rowid - it will be dependant of options, if you use product id- it will disregard options when calculating the new quantaty
		//
		//$current_qty = $this->sfcart->product_qty($rowid);
		$current_qty 	= $this->sfcart->product_qty($product->id, 'id');
		$mid_qty 		= $this->sfcart->product_qty($product->pgroup_id, 'pgroup_id');


	

	
		//
		// Requested new qty 
		//
		$nq = $current_qty + $qty;
		
		
		
		//
		// Get discounted price if it exist
		// Override the item price - if the new quantaty (nq) changes and a lower price is available
		//
		


		// 1. Get the current QTY of items assigned to PGROUP
		// 2. Add to incoming QTY
		// 3. Get any MID by PGROUP
		hlp_get_price($product, $nq, $mid_qty);
		
		//
		// now we want to check the product group Pricing tables - as price groups overrides - product prices
		//

   

		//
		// Prepare the cart item before adding
		//
		$data = $this->_prepare_item_for_cart($product, $qty, $options);

		
		
		//
		// Add to cart
		//
		$success = $this->sfcart->insert($data);
		


		//
		// Trigger Event to Notify User of status (success/Failer)
		//
		Events::trigger('evt_cart_item_added', array('id' => $id, 'name' => $data['name'], 'success' => $success) );



		//
		// Update the cart totals/prices
		//
		$this->run_mid_on_cart();


		
		//
		// Format return message
		//
		if($success)
		{
			$_ERROR_MESSAGE = 101;
			$_MESSAGE_STATUS  = JSONStatus::Success;
		}
		else
		{
			$_ERROR_MESSAGE = 200;
			$_MESSAGE_STATUS  = JSONStatus::Error;
		}


		$message = sprintf( $this->_MESSAGES[$_ERROR_MESSAGE] , $product->name ); 


		//
		// Return data/messages
		//
		if($this->input->is_ajax_request())
		{
			
			//prepare ajax return statement
			$total_items = $this->sfcart->total_items();
			if($total_items==NULL) $total_items = 0;

			$sys_message['status'] = $_MESSAGE_STATUS;
			$sys_message['qty'] = $total_items; //total items in cart
			$sys_message['cost'] =  number_format( (float) $this->sfcart->total_cost_contents() , 2); //cost of cart
			$sys_message['message'] = $message;

			echo json_encode($sys_message);return;
		}
		else
		{

			$this->session->set_flashdata( $_MESSAGE_STATUS , $message );
			
			//
			// redirect them back to page
			//
			redirect($url_redir);
		}
	}
	
	

	/**
	 * Redirect after success
	 *
	 * @param INT $id
	 * @param INT $qty
	 *
	 * @access public
	 */
	public function _add($id = 0, $qty = 1) 
	{
	
	

		//
		// Check id the product ID and QTY values are OK
		//
		if( (!$id ) OR (!$qty) ) 
		{
			//Product ID or QTY was not set
			return 201;
		}


		//
		// Check that ID/QTY is a valid int, do not allow anything else other than an INT
		//
		$id = intval($id);
		$qty = intval($qty);



		// Get product from DB
		$item = $this->products_front_m->get($id,'id');  

		
		
		//
		// Check if product exist or still available
		//
		if(!$item)
		{
			return 202;
		}

		
	
		//
		// Check product validady (visible or deleted) 
		// 
		// This is important to check because in products_front_m if the user is admin it does not check this.
		// So it is a must at this stage.
		//
		if( is_deleted($item) || ($item->public === ProductVisibility::Invisible ) )
		{
			return 203;
		}
		
			
		//
		// Check for inventory levels
		//
		if(!($this->_check_inventory($item, $qty)) ) 
		{
			return 204;
		}
	


		//
		// Check if User req to login
		//
		if ( $this->login_required && !$this->has_logged_in_user) 
		{
			return 210;
		}


		// 
		// If we have reached this point then we can validate successfully
		//
		return $item;

	
	}
	
	
	/**
	 * update()
	 *
	 * 
	 * @access public
	 */
	public function update() 
	{
	
		// Lets get some validation here
		$data = $this->input->post();
		$update_data = array();
		

		foreach ($data as $d_item) 
		{
			
			$update_item = array();

			$update_item['rowid'] = $d_item['rowid'];
			$update_item['id'] = $d_item['id'];
			$update_item['qty'] = $d_item['qty'];
			
			$item = $this->products_front_m->get( $d_item['id'] );
			
	
			if ($item) 
			{

				// $mid_qty is the qty of items in the cart that are related by pgroup
				$mid_qty = $this->sfcart->product_qty($item->pgroup_id, 'pgroup_id');


				hlp_get_price($item, $d_item['qty'], $mid_qty);

				$update_item['price'] = $item->price_at;

				$update_item['base'] = $item->price_base;

			}
			
			$update_data[] = $update_item;

		}

		//apply possible qty changes and dletes
		$result = $this->sfcart->update($update_data);


		$this->run_mid_on_cart();
		 
		
		redirect('shop/cart');
	}





	private function _update() 
	{
	
		// Lets get some validation here
		$data = $this->input->post();
		$update_data = array();
		

		foreach ($data as $key => $d_item) 
		{
			
			$update_item = array();


			if( isset($d_item['id']) )
			{

				if( isset($d_item['rowid']) )
				{
					if( isset($d_item['qty']) )
					{
						continue;
					}

				}

			}

			//unset invalid update data
			unset($data[$key]); 

		}

		return $data;


	}

	/**
	 * To keep all cart iotems in sync with MID
	 * This function must be run every time AFTER the cart is altered (add/remove/change).
	 *
	 * It must be kept outside of SFCart.
	 * 
	 * @return [type] [description]
	 */
	public function run_mid_on_cart() 
	{
	
		//
		// Update multiple cart items at once
		//
		$update_data = array();

		foreach ($this->sfcart->contents() as $item) 
		{
			
		
			$product = $this->products_front_m->get( $item['id'] );
			

			if ($product) 
			{


				$mid_qty = $this->sfcart->product_qty($item['pgroup_id'], 'pgroup_id');
 
				
				hlp_get_price($product, $item['qty'], $mid_qty);


				$update_item = array();

				$update_item['rowid'] = $item['rowid'];
				$update_item['id'] = $item['id'];
				$update_item['qty'] = $item['qty'];


				//if options we have to run the recalc here
				$update_item['rowid'] = $item['rowid'];
				$update_item['price'] = $product->price_at;
				$update_item['base'] = $product->price_base;


			}
			
			$update_data[] = $update_item;

		}

		//apply possible qty changes and dletes
		$result = $this->sfcart->update($update_data);
		 


	}



	
	/**
	 * Delete an item from the cart
	 *
	 * @param String RowId of product in cart
	 * @access public
	 */
	public function delete($rowid) 
	{

		$url_redir = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'shop/cart';


		$items = $this->sfcart->contents();

		if($items[$rowid])
		{
			//found :)
			//get the name
			$prod_name = $items[$rowid]['name'];
			$this->sfcart->remove($rowid);
			$_MESSAGE_CODE = 301;
			$_STATUS = JSONStatus::Success;

		}
		else
		{
			// item does not exist in cart
			$prod_name = lang('shop:cart:unknown');
			$_MESSAGE_CODE = 302;
			$_STATUS = JSONStatus::Error;
		}




		//
		// This is important, we need to update the cart item values to keep MID values in sync.
		//
		$this->run_mid_on_cart();



		$message = sprintf( $this->_MESSAGES[$_MESSAGE_CODE] , $prod_name );




		if($this->input->is_ajax_request())
		{
			$total_items = $this->sfcart->total_items();
			if($total_items==NULL) $total_items = 0;


			$sys_message['qty'] = $total_items; //total items in cart
			$sys_message['cost'] =  number_format( (float) $this->sfcart->total_cost_contents() , 2); //cost of cart
			$sys_message['message'] = $message;
			$sys_message['status'] = $_STATUS;
			echo json_encode($sys_message);die;
		}
		else
		{
			// if the product/ request faled to validate just redirect now
			$this->session->set_flashdata( $_STATUS , $message );
			redirect($url_redir);
		}
		
	}

	
	/**
	 * This will clear the entire cart of its contents
	 * and shipping values / a full reset.
	 *
	 *
	 */
	public function drop() 
	{
	
		$this->sfcart->destroy();
		
		redirect('shop/cart');
	}
	
	
	/**
	 * This function checks wheather the requested stock item
	 * is in stock and has enough inventory for the request add
	 * @param unknown_type $item
	 * @access private
	 */
	private function _check_inventory($item, $qty) 
	{
		
		// Check 1: only allow the in-stock status
		if( $item->status !== InventoryStatus::InStock )
		{
			//no stock
			return FALSE;
		}
		
		// If unlimited stock - no further validation required
		if (($item->inventory_type == InventoryType::Unlimited )) return TRUE;

					
		// Everything below here is subject to Qty availability
		if (($item->inventory_on_hand >= $qty)) return TRUE;

				
		// Anything below here we just dont have the stock!!
		return FALSE;

	}
	

	/**
	 * 
	 * @param unknown_type $item
	 * @param unknown_type $qty
	 * @param unknown_type $options
	 * @return multitype:unknown NULL mixed
	 */
	private function _prepare_item_for_cart($item, $qty, $options) 
	{
		
		// Clean name from bad characters
		$name = preg_replace("/[^A-Za-z0-9 ]/", "", convert_accented_characters($item->name) );
		
		// Assign the Cart item array
		$data = array(
				'id' => $item->id,
				'slug' => $item->slug,
				'qty' => $qty,
				'price' => $item->price_at,
				'base' => $item->price_base,
				'name' => $name,
				'ignor_shipping' => $item->ignor_shipping,
				'options' => $options,
				'pgroup_id' => $item->pgroup_id,
				
				'price_bt' => $item->price_bt, /*before tax value*/
				'package_id' => $item->package_id,

		);
		
		return $data;
		
	}

	

	/**
	 * Prepares the Key=>value data for the options
	 *
	 *
	 */
	private function _get_option_fields($product_id) 
	{

		//
		// Load models
		//
		$this->load->model('options_m');
		$this->load->model('options_product_m');



		//
		// By default we do not ignor shipping, if an option sets to ignor then we do override this.
		//
		$ignor_shipping = FALSE;	



		//
		// Setup the default options array
		//
		$OPTIONS_TO_Return = array();
		
		


		$product_options_available = $this->options_product_m->get_prod_options($product_id);
		



		foreach ($product_options_available as $option_available) 
		{

			//
			// Get the field name that should have been used in the HTML
			//
			$_OP_INPUT_NAME = 'prod_options_' . $option_available->option_id;


			//
			// Get the option from the DB
			//
			$option = $this->options_m->get($option_available->option_id);



			//
			// Check to see if we have a File Upload
			//
			if($option->type == "file")
			{
				//var_dump($_FILES[  $_OP_INPUT_NAME  ]);die;

				if(!(isset( $_FILES[  $_OP_INPUT_NAME  ] ) ) ) continue;


				$F_NAME_PART = date("YmdHi",time());

				// 
				// Get the filename
				// 
				$F_NAME = $_FILES[  $_OP_INPUT_NAME  ]['name'];

				//check if a file exist in the upload data
				if($_FILES[  $_OP_INPUT_NAME  ]['name'] == "")
				{
					continue;
				}


				//
				// Upload and get the ID
				//
				$data = $this->upload(  $_OP_INPUT_NAME,  $F_NAME_PART . '-' . $F_NAME );

				if($data)
				{
					//file uploaded succesfully
				}
				else
				{
					echo "no file to add";die;
				}
				
							
				//build the option array that will be sent to the cart
				//array( 'max_qty' => 0 ,'operator' => '+=' , 'operator_value' => '0');
				// Get the label from the db/cache
				$OPTIONS_TO_Return[$_OP_INPUT_NAME] = array('name' => $option->name, 
										'value' => $data, /* $option->values->value */
										'label' => $data, /* $option->values->value */
										'user_data' => '',  /*used in cart view*/
										'max_qty' => 0, 
										'operator'=> 'n', //n = skip calc 
										'operator_value' => 0, 
										'type' => $option->type);


			}	
			elseif($option->type == 'text') //we have to handle the text option as they do not have sub-options and do not alter the price
			{

				//echo "From DB:<br/>";
				//var_dump($option);
				//echo "<br/><hr><br>";
				//echo "OPTION_NAME:". $option_name . "<hr>";

				$POST_value = $this->input->post(  $_OP_INPUT_NAME  );


				if( $POST_value === null ) continue;

				if( $POST_value === "" ) continue;


				//build the option array that will be sent to the cart
				//array( 'max_qty' => 0 ,'operator' => '+=' , 'operator_value' => '0');
				// Get the label from the db/cache
				$OPTIONS_TO_Return[$_OP_INPUT_NAME] = array('name' => $option->name, 
										'value' => $POST_value, /* $option->values->value */
										'label' => $POST_value, /* $option->values->value */
										'user_data' => 'text',  /*used in cart view*/
										'max_qty' => 0, 
										'operator'=> 'n', //n = skip calc 
										'operator_value' => 0, 
										'type' => $option->type);

			
			}	
			else
			{
				
				if(!$this->input->post(  $_OP_INPUT_NAME) ) continue;
				

				$POST_value = $this->input->post(  $_OP_INPUT_NAME  );



				$option = $this->options_m->get_option_by_id(  $_OP_INPUT_NAME, $POST_value  );	


			
				//build the option array that will be sent to the cart
				
				// Get the label from the db/cache
				$OPTIONS_TO_Return[$_OP_INPUT_NAME] = array('name' => $option->name, 
										'value' => $POST_value, /* $option->values->value */
										'label' => $option->values->label,  /*used in cart view*/
										'user_data' => $option->values->user_data,  /*used in cart view*/
										'max_qty' => $option->values->max_qty, 
										'operator'=>$option->values->operator, 
										'operator_value' => $option->values->operator_value, 
										'type' => $option->type);


				$ignor_shipping = $option->values->ignor_shipping;


			}
		}


	
		return array( $ignor_shipping, $OPTIONS_TO_Return );
		
	}


	/**
	 * We will only allow ZIP and image (jpg|png|bit) at this stage to prevent uploading bad scripts
	 * 
	 * @param  string $_expected_form_input_name [description]
	 * @param  string $filename                  [description]
	 * @return [type]                            [description]
	 */
	public function upload(  $_expected_form_input_name = 'fileupload', $filename ='file_for_order')
	{

		//lets do some pre-check before we let it into pyro system.
		//Right now the file is in the tmp dir, before we let it loose we do some checks, otherwise delete from tmp
		$upload_file_data = $_FILES[  $_expected_form_input_name  ];

		$tmp_name = ($upload_file_data['tmp_name']);

		//$size = $upload_file_data['size'];
		//$name = $upload_file_data['name'];
		$file_name_only = $upload_file_data['name'];		


		$file_info = pathinfo($file_name_only);


		$filename = $file_info['filename'];
		$extension = $file_info['extension'];
		$basename = $file_info['basename'];




		$valid_files = array('png', 'jpg', 'jpeg', 'bmp' ,'zip', 'txt', 'doc', 'docx');

		if(!in_array($extension, $valid_files)) 
		{
			return FALSE;
		}


		/*
		array
			'dirname' => string 'C:\wamp\tmp' (length=11)
			'basename' => string 'php80BC.tmp' (length=11)
			'extension' => string 'tmp' (length=3)
			'filename' => string 'php80BC' (length=7)
		*/


		$this->load->library('files/files');


		//
		// where do we upload files to
		//
		$folder_id =  Settings::get('shop_upload_file_orders');


	    //$upload = Files::upload($folder_id, 'file_for_order','fileupload');
	    $upload = Files::upload( $folder_id , $filename,  $_expected_form_input_name );


	    //var_dump($upload);die;


	    $filesize = $upload['data']['filesize'];
	    $extension = $upload['data']['extension'];



	    $file_id = $upload['data']['id'];
	
		return $file_id;

	}	
}