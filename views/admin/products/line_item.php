
			<table>

				<thead>		
					<tr>
						<th class="collapse"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
						<th class="collapse"><?php echo shop_lang('shop:products:id');?></th>
						<th class="collapse"><?php echo shop_lang('shop:products:image');?></th>
						<th class="collapse"><?php echo shop_lang('shop:products:name');?></th>
						<th class="collapse"><?php echo shop_lang('shop:products:on_hand');?></th>
						<th class="collapse"><?php echo shop_lang('shop:products:visibility');?></th>
						<th class="collapse"><?php echo shop_lang('shop:products:category'); ?></th>
						<th class="collapse"><?php echo shop_lang('shop:products:price'); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($products as $product) : ?>
						<tr class="<?php echo alternator('even', ''); ?>">
							
							<td>	
								<?php echo form_checkbox('action_to[]', $product->id); ?>
							</td>
							<td>	
								<?php echo $product->id; ?>
							</td>							
							<td>
								<?php if ($product->public==0):?> 
								<?php $_hclass = "_hidden";?>
								<?php else:?> 
								<?php $_hclass = "";?>
								<?php endif;?> 
								
								<?php if ($product->cover_id): ?>
									<img src="files/thumb/<?php echo $product->cover_id;?>/50/50" alt="" class="<?php echo $_hclass;?>"  id="sf_img_<?php echo $product->id;?>" />
								<?php else: ?>
									<div class="img_48 img_noimg"></div>
								<?php endif; ?>

							</td>							
							<td><?php echo anchor('shop/product/'.$product->slug,$product->name, 'target="_blank" class="category"'); ?></td>
							<td class="collapse">

								<?php echo $product->_inventory_data; ?>

							</td>
							<td class="collapse">
							 		<?php if ($product->public == 1):?> 
									<a href="javascript:sell(<?php echo $product->id;?>)" class="tooltip-s img_icon img_visible " title="<?php echo shop_lang('shop:products:click_to_change');?>" status="1" pid="<?php echo $product->id;?>" id="sf_ss_<?php echo $product->id;?>"></a>	
									<?php else:?>
									<a href="javascript:sell(<?php echo $product->id;?>)" class="tooltip-s img_icon img_invisible "  title="<?php echo shop_lang('shop:products:click_to_change');?>" status="0" pid="<?php echo $product->id;?>" id="sf_ss_<?php echo $product->id;?>"></a>		
									<?php endif;?>
							</td>
							<td class="collapse">
						
								<?php echo $product->_category_data ;?>

							</td>
							

							<td class="collapse">

								<?php echo $product->_price_data;?>
									
							</td>


							<td>
								<span style="float:right;">

									<?php $this->load->view('shop/admin/fragments/products_list_dropdown', array('id' => $product->id) ); ?>

								</span>
								
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="9">



							<div class="inner" style="float:none;">
								
								
									<span style="padding-bottom:0px;bottom:0;vertical-align:top;">

										<?php echo form_dropdown('multi_edit_option', array(

																						'noaction' => shop_lang('shop:products:take_no_action'), 
																						'delete' => shop_lang('shop:products:delete_selected_products'),
																						'invisible' => shop_lang('shop:products:make_all_invisible'),
																						'visible' =>  shop_lang('shop:products:make_all_visible') )

																	,"style='vertical-align:top;'");
																?>

										<button class="shopbutton button-rounded green" value="multi_edit_option" name="btnAction" type="submit" style="vertical-align:top;">go</button>

									</span>
							
							</div>			

							<div class="inner" style="float:none;">
									<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
							</div>			
						
						</td>
					</tr>
				</tfoot>				
			</table>


<style>

</style>
