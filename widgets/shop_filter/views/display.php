<!--- FILE.START:VIEW.WIDGETS.FILTER --->
<?php echo form_open('shop/products/'); ?>
<div class="nc_widget">

	<div id="wfilter" class="wpanel filters" style="margin-bottom:5px;padding:15px;">	

			<?php echo form_hidden('f_module', $module_details['slug']); ?>
			
			<div style="float:left">
				<p><?php echo lang('category'); ?>
				<?php echo form_dropdown('f_category',  $categories, set_value('f_category',$selected_category, "style='float:left'") ); ?></p>
			</div>
			<div style="float:left">
				<p><?php echo lang('order_by'); ?>
				<?php echo form_dropdown('f_order_by',  array(0=> lang('id'),1=> lang('name'),2=> lang('category')) , "style='float:left'"); ?></p>
			</div>
			<div style="float:left">	
				<?php $user_display_qty_filter = (isset($user_display_qty_filter))? $user_display_qty_filter : 5 /*default*/ ;?>
				<p><?php echo lang('per_page'); ?>
				<?php echo form_dropdown('f_items_per_page', array(5=>"5", 10=>"10", 20=>"20", 50=>"50"), $user_display_qty_filter, 'style="width:86px;"' ); ?></p>
			</div>
			<div>	
				<input type="submit" value="Filter" class="ncbtn" style="margin-top:5px;"/>
			</div>


	</div>	
</div>		
<?php echo form_close(); ?>
<!--- FILE.END:VIEW.WIDGETS.FILTER --->