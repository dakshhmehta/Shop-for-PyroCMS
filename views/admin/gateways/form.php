<section class="title">

	<h4><?php echo lang('shop:gateways:gateways'); ?></h4>

</section>

<section class="item">

	<div class="content">

		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>

			<?php echo form_hidden('id', $gateway->id); ?>

		<div class="form_inputs">

			<fieldset>

				<legend><?php echo lang('shop:gateways:gateway'); ?></legend>
				<ul>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="name"><?php echo lang('shop:common:name'); ?><span>*</span></label>
						<div class="input"><?php echo form_input('title', set_value('name', $gateway->title), 'class="width-15"'); ?></div>
					</li>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="desc"><?php echo lang('shop:gateways:description'); ?><span>*</span></label>
						<div class="input"><?php echo form_textarea('desc', set_value('desc', $gateway->desc), 'class="width-15"'); ?></div>
					</li>
				</ul>

			</fieldset>

			<fieldset>
				<legend></legend>

				<?php $this->load->view('admin/merchant/'.$gateway->slug.'/form'); ?>
				
			</fieldset>

		</div>


		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
		</div>


		<?php echo form_close(); ?>

	</div>

</section>