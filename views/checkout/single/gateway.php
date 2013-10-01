<div class="wpanel">
	<h2 id="nc-view-title"></h2>
	<div class="shop-container">
		<p><?php echo lang('order_placed_please_pay'); ?></p>
		<?php $this->load->file($gateway->display); ?>
		<p>
			<a href="{{ url:site }}shop"><?php echo lang('back_to_shop'); ?></a>
		</p>
	</div>
</div>