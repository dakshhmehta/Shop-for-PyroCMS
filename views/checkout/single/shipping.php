
<div id="ncShippingMethod" class="collapsable_checkout">

<fieldset>


	<?php if (count($shipping) > 1):?>
		<h3>
			Select Shipping Method		
		</h3>
	<?php endif; ?>
		
	<table>

		<?php if (count($shipping)==1):?>
			<?php echo form_hidden('shipping_method_id',$shipping[0][0]); ?>
		<?php else: ?>
		<?php foreach ($shipping as $ship):  ?>
		
			<tr class="<?php echo alternator('even', ''); ?>">
			
				<td>
					<span style="font-weight:600">
						<?php echo form_radio('shipping_method_id', $ship[0], set_radio('shipping_method_id', $ship[0], TRUE)) . $ship[1]; ?>  
					</span>
					<small><?php echo $ship[2]; ?></small>
				</td>		
			</tr>
			
		<?php endforeach; ?>
			<?php endif; ?>
	</table>
		
</fieldset>

</div>
