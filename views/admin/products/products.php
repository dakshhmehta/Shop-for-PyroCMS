<!--- FILE.START:VIEW.ADMIN.PRODUCTS.PRODUCTS -->
<section class="title">

	<h4><?php echo lang('products'); ?></h4>
	
	<span style="float:right;">
	
		<?php //if ($products) : ?>
		<a id="flink" href="javascript:toggle_filter()" class='tooltip-s img_icon_title img_filter' title='<?php echo lang('filter'); ?>'></a>
		<?php //endif; ?>
		<a href="admin/shop/products/create" class='tooltip-s img_icon_title img_create' title='<?php echo lang('new'); ?>'></a>
		
	</span>
	
</section>

<section class="item">

	<div class="content">
	
		<?php $this->load->view('admin/products/filter'); ?>
	
		<?php if ($products) : ?>

			<div style="clear:both"></div>

			<?php echo form_open('admin/shop/products/action'); ?>
			
				<div id="filter-stage" class="">

						<?php $this->load->view('admin/products/line_item'); ?>

				</div>
				
			<?php echo form_close(); ?>

		<?php else : ?>
		
			<div class="no_data">
				<p></p>
				<?php echo lang('nodata_products'); ?>
			</div>
			
		<?php endif; ?>

	</div>
	
</section>
<!--- FILE.END:VIEW.ADMIN.PRODUCTS.PRODUCTS --->