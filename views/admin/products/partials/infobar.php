
			




					<span style="float:none;">
					
						<ul>
						

							<li class="<?php echo alternator('', 'even'); ?>">
								<?php if ($public == 1):?>
								<a href="javascript:sell(<?php echo $id;?>)" class="tooltip-s img_icon img_visible " title="<?php echo shop_lang('shop:products:click_to_change');?>" status="1" pid="<?php echo $id;?>" id="sf_ss_<?php echo $id;?>"></a>	
								<?php else:?>
								<a href="javascript:sell(<?php echo $id;?>)" class="tooltip-s img_icon img_invisible "  title="<?php echo shop_lang('shop:products:click_to_change');?>" status="0" pid="<?php echo $id;?>" id="sf_ss_<?php echo $id;?>"></a>
								<?php endif;?>
								<br />
							</li>  	


							<li class="<?php echo alternator('', 'even'); ?>">
								<span class='s_status s_paid'><?php echo shop_lang('shop:products:date_created');?>:<?php echo nc_format_date($date_created,'hms'); ?></span><br />
								<span class='s_status s_pending'><?php echo shop_lang('shop:products:date_updated');?>:<?php echo nc_format_date($date_updated,'hms'); ?></span><br />
							</li>


							<li><?php echo anchor('shop/product/'.$slug, shop_lang('shop:products:view_online') , 'target="_blank" class="nc_links"'); ?></li>				
		
							
							   
						</ul>	

					</span>
	
			