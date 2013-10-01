<div id="shop_checkout_merchant">

	<?php //echo form_open(); ?>
 		<h4>Payment Instructions</h4>
	    <p>Please pay <?php echo nc_format_price($order->cost_total); ?> directly to:</p>
	    <?php echo $gateway->desc; ?>

 		<br />
 		<br />
 		<h4>Order Details</h4>
 		Order ID: <?php echo $order->id; ?> <br />
 		Order Status: <?php echo $order->status; ?> <br />
 		Order Amount: <?php echo nc_format_price($order->cost_total); ?> <br />
 		<br />
 		Your IP Address: <?php echo $order->ip_address; ?> <br />


 		<br />

		Customer Billing Address: <?php echo nc_bind_address($billing); ?> <br />


 		<br />
 		  		

	    <p>
	    	Your order will be shipped once funds have been cleared.
	    	You can check the status of your order in the <strong>{{ shop:uri to='my' text='My Account' }}</strong> section.
	    </p>

	    <a style='margin-top:15px;margin-left:0px;float:left;' href="{{url:site}}shop" class="TLDButton">back to shop</a>

	<?php //echo form_close(); ?>

</div>
