<!--- FILE.START:VIEW.CHECKOUT.SINGLE.EXISTING_ADDR_SHIPPING -->
<div id="ncExistingAddressShipping" class="collapsable_checkout">
<?php if(!count($addresses) ): ?>
<input type="radio" name="existing_address_shipping_id" value="-1" class="" style='display:none' checked="checked" />
<?php else: ?>
				<fieldset>
					<h3>Shipping Address</h3>	
					<table style="">
							<tr style="">
								<td style="border:0px;"><?php echo lang('option'); ?></td>
								<td style="border:0px;"><?php echo lang('address'); ?></td>
								<td style="border:0px;"><?php echo lang('city'); ?></td>
								<td style="border:0px;"><?php echo lang('state'); ?></td>
								<td style="border:0px;"><?php echo lang('zip'); ?></td>
								<td style="border:0px;"><?php echo lang('country'); ?></td>
							</tr>		
								<tr style="">
									<td style="border:0px;">

											<?php echo form_radio('existing_address_shipping_id', -1, TRUE ); ?>
									</td>
									<td colspan='5'>Create new address</td>
								</tr>	
							<?php foreach ($addresses as $value): ?>
								<tr style="">
									<td style="border:0px;"><?php echo form_radio('existing_address_shipping_id', $value->id,TRUE); ?></td>
									<td style="border:0px;"><?php echo $value->address1.', '.$value->address2; ?></td>
									<td style="border:0px;"><?php echo $value->city; ?></td>
									<td style="border:0px;"><?php echo $value->state; ?></td>
									<td style="border:0px;"><?php echo $value->zip; ?></td>
									<td style="border:0px;"><?php echo $value->country; ?></td>
								</tr>
							<?php endforeach; ?>
					</table>
				</fieldset>
<?php endif; ?>
</div>
<!--- FILE.END:VIEW.CHECKOUT.SINGLE.EXISTING_ADDR_SHIPPING -->