			<fieldset>
				<ul>
					<li>
						<label><?php echo lang('shop:address:field:email'); ?></label>
						<div class="value">
							<?php echo $invoice->email; ?>
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:address:field:first_name'); ?></label>
						<div class="value">
							<?php echo $invoice->first_name; ?>
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:address:field:last_name'); ?></label>
						<div class="value">
							<?php echo $invoice->last_name; ?>
						</div>
					</li>
					<?php if ($invoice->company != ""): ?>
					<li>
						<label><?php echo lang('shop:address:field:company'); ?></label>
						<div class="value">
							<?php echo $invoice->company; ?>
						</div>
					</li>
					<?php endif; ?>
					<li>
						<label><?php echo lang('shop:orders:address'); ?></label>
						<div class="value">
							<?php echo $invoice->address1; ?> , 
							<?php echo $invoice->address2; ?>
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:address:field:city'); ?></label>
						<div class="value">
							<?php echo $invoice->city; ?>
						</div>
					</li>
					<?php if ($invoice->state != ""): ?>
					<li>
						<label><?php echo lang('shop:address:field:state'); ?></label>
						<div class="value">
							<?php echo $invoice->state; ?>
						</div>
					</li>
					<?php endif; ?>
					<?php if ($invoice->country != ""): ?>
					<li>
						<label><?php echo lang('shop:address:field:country'); ?></label>
						<div class="value">
							<?php echo $invoice->country; ?>
						</div>
					</li>
					<?php endif; ?>
					<li>
						<label><?php echo lang('shop:address:field:zip'); ?></label>
						<div class="value">
							<?php echo $invoice->zip; ?>
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:address:field:phone'); ?></label>
						<div class="value">
							<?php echo $invoice->phone; ?>
						</div>
					</li>
				</ul>
			</fieldset>