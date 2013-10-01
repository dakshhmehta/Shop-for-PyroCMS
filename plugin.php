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
 * @author		Salvatore Bordonaro
 * @version		0.90.0.000
 * @website		http://www.inspiredgroup.com.au/
 * @package		Plugin Class for NITRO-CART
 * @system		PyroCMS 2.1.x
 *
 */
class Plugin_Shop extends Plugin 
{

	/**
	 * Method 1: Simple - Just Pass the ID of the product
	 *
	 * {{ shop:options id="5" }}
	 *
	 *		{{ display }}
	 *
	 * {{ shop:options }}
	 *
	 *
	 * ============ =========== ========== ========== ========== ========== =========
	 *
	 * Method 2: Advanced - Check the type of the option to process differently
	 *
	 * {{ shop:options id="5" }}
	 *
	 *		{{ if type == "radio" }}
	 *
	 *			{{ form }} {{ label }} <br />
	 *
	 *		{{ else }}
	 *
	 *			{{ display }}
	 *
	 *		{{ endif }}
	 *
	 * 	{{ shop:options }}
	 *
	 *
	 */
	function options() 
	{
	
		// Get the attributes
		$product_id = $this->attribute( 'id', NULL ); // product ID - 
		$txtClass = $this->attribute( 'txtBoxClass' , '' );  
		
		$ci =& get_instance();
		$ci->load->library('options_library');
		$ci->load->model('options_m');
		
		$options = $ci->options_m->get_options( $product_id ); //Get the options
		$options = Options_Library::Process( $options, $txtClass ); //process them so they can be used by lex
		
		return $options;

	}	



	/**
	 * This is really only used like base_url() but we need an option that allows us to get the https:// prefix.
	 * 
	 * {{ shop:domain }} 					- return http://mysite.com
	 *
	 * {{ shop:domain use_https="YES" }} 	- return https://mysite.com
	 *
	 *
	 *
	 * 
	 * @return [type] [description]
	 */
	function domain() 
	{

		$ci =& get_instance();
		$ci->load->helper('shop_public');

		//default
		$use_https = FALSE;

		$use_https_option = $this->attribute( 'use_https' , 'YES' );  		
		
		if($use_https_option == 'YES')
		{
			
			if ( Settings::get('nc_ssl_required') == SettingMode::Enabled) 
			{
				$use_https = TRUE;
			}

		}

		return url_domain($use_https);
		
	}	
	
	
	/**
	 * @author Salvatore Bordonaro
	 * @description
	 *
	 *              The shop:categories plugin allows the developer
	 *				to iterate over all the categories and display them as they wish
	 *				anywhere on their site.
	 *
	 *
	 *
	 * {{ shop:categories }}
	 *
	 *    {{ name }}		
	 *    {{ link }}  		- Creates full link tag
	 *    {{ id }}	 		- INT
	 *    {{ slug }} 		- Unique slug for category 
	 *    {{ uri }} 		- The full URI for the category, the slug will only return the text part not the full site url. 
	 *	  {{ description }}	
	 *
	 * {{ /shop:categories }}
	 */
	function categories()
	{
		$CI =& get_instance();
		$CI->load->model('shop/categories_m');

		//uri stuff
		$segment_2 = $CI->uri->segment(2,0); //categories / products ect
		$segment_3 = $CI->uri->segment(3,0); //either the text or FALSE
		$navigating_category = ($segment_2 == 'category')? TRUE : FALSE;
		$expand_node = -1;





		if($navigating_category)
		{
			$selected_category = $CI->categories_m->get_by('slug', $segment_3);

			$expand_node = $selected_category->parent_id;
		}




		//get all parent categores
		$categories = $CI->categories_m->order_by('order', 'asc')->where('parent_id',0)->get_all();



		//iterate until we get a category we are viewing on page
		foreach($categories as $category)
		{


			$category->uri = "{{url:site}}shop/category/".$category->slug;




			//if( ($category->slug == $segment_3 ) || ($category->id  == $expand_node) )
			//{
				//$category->link = "<a class='' href='".$category->uri."'>".$category->name."</a>";
			//}
			//else
			//{
				//$category->link = "<a href='".$category->uri."'>".$category->name."</a>";
			//}
			
			$class='';

			if( ($category->slug === $segment_3 ))
			{
				$class='active';
			}

		
			if( ($category->slug == $segment_3 ) || ($category->id  == $expand_node) )
			{
				$category->categories = $CI->categories_m->order_by('order', 'asc')->where('parent_id',$category->id)->get_all();

				//iterate until we get a category we are viewing on page
				foreach($category->categories as $subcategory)
				{

					$subcategory->uri = "{{url:site}}shop/category/".$subcategory->slug;

					if($subcategory->slug === $segment_3 )
					{
						$subcategory->link = "<a class='active' href='".$subcategory->uri."'>".$subcategory->name."</a>";		

						if($subcategory->parent_id == $category->id)
						{
							$class='active';
						}			
					}
					else
					{
						$subcategory->link = "<a href='".$subcategory->uri."'>".$subcategory->name."</a>";					
					}

				}	
				

			}

			//parent category link
			$category->link = "<a class='$class' href='".$category->uri."'>".$category->name."</a>";




		}


		return $categories;



	}


