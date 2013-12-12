<div id="MerchantPage">

	
 		<h4>Payment Instructions</h4>

	    <p>Please pay  {{shop:currency}} {{order.cost_total}} directly to:</p>

	    {{gateway.desc}}

 		<br />
 		<br />
 		<h4>Order Details</h4>
 		
 		Order ID: {{order.id}} <br />

		{{if order.pin != ''}}
			Your PIN number is {{order.pin}}<br />
		{{endif}} 

 		Order Status: {{order.status}} <br />
 		Order Amount: {{shop:currency}} {{order.cost_total}} <br />
 		Billing Email: {{billing.email}} <br />


 		<br />
 		Your IP Address: {{order.ip_address}} <br />


 		<br />

		Customer Billing Address: <?php echo nc_bind_address($billing); ?> <br />




 		<br />
 		  		

	    <p>
	    	Your order will be shipped once funds have been cleared.
	    	You can check the status of your order in the <strong>{{ shop:uri to='my' text='My Account' }}</strong> section.
	    </p>

	    <a href="{{url:site}}shop">back to shop</a>

</div>
