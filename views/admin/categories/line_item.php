

				<tr class="<?php echo alternator('even', ''); ?>">

					<td><input type="checkbox" name="action_to[]" value="<?php echo $category->id; ?>"  /></td>
					<td><?php echo $category->id; ?></td>
					<td>
						<?php if ($category->image_id > 0): ?>
							<img src="files/thumb/<?php echo $category->image_id;?>/50/50" alt="<?php echo $category->name." (Image)";?>" />
						<?php else: ?>
							<div class="img_noimg"></div>
						<?php endif; ?>
					</td>							
					<td><?php echo $category->name; ?></td>
					<td>
						<span style="float:right;">

							<span class="button-dropdown" data-buttons="dropdown">
							
									<a href="#" class="shopbutton button-rounded button-flat-primary"> 
										<?php echo lang('shop:categories:actions');?> 
										<i class="icon-caret-down"></i>
									</a>
									 
									<!-- Dropdown Below Button -->
									<ul class="button-dropdown">

										<li class=''><a class="" href="<?php echo site_url('admin/shop/categories/edit/' . $category->id); ?>"><?php echo lang('shop:categories:edit');?> </a></li>
										<li class='button-dropdown-divider delete'><a class="confirm" href="<?php echo site_url('admin/shop/categories/delete/' . $category->id); ?>"><?php echo lang('shop:categories:delete');?></a></li>
									</ul>

							</span>

						</span>						
					</td>
				</tr>
