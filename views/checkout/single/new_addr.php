<!--- FILE.START:VIEW.CHECKOUT.SINGLE.NEW_ADDR -->
		<div id="ncNewAddress" class="collapsable_checkout">
			<div class=''>
				<fieldset>
					<h4>Enter Billing Address</h4>
					<ul class="two_column">
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('first_name'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_input('first_name', set_value('first_name',(isset($first_name)?$first_name:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('last_name'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_input('last_name', set_value('last_name',(isset($first_name)?$last_name:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('company'); ?></label>
							<div class="input">
								<?php echo form_input('company', set_value('company',(isset($company)?$company:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('email'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_input('email', set_value('email',(isset($email)?$email:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('phone'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_input('phone', set_value('phone', (isset($phone)?$phone:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('address1'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_input('address1', set_value('address1', (isset($address1)?$address1:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('address2'); ?></label>
							<div class="input">
								<?php echo form_input('address2', set_value('address2',  (isset($address2)?$address2:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('city'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_input('city', set_value('city',(isset($city)?$city:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('state'); ?></label>
							<div class="input">
								<?php echo form_input('state', set_value('state', (isset($state)?$state:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('zip'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_input('zip', set_value('zip', (isset($zip)?$zip:'')) ); ?>
							</div>
						</li>
						<li class="<?php echo alternator('odd', 'even'); ?>">
							<label><?php echo lang('country'); ?><span>*</span></label>
							<div class="input">
								<?php echo form_dropdown('country', $countryList, set_value('country', (isset($country)?$country:'')) ); ?>
							</div>
						</li>						
					</ul>
				</fieldset>	
			</div>
		</div>
		<div id="ncSameForShipping" class="collapsable_checkout">
			<?php echo $this->load->view('shop/checkout/single/sameforshipping'); ?>
		</div>			
<!--- FILE.END:VIEW.CHECKOUT.SINGLE.NEW_ADDR -->
