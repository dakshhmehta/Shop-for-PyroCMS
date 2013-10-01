<!--- FILE.START:VIEW.ADMIN.PRODUCTS.LINE_ITEM -->
			<table>
				<thead>		
					<tr>
						<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
						<th><?php echo lang('id');?></th>
						<th><?php echo lang('image');?></th>
						<th><?php echo lang('product_name'); ?></th>
						<th class="collapse"><?php echo lang('on_hand');?></th>
						<th class="collapse"><?php echo lang('visibility');?></th>
						<th class="collapse"><?php echo lang('category'); ?></th>
						<th class="collapse"><?php echo lang('date'); ?></th>
						<th class="collapse"><?php echo lang('price'); ?></th>
						<th width="220"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($products as $post) : ?>
						<tr class="<?php echo alternator('even', ''); ?>">
							
							<td>	
								<?php echo form_checkbox('action_to[]', $post->id); ?>
							</td>
							<td>	
								<?php echo $post->id; ?>
							</td>							
							<td>
								<?php if ($post->public==0):?> 
								<?php $_hclass = "_hidden";?>
								<?php else:?> 
								<?php $_hclass = "";?>
								<?php endif;?> 
								
								<?php if ($post->cover_id): ?>
									<img src="files/thumb/<?php echo $post->cover_id;?>/50/50" alt="" class="<?php echo $_hclass;?>"  id="sf_img_<?php echo $post->id;?>" />
								<?php else: ?>
									<div class="img_48 img_noimg"></div>
									<?php //echo $post->cover_id ;?>
								<?php endif; ?>

							</td>							
							<td><?php echo anchor('shop/product/'.$post->slug,$post->name, 'target="_blank" class="category"'); ?></td>
							<td class="collapse">
								<?php 
									if($post->inventory_type == 1)
									{
										echo "UNLIMITED"; 
									}
									else
									{
										echo $post->inventory_on_hand; 
									}
									
								
								?>
							</td>
							<td class="collapse">
							 		<?php if ($post->public == 1):?> 
									<a href="javascript:sell(<?php echo $post->id;?>)" class="tooltip-s img_icon img_visible " title="<?php echo lang('click_to_change');?>" status="1" pid="<?php echo $post->id;?>" id="sf_ss_<?php echo $post->id;?>"></a>	
									<?php else:?>
									<a href="javascript:sell(<?php echo $post->id;?>)" class="tooltip-s img_icon img_invisible "  title="<?php echo lang('click_to_change');?>" status="0" pid="<?php echo $post->id;?>" id="sf_ss_<?php echo $post->id;?>"></a>		
									<?php endif;?>
							</td>
							<td class="collapse"><a href="admin/shop/categories/edit/<?php echo $post->category_id; ?>" class="category"><?php echo $post->category_name; ?></a></td>
							<td class="collapse"><?php echo nc_format_date($post->date_created); ?></td>
							<td class="collapse"><?php echo nc_format_price($post->price); ?></td>
							<td>
								<span style="float:right">
								<?php echo anchor('admin/shop/products/edit/' . $post->id, ' ', array('title'=>'Edit', 'class'=>'img_icon img_edit tooltip-s')); ?>
								<?php echo anchor('admin/shop/products/duplicate/' . $post->id, ' ', array('title'=>'Duplicate', 'class'=>'img_icon img_copy tooltip-s')); ?>
								<?php echo anchor('admin/shop/products/delete/' . $post->id, ' ', array('title'=>'Delete', 'class'=>'img_icon img_delete confirm tooltip-s')); ?>
								</span>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="10">
							<div class="inner" style="float:left;">
								<ul>
									<li>
										<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
									</li>
								</ul>
							</div>
						</td>
					</tr>
				</tfoot>				
			</table>
<!--- FILE.END:VIEW.ADMIN.PRODUCTS.LINE_ITEM -->			