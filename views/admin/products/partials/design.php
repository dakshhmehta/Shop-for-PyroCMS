
				<fieldset>
					<ul>
						<li>
							<label>
								<?php echo lang('shop:products:page_design'); ?>
								<small>
									<?php echo lang('shop:products:page_design_description'); ?>
								</small>
							</label>

							<div class="input">
								<select name="page_design_layout" id="page_design_layout">
									<option value="products_single"><?php echo lang('shop:products:default'); ?></option>
									<?php echo $design_select; ?> 
								</select>
							</div>
						</li>	

					</ul>
				</fieldset>
			