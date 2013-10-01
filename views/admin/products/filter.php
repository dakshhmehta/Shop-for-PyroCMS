<!--- FILE.START:VIEW.ADMIN.PRODUCTS.FILTER -->
<div class='item' id="filters_group" style="">
	<fieldset id="filters" style="display:block;">
		<div class='item' id="hideable_filters" style="display:none;">
		
			<?php echo form_open('admin/shop/products/callback'); ?>
			<?php echo form_hidden('f_module', $module_details['slug']); ?>
			<div class='item one_half' style="float:left;width:auto;">
				<ul> 
				
					<li>
						<?php echo lang('order_by', 'f_order_by'); ?><br />
						<?php echo form_dropdown('f_order_by',  array(0=> lang('id'),1=> lang('name'),2=> lang('category'),3=> 'ID Descending', 4=> 'Name Descending'),$order_by ); ?>
					</li>				
					<li>
						<?php echo lang('per_page', 'f_items_per_page'); ?><br />
						<?php echo form_dropdown('f_items_per_page', array(5=>"5", 10=>"10", 20=>"20", 50=>"50", 100=>"100", 200=>"200"), $limit); ?>
					</li>

					
				</ul>
			</div>

			<div class='item one_half last' style="float:left;width:auto;">
				<ul>  
					<li>
						<?php echo lang('category', 'f_category'); ?><br />
					
							<select name="f_category" id="f_category">
								<option value="0"><?php echo lang('global:select-pick'); ?></option>
								<?php echo $categories; ?> 
							</select>

					</li>
					<li>
						<?php echo lang('visibility', 'f_visibility'); ?><br />
						<?php echo form_dropdown('f_visibility',  array(0 => lang('global:select-all'),1=> 'Public',2=> 'Hidden'), $visibility ); ?>
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
							<?php echo lang('quick_search', 'f_keyword_search'); ?><br />
							<?php echo form_input('f_keyword_search',  $quick_search, 'style="width:215px;height: 20px; padding: 3px 10px;"'); ?>
						</li>
					</ul>
			</div>
		<?php echo form_close(); ?>
		</div>
	</fieldset>
	
</div>
<!--- FILE.END:VIEW.ADMIN.PRODUCTS.FILTER -->