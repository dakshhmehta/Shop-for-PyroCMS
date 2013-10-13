

			<fieldset>


				<ul>
					<li>
						<label for="price"><?php echo shop_lang('shop:products:price'); ?><span>*</span><br />
							<small><?php echo shop_lang('shop:products:price_description'); ?></small>
						</label>
						<div class="input">
							<?php echo ss_currency_symbol().' '.sf_text('price',$price);?>
						</div>
					</li>
					<?php /*
					<li>
						<label for="autotax"><?php echo shop_lang('shop:products:tax'); ?> <span></span>
						<br />
						<small><?php echo shop_lang('shop:products:tax_description'); ?></small></label>
						<div class="input">
							<?php echo form_dropdown('tax_id', sf_prep_taxes($tax_groups) ,$tax_id, "id='tax_id' ");?>
						</div>
					</li>					
					<li>
						<label for="autotax"><?php echo shop_lang('shop:products:tax_calc_mode'); ?><span></span>
						<br />
						<small><?php echo shop_lang('shop:products:tax_calc_mode_description'); ?></small></label>
						<div class="input">
							<?php echo form_dropdown('tax_dir', array(0=> shop_lang('shop:products:inclusive'),1=> shop_lang('shop:products:exclusive')) ,$tax_dir, "id='tax_dir' ");?>
						</div>
					</li>	
					*/ ?>
					<li>
						<label for="price_base"><?php echo shop_lang('shop:products:base_price'); ?> <span></span><br />
							<small><?php echo shop_lang('shop:products:base_price_description'); ?></small>
						</label>
						<div class="input">
							<?php echo ss_currency_symbol().' '.sf_text('price_base',$price_base);?>
						</div>
					</li>					
					<li>
						<label for="price"><?php echo shop_lang('shop:products:rrp'); ?> <span></span><br />
							<small><?php echo shop_lang('shop:products:rrp_description'); ?></small>
						</label>
						<div class="input">
							<?php echo ss_currency_symbol().' '.sf_text('rrp',$rrp);?>
						</div>
					</li>					
				</ul>
				<?php echo shop_lang('shop:products:or_set_a_price_group'); ?>
				<ul>

					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="pgroup_id">
								<?php echo shop_lang('shop:products:pgroup'); ?>
							<small>
							<?php echo shop_lang('shop:products:pgroup_description'); ?>
							</small>						
						</label>
						<div class="input">
							<select name="pgroup_id" id="pgroup_id">
								<option value=""><?php echo lang('global:select-pick'); ?></option>
								<?php echo $group_select; ?> 
							</select>
						</div>
					</li>		

				</ul>

			</fieldset>			
	

