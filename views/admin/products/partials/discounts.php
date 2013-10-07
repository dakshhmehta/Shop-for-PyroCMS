

				<fieldset>
					<div style="padding:10px;">
						<ul>
							<li>
							<label for=""><?php echo shop_lang('shop:products:discounts'); ?><span></span>
								<small><?php echo shop_lang('shop:products:discounts_description'); ?></small>
					
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
														  <th class='tooltip-s' title="<?php echo shop_lang('shop:products:min_purchase_req');?>"><?php echo shop_lang('shop:products:min_qty'); ?></th>
														  <th class='tooltip-s' title="<?php echo shop_lang('shop:products:discounted_retail_price'); ?>"><?php echo shop_lang('shop:products:price'); ?></th>
														  <th class='tooltip-s' title="<?php echo shop_lang('shop:products:remove'); ?>"><?php echo shop_lang('shop:products:actions'); ?></th>
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