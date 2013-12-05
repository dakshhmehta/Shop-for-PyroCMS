
<div class='item' id="filters_group" style="">

	<fieldset id="filters" style="display:block;">
		<div class='item' id="hideable_filters" style="display:none;">
		
			<?php echo form_open('admin/shop/products/callback'); ?>
			<?php echo form_hidden('f_module', $module_details['slug']); ?>
			<div class='item one_half' style="float:left;width:auto;">
				<ul> 
				
					<li>
						<label>
							<?php echo lang('shop:products:order_by'); ?>
						</label>
						<div class="input">

							<?php echo form_dropdown('f_order_by',  

									array(
										0=> lang('shop:common:id'),
										1=> lang('shop:common:name'),
										2=> lang('shop:products:category_id'),
										3=> lang('shop:products:id_descending'),
										4=> lang('shop:products:name_descending')
										),$order_by ); ?>
						</div>
					</li>				
					<li>
						<label>
							<?php echo lang('shop:products:items_per_page'); ?>
						</label>
						<div class="input">
							<?php echo form_dropdown('f_items_per_page', array(5=>"5", 10=>"10", 20=>"20", 50=>"50", 100=>"100", 200=>"200"), $limit); ?>
						</div>
					</li>
					<li>
						<label>
							<?php echo lang('shop:products:custom_field'); ?>
						</label>
						<div class="input">

							<?php echo form_dropdown('f_dynamic_field',  

									array(
										'page_design_layout'=> lang('shop:products:page_design_layout'),
										'date_created'=> lang('shop:products:date_created'),
										),$f_dynamic_field ); ?>


						</div>
					</li>
					
				</ul>
			</div>

			<div class='item one_half last' style="float:left;width:auto;">
				<ul>  
					<li>
						<label>
							<?php echo lang('shop:common:category'); ?>
						</label>
						<div class="input">


								<?php echo $categories; ?> 
	
						</div>

					</li>
					<li>
						<label>
							<?php echo lang('shop:products:visibility'); ?>
						</label>
						<div class="input">
							<?php echo form_dropdown('f_visibility',  array(0 => lang('global:select-all'),1=> 'Public',2=> 'Hidden'), $visibility ); ?>
						</div>
					</li>	
				</ul>
			</div>
			<?php echo form_close(); ?>
		</div> 
		<!-- End hideable -->
		<div style="clear:both"></div>
	
		<div class='item one_half last' style="float:left;width:auto;">	
			<?php echo form_open('admin/shop/products/callback'); ?>
			<div class="inner" style="float:right;">
					<ul>
						<li>
							<label>
							</label>
							<div class="input">
								<b><?php echo lang('shop:products:search'); ?></b> : <?php echo form_input('f_keyword_search',  $quick_search, 'style="width:215px;height: 20px; padding: 3px 10px;"'); ?>
							</div>
						</li>
					</ul>
			</div>
		<?php echo form_close(); ?>
		</div>
	</fieldset>
	
</div>