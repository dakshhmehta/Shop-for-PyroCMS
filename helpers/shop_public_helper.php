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
if (!function_exists('url_domain')) 
{

	/**
	 * [url_domain description]
	 * @param  boolean $show_protocol [description]
	 * @param  string  $protocol      [description]
	 * @return [type]                 [description]
	 */
	function url_domain($use_https = TRUE) 
	{


		$base_url = 'http://' . $_SERVER['SERVER_NAME'];

		//
		// fix for https
		//
		if($use_https)
		{
			return str_replace('http://', 'https://', $base_url);
		}


		//
		// return
		//
		return $base_url;


	}


}


if (!function_exists('nc_prepare_price')) 
{
	/**
	 * $object row not array must be passed
	 *
	 */
	function nc_prepare_price(&$item) 
	{
	
		//
		// Get the required values from the product
		//
		$qty = $item['qty'];
		$qty_price = $item['price'];
		$options = $item['options'];
		$base = $item['base'];
		

		$product_price = 0; //lets start at ZERO

		if($options === null)
			return;

		//
		// pre-check t see if any options are variarion option where price = amount
		//
		foreach($options as $option)
		{

			$operator = $option['operator'];

			if($operator == '=')
			{

				$new_price = (float) $option['operator_value'];

 				$item['price'] = $new_price;

				//return $new_price;
			}
			else
			{
				continue;
			}

		}


		//return $qty_price;


	}


}



if (!function_exists('nc_options_price')) 
{
	/**
	 * $object row not array must be passed
	 *
	 */
	function nc_options_price($item) 
	{
	
		//
		// Get the required values from the product
		//
		$qty = $item['qty'];
		$qty_price = $item['price'];
		$options = $item['options'];
		$base = $item['base'];
		

		$product_price = 0; //lets start at ZERO


		if($options === null)
			return $item;

		//
		// Adjust the total price by the option values
		//
		foreach($options as $option)
		{
		 	
		 	if($option['operator'] == '=') continue; //we have allready handled this above
		 	if($option['operator'] == 'n') continue; //skip calc

			// Adjust (offset the price) - gets new qty and or price
			$return_array = nc_option_price_calc($qty, $qty_price, $option);
			
			//adjust the price offset
			$product_price += $return_array['adjustment'];
			
			//Change the QTY - if needed
			$item['qty'] = $return_array['qty'];
			
			
		}
		

		//
		// The initial basic calculation
		//
		$product_price += $qty_price * $item['qty'];	
		
		
		
		//
		// Finally just add the once off base price
		//		
		$item['price'] = ( $product_price += $base );
		
		
		
		//
		// Send it back
		//
		return $item;

	}

}  

if (!function_exists('nc_option_price_calc')) 
{

	/**
	 * $object row not array must be passed
	 *
	 */
	function nc_option_price_calc($qty, $qty_price, $option_in) 
	{

		
		$max_qty = $option_in['max_qty'];
		$operator = $option_in['operator'];
		$operator_value = (float) $option_in['operator_value'];
		$op_type = $option_in['type'];
		

		
		$by_qty = TRUE;
		
		
		switch($operator) 
		{
		
			/*
			 * Basic
			 *
			 *
			 *
			 */
			case '+':
				$adjustment_amount =  $operator_value;		
				$by_qty = FALSE;
				break;			 
			case '-':
				$adjustment_amount = (0 - $operator_value);
				$by_qty = FALSE;
				break;
				
				
				
			/*
			 * Intermediate
			 *
			 *
			 *
			 */
			case '+q':
				$adjustment_amount = $operator_value;				
				break;	
			case '-q':
				$adjustment_amount = (0 - $operator_value);
				break;	
			
				
			
			default:
				$adjustment_amount = 0;

		}
		
		
		
		
		//
		// Set the default return amounts
		//
		$return_array = array();
		
		
		//
		// adjust the qty  if max is too large: if max==0 then its unlimited
		// here we are finding out how many to apply the discount or surcharge to (limiter)
		//
		$return_array['qty'] = ( ($max_qty > $qty) OR ($max_qty == 0) )? $qty : $max_qty ;
			
			
			
		//
		// Multiply the adjustment by the Users Selected QTY (Intermediate and Advanced)
		//
		$return_array['adjustment'] =  ( $by_qty )?  ($return_array['qty'] * $adjustment_amount ) :  $adjustment_amount ;
		
		
		
		
		return $return_array;
		


	}

}

