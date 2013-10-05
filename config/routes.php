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
 


$route['shop/admin/images(/:any)?']			= 'admin/images$1';
$route['shop/admin/shipping(:any)?']		= 'admin/shipping$1';
$route['shop/admin/packages(:any)?']		= 'admin/packages$1';
$route['shop/admin/options(:any)?']			= 'admin/options$1';
$route['shop/admin/pgroups(:any)?']			= 'admin/pgroups$1';
$route['shop/admin/gateways(:any)?']		= 'admin/gateways$1';
$route['shop/admin/categories(:any)?']		= 'admin/categories$1';
$route['shop/admin/brands(:any)?']			= 'admin/brands$1';
$route['shop/admin/orders(/:any)?']			= 'admin/orders$1';
$route['shop/admin/products(/:any)?']		= 'admin/products$1';
$route['shop/admin/tax(:any)?']				= 'admin/tax$1';
$route['shop/admin/blacklist(/:any)?']		= 'admin/blacklist$1';

$route['shop/admin(/:any)?']			  	= 'admin/shop$1';




/*
 * Front end routes
 *
 * 
 */
$route['shop/brand(/:any)?']  				= 'brands/brand2$1';
$route['shop/brands(/:any)?']  				= 'brands/brand$1';
$route['shop/product(/:any)?']		 		= 'product/index$1';
$route['shop/category(/:any)?']  			= 'categories/category$1';
$route['shop/products(/:any)?']		 		= 'products/index$1';

$route['shop/my/wishlist(/:any)?'] 			= 'wishlist$1';
