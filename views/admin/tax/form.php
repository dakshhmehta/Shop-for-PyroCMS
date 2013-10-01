<!--- FILE.START:VIEW.ADMIN.TAX.CREATE --->
<section class="title">
	<h4><?php echo lang('tax'); ?></h4>
</section>
<?php echo form_open_multipart($this->uri->uri_string()); ?>
<?php echo form_hidden('id', set_value('id', $id)); ?>
<section class="item">
	<div class="content">	
		<div class="tabs">	
			<ul class="tab-menu">
				<li><a href="#info-tab"><span><?php echo lang('rates');?></span></a></li>						
			</ul>
			<div class="form_inputs" id="info-tab">
				<fieldset>
					<ul>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="name"><?php echo lang('name'); ?> <span>*</span></label>
							<div class="input"><?php echo form_input('name', set_value('name', $name) ); ?> </div>
						</li>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="discount_pcent"><?php echo lang('tax_rate');?> <span></span></label>
							<div class="input"><?php echo form_input('rate', set_value('discount_pcent', $rate)); ?> %</div>
						</li>								
					</ul>
					<div class="buttons">
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</section>
<?php form_close(); ?>
<!--- FILE.END:VIEW.ADMIN.TAX.CREATE --->