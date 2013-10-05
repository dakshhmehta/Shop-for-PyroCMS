<!--- FILE.START:VIEW.MY.ADDRESS -->
<h2 id="nc-view-title"><?php echo lang('address'); ?></h2>

		<ul>
		{{ shop:mylinks remove='wishlist shop' active='addresses' }}
			{{link}}
		{{ /shop:mylinks }}
		</ul>

<?php
if (validation_errors()) 
{
	echo validation_errors('<div class="error">', '</div>');
}
?>

<div class="address_info wpanel">
	<?php echo form_open(); ?>
	<?php echo form_hidden('user_id', $this->current_user->id); ?>
	<fieldset>
		<ul class="two_column">
			<li class="<?php echo alternator('odd', 'even'); ?>">
				<label><?php echo lang('first_name'); ?><span>*</span></label>
				<div class="input">
					<?php echo form_input('first_name', set_value('first_name', $first_name)); ?>
				</div>
			</li>
			<li class="<?php echo alternator('odd', 'even'); ?>">
				<label><?php echo lang('last_name'); ?><span>*</span></label>
				<div class="input">
					<?php echo form_input('last_name', set_value('last_name', $last_name)); ?>
				</div>
			</li>
			<li class="<?php echo alternator('odd', 'even'); ?>">
				<label><?php echo lang('company'); ?></label>
				<div class="input">
					<?php echo form_input('company', set_value('company', $company)); ?>
				</div>
			</li>
			<li class="<?php echo alternator('odd', 'even'); ?>">
				<label><?php echo lang('email'); ?><span>*</span></label>
				<div class="input">
					<?php echo form_input('email', set_value('email', $email)); ?>
				</div>
			</li>
			<li class="<?php echo alternator('odd', 'even'); ?>">
				<label><?php echo lang('phone'); ?><span>*</span></label>
				<div class="input">
					<?php echo form_input('phone', set_value('phone', $phone)); ?>
				</div>
			</li>
			<li class="<?php echo alternator('odd', 'even'); ?>">
				<label><?php echo lang('address1'); ?><span>*</span></label>
				<div class="input">
					<?php echo form_input('address1', set_value('address1', $address1)); ?>
				</div>
			</li>
			<li class="<?php echo alternator('odd', 'even'); ?>">
				<label><?php echo lang('address2'); ?></label>
				<div class="input">
					<?php echo form_input('address2', set_value('address2', $address2)); ?>
				</div>
			</li>
			<li class="<?php echo alternator('odd', 'even'); ?>">
				<label><?php echo lang('city'); ?><span>*</span></label>
				<div class="input">
					<?php echo form_input('city', set_value('city', $city)); ?>
				</div>
			</li>
			<li class="<?php echo alternator('odd', 'even'); ?>">
				<label><?php echo lang('state'); ?></label>
				<div class="input">
					<?php echo form_input('state', set_value('state', $state)); ?>
				</div>
			</li>
			<li class="<?php echo alternator('odd', 'even'); ?>">
				<label><?php echo lang('country'); ?></label>
				<div class="input">
					<?php echo form_input('country', set_value('country', $country)); ?>
				</div>
			</li>
			<li class="<?php echo alternator('odd', 'even'); ?>">
				<label><?php echo lang('zip'); ?><span>*</span></label>
				<div class="input">
					<?php echo form_input('zip', set_value('zip', $zip)); ?>
				</div>
			</li>
			<li> 
				<label><?php echo form_checkbox('agreement', 1, FALSE); ?><?php echo lang('agreement_field'); ?></label>
				<span style="float: right;">
					<?php echo anchor('shop/my/', lang('dashboard')); ?> | 
					<?php echo form_reset('reset', lang('clear'), 'class="button"'); ?>
					<?php echo form_submit('submit', lang('save')); ?>
				</span>
			</li>
		</ul>
	</fieldset>
</div>
<?php echo form_close(); ?>
<!--- FILE.END:VIEW.MY.ADDRESS -->
