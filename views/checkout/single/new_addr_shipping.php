
		<div id="ncNewAddressShipping" class="collapsable_checkout">
				<fieldset>
					<h4>Enter Shipping Address</h4>
					<ul class="two_column">
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('first_name'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_input('shipping_first_name', set_value('shipping_first_name', (isset($shipping_first_name)?$shipping_first_name:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('last_name'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_input('shipping_last_name', set_value('shipping_last_name', (isset($shipping_last_name)?$shipping_last_name:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('company'); ?></label>
							<div class="input">
								<?php echo form_input('shipping_company', set_value('shipping_company',(isset($shipping_company)?$shipping_company:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('email'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_input('shipping_email', set_value('shipping_email', (isset($shipping_email)?$shipping_email:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('phone'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_input('shipping_phone', set_value('shipping_phone', (isset($shipping_phone)?$shipping_phone:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('address1'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_input('shipping_address1', set_value('shipping_address1', (isset($shipping_address1)?$shipping_address1:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('address2'); ?></label>
							<div class="input">
								<?php echo form_input('shipping_address2', set_value('shipping_address2', (isset($shipping_address2)?$shipping_address2:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('city'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_input('shipping_city', set_value('shipping_city', (isset($shipping_city)?$shipping_city:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('state'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_input('shipping_state', set_value('shipping_state', (isset($shipping_state)?$shipping_state:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('zip'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_input('shipping_zip', set_value('shipping_zip', (isset($shipping_zip)?$shipping_zip:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('country'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_dropdown('shipping_country', $countryList, set_value('shipping_country', (isset($shipping_country)?$shipping_country:'')) ); ?>
							</div>
						</li>						
					</ul>
				</fieldset>	
		</div>

