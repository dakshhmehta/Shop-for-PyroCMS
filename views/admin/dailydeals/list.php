

<section class="title">

	<h4><?php echo shop_lang('shop:dailydeals:daily_deals');?></h4>
	<span style="float:right;">		
	</span>
	
</section>

<section class="item">

	<div class="content">
	
	
		<?php if ($products) : ?>

			<div style="clear:both"></div>

			<?php echo form_open('admin/shop/dailydeals/action'); ?>
			
				<div id="" class="">

						<?php $this->load->view('admin/dailydeals/line_item'); ?>

				</div>
				
			<?php echo form_close(); ?>

		<?php else : ?>
		
			<div class="no_data">
				<p></p>
				<?php echo shop_lang('shop:dailydeals:you_have_no_deals_available');?>
			</div>
			
		<?php endif; ?>

	</div>
	
</section>


