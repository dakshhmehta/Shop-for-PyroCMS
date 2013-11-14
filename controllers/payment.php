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
		
	}
	

	

    /**
     * The new gateway function
     */
    public function order($order_id = 0) 
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
        // Get the order from the DB
        //
        $data->order = $this->orders_m->get($order_id);



        //
        // Simple Order validation
        //
        if (!$data->order)
        {
            $this->session->set_flashdata('error', 'Error, no order found');
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
        
        $order_id       = $this->session->userdata('order_id');
        $order          = $this->orders_m->get($order_id);
        $gateway        = $this->gateway_library->get($order->gateway_id);
        $settings       = $gateway->options;

        $this->load->model('addresses_m');

        $billing_addr   = $this->addresses_m->get($order->billing_address_id);

        //var_dump($settings );die;


        // Initialize CI-Merchant
        $this->lang->load('merchant');
        $this->load->library('merchant');
        $this->merchant->load($gateway->slug);
        $this->merchant->initialize($settings); //options are the settings


        $params = $gateway->get_params( $order );


        $params = array_merge(
            array(
            	'email' => $billing_addr->email,
                'amount' =>  (float) $order->cost_total,
                'currency' =>  Settings::get('ss_currency_code'),
              ), $this->input->post() , $params 

        );


        
        //
        //  Store the params as JSON in the order field
        //
        $this->orders_m->set_payment_parm( $order->id, $params );


        $response  = $this->merchant->purchase($params);


        //todo:handle payment methods other than paypal
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


		/* i.e order paid, lets bypass here */
        if( ! $this->_validate_callback_req($data->order) )
        {
        	redirect('shop');
        }
	







		$data->gateway 	= $this->gateway_library->get($data->order->gateway_id);


		$data->settings = $data->gateway->options;


		//var_dump($data->order);

        $this->merchant->load($data->gateway->slug);
        $this->merchant->initialize($data->settings);


        // Get the params
        $params = (array) json_decode($data->order->data);




        $response = $this->merchant->purchase_return( $params );


	
		$data->gateway->callback($response);

		switch($response->status())
		{


			case Merchant_response::AUTHORIZED:
				$set_status =  OrderStatus::Pending ;
				break;

			case Merchant_response::COMPLETE:
				$set_status =  OrderStatus::Paid ;
				$this->orders_m->mark_as_paid($order_id);
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
	




	public function notify($order_id) 
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
	 * Handles cancel from payment gateway
	 *
	 *
	 */
	public function cancel($order_id) 
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




	public function _validate_callback_req($order)
	{


		//Does order exist
		if( ! $order )
		{
			$this->session->set_flashdata('Order does not exist');
			return FALSE;
		}


		//
		if( $order->status === OrderStatus::Paid )
		{
			$this->session->set_flashdata('Order has been paid');
			return FALSE;
		}	


		return TRUE;

	}

}

