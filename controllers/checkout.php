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
class Checkout extends Public_Controller 
{

	// Support multiple checkout theme/styles
	protected $theme_name = 'single';

	protected $checkout_version = '0.1';
	
	public function __construct() 
	{
		parent::__construct();

		$this->lang->load('merchant');
		
		// Retrieve some core settings
		//$this->use_css =  Settings::get('nc_css');
		$this->use_jq =  Settings::get('nc_jq');
		$this->shop_title = Settings::get('ss_name');		//Get the shop name
		$this->shopsubtitle = Settings::get('ss_slogan');		//Get the shop subtitle
		$this->distribution_location =  Settings::get('ss_distribution_loc');  // for shipping calcs
		$this->ss_require_login =  Settings::get('ss_require_login');  // for shipping calcs

		// Set the theme layout path - This allows us to have muiltiple checkout themes
		$this->theme_layout_path =  'checkout/'.$this->theme_name.'/master';



		

		$this->_session = session_id();
		// Require SSL
		if ($this->settings->ss_ssl_required and strtolower(substr(current_url(), 4, 1)) != 's') 
		{
			redirect(str_replace('http:', 'https:', current_url()) . '?session=' . session_id());
			die;
		}
		
		// Session
		if ($this->input->get('session')) 
		{
			$this->_session = session_id($this->input->get('session'));
			session_regenerate_id();
		}

		// Setup arrays used for checkout validation
		$this->tmp_addr = array();
		$this->return_validation = array();
		$this->return_validation['fields']  = array();
		$this->return_validation['message'] = array();	
		
		// Apply CSS or JS Libraries if required
		//if ($this->use_css) _setCSS($this->template);
		if ($this->use_jq) _setJQ($this->template);
		
	}
	
	private function _load_classes()
	{
		// Load Classes
		$this->load->model('addresses_m');
		$this->load->model('orders_m');
		$this->load->model('products_front_m');
		$this->load->library('Package_library');
		$this->load->library('Shipping_library');
		$this->load->library('Gateway_library');
		$this->load->library('formvalidation');	
	}	
	
	
	/**
	 * This is called by the jQuery function that sends the form - it forces a validation but does not allow for addresses to be created
	 * in the db
	 *
	 */
	public function validate_ax() 
	{	
		$this->validate( PostMethod::Ajax , FALSE); 	
	}
	
