<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

 # 
 # SHOP for PyroCMS
 # -----------------------------------------------------------------
 # Author: Salvatore Bordonaro
 # License: See Full license details on the License.txt file
 #
 #
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





#
# Uncomment the next line if you want to have the uri for diplsaying products
# work with the following notations (not just the standard);
#
# Standard domain.com/shop/products/product/{slug}
# 
# After  domain.com/shop/product/{slug}
# After  domain.com/product/{slug}
# 
#$route['shop/product(/:any)']		 		= 'products/product$1';





#
# We need this to map the dashboard to the shop/my URI
#
$route['shop/my']		 		    		= 'my/dashboard/index';