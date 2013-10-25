<?php


?>

	<span style="float:right;">
		
		<a class="tooltip-s shopbutton button-rounded" href="<?php echo site_url('admin/shop/pgroups/edit/' . $group->id); ?>"><?php echo shop_lang('shop:pgroups:edit');?></a>
	
		<span class="button-dropdown" data-buttons="dropdown">
			<a href="#" class="shopbutton button-rounded button-flat-primary"> 
				<?php echo shop_lang('shop:pgroups:actions');?> 
				<i class="icon-caret-down"></i>
			</a>
			 
			<!-- Dropdown Below Button -->
			<ul class="button-dropdown">

				<li class=''><a class="tooltip-s" href="<?php echo site_url('admin/shop/pgroups/edit/' . $group->id); ?>"><?php echo shop_lang('shop:pgroups:edit');?></a></li>
				<li class='button-dropdown-divider delete'><a class="tooltip-s confirm" href="<?php echo site_url('admin/shop/pgroups/delete/' . $group->id); ?>"><?php echo shop_lang('shop:pgroups:delete');?></a></li>
					 
			</ul>

		</span>