	/**
	 * This is the validate function, its called by the place order function and the validate function
	 * @param 	PostMethod Ajax|Normal			enum
	 * @param	Boolean $place_order	Is the user attempting to place order or just validate - this determines whether addresses are created in db
	 */
	public function validate( $ajax = TRUE, $place_order = FALSE )
	{
		$this->_load_classes();
				
		$this->return_validation['status'] = 'error';
		
		$this->return_validation['shipping'] = array(6,'2.00');
			
		if ($this->input->post())
		{
	
			$input = $this->input->post();
			
			
			if ( $this->_step1_validate_user($input) )
			{
			
				// We get the User Address (Billing and Shipping)
				if ( $this->_step2_address($input,$place_order) )
				{
				
					//calc the shipping
					$shipping_method_id = $input['shipping_method_id'];
					$shipping_cost = $this->calc_shipping_by_id($shipping_method_id, $this->tmp_addr ) ; //send the shipping method and the selected address
					$this->return_validation['shipping'] = $shipping_cost;
					$this->return_validation['cart_total'] = $this->sfcart->total();
					$this->return_validation['status'] = 'success';
	
				}
				
			}
			
		}
		
		$this->return_validation['custom'] = $this->tmp_addr;
		

		if($ajax) 
		{ 
			echo json_encode($this->return_validation); 
			exit();
		}
		

		//else
		if( $this->return_validation['status'] == 'success')
		{
			return TRUE;
		}
		
		return FALSE;
	}
	

	
	public function place()
	{
		$this->load->library('fraud_control');

		if($this->input->post())
		{
			$input = $this->input->post();
			$input['ip_address'] = $this->input->ip_address();
			

			if ( $this->validate( PostMethod::Normal, TRUE ) ) //the true will record the addresses in the sysystem db, the false says its NOT ajax
			{
			
				// Now place order
				$shipping_method_id = $input['shipping_method_id'];
				$gateway_method_id = $input['gateway_method_id'];
				
				$this->session->set_userdata('shipping_method_id', $shipping_method_id);
				$this->session->set_userdata('gateway_method_id', $gateway_method_id);
				
				// recalc the shipping
				$this->calc_shipping_by_id($shipping_method_id, $this->tmp_addr ) ;


				// 
				// we need this so that the fraud tools know which version of the input
				// to chek against
				// 
				$input['checkout_version'] = $this->checkout_version;
				$input['order_total'] = $this->sfcart->total();

				//
				// Now we are ready to place an order, lets validate against the blacklist
				//
				if( $this->fraud_control->validate_order($input) )
				{
					//get a score
 					$trust_object = $this->fraud_control->get_trust_score($input);


 					$input['trust_score'] = $trust_object->score;

					// Place the order - redirect here
					$this->place_order($input, $trust_object->events) ;

					//echo "GOOD";die;
				}
				else
				{


					$a_id = $this->session->userdata('shipping_address_id');

					$address = $this->addresses_m->get($a_id);

					$array_data = array();
					$array_data['email'] = $address->email;
					$array_data['phone'] = $address->phone;
					$array_data['user_id'] =  $this->session->userdata('customer_id');
					$array_data['cost_total'] =  $this->sfcart->total();
					$array_data['shipping_address'] = $this->session->userdata('shipping_address_id');
					$array_data['billing_address'] =  $this->session->userdata('billing_address_id');

					Events::trigger('evt_blacklist_attempt', $array_data);

					$this->session->set_flashdata('error','You have been blocked from placing orders.');

					redirect('shop');					

				}
				
			}
		}
	}	

	
	// Can we proceeed to checkout ??
	private function _check_to_continue() 
	{
		// This is not a duplicate of check /validate user, only if not allowed check
		if($this->ss_require_login && (! $this->current_user) )
		{ 
			redirect('users/login');
		}
		
		// If no items go back to the cart
		if (!$this->sfcart->total_items()) 
		{ 
			redirect('shop/cart');
		}
	}




	
	/**
	 * Display the page
	 * Ajax calls/responses handle the rest
	 *
	 */
	public function index() 
	{
		
		// Check before loading classes!!
		$this->_check_to_continue();
		
		// Load the classes for checkout
		$this->_load_classes();


		// Collect all Existing addresses for this user
		$data->addresses = ($this->current_user)? $this->addresses_m->get_active_by_user($this->current_user->id): array() ;
		

		// List of approved countries
		$data->countryList = get_country_from_iso2alpha( '','normal', TRUE ); 
		

		// Get all shipping options:$data->shipping is an array of objects
		$data->shipping = $this->shipping_library->get_enabled();

		//To start let the shipping address be 0 (no selected address)
		$data->shipping = $this->calc_all_shipping($data->shipping,0);
		

		// Get a list of setup and enabled gateways by the admin
		$data->payments = $this->gateway_library->get_enabled();


		//var_dump($this->sfcart->contents());
		
		
		$this->template
			->title($this->module_details['name'], lang('customer_title'))
			->build($this->theme_layout_path,$data);
			
	}
	

	
	private function _step1_validate_user($input)
	{
		// If user is logged in - we are ll good - just record the user id
		if( $this->current_user )
		{ 
			// User is logged in - Set the user id
			$this->session->set_userdata('customer_id', $this->current_user->id ); // if Guest then -1
			return TRUE;
		}
		
	
		// User is not logged in - but we dont require auth - then thats ok too
		if (!$this->ss_require_login )
		{
		
			// Check if guest is selected store the guest id
			// Have they selected Guest
			if (isset($input['user_type']))
			{
				$this->session->set_userdata('customer_id', 0 ); // if Guest then 0
				return TRUE;
			}
			
			//If not warn them
			$this->return_validation[fields][] = 'user_type';
		}

		// Else system requires account - we actually should get here - as there is a pre-check - but best to handle it
		$this->return_validation[fields][] = 'user_type';
		$this->return_validation[message][] = 'Please sign in or create an account';
		
		return FALSE;
	}
	
	
	/**
	 * Only for logged in users
	 *
	 */
	private function _step2_address($input, $place_order = FALSE )
	{
		// Get Billing
		if ($this->_step2_validate_existing_address($input, 'billing') )
		{
		
			// Get Shipping
			if ($this->_step2_validate_existing_address($input, 'shipping') )
			{
				// Only if we are intending to place order on this action
				//if simple a validate then we dont add the manual address
				if($place_order)
				{
					// Now that both addresses validate, if they are manual input we add them to the db
					//Checks are done inside the function to se wheather its neede
					$this->_step2_store_address($input, 'billing');
					$this->_step2_store_address($input, 'shipping');
				}
				
				return TRUE;
			
			}

		}
		
		$this->return_validation['message'][] = 'Unable to validate address';

		return FALSE;
	}
	
