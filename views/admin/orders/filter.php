
	<fieldset id="filters">	
			
		<legend></legend>

		<?php echo form_open('admin/shop/orders'); ?>

		<?php echo form_hidden('f_module', $module_details['slug']); ?>
		<ul>  
			<li>
				
				<?php echo lang('shop:status:status');?>

				<br />
				<span style="vertical-align:top">
				<?php echo form_dropdown('f_order_status',  array(
						
						
					'all'=> lang('shop:status:status_all'),
					'all_closed'=>  lang('shop:status:status_all_closed'),
					'all_open'=>  lang('shop:status:status_all_open'),
					'placed'=>  lang('shop:status:placed'),
					'pending'=>  lang('shop:status:pending'),
					'paid'=>  lang('shop:status:paid'),
					'complete'=>  lang('shop:status:complete'),
					'processing'=>  lang('shop:status:processing'),
					'shipped'=>   lang('shop:status:shipped'),
					'returned'=>  lang('shop:status:returned'),
					'cancelled'=>   lang('shop:status:cancelled'),
					'closed'=>   lang('shop:status:closed'),
					
					 ),$curr_status_filter," style='vertical-align:bottom'"); 

				?>
				<button style='vertical-align:top' type="submit" value="" class="btn green"> <?php echo lang('shop:orders:filter');?></button>
				</span>
			</li>						
		</ul>
		<?php echo form_close(); ?>
	</fieldset>
