<!--- FILE.START:VIEW.CART.STANDARD.CART_TOTALS --->
	   <div>
			<div>
				<h2><?php echo lang('cart_totals'); ?></h2>
				<table cellpadding="0" cellspacing="0">
				  <tbody>			  
					<tr>
					  <th>
						<strong><?php echo lang('items'); ?></strong>
					  </th>
					  <td>
						<?php echo nc_format_price($this->sfcart->items_total()); ?> 
					  </td>
					</tr>
					<tr>
					  <th>
						<strong><?php echo lang('shipping'); ?></strong>
					  </th>
					  <td>
						<?php echo nc_format_price( $this->sfcart->shipping_total() ); ?>
					  </td>
					</tr>					
					<tr>
					  <th>
						<strong><?php echo lang('order_total'); ?></strong>
					  </th>
					  <td>
						<strong>
						  <span><?php echo nc_format_price($this->sfcart->total()); ?></span>
						</strong>
					  </td>
					</tr>
				  </tbody>
				</table>
			</div>
		</div>			
<!--- FILE.END:VIEW.CART.STANDARD.CART_TOTALS --->		