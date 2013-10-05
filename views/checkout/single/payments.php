<!--- FILE.START:VIEW.CHECKOUT.PAYMENTS -->
<div id="ncPaymentsMethod" class="collapsable_checkout">

	<fieldset>
		<?php if (count($payments) >1):?>
		<h3>
			<?php echo lang('payment_method'); ?>
		</h3>
	<?php endif; ?>
		<ul>
		<?php if (count($payments)==1):?>
		
				<li class="<?php echo alternator('even', ''); ?>">
					<label class="radio" style="display:none">
						<?php echo form_hidden('gateway_method_id', $payments[0]->id); ?>
					</label>
				</li>
		
		<?php else: ?>
		
			<?php foreach ($payments as $item): ?>

				<li class="<?php echo alternator('even', ''); ?>">

					<label class="radio">
					
						<?php echo form_radio('gateway_method_id', $item->id, set_radio('gateway_method_id', $item->id, TRUE)) . $item->title; ?>

						<?php /*echo $item->image ? '<img src="'.$item->image.'" alt="'.$item->title.'" style="float:right;" /><br class="clear" />' : ''; */ ?>

					</label>

				
				</li>

			<?php endforeach; ?>

		<?php endif; ?>
		</ul>
	</fieldset>

</div>
<!--- FILE.END:VIEW.CHECKOUT.PAYMENTS -->