if (!function_exists('_setJQ')) 
{
	
	function _setJQ($template,$ps =0) 
	{
		$template->append_metadata('<script src="http://code.jquery.com/jquery-2.0.0.min.js"></script>');
		
		return $template;
	
	
	
		$template->append_js('module::lib/jquery.js');
		
		return $template;
		
		$template->append_metadata('<script src="http://code.jquery.com/jquery-1.9.1.js"></script>');
		
		return $template;
	}
}


if (!function_exists('_setCSS')) 
{
	
	/**
	 * This will set the CSS to the template when required
	 *
	 * @param unknown_type $template
	 * @param unknown_type $ps Include the jquery.plusshift.js javascript module
	 */
	function _setCSS($template,$ps =0) 
	{
	
		$template->append_metadata("<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>")
				 ->append_metadata("<link href='http://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>")
				 ->append_css('module::nc_global.css')
				 ->append_css('module::nc_cartinfo.css')
				 ->append_css('module::nc_carttable.css')
				 ->append_css('module::shop.css');
		
		if ($ps) 
		{
			$template->append_metadata('<script src="http://code.jquery.com/jquery-1.9.1.js"></script>')
			 		 ->append_js('module::lib/jquery.plusshift.js');
		}
		
		return $template;
	}
}


if (!function_exists('sf_parcel_is_smaller')) 
{

	/**
	 * This is useful for shipping methods to test if the parcels fit specific sizes
	 * 
	 * @example  if the Restriction size is 132x120 and the given parcel is 135x120 this will return FALSE;
	 * 
	 * 
	 * @param Array $restriction : Array of Dimentions
	 * @param Array $parcel : Array of Dimentions
	 * TODO:not sure wheather this is needed
	 */
	function sf_parcel_is_smaller($restriction, $parcel)
	{
		if ($restriction['height'] < $parcel['height']) 
			return FALSE ;
		
		if ($restriction['width'] < $parcel['width'])
			return FALSE ;
		
		if ($restriction['depth'] < $parcel['depth'])
			return FALSE ;		
		
		return TRUE;
	}
	
}

if (!function_exists('sf_check_parcel_weight')) 
{

	/**
	 * This is useful for shipping methods to test if the parcels fit specific sizes
	 *
	 * @example  if the Restriction size is 132x120 and the given parcel is 135x120 this will return FALSE;
	 *
	 *
	 * @param Array $restriction : Array of Dimentions
	 * @param Array $parcel : Array of Dimentions
	 * TODO:Is this needed ?
	 */
	function sf_check_parcel_weight($restriction_weight, $parcel_weight) 
	{

		if ($restriction_weight < $restriction_weight)
			return FALSE ;

		return TRUE;

	}

}



