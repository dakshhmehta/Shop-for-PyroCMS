

<section class="title">

	<h4><?php echo lang('shop:products:products');?></h4>
	
	<span style="float:right;">
	
		<?php //if ($products) : ?>
		<a id="flink" href="javascript:toggle_filter()" class='tooltip-s img_icon_title img_filter' title='<?php echo lang('shop:products:filter');?>'></a>
		<?php //endif; ?>
		<a href="admin/shop/product/create" class='tooltip-s img_icon_title img_create' title='<?php echo lang('shop:products:new');?>'></a>
		
	</span>
	
</section>

<section class="item">

	<div class="content">
	
		<?php $this->load->view('admin/products/filter'); ?>
	
		<?php if ($products) : ?>

			<div style="clear:both"></div>

			<?php echo form_open('admin/shop/products/action'); ?>

							
								<table>

									<thead>		
										<tr>
											<th class="collapse"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
											<th class="collapse"><?php echo lang('shop:common:id');?></th>
											<th class="collapse"><?php echo lang('shop:common:image');?></th>
											<th class="collapse"><?php echo lang('shop:common:name');?></th>
											<th class="collapse"><?php echo lang('shop:products:on_hand');?></th>
											<th class="collapse"><?php echo lang('shop:products:visibility');?></th>
											<th class="collapse"><?php echo lang('shop:products:category'); ?></th>
											<th class="collapse"><?php echo lang('shop:products:custom_field'); ?></th>
											<th class="collapse"><?php echo lang('shop:products:price'); ?></th>

											<th></th>
										</tr>
									</thead>
									<tbody id="filter-stage">
										
									
									</tbody>
									<?php $this->load->view('admin/products/products_multi_update'); ?>


							</table>
					
							
				
			<?php echo form_close(); ?>

		<?php else : ?>
		
			<div class="no_data">
				<p></p>
				<?php echo lang('shop:products:no_data');?>
			</div>
			
		<?php endif; ?>

	</div>
	
</section>


