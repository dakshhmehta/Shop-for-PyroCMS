								

		<span class="button-dropdown" data-buttons="dropdown">
		
			<a href="#" class="shopbutton button-rounded button-flat-primary"> 
				<?php echo lang('shop:products:actions');?> 
				<i class="icon-caret-down"></i>
			</a>
			 
			<!-- Dropdown Below Button -->
			<ul class="button-dropdown">

				<li class=''><a href="<?php echo 'admin/shop/product/edit/' . $id;?>" class=""><i class="icon-edit"></i> <?php echo lang('shop:common:edit');?></a></li>
				<li class=''><a href="<?php echo 'admin/shop/product/duplicate/' . $id;?>" class=""><i class="icon-copy"></i> <?php echo lang('shop:common:copy');?></a></li>
				<li class='button-dropdown-divider delete'><a href="<?php echo 'admin/shop/product/delete/' . $id;?>" class="confirm"><i class="icon-minus"></i> <?php echo lang('shop:common:delete');?></a></li>
					 
			</ul>

		</span>