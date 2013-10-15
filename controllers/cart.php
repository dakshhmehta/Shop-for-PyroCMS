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
		
				
		// Load required classes
		$this->load->model('products_front_m');
		$this->load->model('product_prices_m');


		
		// Apply default CSS if required
		//if ($this->use_css) _setCSS($this->template);



		//change the next few lines
		if ( $this->login_required && !$this->has_logged_in_user) 
		{
			$this->session->set_flashdata('error', 'You must login before you can add items..');
			redirect('users/login');
		}
		
	}

	/**
	 * Display Cart
	 */
	public function index() 
	{

		$this->template->title($this->module_details['name'])
				->append_css('module::shop.css')
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
	
	
		$url_redir = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'shop/cart';
		
		//var_dump($_FILES);

		//var_dump($this->input->post());die;

		// 
		// Check the post header to see if the item come from a post or a direct link
		//
		if( $this->input->post('id') ) 
		{
		
			// Get the product ID
			$id = $this->input->post('id');
			
			// The POST must contain the QTY
			$qty = intval( $this->input->post('quantity') );

			if($qty)
			{

			}
			else
			{	
				//
				// Accept either qty or quantity
				//
				$qty = intval( $this->input->post('qty') );

				//final check, if not set then set as 1 as the qty
				$qty = ($qty)?$qty:1;
				
			}

			
		}
		
		

		
		//
		// pre-Add checks
		//
		if( ! $product = $this->_add($id, $qty) )
		{
		
			// if the product/ request faled to validate just redirect now
			redirect($url_redir);
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
		//$product->price_at = $this->product_prices_m->get_discounted_price($product->id, $nq, $product->price_at);    


		

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



		$this->run_mid_on_cart();

		
		
		//
		// redirect them back to page
		//
		redirect($url_redir);
		
		
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
			// Set User message 
			$this->session->set_flashdata('feedback', 'Invalid Data');
			
			// Usert has requested invalid data
			return FALSE;
			
		}

		

		// Get product from DB
		$item = $this->products_front_m->get($id,'id');  

		
		
		
		// Check if the product existed
		if(!$item)
		{
			$this->session->set_flashdata('feedback', 'Unable to find product');
			return FALSE;
		}

		
	
		//
		//check product validady (visible or deleted)
		//
		if( is_deleted($item) || ($item->public === ProductVisibility::Invisible ) )
		{
			$this->session->set_flashdata('feedback', lang('product_not_avail') );
			return FALSE;
		}
		
			
		//
		// Check for inventory levels
		//
		if(!($this->_check_inventory($item, $qty)) ) 
		{
			$this->session->set_flashdata('feedback', lang('product_not_avail') );
			return FALSE;
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

	private function __update()
	{

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
		$this->sfcart->remove($rowid);


		$this->run_mid_on_cart();


		redirect('shop/cart');
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
			$this->session->set_flashdata('feedback', lang('user_nostock_warning') );
			return FALSE;
		}
		
		// If unlimited stock - no further validation required
		if (($item->inventory_type == InventoryType::Unlimited )) return TRUE;

					
		// Everything below here is subject to Qty availability
		if (($item->inventory_on_hand >= $qty)) return TRUE;

				
		// Anything below here we just dont have the stock!!
		$this->session->set_flashdata('feedback', "Sorry we only have :". $item->inventory_on_hand. ' available.');


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
				
				// Meta data - not really used
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

		
		$data = $this->upload();
		$has_file = false;

		if($data == "")
		{
			//no file uploaded
		}
		else
		{	
			//we have a file
			//and this is the file id.

		}


		$this->load->model('options_m');

		//
		// By default we do not ignor shipping, if an option sets to ignor then we do override this.
		//
		$ignor_shipping = FALSE;	


		//
		// Setup the default options array
		//
		$options = array();
		
		
		//
		// Options will only come from a post - 
		// if no post, then we have have no options
		//
		if ( !( $this->input->post('prod_options') ) ) return array( $ignor_shipping, $options );


		//
		// Get the request
		//
		$prod_options = $this->input->post('prod_options');
		
		//var_dump($prod_options);die;
		

		//if (isset($prod_options)) 
		//{
			 



			
			//key=delivery value = digital/postal
			foreach ($prod_options as $key => $value) 
			{
		

				//
				// if the user Doesnt add data - dont add it to the request
				// This is only going to appear for text box fields as checkboxes, and radios are
				// not posted if not set
				//
				if ($value == "")
				{
					unset($prod_options[$key]);
					continue; //skip to next
				}


			


				
		
				//
				// Text options can not alter price
				//
				$option = $this->options_m->get_option_value_by_slug($key,$value);	
				

			


				$options[$key] = array();

				//we have to handle the text option as they do not have sub-options and do not alter the price
				if($option->type == 'file')
				{	

					if($value == 'donotremove')
					{
						//var_dump($option);die;
					}
					//
					// Trigger Event to Notify User of status (success/Failer)
					//
					//Events::trigger('evt_send_admin_email', array('attachment' => $value, 'product_id' => 'product_id') );

								

					//build the option array that will be sent to the cart
					//array( 'max_qty' => 0 ,'operator' => '+=' , 'operator_value' => '0');
					// Get the label from the db/cache
					$options[$key] = array('name' => $option->name, 
											'value' => $data, /* $option->values->value */
											'label' => $data, /* $option->values->value */
											'max_qty' => 0, 
											'operator'=> 'n', //n = skip calc 
											'operator_value' => 0, 
											'type' => $option->type);

				}
				elseif($option->type =='text') //we have to handle the text option as they do not have sub-options and do not alter the price
				{
					
					
					//build the option array that will be sent to the cart
					//array( 'max_qty' => 0 ,'operator' => '+=' , 'operator_value' => '0');
					// Get the label from the db/cache
					$options[$key] = array('name' => $option->name, 
											'value' => $value, /* $option->values->value */
											'label' => $value, /* $option->values->value */
											'max_qty' => 0, 
											'operator'=> 'n', //n = skip calc 
											'operator_value' => 0, 
											'type' => $option->type);

				}
				else
				{
					
					
					
					//build the option array that will be sent to the cart
					
					// Get the label from the db/cache
					$options[$key] = array('name' => $option->name, 
											'value' => $value, /* $option->values->value */
											'label' => $option->values->label,  /*used in cart view*/
											'max_qty' => $option->values->max_qty, 
											'operator'=>$option->values->operator, 
											'operator_value' => $option->values->operator_value, 
											'type' => $option->type);


					$ignor_shipping = $option->values->ignor_shipping;


				}


										
				


			}

		//}
	
		return array( $ignor_shipping, $options );
		
	}

	public function upload($file_option_slug=null)
	{

		$this->load->library('files/files');

		$folder_id = 57;

	    $upload = Files::upload($folder_id, 'file_for_order','fileupload');

	    //var_dump($upload['data']['id']);die;

	    $file_id = $upload['data']['id'];
	
		return $file_id;


	   // $second_upload = Files::upload($folder_id, 'Some Name', 'secondfile');
	}	
}