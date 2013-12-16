

			<fieldset>

				<label>
					
					<?php echo lang('shop:products:price_tab_description'); ?>

					<small><?php echo lang('shop:products:price_tab_description_description'); ?></small>

				</label>



				<div class="tabs">		

					<ul class="tab-menu">
						<li><a class=""  data-load="" href="#price-basic-tab"><span><?php echo lang('shop:products:standard'); ?></span></a></li>		
						<li><a class=""  data-load="" href="#price-mid-tab"><span><?php echo lang('shop:products:qty_discount'); ?></span></a></li>																	
					</ul>	


					<div class="form_inputs" id="price-basic-tab">
						<fieldset>
								<ul>
									<li>
										<label for="price"><?php echo lang('shop:common:price'); ?><span>*</span><br />
											<small><?php echo lang('shop:products:price_description'); ?></small>
										</label>
										<div class="input">
											<?php echo ss_currency_symbol().' '.sf_text('price',$price);?>
										</div>
									</li>

									<li>
										<label for="price_base"><?php echo lang('shop:products:base_price'); ?> <span></span><br />
											<small><?php echo lang('shop:products:base_price_description'); ?></small>
										</label>
										<div class="input">
											<?php echo ss_currency_symbol().' '.sf_text('price_base',$price_base);?>
										</div>
									</li>					
									<li>
										<label for="price"><?php echo lang('shop:products:rrp'); ?> <span></span><br />
											<small><?php echo lang('shop:products:rrp_description'); ?></small>
										</label>
										<div class="input">
											<?php echo ss_currency_symbol().' '.sf_text('rrp',$rrp);?>
										</div>
									</li>					
								</ul>
						</fieldset>.
					</div>



					<div class="form_inputs" id="price-mid-tab">
						<fieldset>
							<ul>
								<li class="<?php echo alternator('', 'even'); ?>">
									<label for="pgroup_id">
											<?php echo lang('shop:products:qty_discount'); ?>
										<small>
										<?php echo lang('shop:products:qty_discount_description'); ?>
										</small>						
									</label>
									<div class="input">
										
										<?php echo $group_select; ?> 
										
									</div>
								</li>		
							</ul>
						</fieldset>.
					</div>
				</div>


			</fieldset>			
	


		<script>


		</script>