
<div id="ncExistingAddress" class="collapsable_checkout">
<?php if(!count($addresses) ): ?>
<input type="radio" name="existing_address_id" value="-1" class="" style='display:none' checked="checked" />
<?php else: ?>
		<fieldset>
			<h3>Billing Address</h3>	
			<table class="">
					<tr class="">
						<td style="border:0px;"><?php echo lang('option'); ?></td>
						<td style="border:0px;"><?php echo lang('address'); ?></td>
						<td style="border:0px;"><?php echo lang('city'); ?></td>
						<td style="border:0px;"><?php echo lang('state'); ?></td>
						<td style="border:0px;"><?php echo lang('zip'); ?></td>
						<td style="border:0px;"><?php echo lang('country'); ?></td>
					</tr>		
						<tr class="">
							<td style="border:0px;">
									<?php echo form_radio('existing_address_id', -1, TRUE ); ?>
							</td>
							<td colspan='5'>Create new address</td>
						</tr>	
					<?php foreach ($addresses as $value): ?>
						<tr class="">
							<td style="border:0px;"><?php echo form_radio('existing_address_id', $value->id,TRUE); ?></td>
							<td style="border:0px;"><?php echo $value->address1.', '.$value->address2;; ?></td>
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
