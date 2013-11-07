<div id="MerchantPage">

	<?php echo form_open(); ?>
	    <p>Please proceed to PayPal to complete and pay for your order</p>
	    <input type="hidden" name="return_url" value="{{ url:site }}shop/payment/callback/{{order.id}}"/>
	    <input type="hidden" name="cancel_url" value="{{ url:site }}shop/payment/cancel/{{order.id}}"/>    
	    <input type="hidden" name="notify_url" value="{{ url:site }}shop/payment/notify/{{order.id}}"/>    
	    <button type="submit" class="">Pay with PayPal</button>
	<?php echo form_close(); ?>

</div>
