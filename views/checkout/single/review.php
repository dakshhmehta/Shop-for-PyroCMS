	<div id="ncOrderReview" class="collapsable_checkout">
	
		<fieldset>	

			<h3>Review Order</h3>

			<table cellpadding="0" cellspacing="0" border="0" id="cart-table">
				<thead>
					<tr>
						<th class="quantity"><?php echo lang('quantity'); ?></th>
						<th class="desc"><?php echo lang('item'); ?></th>
						<th class="subtotal" ><?php echo lang('subtotal'); ?></th>
					</tr>
				</thead>

				<?php $i = 1; ?>
				<?php foreach ($this->sfcart->contents() as $items): ?>

				<tr>
					<td class="quantity">
						<?php echo $items['qty'];?> &times;
					</td>
					<td class="desc">
						<?php echo $items['name']; ?>
					</td>
					 
					<td class="subtotal" style="text-align:right"><?php echo nc_format_price($items['subtotal']); ?></td>
				</tr>

				<?php $i++; ?>

				<?php endforeach; ?>
				
					<tr>
						<td class="quantity">
							1 &times;
						</td>
						<td style="desc">
							shipping
						</td>
						 
						<td class="subtotal"><?php echo ss_currency_symbol(); ?> <span id="s_shipping_total"><?php echo $this->sfcart->shipping_total() ; ?></span></td>
					</tr>
				</tbody>
				
				<tfoot>
					<tr>
						<td class="quantity"></td>
						<td class="desc"><strong><?php echo lang('total'); ?></strong></td>
						<td class="subtotal"><?php echo ss_currency_symbol(); ?> <span id="s_cart_total"><?php echo $this->sfcart->total(); ?></span></td>
					</tr>
				</tfoot>

			</table>
		
		</fieldset>	
		




		<fieldset>	

			<h3>Confirm Order</h3>

			<span id="ncCheckoutActionButtons">
				<!--<a id="btnValidate" class='btn_disabled'>Validate</a>-->
				<input id='btnSubmit' type='submit' value='submit order' class='btn_disabled'>
			</span>

		</fieldset>



	</div>