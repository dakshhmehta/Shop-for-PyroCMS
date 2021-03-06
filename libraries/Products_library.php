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
class Products_library 
{




	// Private variables.  Do not change!
	private $CI;
	protected $shop_setting;
	

	public function __construct($params = array())
	{
	
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();
		$this->CI->load->library('settings/settings');
		if(empty($this->shop_setting)){
			$this->shop_setting = $this->get_shop_setting();
		}
		log_message('debug', "Products Library Class Initialized");
		
	}

	
	
	/**
	 * Set/clear cover image on product
	 * 
	 * @return [type] [description]
	 */
	public function cover_image() 
	{	

		$this->CI->load->model('products_admin_m');


		$response['status'] = JSONStatus::Error;


		if($this->CI->input->post('prod_id') ) 
		{

			$prod_id = intval( $this->CI->input->post('prod_id'));
			
			$img_id =  $this->CI->input->post('img_id') ;
			
			// Step: remove all default/cover flags for this product (should only be 1)
			$data = array('cover' => 0);
			if ( $this->CI->db->where('product_id',$prod_id)->update('shop_images',$data)  ) 
			{
				// Step: set the flag to this one
				$data = array('cover' => 1);
				if ($this->CI->db->where('id',$img_id)->where('product_id',$prod_id)->update('shop_images',$data)  ) 
				{	
					$_img_ = $this->CI->db->where('id',$img_id)->get('shop_images')->row();

					$src = $_img_->src;

					$response['status'] = JSONStatus::Success;
					$response['src'] = $src;
					
					Events::trigger('evt_product_changed', $prod_id);
				} 
			}


		}

		echo json_encode($response);die;

	}




	public function process_for_list(&$products)
	{
		foreach($products as $product)
		{

			$this->process_category($product);

			$this->process_price($product);

			$this->process_inventory($product);

		}
	}



	private function process_category(&$product)
	{

		$this->CI->load->model('shop/categories_m');
		$category = $this->CI->categories_m->get($product->category_id);

		$cat = ($category->parent_id == 0) ? $category->name :  ss_category_name($category->parent_id) . ' &rarr; ' . $category->name;


		if($product->category_id > 0) 
		{

			$product->_category_data = anchor('admin/shop/categories/edit/' . $product->category_id,  $cat , array('class'=>'')); 
		}
		else
		{
			$product->_category_data = 'no category';
		}

	}


	private function process_price(&$product)
	{

		
		$_class = 's_status s_complete'; 
		$_text = nc_format_price($product->price);	


		if($product->pgroup_id > 0)
		{
			//MID pricing
			$_class = 's_status s_processing'; 
			$_text = lang('shop:products:variable_pricing');												
		}


		$product->_price_data = "<span class='".$_class."''>".$_text."</span>";


	}	


	private function process_inventory(&$product)
	{


		if($product->inventory_type == 1)
		{
			$class_name = 's_unlimited';
			$_inv_text = lang('shop:products:unlimited');
		}
		else
		{
			if($product->inventory_on_hand <= $product->inventory_low_qty)
			{
				$class_name = 's_low';
			}
			else
			{
				$class_name = 's_normal';
			}

			$_inv_text =  $product->inventory_on_hand; 
		}

		$product->_inventory_data  ="<div class='s_status $class_name'>$_inv_text</div>";


	}
	
	/**
	 * Function to get Shop Setting
	 *
	 */
	public function get_shop_setting()
	{
		$results = array();
		$this->CI->load->model('settings/settings_m');
		
		$results['country_id'] = $this->CI->settings->get('ss_distribution_loc');
		$results['shop_name'] = $this->CI->settings->get('ss_name');
		$results['currency_code'] = $this->CI->settings->get('ss_currency_code');
		
		$shopset = $this->CI->settings_m->get_by(array('slug' => 'ss_currency_symbol'));
		$currency_symbol = "";
		$symbol_opt = explode('|', $shopset->options);

		if(!empty($symbol_opt) && !empty($shopset->value))
		{
			$symval = explode("=", $symbol_opt[$shopset->value]);
			$currency_symbol = trim($symval[1]);
		}
		
		$results['currency_symbol'] = $currency_symbol;
		$results['currency_layout'] = $this->CI->settings->get('ss_currency_layout');
		$separator = array(",", ".", " ");
		$results['thousand_sep'] = $separator[$this->CI->settings->get('ss_currency_thousand_sep')];
		$results['decimal_sep'] = $separator[$this->CI->settings->get('ss_currency_decimal_sep')];
		return $results;
	}
	
	/**
	 * Function to get products
	 * used by shop front end and widget
	 * $params = array()
	 */
	public function get_products($params = array(), $details = false, $url = "", $row = 10, $page = 1)
	{
		
		$results = Array('total'=> false, 'pagination'=> false, 'data'=> false);

		if(empty($url))
		{
			$url = site_url('shop/home/%s');
		}
		
		$this->CI->load->library('shop/libpaging');
		$this->CI->load->model('shop/products_front_m');
		
		// default only show available inventory (instock, on hand > low qty, unlimited stock)
		if(empty($params['show_available']))
		{
			$params['show_available'] = true;
		}

        $total_rows = $this->CI->products_front_m->count_custom('public', $params);
        //$total_rows = $this->CI->pyrocache->model('products_front_m', 'count_custom', array('public', $params));
        $paging_param = array('page' => $page, 'maxrow' => $total_rows, 'pagerow' => $row, 'wide' => 2, 'url' => $url);
        $pagination = $this->CI->libpaging->_paging($paging_param);

        $results['data'] = $this->CI->products_front_m->get_many_custom('public', $params+array('limit'=>$pagination['limit']));
	    //$results['data'] = $this->CI->pyrocache->model('products_front_m', 'get_many_custom', array('public', $params+array('limit'=>$pagination['limit'])));
	
		if($total_rows > 0)
		{
			if(strtoupper($this->shop_setting["currency_code"]) == "IDR")
			{
				$decimal = 0;
			}
			else
			{
				$decimal = 2;
			}

			foreach($results['data'] as $key => $row)
			{
				$results['data'][$key]->options = $this->CI->products_front_m->get_product_options_info($row->id);
				$results['data'][$key]->price = number_format($results['data'][$key]->price, $decimal, $this->shop_setting["decimal_sep"], $this->shop_setting["thousand_sep"]);
			}
		}

		$results['total'] = $total_rows;

		if($details)
		{
			$results['pagination'] = $pagination;
		}

		return $results;

	}
	
	public function build_requires_shipping_select($params) 
	{
		 
		$params = array_merge(array('current_id' => 0), $params);
		
		extract($params);
		

		$rs = array(	
							0 	=> 'No'  , 
							1 	=> 'Yes'
						);
		
		$html = '';

		foreach ($rs as $key=>$value) 
		{
			$html .= '<option value="' . $key . '"';
			$html .= $current_id == $key ? ' selected="selected">' : '>';
			$html .= $value . '</option>';
		}
		
	
		return $html;
	}	
}
// END Cart Class
