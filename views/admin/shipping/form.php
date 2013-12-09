
<section class="title">
	<h4><?php echo lang('shop:common:shipping') ; ?></h4>
	<h4 style="float:right"><a href="admin/shop/shipping/" class='button'><?php echo lang('shop:shipping:view_all') ; ?></a></h4>		
</section>


<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
 <?php echo form_hidden('id', $shipping_method->id); ?>


<section class="item">
	<div class="content">
			<div class="tabs">

				<ul class="tab-menu">
					<li><a href="#info-tab"><span><?php echo lang('shop:shipping:details') ; ?></span></a></li>	
					<li><a href="#delivery-tab"><span><?php echo lang('shop:common:description') ; ?></span></a></li>
					<li><a href="#cost-tab"><span><?php echo lang('shop:shipping:cost') ; ?></span></a></li>						
				</ul>

				<div class="form_inputs" id="info-tab">
					<fieldset>
						<ul>
							<li class="<?php echo alternator('', 'even'); ?>">
								<label for="name"><?php echo lang('shop:common:name') ; ?><span></span></label>
								<div class="input"><?php echo $shipping_method->name; ?></div>
							</li>						
							<li class="<?php echo alternator('', 'even'); ?>">
								<label for="name"><?php echo lang('shop:common:label') ; ?> <span>*</span></label>
								<div class="input"><?php echo form_input('title', set_value('name', $shipping_method->title), 'class="width-15"'); ?></div>
							</li>
						</ul>
					</fieldset>
				</div>
				<div class="form_inputs" id="delivery-tab">
					<fieldset>
						<ul>
							<li class="<?php echo alternator('', 'even'); ?>">
								<label for="desc"><?php echo lang('shop:common:description') ; ?><span>*</span></label>
								<div class="input"><?php echo form_textarea('desc', set_value('desc', $shipping_method->desc), 'class="width-15"'); ?></div>
							</li>
						</ul>
					</fieldset>
				</div>	
				<div class="form_inputs" id="cost-tab">						
					<fieldset>
						<?php $this->load->file($shipping_method->form); ?>
					</fieldset>
				</div>					
				
			</div>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
			
	</div>
</section>

<?php echo form_close(); ?>

