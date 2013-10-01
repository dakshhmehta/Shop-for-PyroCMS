<style>

#cart-widget ul, 
#cart-widget ol
{
	margin:0px;
	padding:0px;
}

#cart-widget { 
	position:absolute;
	z-index:9999;

	padding: 1ex; 
	border: 2px solid #aaa; 
	background-color: #F5F5F5; 
	margin: 1em; 
	opacity: 1; 
	height:auto;
	margin-top: 0em; 
	width: auto; 
	margin-left: 5px; 
	overflow: hidden;	
	
	font-family:arial;
	font-size:10px;
	float:right;

	background: none repeat scroll 0 0 #F5F5F5;
	border-color: #999999;
	border-radius: 3px 0 3px 3px;
	border-width: 1px;
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
	left: auto;
	right:auto;
	margin-top: -3px;
	padding: 17px;
	
	
	background-color: #F3F3F3;
	background-image: -moz-linear-gradient(center top , white, #E3E3E3);
	background-repeat: repeat-x;
	border-color: #CCCCCC #CCCCCC #BBBBBB;
	
}


/*
 * extra
 *
 */


#cart-widget a {text-decoration:none;}

/*
 * width
 *
 */

#mini-cart{ width: 235px; }


#cart-widget,
.cart-w-btn { width: auto; }



#mini-cart li {width:200px;}

#cart-widget span {float:right;margin-left:10px;}

#mini-cart,
#mini-cart li {
	list-style-type:none;

}
.cart-item {
 border-bottom: 1px dashed #999999;
	margin: 5px;
	padding:6px;
	}
	
.cart-item a {
	color: #454545;
	padding: 0;
	white-space: normal;
}
	
.cart-item .quantity .price {
	
	font-size: 12px;
	font-weight: bold;

	background: none repeat scroll 0 0 rgba(0, 0, 0, 0.05);
	font-size: 13px;
	padding: 2px 10px;
	border-radius: 100px 100px 100px 100px;


 }
 
 
 
 
 #cart-widget #mini-cart li.buttons a {
	background:#eee;
	width:125px;

	color: #454545;
	white-space: normal;
	font-weight: bold;
	line-height: 16px;
 }
#cart-widget #mini-cart li a.cart:before  {
content:"---";
}
 
#cart-widget #mini-cart li a.cart  {
	color:#999;
	padding:7px;
	border:1px solid #000;
	border-radius: 5px 0px 0px 5px;
	border-left:right;

}
	
#cart-widget #mini-cart li a.cart:hover  {
	color:#666;
	border:1px solid #666;
	border-left:right;
}


#cart-widget #mini-cart li a.checkout:before{
content:"----";
}
#cart-widget #mini-cart li a.checkout  {
	color:#999;
	padding:7px;
	border:1px solid #000;
	border-radius: 0px 5px 5px 0px;
	border-left:none;


}
	
#cart-widget #mini-cart li a.checkout:hover  {
	color:#666;
	border:1px solid #666;
	border-left:none;
}



</style>

<script>
	function sf_show_minicart() 
	{
		var x = window.document.getElementById('mini-cart');
		if (x.style.display == 'block') x.style.display = 'none';
		else x.style.display = 'block';
	}
</script>

<?php if ($cart): ?>

	<div id="cart-widget"  onclick="sf_show_minicart()">
		
		<a class="cart-w-btn">
			Your Cart
		</a>
		
		<span>
				Items: {{ shop:total cart="items" }}
				Sub-Total :<?php  echo nc_format_price($total_cost); /*{{ shop:total cart="sub-total" }}*/ ?>
		</span>
		
		<ul id="mini-cart" style="display:none;">
		
			 <?php foreach ($cart as $item): ?>
			 
				<li class='cart-item'>

					<a href="<?php echo site_url('shop/product/' . $item['slug']); ?>">
						<?php echo sf_get_product_cover( $item['id'] ,50,50 ); ?>
						<?php echo $item['qty'].'&times;'; ?> <?php echo $item['name']; ?>
					</a>
					<span class="quantity">
						<span class="price"><?php echo nc_format_price($item['price']);?></span>
					</span>		
					
				</li>
				
			<?php endforeach; ?>
			

		  <li class="buttons">
		  
			<a class="cart" href="{{ url:site }}shop/cart">
				<?php echo lang('shop:show_cart');?> 
			</a>
			
			<a class="checkout" href="{{ url:site }}shop/checkout">
			  Checkout &rarr;
			</a>
			
		  </li>	

		</ul>
	</div>
	
<?php endif; ?>
<div style="margin-top:40px;" class="clear clearfix">?</div>