	function category()
	{

		//$CI =& get_instance();
		$this->load->model('shop/categories_m');

		$id = $this->attribute('id', 0);

		return $this->categories_m->get_plugin( $id );

	}






	/**
	 * All shop links should be created using this plugin or the helper function
	 * 
	 * Usage:
	 *
	 * {{ shop:uri to='shop' text='shop' }} - returns <a href="{{url:site}}/shop">shop</a>
	 * {{ shop:uri to='cart' text='my cart' }} - returns <a href="{{url:site}}/shop/cart">my cart</a>
	 * {{ shop:uri to='my/orders' text='Orders' }} - returns <a href="{{url:site}}/shop/my/orders">Orders</a>
	 *
	 * 
	 * @return [type] [description]
	 */
	function uri()
	{
		$to = $this->attribute('to', '');
		$text = $this->attribute('text', 'shop');

		$to = 'shop/'.$to;

		return '<a href={{url:site}}'.$to.'>'.$text.'</a>';
	}
	

	 
	function product() 
	{

		$slug = $this->attribute('slug', '');
		$this->load->model('shop/products_front_m');
	  	
		//we shouldnt fetch the product twice. - the get_plugin should work by slug too
		$tmp =  $this->products_front_m->get_by_slug($slug);

		$product =  $this->products_front_m->get_plugin($tmp->id);



		if ($product==NULL) 
			return array();

		if (($product->deleted) || ($product->public == 0)) 
			return array();

		return (array) $product;	

	}



	/**
	 *  Displays all the prices of a product
	 * 
	 * {{ shop:prices id="<?php echo $product->id;?>" lookup="product|pricegroup" }}
	 *		{{if min_qty == '1' }}
	 *
	 *				${{price}} for 1 card <br />
	 *
	 *		{{ else }}
	 *
	 *				${{price}} for {{min_qty}} or more cards <br />
	 *
	 *		{{ endif }}
	 *  {{ /shop:prices }}
	 *
	 *
	 */
	function prices()
	{

		$id = $this->attribute('id', -1);
		$lookup = $this->attribute('lookup', 'pricegroup');

		//group
		$model = 'pgroups_prices_m';
		$method = 'get_by_pgroup';


		if(strtolower(trim($lookup)) == 'product')
		{
			$model = 'product_prices_m';
			$method = 'get_discounts_by_product';
		}

	  	$this->load->model('shop/'. $model);
		$prices =  $this->$model->$method($id);
			
		return $prices;
		

	}



	/**
	 * 
	 * {{ shop:items limit="5" order-by="name" order-dir="asc" category-id="2" }}
	 *	  {{ id }} {{ name }} {{ slug }}
	 * {{ /shop:items }}
	 *
	 * @return	array
	 */
	function products() 
	{
	
		$limit = intval($this->attribute('limit', 0));
		$order_by = $this->attribute('order-by', 'date_created');
		$order_dir = $this->attribute('order-dir', 'asc');
		$category = intval($this->attribute('category-id', $this->attribute('category_id', 0)));
		
		class_exists('products_front_m') OR $this->load->model('shop/products_front_m');
		
		if (is_numeric($category) && $category > 0) 
		{
			$this->products_front_m->where('category_id', $category);
		}
		if (is_numeric($limit) && $limit > 0) 
		{
			$this->products_front_m->limit($limit);
		}

		return $this->products_front_m
					->order_by($order_by, $order_dir)
					->get_all();
	}
	
	
	
	/**
	 * @usage: {{ shop:cart_products shipping="FALSE" }} 			- Display ul->list  of cart, will not include shipping
	 * @usage: {{ shop:cart_products shipping="TRUE" }} 			- Display ul->list  of cart, will include shipping as line item
	 *
	 */
	function cart_products() 
	{
	
		$shipping = $this->attribute('shipping', 'FALSE');
	
		$arr = "";
		$class_v = 'sf_qty';
		$class_z = 'nc_name';
		$class_x = 'sf_price';
		
		foreach ($this->sfcart->contents() as $item)
		{
			
			$arr .= '<li>';
			$arr .= '<span class="'.$class_v.'">'.$item['qty'].'</span>'.nbs();
			$arr .= '<span class="'.$class_z.'">'.$item['name'].'</span>'.nbs();
			$arr .= '<span class="'.$class_x.'">'.$item['price'].'</span>'.nbs();
			$arr .= '</li>';
			

		}
		
		return ''.$arr;
		
	}	
	
	/**
	 *
	 * @usage: {{ shop:total cart="items" }} 			- Total // of products in cart 
	 * @usage: {{ shop:total cart="sub-total" }} 		- Total cost of products
	 * @usage: {{ shop:total cart="total" }} 			- Total cost of products + shipping
	 * @usage: {{ shop:total cart="shipping" }} 		- Total cost of shipping
	 *	 
	 */
	function total() 
	{
		
		$CI =& get_instance();
		$CI->load->library('shop/SFCart');




		$option = $this->attribute('cart', 'total'); //items is default
		   				

		switch ( $option )
		{
			case 'total':
				return $CI->sfcart->total();		
				break;
			case 'sub-total':
				return $CI->sfcart->items_total();			
				break;
			case 'shipping':
				return $CI->sfcart->shipping_total();		
				break;
			case 'items':			
			default:
				return $CI->sfcart->total_items();	
		}
		
	}

}

/* End of file plugin.php */