	private function _step2_store_address($input, $type = 'billing') 
	{
	
		$address_type = ($type == 'billing') ? 'existing_address_id' : 'existing_address_shipping_id'  ;
		$session_address_type = ($type == 'billing') ? 'billing_address_id' : 'shipping_address_id'  ;
		
		//Check billing
		if ( isset($input[$address_type]) ) 
		{
			if ( $input[$address_type] < 0) 
			{

				$shipping_prefix = '';

				if ($type == 'shipping')
				{				
					$shipping_prefix = 'shipping_';
					
					// If the manual input is shipping but differs from billing
					if ( isset($input['alsoshipping']) )  
					{
						// Get the billing address id
						$ship_address_id = $this->session->userdata('billing_address_id');
						$this->session->set_userdata($session_address_type, $ship_address_id);
						return TRUE;

					}

				}				
				

				// Prepare the array
				$data = array(
						'user_id' => $this->session->userdata('customer_id'),
						'email' => $input[$shipping_prefix.'email'],
						'first_name' => $input[$shipping_prefix.'first_name'],
						'last_name' => $input[$shipping_prefix.'last_name'],
						'company' => $input[$shipping_prefix.'company'],
						'address1' => $input[$shipping_prefix.'address1'],
						'address2' => $input[$shipping_prefix.'address2'],
						'city' => $input[$shipping_prefix.'city'],
						'state' => $input[$shipping_prefix.'state'],
						//'country' => get_country_from_iso2alpha($input[$shipping_prefix.'country']),
						'country' => $input[$shipping_prefix.'country'],						
						'zip' => $input[$shipping_prefix.'zip'],
						'phone' => $input[$shipping_prefix.'phone'],
				);
				

				$address_id = $this->addresses_m->set_address($data , $type);
				
				// Store the Address in Session
				$this->session->set_userdata($session_address_type, $address_id);
				
			}
		}
	}

	private function _step2_validate_existing_address($input, $type = 'billing') 
	{
		$address_type = ($type == 'billing') ? 'existing_address_id' : 'existing_address_shipping_id'  ;
		$session_address_type = ($type == 'billing') ? 'billing_address_id' : 'shipping_address_id'  ;
		
		// Should always be set, the default is -1
		if ( isset($input[$address_type]) )
		{
		
			if ( $input[$address_type] > 0 )
			{
				$address_id = $input[$address_type];
				
				// Store the address  ID
				$this->session->set_userdata($session_address_type, $address_id);
				
				if($type=='shipping')
				{
					//Get the address from db					
					$ad = $this->addresses_m->get($address_id);
					$this->set_tmp_address( $ad );					

				}
				return TRUE;
			
			}
		
		}

		// if no existing address - check manual
		return $this->_step2_validate_manual_address($input, $type );
	}
	

