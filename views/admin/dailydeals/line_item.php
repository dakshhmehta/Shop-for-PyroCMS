



			<table>

				<thead>		
					<tr>
						<th class="collapse"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
						<th class="collapse"><?php echo lang('shop:dailydeals:id');?></th>
						<th class="collapse"><?php echo lang('shop:dailydeals:image');?></th>
						<th class="collapse"><?php echo lang('shop:dailydeals:name');?></th>
						<th class="collapse"><?php echo lang('shop:dailydeals:status');?></th>
						<th class="collapse"><?php echo lang('shop:dailydeals:stock_status');?></th>	
						<th class="collapse"><?php echo lang('shop:dailydeals:price');?></th>												
						<th class="collapse"><?php echo lang('shop:dailydeals:mode');?></th>
						<th class="collapse"><?php echo lang('shop:dailydeals:shares'); ?></th>
						<th class="collapse"><?php echo lang('shop:dailydeals:likes'); ?></th>
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
			</table>

