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
class Plugin_Shop extends Plugin 
{
	public $version = '1.0.0';
	public $name = array(
		'en' => 'Shop',
	);
	public $description = array(
		'en' => 'Access user and cart information for almost any part of SHOP.',
	);


	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Asset plugin for a larger example
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'daily_deal' => array(
				'description' => array(
					'en' => 'Display the current daily deal active in SHOP.'
				),
				'single' => false,
				'double' => true,
				'variables' => 'id|cover_id|slug|name|description',
				'attributes' => array(),
			),		
			'images' => array(
				'description' => array(
					'en' => 'Display Gallery and cover images of products.'
				),
				'single' => false,
				'double' => true,
				'variables' => 'id|src|alt|height|width|file_id|local',				
				'attributes' => array(
					'id' => array(
						'type' => 'int',
						'required' => true,
					),
					'max' => array(
						'type' => 'Integer',
						'default' => '0',
						'required' => false,
					),
					'include_cover' => array(
						'type' => 'Boolean',
						'default' => 'NO',
						'required' => false,
					),		
					'include_gallery' => array(
						'type' => 'Boolean',
						'default' => 'YES',
						'required' => false,
					),										
				),
			),				
			'related' => array(
				'description' => array(
					'en' => 'Display a list of related products to another product.'
				),
				'single' => false,
				'double' => true,
				'variables' => 'id|cover_id|slug|name|description',
				'attributes' => array(
					'id' => array(
						'type' => 'int',
						'required' => true,
					),
					'max' => array(
						'type' => 'Integer',
						'default' => '0',
						'required' => false,
					),
				),
			),	
			'options' => array(
				'description' => array(
					'en' => 'Display all hte options assigned to a Product.'
				),
				'single' => false,
				'double' => true,
				'variables' => 'display|label|type',
				'attributes' => array(
					'id' => array(
						'type' => 'Integer',
						'required' => true,
					),
					'txtBoxClass' => array(
						'type' => 'String',
						'default' => '',
						'required' => false,
					),
				),
			),
			'categories' => array(
				'description' => array(
					'en' => 'Display a list of Categories.'
				),
				'single' => false,
				'double' => true,
				'variables' => 'link|categories',
				'attributes' => array(),
			),				
			'category' => array(
				'description' => array(
					'en' => 'Get all fields of a particular category by Category-ID, OR just get the value of a particular field.'
				),
				'single' => false,
				'double' => true,
				'variables' => 'id|slug|name|user_data',
				'attributes' => array(
					'id' => array(
						'type' => 'Integer',
						'required' => true,
					),
					'field' => array(
						'type' => 'String',
						'default' => '',
						'required' => false,
					),
				),
			),	
			'cart' => array(
				'description' => array(
					'en' => 'Display the cart contents.'
				),
				'single' => false,
				'double' => true,
				'variables' => 'id|rowid|name|qty|price|subtotal',
				'attributes' => array(),
			),			
			'currency' => array(
				'description' => array(
					'en' => 'Display the Shop default currency symbol OR format a float value to the Shop currency format.'
				),
				'single' => true,
				'double' => false,
				'variables' => 'id|rowid|name|qty|price|subtotal',
				'attributes' => array(
					'format' => array(
						'type' => 'float',
						'required' => false,
					),
				),
			),	
			'products' => array(
				'description' => array(
					'en' => 'Display a list of ALL products'
				),
				'single' => false,
				'double' => true,
				'variables' => 'id|slug|name|cover_id|price|category_id',
				'attributes' => array(
					'limit' => array(
						'type' => 'Integer',
						'required' => false,
						'default' => '0',
					),
					'order-by' => array(
						'type' => 'String',
						'required' => false,
						'default' => 'date_created',
					),		
					'order-dir' => array(
						'type' => 'String',
						'required' => false,
						'default' => 'asc',
					),	
					'category_id' => array(
						'type' => 'Integer',
						'required' => false,
						'default' => '0',
					),														
				),
			),							
			'product' => array(
				'description' => array(
					'en' => 'Display basic information about a product, Only 1 attribute is required.'
				),
				'single' => false,
				'double' => true,
				'variables' => 'id|slug|name|cover_id|price|category_id',
				'attributes' => array(
					'id' => array(
						'type' => 'Integer',
						'required' => false,
					),
					'slug' => array(
						'type' => 'Integer',
						'required' => false,
					),					
				),
			),	
			'digital_files' => array(
				'description' => array(
					'en' => 'Display a list of files associated with an order or product.'
				),
				'single' => false,
				'double' => true,
				'variables' => 'id|filename|ext',
				'attributes' => array(
					'order_id' => array(
						'type' => 'Integer',
						'required' => false,
					),
					'product_id' => array(
						'type' => 'Integer',
						'required' => false,
					),					
				),
			),	
			'in_wishlist' => array(
				'description' => array(
					'en' => 'Displays contents ONLY if the Product is IN the users wishlist.'
				),
				'single' => false,
				'double' => true,
				'variables' => '',
				'attributes' => array(
					'id' => array(
						'type' => 'Integer',
						'required' => TRUE,
					),				
				),
			),	
			'notin_wishlist' => array(
				'description' => array(
					'en' => 'Displays contents ONLY if the Product is NOT-IN the users wishlist.'
				),
				'single' => false,
				'double' => true,
				'variables' => '',
				'attributes' => array(
					'id' => array(
						'type' => 'Integer',
						'required' => TRUE,
					),				
				),
			),							
			
		);
	
		return $info;
	}

	function dailydeal() 
	{

		$this->load->model('shop/dailydeals_m');
	  	
		//we shouldnt fetch the product twice. - the get_plugin should work by slug too
		$product =  $this->dailydeals_m->get_current();


		if ($product==NULL) 
			return array();

		if (is_deleted($product) || ($product->public == 0)) 
			return array();


		return (array) $product;	

	}	



	/*
	* Parse Tags in shop
	* Window llows us to create areas on the site simply be defining the html markup with these tags.
	*
	* Given that you assign a name, each window can take the content inside each tag and store it in a BD
	* 
	* Usage:
	* {{ parse:tags }}Content to parse.{{ /parse:tags }}
	*
	* @return string
	*
	public function window()
	{
		$name = $this->attribute('name');
		// We will either take the tag pair content as the
		// parameter or we can take a "string" parameter
		$content = ( ! $this->attribute('string')) ? $this->content() : $this->attribute('string');

		$parser = new Lex_Parser();
		$parser->scope_glue(':');

		//store the 

		$content = "{{ webparts:footer_copyright }}" ; //$name;

		return $parser->parse($content, array(), array($this->parser, 'parser_callback'));
	}
	*/


	/**
	 * {{shop:related id="{{product:id}}" max="1" }}
	 *
	 *		<li>
	 *  			<a href="{{ url:site }}shop/product/{{slug}}" class="" thumbnail-url="{{ url:site }}files/thumb/{{cover_id}}/100/">
	 *		</li>
	 *
	 * 
	 * 	{{slug}}
	 *  {{id}}
	 *  {{cover_id}} + all other product fields
	 *
	 * {{/shop:related}}
	 *
	 *
	 * 
	 * @return [type] [description]
	 */
	function related()
	{
		//$ci =& get_instance();
		$this->load->model('products_front_m');

		$id = $this->attribute( 'id' , '0' );  
		$max = $this->attribute( 'max' , '0' );

		$product = $this->products_front_m->get($id, 'id', TRUE);

		if ($product==NULL) 
			return array();

		if($product->related == '')
			return array();

		$related =  json_decode($product->related);	

		$count = 0;
		$ret = array();
		foreach($related as $_id)
		{	$count++;
			if(($max > 0))
			{
				if($count > $max) break;
			}
			$ret[] = $product = (array) $this->products_front_m->get($_id);
		}

		return $ret;
	}







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


		$settings = array('txtClass'=> $txtClass);

		
		
		$ci =& get_instance();
		$ci->load->library('options_library');
		$ci->load->model('options_m');
		
		$options = $ci->options_m->get_options( $product_id ); //Get the options
		$options = Options_Library::Process( $options, $settings ); //process them so they can be used by lex
		
		return $options;

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
		$segment_4 = $CI->uri->segment(4,0); //either the text or FALSE
		$navigating_category = ($segment_3 == 'category')? TRUE : FALSE;
		$expand_node = -1;



		if($navigating_category)
		{
			$selected_category = $CI->categories_m->get_by('slug', $segment_4);

			$expand_node = $selected_category->parent_id;
		}



		//get all parent categores
		$categories = $CI->categories_m->order_by('order', 'asc')->where('parent_id',0)->get_all();



		//iterate until we get a category we are viewing on page
		foreach($categories as $category)
		{


			$category->uri = "{{url:site}}shop/categories/category/".$category->slug;

			$class='';

			if( ($category->slug === $segment_4 ))
			{
				$class='active';
			}

		
			if( ($category->slug == $segment_4 ) || ($category->id  == $expand_node) )
			{
				$category->categories = $CI->categories_m->order_by('order', 'asc')->where('parent_id',$category->id)->get_all();

				//iterate until we get a category we are viewing on page
				foreach($category->categories as $subcategory)
				{

					$subcategory->uri = "{{url:site}}shop/categories/category/".$subcategory->slug;

					if($subcategory->slug === $segment_4 )
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

	/* 
	 * if requesting a field then you get  "result" 
	 *
	 * back, if the category get the array of categry otherwise blank result
	 */
	function category()
	{

		//$CI =& get_instance();
		$this->load->model('shop/categories_m');

		$id = $this->attribute('id', '');
		$field = $this->attribute('field', '');

		$category = $this->categories_m->get( $id );
	

		if($category)
		{
			if($field != '')
			{
				return array('result' => $category->$field );
			}
			else
			{
				return (array) $category;
			}
		}

		return array('result' => '');

	}


	public function order_is_paid()
	{
		$order_id = $this->attribute('id', NULL);

		if ($this->current_user)
		{
			$this->load->model('shop/orders_m');

			$order = $this->orders_m->get( $order_id );

			if($order->pmt_status =='paid')
			{
				return $this->content();
			}

		}

		return '';

	}

	public function order_is_unpaid()
	{
		$order_id = $this->attribute('id', NULL);


		if ($this->current_user)
		{
			$this->load->model('shop/orders_m');

			$order = $this->orders_m->get( $order_id );

			if($order->pmt_status =='unpaid')
			{
				return $this->content();
			}

		}

		return '';

	}

	public function in_wishlist()
	{
		$product_id = $this->attribute('id', NULL);

		if ($this->current_user)
		{
			$this->load->model('shop/wishlist_m');

			$user_id = $this->current_user->id;

			if($this->wishlist_m->item_exist($user_id, $product_id ))
			{
				return $this->content();
			}

		}

		return '';
	}


	public function notin_wishlist()
	{
		$product_id = $this->attribute('id', NULL);

		if ($this->current_user)
		{
			$this->load->model('shop/wishlist_m');

			$user_id = $this->current_user->id;			

			if($this->wishlist_m->item_exist($user_id, $product_id ))
			{
				return '';
			}

		}

		return $this->content();
	}



	public function is_instock()
	{
		$product_id = $this->attribute('id', NULL);


		$this->load->model('shop/products_m');


		$product = $this->products_m->get($product_id, 'id');

		if(!$product)
			return '';

		if($product->status =='in_stock')
		{
			return $this->content();
		}


		return '';
	}

	public function not_instock()
	{
		$product_id = $this->attribute('id', NULL);


		$this->load->model('shop/products_m');


		$product = $this->products_m->get($product_id, 'id');

		if(!$product)
			return '';

		if($product->status =='in_stock')
		{
			return '';
		}

		return $this->content();
	}
	/**
	 * For now we only retrieve the symbol, but we should add options for 2 letter code, etc..
	 * @return [type] [description]
	 * 
	 * {{ shop:currency }} - return $ L or pound
	 * {{ shop:currency format="{{total}}" }} - returns the price submited with the currency
	 */
	function currency()
	{

		$ci =& get_instance();
		$ci->load->helper('shop_public');


		$option = $this->attribute( 'get' , 'symbol' );
		$format = $this->attribute( 'format' , 'NO' ); 

		if($format == "NO")
		{
			//then we just need the symbol
			return ss_currency_symbol();
		}

		// ELSE
		return nc_format_price($format);

	}


	/**
	 *  Displays all the prices of a product
	 *  This is an extremely helpful theme tool.
	 *
	 * Since the shop implements variable pricing this helps designers display the price
	 * of a given product as it searches by user/group and price type
	 *
	 * 
	 * {{ shop:price id="5" }}
	 * 
	 *		{{if min_qty == '1' }}
	 *				${{price}} for 1 <br />
	 *		{{ else }}
	 *				${{price}} for {{min_qty}} or more <br />
	 *		{{ endif }}
	 *		
	 *  {{ /shop:price }}
	 *  
	 *
	 *
	 * Future enhancement - integerate format_price as option
	 *
	 *
	 */
	function price()
	{

		$id = $this->attribute('id', -1);

		if($id=="")
		{
			return array();
		}


		//lookup product price
		$this->load->model('products_front_m');

		$_prod = $this->products_front_m->get($id,'id');


		// 
		// MID_Discount
		// 
		if($_prod->pgroup_id > 0)
		{

			//group
			$model = 'pgroups_prices_m';
			$method = 'get_by_pgroup';

		  	$this->load->model('shop/'. $model);
			$prices =  $this->$model->$method($_prod->pgroup_id);

			if(sizeof($prices) > 0)
			{
				return $prices;		
			}

		}


		// 
		// Qty_Discount
		// 
		$model = 'product_prices_m';
		$method = 'get_discounts_by_product';
	  	$this->load->model('shop/'. $model);
		$prices =  $this->$model->$method($id);


		//
		// Product Price
		//
		if(sizeof($prices) == 0)
		{
			return( array(array( 'price' => $_prod->price, 'min_qty' => 1 ))  ); 
		}


		return $prices;
		
	}


	function images()
	{

		$id = $this->attribute('id', '0');
		$limit = $this->attribute('max', '0');

		$include_cover = $this->attribute('include_cover', 'NO');
		$include_gallery = $this->attribute('include_gallery', 'YES');

		$this->load->model('shop/images_m');


		if($limit != '0')
		{
			$limit = intval($limit);
			$this->images_m->limit($limit);
		}


		// Get the cover image - in future cover_id will be also stored on the images table. For now we need to source from the product row for consistancy of the plugin
		if( strtoupper(trim($include_cover)) == 'YES' )
		{
			$this->db->where('product_id',$id)->where('cover',1);
		}


		// Get the galley images
		if( strtoupper(trim($include_gallery)) == 'YES' )
		{
			$this->db->where('product_id',$id)->or_where('cover',0);
		}


		return (array) $this->images_m->get_images( $id );

	}


	/**
	 * {{shop:digital files order_id="5" }}
	 * 		{{id}} {{filename}}
	 * {{/shop:digital_files}}
	 * 
	 * @return [type] [description]
	 */
	function digital_files() 
	{

		$this->load->model('shop_files_m');
		$order_id = $this->attribute('order_id', '');
		$product_id = $this->attribute('product_id', 'notset');
		
		if($product_id !== 'notset')
		{
			$files =  $this->shop_files_m->get_files($product_id);
		}
		else
		{
			$files =  $this->shop_files_m->get_files_by_order($order_id);
		}
		
		//var_dump($product);die;
		return (array) $files;	

	}


	function product() 
	{

		$id = $this->attribute('id', '');
		$slug = $this->attribute('slug', '');
		$this->load->model('shop/products_front_m');
	  	
	  	$product = NULL;


		if($id !== '')
		{
			$product =  $this->products_front_m->get($id, 'id');
		}
		else
		{
			$product =  $this->products_front_m->get($slug, 'slug');
		}
		


		if ($product==NULL) 
			return array();

		//if we have used the products_front_m we shouldnt have to check this.
		if (is_deleted($product) || ($product->public == 0)) 
			return array();

		return (array) $product;	

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
	
		$limit = $this->attribute('limit', 0);
		$order_by = $this->attribute('order-by', 'date_created');
		$order_dir = $this->attribute('order-dir', 'asc');
		$category = $this->attribute('category_id', '0');
		$category = intval($category);
		
		class_exists('products_front_m') OR $this->load->model('shop/products_front_m');
		
		if ($category > 0) 
		{
			$this->products_front_m->where('category_id', $category);
		}

		if ($limit > 0) 
		{
			$this->products_front_m->limit($limit);
		}

		return  $this->products_front_m
					->order_by($order_by, $order_dir)
					->get_all();
	}
	
	
	
	/**
	 *
	 */
	function cart() 
	{
		return $this->sfcart->contents();		
	}	

	
	/**
	 *
	 * @usage: {{ shop:total cart="items" }} 			- Total // of products in cart 
	 * @usage: {{ shop:total cart="sub-total" }} 		- Total cost of products
	 * @usage: {{ shop:total cart="total" }} 			- Total cost of products + shipping
	 * @usage: {{ shop:total cart="shipping" }} 		- Total cost of shipping
	 * @deprecated
	 */
	function total() 
	{
		
		$CI =& get_instance();
		$CI->load->library('shop/SFCart');


		$format = $this->attribute('format', 'NO'); //items is default
		$option = $this->attribute('cart', 'total'); //items is default
		   				
		$price = 0;

		switch ( $option )
		{
			case 'total':
				$price = $CI->sfcart->total();		
				break;
			case 'sub-total':
				$price =  $CI->sfcart->items_total();			
				break;
			case 'shipping':
				$price =  $CI->sfcart->shipping_total();		
				break;
			case 'items':			
			default:
				$price =  $CI->sfcart->total_items();	

		}


		if(strtoupper($format) == 'YES')
		{
			return nc_format_price($price);
		}

		return $price;
		
	}







	/*
	 *
	 *
	 * DEPRECATED PLUGINS
	 *
	 *
	 * 
	 */

	/**
	 * Customer Dashboard links
	 * 
	 *	{{ shop:mylinks remove='wishlist dashboard orders' }}
	 *		{{link}}
	 *	{{ /shop:mylinks }}
	 * 
	 * @return [type] [description]
	 */
	function mylinks()
	{
		//active make the link active, as the active display section
		$active = $this->attribute('active', '');
		$remove = $this->attribute('remove', '');
		$remove = explode(' ', $remove);

		$links = array();

		$links['dashboard']['link'] = anchor('shop/my/dashboard', lang('shop:my:dashboard'));
		$links['orders']['link'] = anchor('shop/my/orders', lang('shop:my:orders'));
		$links['wishlist']['link'] = anchor('shop/my/wishlist', lang('shop:my:wishlist'));
		$links['messages']['link'] = anchor('shop/my/messages', lang('shop:my:messages'));
		$links['addresses']['link'] = anchor('shop/my/addresses', lang('shop:my:addresses'));

		foreach($remove as $link)
		{
			unset($links[$link]);
		}

		if(isset($links[$active]))
		{
			//set the active class
			$links[$active]['link'] = anchor('shop/my/'.$active, lang('shop:my:' .$active), 'style="font-weight:bold"');
		}

		return $links;

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
	 *{{ shop:uri to="products" use_https="YES" text="view all products" class="some_class" }}
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
	


	/**
	 *
	 * @experimental and should not be documented until we know what we want to do with this.
	 * 
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
			
			if ( Settings::get('ss_ssl_required') == SettingMode::Enabled) 
			{
				$use_https = TRUE;
			}

		}

		return url_domain($use_https);
		
	}	

}

/* End of file plugin.php */