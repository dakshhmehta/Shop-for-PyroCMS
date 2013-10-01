<!--- FILE.START:VIEW.MY.MYMENU --->
<div id="SF_CustomerPage">
	<div class="wpanel">
		<ul>
			<li><?php echo anchor('shop/my/', lang('dashboard')); ?></li>
			<li><?php echo anchor('shop/my/orders', lang('orders')); ?></li>
			<li><?php echo anchor('shop/my/wishlist', lang('wishlist')); ?></li>
			<li><?php echo anchor('shop/my/messages', lang('messages')); ?></li>
			<li><?php echo anchor('shop/my/addresses', lang('addresses')); ?></li>
			<li><?php echo anchor('shop/my/settings', lang('settings')); ?></li>
			<li><a href="{{ url:site }}shop"><?php echo lang('back_to_shop'); ?></a></li>
		</ul>
	</div>
	<div id="SF_DynamicContentPanel">
	
	</div>
</div>
<!--- FILE.END:VIEW.MY.MYMENU --->