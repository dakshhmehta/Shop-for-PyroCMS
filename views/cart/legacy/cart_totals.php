<!--- FILE.START:VIEW.CART.CART_TOTALS --->
	   <div class="cart-totals">
			<div class="cart-totals-table-wrapper">
				<h2>Cart Totals</h2>
				<table cellpadding="0" cellspacing="0">
				  <tbody>
					<tr class="shipping">
					  <th>
						<strong><?php echo lang('items'); ?></strong>
					  </th>
					  <td>
						<?php echo nc_format_price($this->sfcart->items_total()); ?> 
					  </td>
					</tr>
					<tr class="shipping">
					  <th>
						<strong><?php echo lang('shipping'); ?></strong>
					  </th>
					  <td>
						<?php echo nc_format_price( $this->sfcart->shipping_total() ); ?>
					  </td>
					</tr>					
					<tr class="total">
					  <th>
						<strong><?php echo lang('order_total'); ?></strong>
					  </th>
					  <td>
						<strong>
						  <span class="amount"><?php echo nc_format_price($this->sfcart->total()); ?></span>
						</strong>
					  </td>
					</tr>
				  </tbody>
				</table>
				<p>
				  <small></small>
				</p>
			</div>
		</div>			
<!--- FILE.END:VIEW.CART.CART_TOTALS --->		