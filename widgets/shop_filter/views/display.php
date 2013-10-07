
<?php echo form_open('shop/products/'); ?>

<div class="">

	<div id="" class="" style="">	

			<?php echo form_hidden('f_module', $module_details['slug']); ?>
			
			<div style="">
				<<?php echo shop_lang('shop:widget:category');?>
				<?php echo form_dropdown('f_category',  $categories, set_value('f_category',$selected_category) ); ?>
			</div>
			<div style="">

				<?php echo shop_lang('shop:widget:order_by');?>
				<?php echo form_dropdown('f_order_by',  array(0=> lang('id'),1=> lang('name'),2=> lang('category')) ); ?>

			</div>
			<div style="">	

				<?php $user_display_qty_filter = (isset($user_display_qty_filter))? $user_display_qty_filter : 5 /*default*/ ;?>
				<?php echo shop_lang('shop:widget:per_page');?>
				<?php echo form_dropdown('f_items_per_page', array(5=>"5", 10=>"10", 20=>"20", 50=>"50"), $user_display_qty_filter ); ?>

			</div>
			<div>	
				<input type="submit" value="<?php echo shop_lang('shop:widget:filter');?>" />
			</div>


	</div>	
</div>		

<?php echo form_close(); ?>