	private function _step2_validate_manual_address($input, $type='billing')
	{
		// First check if we need to
		// if both addr are manual, and use the same for both, return true
		if ($type == 'shipping')
		{		
			if (isset($input['alsoshipping']))
			{
				//STOR TMP SHIPPING
				$this->set_tmp_address($input,FALSE);
				return TRUE;
			}
		}
		
		// Otherwise check manual address entry
		// Set the right validation rules
		$rules = ($type == 'billing') ? $this->addresses_m->address_validation : $this->addresses_m->shipping_address_validation  ;
		
		
		// Clear the existing rules just in case
		$this->formvalidation->reset_validation();
		

		// Setup Form Validation
		$this->formvalidation->set_rules($rules);   			 
		 
	
		// Submit new address and Validation success
		if ( $this->formvalidation->run() ) 
		{

			if($type =='shipping')
			{
				//STOR TMP SHIPPING
				$this->set_tmp_address($input,TRUE);
			}

			return TRUE;
		}
		
		//list all the form errors
		foreach ( $this->formvalidation->error_as_array() as $key => $message )
		{
			$this->return_validation['fields'][] = $key;
			$this->return_validation['message'][] = $message;
		
		}

		// Could not validate Manual entry address
		return FALSE;
	}
	
	
	
	private function place_order($input, $trust_events = array())
	{


			//
			// Collect data from session/cart and user
			//
			$input['billing_address_id'] = $this->session->userdata('billing_address_id'); 
			$input['shipping_address_id'] = $this->session->userdata('shipping_address_id');
			$input['shipping_id'] =  $this->session->userdata('shipping_method_id');
			
			$input['order_total'] = $this->sfcart->total();
			$input['cost_items'] =  $this->sfcart->items_total();
			$input['cost_shipping'] =  $this->sfcart->shipping_total();
			$input['cost_total'] = $this->sfcart->total();
			$input['order_items_count'] =  $this->sfcart->total_items();
			$input['user_id'] =  $this->session->userdata('customer_id');
			$input['session_id'] = $this->_session;
			

			$cart_items = $this->sfcart->contents();

			$order_id = $this->orders_m->create( $input, $cart_items,  $this->_session );

			if ($order_id) 
			{
			
				// Update Inventory
				$this->_update_inventory();


				//destroy cart
				$this->sfcart->destroy();
				

				$this->load->model('transactions_m');
				
				// Store the new order id in session
				$this->session->set_userdata('order_id', $order_id);

				

				

				$this->session->set_flashdata('success', lang('success'));
				
				// Notify Users/admin with Emails
				 //we can place a order in DB but it is set to pending so no action is required until payment complete
				Events::trigger('evt_order_lodged', $order_id);
				

				// Now write a transaction record 			
				//$tran_id = $this->transactions_m->log($order_id, 0,  0 ,'CUSTOMER', 'Order Placed');
				$tran_id = $this->transactions_m->log_new_order($order_id);


				// value is typiclyy a string "+1 for similar email"
				// or -2 for unknown country
				$this->transactions_m->log_trust_data($order_id, $input['trust_score'],  $trust_events);
				


				// Order is placed so deatroy the cart
				//$this->sfcart->destroy();
				

				// Step 6 
				redirect('shop/checkout/gateway/');
	
			}
			else
			{
				// You need to select a payment method
				$this->session->set_flashdata('error', lang('error'));
				redirect('shop/checkout/');
			}
	}

	



	/**
	 * The new gateway function
	 */
	public function gateway() 
	{


		$this->load->model('orders_m');
		$this->load->library('gateway_library');
		$this->load->library('merchant');

		/*
		 * Check if postback
		 *
		 * If POSTBACK === TRUE - then we are handling a payment, otherwise display the payment/gateway page
		 * 
		 */
		if($this->input->post())
		{
			$this->handle_gateway_postback();
		}




		//
		// Get the order ID - which is the key to all other data
		//
		$order_id  = $this->session->userdata('order_id');





		//
		// Get the order from the DB
		//
		$data->order = $this->orders_m->get($order_id);





		//
		// Simple Order validation
		//
		if (!$data->order)
		{
			$this->session->set_flashdata('error', lang('error'));
			redirect('shop');
		}
		



		//
		// Collect info for Use on payment screen
		//	
		$data->items = $this->orders_m->get_order_items($order_id);
		$data->billing = $this->orders_m->get_address($data->order->billing_address_id);




		//
		// Get the gateway from the order
		//
		$data->gateway = $this->gateway_library->get($data->order->gateway_id);


		//
		// Load the ci -merchant
		//
		$this->merchant->load($data->gateway->slug);
		


		 
		//
		// Prep/Get the gateway options
		//
		$data->options = $data->gateway->options;


		//Build path to merchant view
		$view_file = 'gateways/'.$data->gateway->slug.'/display';



		//
		// Display the gatwway page with their own option (if they have any)
		//
		$this->template
			->title($this->module_details['name'], lang('customer'))
			->build($view_file, $data);


	}



