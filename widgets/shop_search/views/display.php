<?php if($enabled) : ?>
<div class="nc_widget">
<?php echo form_open('shop/search/'); ?>
	<span id="SF_Widget">
		<input type="text" id="shop_search_box" name="shop_search_box" />
		<input type="submit" name="submit" value="Search" class="ncbtn" />
	</span>
<?php echo form_close(); ?>	
</div>
<?php endif; ?>
