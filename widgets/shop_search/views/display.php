<?php if($enabled) : ?>

<?php echo form_open('shop/search/'); ?>

		<input type="text" id="shop_search_box" name="shop_search_box" />
		<input type="submit" name="submit" value="<?php echo lang('shop:search:search');?>"  />

<?php echo form_close(); ?>	

<?php endif; ?>
