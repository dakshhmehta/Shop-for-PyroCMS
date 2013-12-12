			<fieldset>
				<ul>
					<li>
						<label><?php echo lang('shop:address:field:email'); ?></label>
						<div class="value">
							<?php echo $shipping_address->email; ?>
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:address:field:first_name'); ?></label>
						<div class="value">
							<?php echo $shipping_address->first_name; ?>
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:address:field:last_name'); ?></label>
						<div class="value">
							<?php echo $shipping_address->last_name; ?>
						</div>
					</li>
					
					<?php if ($shipping_address->company != ""): ?>
					<li>
						<label><?php echo lang('shop:address:field:company'); ?></label>
						<div class="value">
							<?php echo $shipping_address->company; ?>
						</div>
					</li>
					<?php endif; ?>

					<li>
						<label><?php echo lang('shop:orders:address'); ?></label>
						<div class="value">
							<?php echo $shipping_address->address1; ?>,
							<?php echo $shipping_address->address2; ?>
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:address:field:city'); ?></label>
						<div class="value">
							<?php echo $shipping_address->city; ?>
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:address:field:state'); ?></label>
						<div class="value">
							<?php echo $shipping_address->state; ?>
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:address:field:country'); ?></label>
						<div class="value">
							<?php echo $shipping_address->country; ?>
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:address:field:zip'); ?></label>
						<div class="value">
							<?php echo $shipping_address->zip; ?>
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:address:field:phone'); ?></label>
						<div class="value">
							<?php echo $shipping_address->phone; ?>
						</div>
					</li>
				</ul>
			</fieldset>