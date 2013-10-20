

<section class="title">

	<h4><?php echo shop_lang('shop:products:products');?></h4>
	
	<span style="float:right;">
	
		<?php //if ($products) : ?>
		<a id="flink" href="javascript:toggle_filter()" class='tooltip-s img_icon_title img_filter' title='<?php echo shop_lang('shop:products:filter');?>'></a>
		<?php //endif; ?>
		<a href="admin/shop/product/create" class='tooltip-s img_icon_title img_create' title='<?php echo shop_lang('shop:products:new');?>'></a>
		
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
				<?php echo shop_lang('shop:products:no_data');?>
			</div>
			
		<?php endif; ?>

	</div>
	
</section>

<script>

</script>


<script>
	qm_create(0,{showDelay:200,hideDelay:200,interaction:'hover',cnGlobalApplySubsLev2Plus:['qm-flush-top','qm-match-parent-sub-height'],autoResize:false});
</script>
