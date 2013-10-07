<?php if($enabled) : ?>

<?php echo form_open('shop/search/'); ?>
	<span>
		<input type="text" id="shop_search_box" name="shop_search_box" />
		<input type="submit" name="submit" value="<?php echo shop_lang('shop:front:search');?>" class="ncbtn" />
	</span>
<?php echo form_close(); ?>	

<?php endif; ?>
