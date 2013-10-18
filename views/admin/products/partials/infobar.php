
			
					<span style="float:none;">
					
						<ul>
							<li class="<?php echo alternator('', 'even'); ?>">
								<?php if ($public == 1):?>
								<a href="javascript:sell(<?php echo $id;?>)" class="tooltip-s img_icon img_visible " title="<?php echo shop_lang('shop:products:click_to_change');?>" status="1" pid="<?php echo $id;?>" id="sf_ss_<?php echo $id;?>"></a>	
								<?php else:?>
								<a href="javascript:sell(<?php echo $id;?>)" class="tooltip-s img_icon img_invisible "  title="<?php echo shop_lang('shop:products:click_to_change');?>" status="0" pid="<?php echo $id;?>" id="sf_ss_<?php echo $id;?>"></a>
								<?php endif;?>
							</li>  
							<li><?php echo anchor('shop/product/'.$slug, shop_lang('shop:products:view_online') , 'target="_blank" class="nc_links"'); ?></li>				
							<!--li><php echo anchor('admin/shop/products/view/'.$id, shop_lang('shop:products:view_as_admin') , 'target="_blank" class="nc_links modal"'); ?></li-->
							
							<li class="<?php echo alternator('', 'even'); ?>">
									<?php echo anchor('admin/shop/product/delete/' . $id, shop_lang('shop:products:delete'), array('class'=>'confirm nc_links delete')); ?>
							</li>								   
						</ul>	

					</span>
	
			