

			<fieldset>

				<label>
					
					<?php echo lang('shop:products:price_tab_description'); ?>

					<small><?php echo lang('shop:products:price_tab_description_description'); ?></small>

				</label>



				<div class="tabs">		

					<ul class="tab-menu">
						<li><a class=""  data-load="" href="#price-basic-tab"><span><?php echo lang('shop:products:standard'); ?></span></a></li>		
						<li><a class=""  data-load="" href="#price-qtydiscount-tab"><span><?php echo lang('shop:products:qty_discount'); ?></span></a></li>	
						<li><a class=""  data-load="" href="#price-mid-tab"><span><?php echo lang('shop:products:mid_discount'); ?></span></a></li>																	
					</ul>	


					<div class="form_inputs" id="price-basic-tab">
						<fieldset>
								<ul>
									<li>
										<label for="price"><?php echo lang('shop:products:price'); ?><span>*</span><br />
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


					<div class="form_inputs" id="price-qtydiscount-tab">
						<fieldset>
							<ul>
							<li>
								<label for=""><?php echo lang('shop:products:qty_discounts'); ?><span></span>
									<small><?php echo lang('shop:products:qty_discounts_description'); ?></small>
						
								</label>
								<label for=""><span></span><br />
									<small></small>
								</label>
							</li>
								<div class="input">
									<div class='' style="float:left;">
										<div class="scrollable_panel">
											<table id="discounts-list">
														<tr>
															  <th class='tooltip-s' title="<?php echo lang('shop:products:min_purchase_req');?>"><?php echo lang('shop:products:min_qty'); ?></th>
															  <th class='tooltip-s' title="<?php echo lang('shop:products:discounted_retail_price'); ?>"><?php echo lang('shop:products:price'); ?></th>
															  <th class='tooltip-s' title="<?php echo lang('shop:products:remove'); ?>"><?php echo lang('shop:products:actions'); ?></th>
														</tr>					
												<?php $index = 0; ?>
													<?php foreach ($discounts as $atr): ?>
														<tr id="item_<?php echo $index; ?>">
																<td><?php echo form_input('discounts[' . $index . '][min_qty]', set_value('discounts[' . $index . '][min_qty]', $atr->min_qty), 'class="disc_qty"'); ?></td>
																<td><?php echo form_input('discounts[' . $index . '][price]', set_value('discounts[' . $index . '][price]', $atr->price), 'class="disc_price"'); ?></td>
																<td><a class="img_delete img_icon remove" data-row="item_<?php echo $index; ?>"></a></td>
														</tr>
														<?php $index++; ?>
													<?php endforeach; ?>
											</table>
											 <a id="add-discounts" class="tooltip-s img_create img_icon" title="<?php echo lang('new_tier');?>"> </a>
										</div>
									</div>
								</div>
							</ul>
						</fieldset>.
					</div>


					<div class="form_inputs" id="price-mid-tab">
						<fieldset>
							<ul>
								<li class="<?php echo alternator('', 'even'); ?>">
									<label for="pgroup_id">
											<?php echo lang('shop:products:pgroup'); ?>
										<small>
										<?php echo lang('shop:products:pgroup_description'); ?>
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
		$('#add-discounts').click(function() {
			var id = $("#discounts-list tr").length;
			var content = '';
			content += '<tr id="item_'+id+'">';
			content += '   <td><input type="text" class="disc_qty" value="" name="discounts['+id+'][min_qty]"></td>';
			content += '   <td><input type="text" class="disc_price" value="" name="discounts['+id+'][price]"></td>';		
			content += '   <td><a class="img_delete img_icon remove" data-row="item_'+id+'"></a></td>';
			content += '</tr>';
			$('#discounts-list').append(content);
			return false;
		});
        

    
        
		$('#discounts-list .remove').live('click', function(e) 
		{
			var item = $(this).attr('data-row');
			var test = confirm('Please confirm action');
			if (test) {
				$('#'+item).remove();
			}
			return false;
		});
        

		</script>