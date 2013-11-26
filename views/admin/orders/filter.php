
	<fieldset id="filters">	
			
		<legend></legend>

		<?php echo form_open('admin/shop/orders'); ?>

		<?php echo form_hidden('f_module', $module_details['slug']); ?>
		<ul>  
			<li>
				
				<?php echo lang('shop:orders:status');?>

				<br />
				<span style="vertical-align:top">
				<?php echo form_dropdown('f_order_status',  array(
						
						
					'all'=> lang('shop:orders:status_all' , 'status_'),
					'all_closed'=>  lang('shop:orders:status_all_closed', 'status_'),
					'all_open'=>  lang('shop:orders:status_all_open', 'status_'),
					'placed'=>  lang('shop:orders:status_placed', 'status_'),
					'pending'=>  lang('shop:orders:status_pending', 'status_'),
					'paid'=>  lang('shop:orders:status_paid', 'status_'),
					'complete'=>  lang('shop:orders:status_complete', 'status_'),
					'processing'=>  lang('shop:orders:status_processing', 'status_'),
					'shipped'=>   lang('shop:orders:status_shipped', 'status_'),
					'returned'=>  lang('shop:orders:status_returned', 'status_'),
					'cancelled'=>   lang('shop:orders:status_cancelled', 'status_'),
					'closed'=>   lang('shop:orders:status_closed', 'status_'),
					
					 ),$curr_status_filter," style='vertical-align:bottom'"); 

				?>
				<button style='vertical-align:top' type="submit" value="" class="btn green"> <?php echo lang('shop:orders:filter');?></button>
				</span>
			</li>						
		</ul>
		<?php echo form_close(); ?>
	</fieldset>
