

				<tr class="<?php echo alternator('even', ''); ?>">
					<td><input type="checkbox" name="action_to[]" value="<?php echo $category->id; ?>"  /></td>
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
							<a class="img_icon img_edit" href="<?php echo site_url('admin/shop/categories/edit/' . $category->id); ?>"> </a>
							<a class="img_icon img_delete confirm" href="<?php echo site_url('admin/shop/categories/delete/' . $category->id); ?>"> </a>	
						</span>
					</td>
				</tr>