if (!function_exists('sf_sort_into_packages')) 
{		

	/**
	 * Sorts the cart into packages for shipping module
	 * 
	 * @param  [type] $cart [description]
	 * @return [type]       [description]
	 */
	function sf_sort_into_packages( $cart )
	{
	
		//Load libraries & modules
		$CI =& get_instance();
		$CI->load->library('package_library');
		
		

		// 
		// init
		// 
		$parcels = array(); //create the package array
		$parcels['item_count'] = 0;
		$parcels['items'] = array();


 
 		//
		// Initialize and assign the item to the right package/group
		// 
		foreach ($cart->contents() as $item) 
		{
			//var_dump($item);

			//
			// If a product has an option to ignor shipping - then we remove it from the packages here
			//
			//if($item['ignor_shipping']) continue;

			//
			// Assign item to package
			//
			$parcels['items'][$item['package_id']][] = $item;

		}

		//var_dump($parcels['items'][10][0]);die;


		$packages = array();


 		//
		// Add products to the packages
		// 
		// ($key => $val) == ($package_id => $items)
		// 
		foreach ($parcels['items'] as $package_id => $items) 
		{	
			
			//var_dump($package_id);
			//var_dump($items);

			$package = $CI->package_library->get( $package_id );


			//
			// Do not pass this package to shipping calc
			// Shipping is ignored
			//
			if ($package->options['ignor_shipping']) continue;

	
			$package->items = $items;


			$packages[] = $package;

		}


		//
		// Clear from memory
		//
		unset($parcels);


 		//
		// Now count the items in the packages
		// 
		$v = 0;
		foreach ($packages as $package) 
		{	
			foreach ($package->items as $item) 
			{
				$v += $item['qty'];
			}

			$package->item_count += $v;
		}
	
	


		return $packages;

		 
	}
}



if (!function_exists('nc_bind_address')) 
{
	/**
	 * $object row not array must be passed
	 * Used only in the event class for sending email
	 */
	function nc_bind_address($address_row,$format ='inline') 
	{
		
		
		if($format =='inline')
		{
			return $address_row->address1.', '.$address_row->address2. ', '.$address_row->city . ' '.$address_row->zip;
		}
		
		return $address_row->address1.', '.$address_row->address2. ', '.$address_row->city . ' '.$address_row->zip;
		
	}

}

if (!function_exists('sf_string_to_decimal'))
 {

	/*
	 * This is mainly used at the db models level to clean values before they are entered
	 */
	function sf_string_to_decimal($value) 
	{
	
		if (trim($value) == '') return 0.00;
		
		# Else
		$value = floatval($value);
		
		return $value; 
	}
}



if (!function_exists('_get_pagination_limit')) 
{
	
	function _get_pagination_limit($default_limit=null) 
	{
		
		$CI =& get_instance();
	
		# Get the default limit in settings if no limit is set by session
		if ($default_limit==null)
		$default_limit = Settings::get('ss_qty_perpage_limit'); # get the default limit defined in settings (Pagination)
			
		# get filter qty by session
		$pag_qty = $CI->session->userdata('user_display_qty_filter');
			
		$pag_qty = ($pag_qty)?$pag_qty:$default_limit;
					
		return $pag_qty;
					
	}
}

if (!function_exists('orderby_helper')) 
{
	/**
	 * @deprecated There is no alternative as yet but try not to use this
	 * @param unknown_type $option
	 * @return string
	 */	
	function _orderby_helper($option) 
	{
	
		switch($option) 
		{
			case 0:
				return 'id';
				break;
			case 1:
				return 'name';
				break;
			case 2:
				return 'category_id';
				break;
			default:
				return 'id';
				break;
		}
	}
}


// Capture vardump
if (!function_exists('sf_dump')) 
{
	
	# we do this because ''$dump = print_r($variable, true);'' doesnt work for objects
	function sf_dump($yourarray) 
	{
		ob_start();
		var_dump($yourarray);
		return ob_get_clean();
	}
}


if (!function_exists('sf_text'))
 {
	
	/**
	 * @deprecated DO NOT USE - Please use codeignighter anchor()
	 * @param unknown_type $name
	 * @param unknown_type $value
	 * @param unknown_type $option
	 * @return string
	 */
	function sf_text($name,$value, $option = '')
	{
				
		return form_input($name, $value, 'id="'.$name.'" '.$option);
			
	}
}





