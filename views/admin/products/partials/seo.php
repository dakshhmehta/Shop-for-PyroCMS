

				<fieldset>
					<ul>
					
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="meta_desc"><?php echo lang('shop:products:meta_description'); ?>
								<small><?php echo lang('shop:products:meta_description_description'); ?>.</small>
							</label>
							<div class="input"><?php echo form_textarea('meta_desc', set_value('meta_desc', $meta_desc), 'style="width: 50%"'); ?></div>
						</li>

						<li>
							<label for="keywords"><?php echo lang('shop:products:keywords'); ?><br />
								<small><?php echo lang('shop:products:keywords_description'); ?></small>
							</label>
							<div class="input">
								<?php echo form_input('keywords', $keywords, 'id="keywords"') ?>
							</div>
						</li>
					</ul>

				</fieldset>			

				<script>
					    //$('#keywords').tagsInput();
					   // $('#keywords').tagsInput({});

						$('#keywords').tagsInput({
							autocomplete_url: 'admin/keywords/autocomplete'
						});
				</script
		
		