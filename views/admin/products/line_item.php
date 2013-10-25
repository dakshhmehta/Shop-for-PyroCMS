
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
								<?php endif; ?>

							</td>							
							<td><?php echo anchor('shop/product/'.$post->slug,$post->name, 'target="_blank" class="category"'); ?></td>
							<td class="collapse">
								<?php 


									if($post->inventory_type == 1)
									{
										$class_name = 's_unlimited';
										$_inv_text = shop_lang('shop:products:unlimited');
									}
									else
									{
										if($post->inventory_on_hand <= $post->inventory_low_qty)
										{
											$class_name = 's_low';
										}
										else
										{
											$class_name = 's_normal';
										}

										$_inv_text =  $post->inventory_on_hand; 
									}

									echo "<div class='s_status $class_name'>$_inv_text</div>";
									
								
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
						
								<?php 

									$cat = ($post->category->parent_id == 0)?$post->category->name :  ss_category_name($post->category->parent_id) . ' &rarr; ' . $post->category->name;

								?>
						
								<?php if($post->category_id > 0) : ?>
								
									
									<?php echo anchor('admin/shop/categories/edit/' . $post->category_id,  $cat , array('class'=>'')); ?>


								<?php endif; ?>

							</td>
							<td class="collapse"><?php echo nc_format_price($post->price); ?></td>
							<td>
								<span style="float:right;">

									<span class="button-dropdown" data-buttons="dropdown">
										<a href="#" class="shopbutton button-rounded button-flat-primary"> 
											<?php echo shop_lang('shop:products:actions');?> 
											<i class="icon-caret-down"></i>
										</a>
										 
										<!-- Dropdown Below Button -->
										<ul class="button-dropdown">

											<li class=''><a href="<?php echo 'admin/shop/product/edit/' . $post->id;?>" class=""><i class="icon-edit"></i> <?php echo shop_lang('shop:products:edit');?></a></li>
											<li class=''><a href="<?php echo 'admin/shop/product/duplicate/' . $post->id;?>" class=""><i class="icon-copy"></i> <?php echo shop_lang('shop:products:copy');?></a></li>
											<li class='button-dropdown-divider delete'><a href="<?php echo 'admin/shop/product/delete/' . $post->id;?>" class="confirm"><i class="icon-minus"></i> <?php echo shop_lang('shop:products:delete');?></a></li>
												 
										</ul>

									</span>

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

										<button class="btn green" value="multi_edit_option" name="btnAction" type="submit" style="vertical-align:top;">go</button>

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
