



			<table>

				<thead>		
					<tr>
						<th class="collapse"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
						<th class="collapse"><?php echo shop_lang('shop:dailydeals:id');?></th>
						<th class="collapse"><?php echo shop_lang('shop:dailydeals:image');?></th>
						<th class="collapse"><?php echo shop_lang('shop:dailydeals:name');?></th>
						<th class="collapse"><?php echo shop_lang('shop:dailydeals:status');?></th>
						<th class="collapse"><?php echo shop_lang('shop:dailydeals:stock_status');?></th>	
						<th class="collapse"><?php echo shop_lang('shop:dailydeals:price');?></th>												
						<th class="collapse"><?php echo shop_lang('shop:dailydeals:mode');?></th>
						<th class="collapse"><?php echo shop_lang('shop:dailydeals:shares'); ?></th>
						<th class="collapse"><?php echo shop_lang('shop:dailydeals:likes'); ?></th>
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


							<td class="collapse">
								<?php if ($product->cover_id): ?>
									<img src="files/thumb/<?php echo $product->cover_id;?>/50/50" alt="" class=""  id="sf_img_<?php echo $product->id;?>" />
								<?php else: ?>
									<div class="img_48 img_noimg"></div>
								<?php endif; ?>									
							</td>							

							<td class="collapse">
								<?php echo $product->name;?>
							</td>



							<td class="collapse">
								<div class='s_status s_<?php echo $product->status;?>'>
									<?php echo $product->status;?>
								</div>
							</td>							

							<td class="collapse">
								<?php echo $product->stock_status;?>
							</td>	

							<td class="collapse">
								<?php echo $product->price;?>
							</td>		

							<td class="collapse">
								<?php echo $product->mode;?>
							</td>

							<td class="collapse">
								<?php echo $product->shares;?>
							</td>							

							<td class="collapse">
								<?php echo $product->likes;?>
							</td>


							<td>
								<span style="float:right;">

									<?php $this->load->view('shop/admin/fragments/dailydeals_list_dropdown', array('id' => $product->id) ); ?>

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

																						'noaction' => shop_lang('shop:dailydeals:take_no_action'), 
																						'archive' => shop_lang('shop:dailydeals:archive'), 
																					 )

																	,"style='vertical-align:top;'");
																?>

										<button class="shopbutton button-rounded green" value="multi_edit_option" name="btnAction" type="submit" style="vertical-align:top;">go</button>
										<a class="shopbutton button-rounded button-flat-primary"  style="vertical-align:top;" href="#">View deal</a>

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
