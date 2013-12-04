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
 
$route['shop/admin/maintenance(/:any)?']	= 'admin/maintenance$1';
$route['shop/admin/dailydeals(/:any)?']		= 'admin/dailydeals$1';
$route['shop/admin/images(/:any)?']			= 'admin/images$1';
$route['shop/admin/shipping(:any)?']		= 'admin/shipping$1';
$route['shop/admin/packages(:any)?']		= 'admin/packages$1';
$route['shop/admin/options(:any)?']			= 'admin/options$1';
$route['shop/admin/pgroups(:any)?']			= 'admin/pgroups$1';
$route['shop/admin/gateways(:any)?']		= 'admin/gateways$1';
$route['shop/admin/categories(:any)?']		= 'admin/categories$1';
$route['shop/admin/brands(:any)?']			= 'admin/brands$1';
$route['shop/admin/orders(/:any)?']			= 'admin/orders$1';
$route['shop/admin/product(/:any)?']		= 'admin/product$1';
$route['shop/admin/products(/:any)?']		= 'admin/products$1';
$route['shop/admin/tax(:any)?']				= 'admin/tax$1';
$route['shop/admin/blacklist(/:any)?']		= 'admin/blacklist$1';
$route['shop/admin/manage(/:any)?']			= 'admin/manage$1';
$route['shop/admin/analytics(/:any)?']		= 'admin/charts$1';
$route['shop/admin(/:any)?']			  	= 'admin/shop$1';
$route['admin(/:any)?']			  			= 'admin/shop$1';



/*
 * Front end routes
 */
$route['shop/product(/:any)']		 		= 'product/index$1';
$route['shop/products(/:num)']		 		= 'products/index$1';
$route['shop/categories(/:num)']		 	= 'categories/index$1';
$route['shop/brands(/:num)']		 		= 'brands/index$1';
$route['shop/home(/:num)']		 		    = 'shop/index$1';

//We only need 1 route to the dashboard,
$route['shop/my']		 		    		= 'my/dashboard/index';

/*
$route['shop/special(/:any)']		 		= 'special/index$1';
$route['shop/brand(/:any)?']  				= 'brands/brand$1';
$route['shop/brands(/:any)?']  				= 'brands/index$1';
$route['shop/product(/:any)?']		 		= 'product/index$1';
$route['shop/category(/:any)?']  			= 'categories/category$1';
$route['shop/products(/:any)?']		 		= 'products/index$1';
$route['shop/my/wishlist(/:any)?'] 			= 'wishlist$1';
$route['products(/:num)?']		 			= 'shop/products/index$1';
*/