	/**
	 * After Gateway screen is presented to user it post back to here
	 * @return [type]
	 */
	private function handle_gateway_postback()
	{
		
		//should only enter here through postback as directed from :::: public function gateway($_oder___id = NULL) 
		
		$order_id 		= $this->session->userdata('order_id');
		$order 			= $this->orders_m->get($order_id);
		$gateway 		= $this->gateway_library->get($order->gateway_id);
		$settings 		= $gateway->options;

		//var_dump($settings );die;


        // Initialize CI-Merchant
        $this->lang->load('merchant');
        $this->load->library('merchant');
        $this->merchant->load($gateway->slug);
        $this->merchant->initialize($settings); //options are the settings


        $params = $gateway->get_params( $order );


        $params = array_merge(
        	array(
	        	'amount' =>  (float) $order->cost_total,
	    		'currency' =>  Settings::get('ss_currency_code'),
	          ), $this->input->post() , $params 

	    );


        
		//
		//  Store the params as JSON in the order field
		//
		$this->orders_m->set_payment_parm( $order->id, $params );


        $response  = $this->merchant->purchase($params);



		if ($response->success())
		{
		    // mark order as complete
		    $gateway_reference = $response->reference();
		    echo 'TXN Completed:'.$gateway_reference;die;
		}
		else
		{
			echo "<pre>";
		    $message = $response->message();
		    echo('Error processing payment: ' . $message);

		    var_dump($response);

		    exit;
		}


        //
        // Now record in our system
        //

	}
	



	
	/**
	 * Call to update inventory
	 */
   private function _update_inventory()  
   {

		foreach ($this->sfcart->contents() as $product)  
		{
			$this->products_front_m->update_inventory( $product['id'] ,  $product['qty'] );
		}
		
		return TRUE;
	}
	
	

	/**
	*
	*
	* bug: do not count the shipping line item
	*
	*/
	private function calc_all_shipping($shipping_methods ,$address)
	{
			$ret_array = array();

			foreach ($shipping_methods as $shipping_method) 
			{
				$ret_array[] = $this->calc_shipping_by_id($shipping_method->id, $address);
			}
	
			return $ret_array;
	}
	

   /**
	*
	* @param INT $id The shipping ID to calc by
	* @param String $address The address to deliver to
	* @param Array $parcels The array of parcels to deliver
	*/
	private function calc_shipping_by_id($id, $to_address) 
	{
	
		$from_address = array(); //dispatch address
		$parcels = sf_sort_into_packages( $this->sfcart );
	
		$dispatcher = $this->shipping_library->get( $id );
	
		// expected array(id,name,description,cost,handling,discount.)
		$shipping_cost_array = $dispatcher->calc($dispatcher->options, $parcels, $to_address, $to_address);
		
		$sc = ($shipping_cost_array[3] + $shipping_cost_array[4]) - $shipping_cost_array[5];

	
		// Set cost in session and cart
		$this->session->set_userdata('shipping_cost', $sc);


		$this->sfcart->set_shipping($sc,0);	

		return $shipping_cost_array;	
	}
	
	
	/**
	 *
	 *@param Boolean $use_prefix		If the data input came from the Shipping address custom entry.
	 */
	private function set_tmp_address( $add_array , $use_prefix = FALSE )
	{

		$add_array = (array)$add_array; //Just in case we get an object

		$prefix = '';

		if($use_prefix)
			$prefix = 'shipping_';

		$this->tmp_addr['address1'] = $add_array[$prefix.'address1'];
		$this->tmp_addr['address2'] = $add_array[$prefix.'address2'];
		$this->tmp_addr['city'] = $add_array[$prefix.'city'];
		$this->tmp_addr['state'] = $add_array[$prefix.'state'];
		$this->tmp_addr['zip'] = $add_array[$prefix.'zip'];
		$this->tmp_addr['country'] = $add_array[$prefix.'country'];
	}
	

	

}

