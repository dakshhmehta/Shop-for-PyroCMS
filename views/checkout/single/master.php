<!--- FILE.START:VIEW.CHECKOUT.SINGLE.MASTER -->
<div id="SF_CheckoutPage">

	<h2>Checkout</h2>

	<div class="wpanel">
	
		<?php echo $this->load->view('shop/checkout/single/validation_messages'); ?>
		
			<div id="ncSingleCheckoutPage">
			
				<?php 
				
					if(!$this->current_user)
					{
						$this->load->view('shop/checkout/single/login');
						$this->load->view('shop/checkout/single/register');
					}

					$attributes = array( 'id' => 'myform');


					echo form_open('shop/checkout/place', $attributes);

					if(!$this->current_user)
					{
						//$this->load->view('shop/checkout/single/register');
					}
					else
					{					
						$this->load->view('shop/checkout/single/existing_addr');
						$this->load->view('shop/checkout/single/existing_addr_shipping');
					}

					$this->load->view('shop/checkout/single/new_addr'); 
					$this->load->view('shop/checkout/single/new_addr_shipping'); 
					$this->load->view('shop/checkout/single/shipping'); 
					$this->load->view('shop/checkout/single/payments'); 
					$this->load->view('shop/checkout/single/review'); 
					
					echo form_close(); 
					
				?>
				
			</div>

	</div>

</div>
<script  type="text/javascript">

		function check_address()
		{
		
			var v = $("input[name='existing_address_id']:checked").val();
			var a = $("input[name='existing_address_shipping_id']:checked").val();
						
			
			if ((v < 0)  || (v == '-1'))
			{
				$('#ncNewAddress').show(); 
			}
			else 
			{
				$('#ncNewAddress').hide();
			}
		
			
			if ((a < 0)  || (a == '-1'))
			{
				$('#ncNewAddressShipping').show(); 
			}
			else 
			{
				$('#ncNewAddressShipping').hide();	
				//$("input[name='alsoshipping']").hide();
				$("input[id='ncSameForShipping']").hide();
			}
			
			
			if ((v < 0)  && (a < 0))
			{
				$("input[name='alsoshipping']").show();
				$("#ncAlsoForShippingContainer").show();
				$("input[name='alsoshipping']").prop('checked', false);
			}
			else
			{
				$("input[name='alsoshipping']").hide();
				$("#ncAlsoForShippingContainer").hide();			
				$("input[name='alsoshipping']").prop('checked', false);
			}
			
			// Require user to validate and update shipping before place order
			invalidate();
			
			console.log('check address complete');
			
			return true;
		
		}
		
		function init()
		{
			// First show all values
			$('#ncNewAddress').show(); 
			$('#ncNewAddressShipping').show(); 
			$("input[id='ncSameForShipping']").show();
			// Hide whats not needed
			$("input[name='alsoshipping']").prop('checked', false);
			console.log('initialized');
		}

		function validate()
		{
			invalidate();
			
			$.post('{{url:site}}shop/checkout/validate_ax',  $('#myform').serialize())
			
				.done(function(data) 
				{		

					var obj = jQuery.parseJSON(data);
					
					if(obj.custom != null)
					{
						console.log(obj.custom);
					}					
					if (obj.status == 'success') 
					{
						var total_shipping = (obj.shipping[3]) + (obj.shipping[4]) - (obj.shipping[5]);
						$("#s_shipping_total").html(total_shipping);
						$("#s_cart_total").html(obj.cart_total);
						enable_place_order();
						console.log('validation finished [success]');
					}
					else
					{
						for(i=0;i< obj.fields.length;i++)
						{ 
							selector = "input[name='" + obj.fields[i] + "']";
							$(selector).attr("class", 'err_field');
						}
						//invalidate();
						console.log('validation finished [failed]');						
					}
					
				});
				
		}
		function enable_place_order() 
		{  
			$("#btnSubmit").attr('class', 'btn_enabled');
			//$("#btnValidate").attr('class', 'btn_disabled');
			console.log('enable_place_order complete'); 
		}		
		function invalidate() 
		{  
			$("select").attr('class', '');
			$("input[type='text']").attr('class', '');	/*male sure not to selectthe submit button	*/
			$("#btnSubmit").attr('class', 'btn_disabled');  
			//$("#btnValidate").attr('class', 'btn_enabled'); 
			console.log('invalidated complete'); 
		}
		
		
$(document).ready(function()
{

		console.log('document.ready');
		
       /*
        $("#btnValidate").click(function() 
		{
			validate(); 
        });
		*/

        $("input[name='existing_address_id']").change(function() 
		{
			check_address();
			validate();
        });
        $("input[name='existing_address_shipping_id']").change(function() 
		{
			check_address(); 
			validate();
        });
		
		$("input[name=alsoshipping]").click(function()
		{

			is_checked = $("input[name=alsoshipping]:checked").val()

			if (is_checked == 1) 
			{
	
				var v = $("input[name='existing_address_id']:checked").val();
				var a = $("input[name='existing_address_shipping_id']:checked").val();
				
				if  ((v == -1) && (a == -1) )
				{

					$('#ncNewAddressShipping').hide();
				}
				else
				{
	
					$('#ncNewAddressShipping').show(); 
				}

			}
			else
			{
		
				$('#ncNewAddressShipping').show(); 
			}
			
			// Require user to validate and update shipping cost
			invalidate();
	  });
	  
	
	// These events are checking for validation requirementrs
	var ifunc = function() {  invalidate(); } 
	var val = function() {  validate(); }
	
	// Invalidate and wait for more user input
	$("select").keyup(ifunc).keypress(ifunc).blur(ifunc);		
	$("input[type='text']").keyup(ifunc).keypress(ifunc).change(ifunc);		
	
	// Send for validation
	$("select").change(val);		
	$("input[type='text']").blur(val);
	$("input[type='radio']").change(val);
	
	// Call on load ready
	init();
	check_address();
	validate();
});


</script>
<!--- FILE.END:VIEW.CHECKOUT.SINGLE.MASTER -->