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

/**
 * The Enum Enum holds our generic values
 *
 */
final class Enums
{
	/*
	const Zero = 0;
	const EmptyString = "";	
	const True = TRUE;	
	const False = FALSE;	
	*/

}

final class AdminMenu
{
	const Light 	= 1;
	const Advanced 	= 0;
}


final class ProductStatus
{
	const Deleted 	= 1;
	const Active 	= 0;
}




/**
 *
 *
 */
final class PaymentResponse
{
	const Authorized 	= 'authorized';
}



/**
 *
 *
 */
final class Action
{
	const View 		= 60;
	const Add 		= 40;
	const Edit 		= 20;
	const Delete 	= 0;
}



/**
 * All views and JS should use the following strings to match this
 * PHP Enum, We will use PostAction::Delete which results in "delete"
 * So in JS and HTML do not do; 
 *
 * BAD:
 * siteurl.com/shop/wishlist/del/1
 *
 * Good:
 * siteurl.com/shop/wishlist/delete/1 
 */
final class PostAction
{
	const View 		= 'view';
	const Add 		= 'add';
	const Edit 		= 'edit';
	const Delete 	= 'delete';
}




/**
 *
 *
 */
final class ProductVisibility
{
	const Invisible 		= 0;
	const Visible 			= 1;
}



/**
 *
 *
 */
final class JSONStatus
{
	const Success 		= 'success';
	const Error 		= 'error';
}



/**
 * Inventory Status
 *
 */
final class InventoryType
{
	const Unlimited 	= 1;
	const Countable 	= 0;

}

/**
 * Inventory Status
 *
 */
final class InventoryStatus
{
	const InStock 		= 'in_stock';
	const OutOfStock 	= 'out_of_stock';
	/* ..... more to be added ... */
}



/**
 *
 *
 */
final class OrderStatus
{
	/* ..... more to be added ... */	
	const Pending 		= 'pending';
	const Paid 			= 'paid';
	const Processing 	= 'processing';
	const Shipped 		= 'shipped';
	const Returned 		= 'returned';
	const Cancelled 	= 'cancelled';
	const Closed 		= 'closed';
	const ReOpened 		= 'reopen';

}


final class TaxMode
{
	const Inclusive 		= 0;
	const Exclusive 		= 1;	
}

/**
 * Im not happy with this class/enum name
 * Is there something that makes more sense
 */
final class RWMode
{
	const ReadOnly 		= TRUE;
	const Editable 		= FALSE;	
}

final class PostMethod
{

	const Normal 		= 0;		
	const Ajax 			= 1;

}


final class SettingMode
{
	const Enabled 		= 1;
	const Disabled 		= 0;	
}