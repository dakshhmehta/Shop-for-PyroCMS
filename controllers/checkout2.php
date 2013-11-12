<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Checkout2 extends Public_Controller {

    var $customer_validation = array();
    var $address_validation = array();


    protected $theme_name = 'multistep';

    public function __construct() 
    {
        parent::__construct();

        $this->theme_layout_path =  'checkout/'.$this->theme_name.'/';        

        if ($this->settings->store_ssl_required and strtolower(substr(current_url(), 4, 1)) != 's') 
        {
            redirect(str_replace('http:', 'https:', current_url()) . '?session=' . session_id());
            exit();
        }
        
        if ($this->input->get('session')) 
        {
            session_id($this->input->get('session'));
            session_regenerate_id();
        }


        $this->_session = session_id();


        $this->load->library('form_validation');
        $this->load->model('addresses_m');
        $this->load->model('orders_m');
        $this->load->model('products_front_m');
        $this->load->library('Package_library');
        $this->load->library('Shipping_library');
        $this->load->library('Gateway_library');
        $this->load->library('formvalidation'); 

        if (!$this->sfcart->total_items()) 
        {
            redirect('shop/cart');
        }
    }


    public function delete_address($id) 
    {
        $cid = $this->session->userdata('user_id');

        if ($cid == $this->current_user->id) 
        {
            $this->db->where('user_id', $cid)
                    ->where('id', $id)->delete('store_addresses');
        }

        redirect('shop/checkout2/address');
    }

    /**
     * STEP 1
     */
    public function index() 
    {

        if ($this->current_user) 
        {
            redirect('shop/checkout2/billing');
        }

        if( $this->input->post() ) 
        {
            $input = $this->input->post();

            if ($input['customer'] == 'register') 
            {
                $this->session->set_userdata('checkout_proccess', true);
                redirect('users/register');
            }
            if ($input['customer'] == 'guest') 
            {
                $this->session->set_userdata('user_id', 0);
                redirect('shop/checkout2/billing');
            }

            $this->session->set_flashdata('success', 'success');
            redirect('shop/checkout2/billing');
        }


        $this->template->title($this->module_details['name'], 'cust_title')
                ->build( $this->theme_layout_path . 'customer');
    }

    /**
     * STEP 2
     */
    public function billing() 
    {

        if($this->input->post())
        {
        }
        else
        {
            //check to see if previously stored
        }


        $this->address_validation =  $this->addresses_m->address_validation;

        $this->form_validation->set_rules( $this->address_validation );
       
        //
        // Initi the data
        //
        foreach ($this->address_validation AS $rule) 
        {
            $data->{$rule['field']} = $this->input->post($rule['field']);
        }
        $data->addresses = array();


        //
        // if logged in get some fields from our profile
        //
        if ($this->current_user) 
        {
            $data = $this->current_user;

            foreach ($this->address_validation AS $rule) 
            {
                $data->{$rule['field']} = isset($this->current_user->{$rule['field']}) ? $this->current_user->{$rule['field']} : $this->input->post($rule['field']);
            }

            $data->address1 = isset($this->current_user->address_line1) ? $this->current_user->address_line1 : '';
            $data->address2 = isset($this->current_user->address_line2) ? $this->current_user->address_line2 : '';
            $data->city = isset($this->current_user->address_line3) ? $this->current_user->address_line3 : '';
            $data->zip = isset($this->current_user->postcode) ? $this->current_user->postcode : '';


            $data->addresses = $this->db->where('user_id', $this->current_user->id)->get('shop_addresses')->result();
        } 



        if($this->input->post('address_id')) 
        {

            $this->session->set_userdata('billing', $this->input->post('address_id'));

            if ($this->input->post('sameforshipping')) 
            {
                $this->session->set_userdata('shipping', $this->input->post('address_id'));
                redirect('shop/checkout2/shipment');
            } 


            redirect('shop/checkout2/shipping');
            
        }

        if ($this->form_validation->run()) 
        {

            $input = $this->input->post();

            $address_id = $this->addresses_m->set_address($input);

            $this->session->set_userdata('billing', $address_id);

            if ($this->input->post('sameforshipping')) 
            {
                $this->session->set_userdata('shipping', $address_id);
                redirect('shop/checkout2/shipment');
            } 


            redirect('shop/checkout2/shipping');
            

        }


        

        $this->template->title($this->module_details['name'],'billing')
                ->build($this->theme_layout_path .'address', $data);
    }


    public function shipping() 
    {


        $this->address_validation =  $this->addresses_m->address_validation;
        


        $this->form_validation->set_rules( $this->address_validation );
       
          

        foreach ($this->address_validation AS $rule) 
        {
            $data->{$rule['field']} = $this->input->post($rule['field']);
        }

        $data->addresses = array();


        //we should try to populate with all the billing fields that were set
        if ($this->current_user) 
        {
            $data = $this->current_user;

            foreach ($this->address_validation AS $rule) 
            {
                $data->{$rule['field']} = isset($this->current_user->{$rule['field']}) ? $this->current_user->{$rule['field']} : $this->input->post($rule['field']);
            }

            $data->address1 = isset($this->current_user->address_line1) ? $this->current_user->address_line1 : '';
            $data->address2 = isset($this->current_user->address_line2) ? $this->current_user->address_line2 : '';
            $data->city = isset($this->current_user->address_line3) ? $this->current_user->address_line3 : '';
            $data->zip = isset($this->current_user->postcode) ? $this->current_user->postcode : '';


            $data->addresses = $this->db->where('user_id', $this->current_user->id)->get('shop_addresses')->result();
        } 




        if($this->input->post('address_id')) 
        {
            $this->session->set_userdata('shipping', $this->input->post('address_id'));

            redirect('shop/checkout2/shipment');
        }



        if ($this->form_validation->run()) 
        {

            $input = $this->input->post();

            $address_id = $this->addresses_m->set_address($input);

            $this->session->set_userdata('shipping', $address_id);

            redirect('shop/checkout2/shipment');

        }
        

        $this->template->title($this->module_details['name'],'shipping')
                ->build($this->theme_layout_path .'shipping_address', $data);

    }



    /**
     * STEP 3
     */
    public function shipment() 
    {

        //get all
        $data->shipments = $this->shipping_library->get_enabled();

        //calc
        $this->calc_all_shipping($data->shipments , $this->session->userdata('shipping') );


        //set rules
        $this->form_validation->set_rules('shipment_id', lang('store:shipment_field'), 'required|numeric|trim');


        //validate if postback
        if ($this->form_validation->run()) 
        {
            //shipping cost /calc
            $cost = $this->calc_shipping_by_id( $this->input->post('shipment_id'), $this->session->userdata('shipping') );

            $this->session->set_userdata('shipment_id', $this->input->post('shipment_id')); 
            $this->session->set_userdata('shipping_cost', $cost); 


            $this->session->set_flashdata('success', 'success');


            redirect('shop/checkout2/gateway');
        }



        $this->template->title($this->module_details['name'], 'shipments')
                ->build($this->theme_layout_path . 'shipment', $data);
    }

    /**
     * STEP 3
     */
    public function gateway() 
    {

        //get all
        $data->gateways = $this->gateway_library->get_enabled();


        //set rules
        $this->form_validation->set_rules('gateway_id', 'gateway', 'required|numeric|trim');


        //validate if postback
        if ($this->form_validation->run()) 
        {

            $this->session->set_userdata('gateway_id', $this->input->post('gateway_id')); 


            $this->session->set_flashdata('success', 'success gateway stored');

            
            //now place order
            $order_id = $this->place_order();

            if($order_id > 0)
            {
                redirect('shop/payment/order/'.$order_id);
            }
            
        }



        $this->template->title($this->module_details['name'], 'shipments')
                ->build($this->theme_layout_path . 'gateways', $data);
    }


    private function place_order($trust_events = array())
    {


            //
            // Collect data from session/cart and user
            //
            $input['user_id'] =  $this->session->userdata('customer_id');
            $input['cost_items'] =  $this->sfcart->items_total();
            $input['cost_shipping'] =  $this->sfcart->shipping_total();
            //$input['cost_total'] = ($inputs['cost_items'] + $inputs['cost_shipping']);
            $input['shipping_id'] =  $this->session->userdata('shipment_id');
            $input['gateway_method_id'] =  $this->session->userdata('gateway_id');;

            $input['billing_address_id'] = $this->session->userdata('billing'); 
            $input['shipping_address_id'] = $this->session->userdata('shipping');
            $input['session_id'] = $this->_session;
            $input['ip_address'] =  $this->input->ip_address();
            $input['trust_score'] =  0;
  

           

            $cart_items = $this->sfcart->contents();

            $order_id = $this->orders_m->create( $input, $cart_items);

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
                



                // Step 6 
                return $order_id;
    
            }


            // You need to select a payment method
            $this->session->set_flashdata('error', 'Unable to place order - ERROR CHK2' . __LINE__);
            return 0;
            

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

            $shipping_method->shipping_cost = $this->calc_shipping_by_id($shipping_method->id, $address);
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
    

        $shipping_cost_array = $dispatcher->calc($dispatcher->options, $parcels, $to_address, $to_address);

        return $shipping_cost_array[3];

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