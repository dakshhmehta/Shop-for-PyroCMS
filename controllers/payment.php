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
class Payment extends Public_Controller 
{

	// Support multiple checkout theme/styles
	protected $theme_name = 'single';
	
	public function __construct() 
	{
		parent::__construct();
		
		// Retrieve some core settings
		$this->use_css =  Settings::get('nc_css');
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
		if ($this->use_css) _setCSS($this->template);
		if ($this->use_jq) _setJQ($this->template);
		
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
		$view_file = 'merchant/'.$data->gateway->slug.'/display';



		//
		// Display the gatwway page with their own option (if they have any)
		//
		$this->template
			->title($this->module_details['name'], lang('customer'))
			->build($view_file, $data);


			//->build('checkout/single/gateway', $data);



	}
	/**
	 * After Gateway screen is presented to user it post back to here
	 * @return [type]
	 */
	private function handle_gateway_postback()
	{
		


		//should only enter here through postback as directed from :::: public function gateway($_oder___id = NULL) 
		
		$order_id 		= $this->session->userdata('order_id');
		$data->order 	= $this->orders_m->get($order_id);
		$data->gateway 	= $this->gateway_library->get($data->order->gateway_id);
		$data->settings = $data->gateway->options;






        // Initialize CI-Merchant
        $this->load->library('merchant');
        $this->merchant->load($data->gateway->slug);
        $this->merchant->initialize($data->settings); //options are the settings

        // Collect any posted data from the page
        $posted_data = $this->input->post(NULL, TRUE);


        $params = array_merge(array(
        	'amount' => $this->sfcart->total(),
    		'currency' => 'AUD',
            'notify_url' => site_url() . '/callback/' . $order_id, /*no need for gateway slug, we can get it from the order_id */
            'return_url' => site_url() . '/callback/' . $order_id, //populated from form
            'cancel_url' => site_url() . '/cancel'
          ), $posted_data ? $posted_data : array(), array(
			'currency_code'  => 'AUD',
	        'amount'         => $this->sfcart->total(),
	        'order_id'       => $order_id,
	        'transaction_id' => $order_id,
	        'reference'      => 'Order #' . $order_id,
	        'description'    => 'Order #' .$order_id,
	        'first_name'     => 'Sal',
	        'last_name'      => 'Bordonaro',
	        'address1'       => '61 Silverye',
	        'address2'       => '',
	        'city'           => 'Melbourne',
	        'region'         => 'fname',
	        'country'        => 'AUS',
	        'postcode'       => '3000',
	        'phone'          => '55555555',
	        'email'          => 'cust@email.com',
	    ));


		//
		//  Store the params as JSON in the order field
		//
		$this->orders_m->set_payment_parm( $order_id, $params );


        $response  = $this->merchant->purchase($params);


        //
        // Now record in our system
        //

	}
	





		



	public function callback($order_id)
	{

        // Initialize CI-Merchant
        $this->load->library('gateway_library');
        $this->load->library('merchant');
        $this->load->model('orders_m');
        $this->load->library('session');
        $this->load->model('transactions_m');


        //
        // We have to re-instate the sesssion from the order
        //

        $data = new stdClass();



		$data->order 	= $this->orders_m->get($order_id);



		//check if order is paid
		if( $data->order->status === OrderStatus::Paid )
		{
			$this->session->set_flashdata('Order has been paid');

			//Do not preoceed
			redirect('shop');
		}


		//restore session
		//session_id($data->order->session_id);



		$data->gateway 	= $this->gateway_library->get($data->order->gateway_id);


		$data->settings = $data->gateway->options;


		//var_dump($data->order);

        $this->merchant->load($data->gateway->slug);
        $this->merchant->initialize($data->settings);


        // Get the params
        $params = (array) json_decode($data->order->data);




        $response = $this->merchant->purchase_return( $params );


	


		switch($response->status())
		{


			case Merchant_response::AUTHORIZED:
				$set_status =  OrderStatus::Pending ;
				break;

			case Merchant_response::COMPLETE:
				$set_status =  OrderStatus::Paid ;
				break;



			case Merchant_response::REDIRECT:
				$set_status =  OrderStatus::Pending ;
				break;		

			case Merchant_response::REFUNDED:
				$set_status =  OrderStatus::Pending ;
				break;	

			//default is to FAIL
			case Merchant_response::FAILED:
			default:
				$set_status =  OrderStatus::Pending ;
				break;
		}





		// Set the order status
		$this->orders_m->set_status($order_id, $set_status );


 		$data_val = isset($_POST) ?  $_POST  :  $_GET ;
 		$data_val['reference'] = $response->reference();
		

		$item = array(
					'order_id' => $data->order->id,
					'txn_id' => $data->order->id,
					'status' => 'accepted', // status: accepted, rejected, pending
					'reason' =>  'PAYMENT',
					'amount' => $data->order->cost_total,
					'refund' => 0,
					'user' => $data->gateway->short_title,
					'gateway' => 'Paypal Express',
					'timestamp' => time(),
					'data'  => json_encode($data_val),
				);
		


		//record this in transactions
		$this->transactions_m->insert($item);


		// Let everyone know
		Events::trigger('evt_gateway_callback', $item);



		redirect('shop');

	}







	/**
	 * Handles Success from payment gateway after payment made
	 * Not always used but it tells nitro that we can stop https and return to wherever we want
	 *
	 */
	public function success() 
	{
		// Stop the https session
		if (strtolower(substr(current_url(), 4, 1)) == 's') 
		{
			redirect(str_replace('https:', 'http:', site_url('shop')) . '?session=' . session_id(), 'refresh');
		}
	
		// display success message
		$this->template
				->title($this->module_details['name'], lang('customer_title'))
				->build('checkout/success');
	}
	
	

	/**
	 * Handles cancel from payment gateway
	 *
	 *
	 */
	public function cancel() 
	{
		if (strtolower(substr(current_url(), 4, 1)) == 's') 
		{
			redirect(str_replace('https:', 'http:', site_url('shop')) . '?session=' . session_id());
		}
		else
		{
			$this->session->set_flashdata('notice', lang('payment_canceled'));
			redirect('shop');
		}
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
	
	


	

}