if (!function_exists('get_country_from_iso2alpha')) 
{
	
	
	/* $code = required either 2 letter country code or for reverse use country name
	 *
	 *
	 * @description: 	-  	Normal mode will get the country name from the ISO 2 Alpha code
	 *			 		-	Reverse will get the country code from the country name
	 *
	 *
	 * @example:
	 * echo get_country_from_iso2alpha( 'AU' ); 				//returns Australia
	 * echo get_country_from_iso2alpha( 'AU' , 'reverse'); 		//returns AU
	 *
	 *
	 * @param $mode  normal|reverse|
	 */
	function get_country_from_iso2alpha( $code,$mode = 'normal',$getarray = FALSE )
	{

			$ci = & get_instance();
		

			$cl = $ci->db->where('enabled',1)->select('name')->select('code2')->get('shop_countries')->result();


			$countryList = array();

			foreach ($cl as $country) 
			{
				$countryList[$country->code2] = $country->name;
			}
 
			
			//return the full array
			if ($getarray)
				return $countryList;
				
			if ($mode == 'reverse') 
				return array_search($code, $countryList); 		

			
			if(isset($countryList[$code]))
					return $countryList[$code];

			//else
			
			return $code;

			
	
	}
}



/*
 *
 *
 * @deprecated - please do not use anymore
 */
if (!function_exists('sf_prep_taxes')) 
{

	function sf_prep_taxes($tax_groups) 
	{
	
		$tax_array = array();
		
		foreach ($tax_groups as $tax) 
		{
			$tax_array[$tax->id] = $tax->name;
		}
		
		return $tax_array;
		
	}
	
}



if (!function_exists('sf_get_product_cover')) 
{

	function sf_get_product_cover($product_id, $w = 55, $h = 55, $image_list_id = 0) 
	{
	
		$ci = & get_instance();
		
		$product = $ci->db->select('cover_id')->where('id', $product_id)->limit(1)->get('shop_products')->row();

		if ($product) 
			return img(site_url('files/thumb/'.$product->cover_id.'/'.$w.'/'.$h));
		return '';

	}
}


if (!function_exists('ss_currency_symbol')) 
{

	function ss_currency_symbol() 
	{
		
		$symbols = array(0=>'',1=>'L',2=>'&#36;', 3=>'&#163;', 4=>'&#165;', 5=> 'Rp' ,6=> '&#128;');
		
		return $symbols[Settings::get('ss_currency_symbol')];
		
	}

}



if (!function_exists('nc_format_price')) 
{

	function nc_format_price($price_value, $strict_mode = TRUE, $decimal_points =  2) 
	{
		
		$p_pre = $p_post = "";

		$seperators = array( 0=> ',', 1=> '.', 2=> ' ');
		$symbols = array(0=>'',1=>'L',2=>'&#36;', 3=>'&#163;', 4=>'&#165;', 5=> 'Rp' ,6=> '&#128;');
		
		$layout 		= Settings::get('ss_currency_layout');
		$symbol 		= $symbols[Settings::get('ss_currency_symbol')];
		$thous 			= $seperators[Settings::get('ss_currency_thousand_sep')];
		$dec_point 		= $seperators[Settings::get('ss_currency_decimal_sep')];
		

		$price_value = number_format($price_value,  $decimal_points,  $dec_point,  $thous);	

		$prefix = '';
		$suffix = '';


		if ($layout == '1') 	
			$prefix = $symbol.' ';
		else
			$suffix = ' '.$symbol;
			
		return $prefix.$price_value.$suffix;

	}

}



/*date('d / M / Y ', $order->order_date)*/
if (!function_exists('nc_format_date')) 
{

	function nc_format_date($date) 
	{

		$formats = array(0 =>"d-m-Y",1=>"d/m/Y",2=>"m-d-Y",3=>"m/d/Y");
		
		$format = Settings::get('nc_date_format');
		
		return date($formats[$format],$date);

	}

}




if (!function_exists('nc_pagination')) 
{

	function nc_pagination($uri, $total_items, $limit, $uri_segment = 4)
	{


		$ci =& get_instance();
		$ci->load->library('pagination');

		$config['base_url'] = $uri;
		$config['total_rows'] = $total_items;
		$config['per_page'] = $limit;


		$config['uri_segment'] = $uri_segment;
		//$config['num_links'] = 5;
		$config['use_page_numbers'] = FALSE;
		//$config['page_query_string'] = FALSE;



		$ci->pagination->initialize($config);

		return $ci->pagination->create_links();




	}

}