<div>

		<?php echo form_open('shop/cart/update'); ?>


		<div>
			<h2><?php echo lang('cart'); ?></h2>
		</div>

	  


		<!-- Start Shopping Cart Table -->
		
		  <table>
		  
			<thead>
			  <tr>
				<th><?php echo lang('image'); ?></th>
				<th><?php echo lang('item'); ?></th>
				<th><?php echo lang('price'); ?></th>
				<th><?php echo lang('qty'); ?></th>
				<th><?php echo lang('subtotal'); ?></th>
				<th></th>				
			  </tr>
			</thead>
			
			<tbody>


					{{ shop:cart_contents }}

						<input type="hidden" name="{{counter}}[id]" value="{{ id }}" />
						<input type="hidden" name="{{counter}}[rowid]" value="{{ rowid }}" />
						<input type="hidden" name="{{counter}}[price]" value="{{ price }}" />
						<input type="hidden" name="{{counter}}[base]" value="{{ base }}" />
				
						<tr>
							<td>
								<a href="{{url:site}}shop/product/{{slug}}">
									{{ shop:coverimage id="{{ id }}" }}
								</a>
							</td>

							<td>
								<a href="{{url:site}}shop/product/{{slug}}">
									{{ name }}
								</a>
							</td>

							<td>
								<a href="{{url:site}}shop/product/{{slug}}">
									{{ price }}
								</a>
							</td>

							<td>
								<input type="text" name="{{counter}}[qty]" value="{{ qty }}" size="4" />
							</td>


							<td>
								<span>{{shop:pricer price="{{ subtotal }}" }}</span> *
							</td>

							<td>
								<a href="{{url:site}}shop/cart/delete/{{rowid}}">
									&times;
								</a>					
							</td>	
					</tr>
					{{ /shop:cart_contents }}



				  <tr>
				  
					<td colspan="6">
					
						<a href="{{url:site}}shop/cart/drop"><?php echo lang('delete');?></a>
						
						<input name="update_cart" type="submit" value="<?php echo lang('update_cart');?>" />
						
						<a href="{{url:site}}shop/checkout/"><?php echo lang('checkout');?></a>
						
					</td>
					
				  </tr>
				
		

			</tbody>
			
		  </table>


	   <div>
			<div>
				<h2><?php echo lang('cart_totals'); ?></h2>
				<table>
				  <tbody>			  
					<tr>
					  <th>
						<strong><?php echo lang('items'); ?></strong>
					  </th>
					  <td>
					  	{{ shop:total cart="sub-total" format='YES' }}
					  </td>
					</tr>				
					<tr>
					  <th>
						<strong><?php echo lang('order_total'); ?></strong>
					  </th>
					  <td>
						<strong>
						  <span>
						  		{{ shop:total cart="total" format='YES' }}
						  </span>
						</strong>
					  </td>
					</tr>
				  </tbody>
				</table>
			</div>
		</div>			
	

		<?php echo form_close(); ?>

</div>