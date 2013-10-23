
			<table>
				<thead>
					<tr>
						<td colspan="10">
							<div class="inner" style="float:left;">
									<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>	
							</div>
						</td>
					</tr>
				</thead>		
				<thead>		
					<tr>
						<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
						<th><?php echo shop_lang('shop:products:id');?></th>
						<th><?php echo shop_lang('shop:products:image');?></th>
						<th><?php echo shop_lang('shop:products:name');?></th>
						<th class="collapse"><?php echo shop_lang('shop:products:on_hand');?></th>
						<th width="40" class="collapse"><?php echo shop_lang('shop:products:visibility');?></th>
						<th class="collapse"><?php echo shop_lang('shop:products:category'); ?></th>
						<th class="collapse"><?php echo shop_lang('shop:products:date'); ?></th>
						<th class="collapse"><?php echo shop_lang('shop:products:price'); ?></th>
						<th width="120"></th>
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
									<img data-dropdown="#dropdown-1"  src="files/thumb/<?php echo $post->cover_id;?>/50/50" alt="" class="<?php echo $_hclass;?>"  id="sf_img_<?php echo $post->id;?>" />
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
										echo shop_lang('shop:products:unlimited');
									}
									else
									{
										echo $post->inventory_on_hand; 
									}
									
								
								?>
							</td>
							<td class="collapse">
							 		<?php if ($post->public == 1):?> 
									<a href="javascript:sell(<?php echo $post->id;?>)" class="tooltip-s img_icon img_visible " title="<?php echo shop_lang('shop:products:click_to_change');?>" status="1" pid="<?php echo $post->id;?>" id="sf_ss_<?php echo $post->id;?>"></a>	
									<?php else:?>
									<a href="javascript:sell(<?php echo $post->id;?>)" class="tooltip-s img_icon img_invisible "  title="<?php echo shop_lang('shop:products:click_to_change');?>" status="0" pid="<?php echo $post->id;?>" id="sf_ss_<?php echo $post->id;?>"></a>		
									<?php endif;?>
							</td>
							<td class="collapse">
							<a href="admin/shop/categories/edit/<?php echo $post->category_id; ?>" class="category">

								<?php 
									if($post->category->parent_id == 0)
									{
										$cat = $post->category->name; 
									}
									else
									{
										$cat =  ss_category_name($post->category->parent_id) . ' &rarr; ' . $post->category->name;
									}
								

								?>
							</a>
								<?php if($post->category_id > 0) : ?>
								
									<ul id="qm0" class="qmmc qm-horizontal-c" style="height:auto;width:96px;">
										<li>
											<a  style="z-index:0;"  class="category qmitem-m" href="javascript:void(0);">

												<?php echo $cat;?>

											</a>
											<ul class="qmsub">
												<li>
													<?php echo anchor('admin/shop/categories/edit/' . $post->category_id, 'edit', array('class'=>'category qmitem-s')); ?>

												</li>
											</ul>
										</li>
									</ul>

								<?php endif; ?>

							</td>
							<td class="collapse"><?php echo nc_format_date($post->date_created); ?></td>
							<td class="collapse"><?php echo nc_format_price($post->price); ?></td>
							<td>
								<span style="float:right;">

									<ul id="qm0" class="qmmc qm-horizontal-c" style="height:auto;width:96px;">
										<li>
											<button style="z-index:0;"  class="btn dropdown" onclick="return false;">
												<?php echo shop_lang('shop:products:actions');?>
											</button>
									
											<ul class="qmsub">
												 
												<li><?php echo anchor('admin/shop/product/edit/' . $post->id, shop_lang('shop:products:edit'), array('class'=>'qmitem-s')); ?></li>
												<li><?php echo anchor('admin/shop/product/duplicate/' . $post->id, shop_lang('shop:products:copy'), array('class'=>'qmitem-s')); ?></li>
												<li><span class="qmdivider qmdividerx"></span></li>
												<li><?php echo anchor('admin/shop/product/delete/' . $post->id,  shop_lang('shop:products:delete'), array('class'=>'delete qmitem-s confirm')); ?></li>
												 
											</ul>
										</li>
									</ul>
								</span>
								

								
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="10">
							<div class="inner" style="float:none;">
								
									<div class="buttons">
										<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>

										<span>|||</span>
										<button class="btn blue confirm" value="visible" name="btnAction" type="submit">
											<span>Put Online</span>
										</button>


										<button class="btn orange" value="invisible" name="btnAction" type="submit">
											<span>Put offline</span>
										</button>
								

									</div>
							
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
