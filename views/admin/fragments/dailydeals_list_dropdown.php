								

		<span class="button-dropdown" data-buttons="dropdown">
		
			<a href="#" class="shopbutton button-rounded button-flat-primary"> 
				<?php echo shop_lang('shop:dailydeals:actions');?> 
				<i class="icon-caret-down"></i>
			</a>
			 
			<!-- Dropdown Below Button -->
			<ul class="button-dropdown">
				<li class=''><a href="<?php echo 'admin/shop/dailydeals/start/' . $id;?>" class=""><i class="icon-star"></i> <?php echo shop_lang('shop:dailydeals:start');?></a></li>
				<li class=''><a href="<?php echo 'admin/shop/dailydeals/activate/' . $id;?>" class=""><i class="icon-refresh"></i> <?php echo shop_lang('shop:dailydeals:activate');?></a></li>				
				<li class='button-dropdown-divider delete'><a href="<?php echo 'admin/shop/dailydeals/stop/' . $id;?>" class="confirm"><i class="icon-minus"></i> <?php echo shop_lang('shop:dailydeals:stop');?></a></li>
				<li class='button-dropdown-divider delete'><a href="<?php echo 'admin/shop/dailydeals/archive/' . $id;?>" class="confirm"><i class="icon-minus"></i> <?php echo shop_lang('shop:dailydeals:archive');?></a></li>				
			</ul>

		</span>