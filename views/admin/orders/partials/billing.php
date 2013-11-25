			<fieldset>
				<ul>
					<li>
						<label><?php echo lang('shop:orders:email'); ?></label>
						<div class="value">
							<?php echo $invoice->email; ?>
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:orders:first_name'); ?></label>
						<div class="value">
							<?php echo $invoice->first_name; ?>
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:orders:last_name'); ?></label>
						<div class="value">
							<?php echo $invoice->last_name; ?>
						</div>
					</li>
					<?php if ($invoice->company != ""): ?>
					<li>
						<label><?php echo lang('shop:orders:company'); ?></label>
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
						<label><?php echo lang('shop:orders:city'); ?></label>
						<div class="value">
							<?php echo $invoice->city; ?>
						</div>
					</li>
					<?php if ($invoice->state != ""): ?>
					<li>
						<label><?php echo lang('shop:orders:state'); ?></label>
						<div class="value">
							<?php echo $invoice->state; ?>
						</div>
					</li>
					<?php endif; ?>
					<?php if ($invoice->country != ""): ?>
					<li>
						<label><?php echo lang('shop:orders:country'); ?></label>
						<div class="value">
							<?php echo $invoice->country; ?>
						</div>
					</li>
					<?php endif; ?>
					<li>
						<label><?php echo lang('shop:orders:zip'); ?></label>
						<div class="value">
							<?php echo $invoice->zip; ?>
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:orders:phone'); ?></label>
						<div class="value">
							<?php echo $invoice->phone; ?>
						</div>
					</li>
				</ul>
			</fieldset>