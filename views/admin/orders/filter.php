
	<fieldset id="filters">	
			
		<legend></legend>

		<?php echo form_open('admin/shop/orders'); ?>

		<?php echo form_hidden('f_module', $module_details['slug']); ?>
		<ul>  
			<li>
				Status<br />
				<?php echo form_dropdown('f_order_status',  array(
						
						
					'all'=> shop_lang('shop:orders:status_all' , 'status_'),
					'all_closed'=>  shop_lang('shop:orders:status_all_closed', 'status_'),
					'all_open'=>  shop_lang('shop:orders:status_all_open', 'status_'),
					'placed'=>  shop_lang('shop:orders:status_placed', 'status_'),
					'pending'=>  shop_lang('shop:orders:status_pending', 'status_'),
					'paid'=>  shop_lang('shop:orders:status_paid', 'status_'),
					'complete'=>  shop_lang('shop:orders:status_complete', 'status_'),
					'processing'=>  shop_lang('shop:orders:status_processing', 'status_'),
					'shipped'=>   shop_lang('shop:orders:status_shipped', 'status_'),
					'returned'=>  shop_lang('shop:orders:status_returned', 'status_'),
					'cancelled'=>   shop_lang('shop:orders:status_cancelled', 'status_'),
					'closed'=>   shop_lang('shop:orders:status_closed', 'status_'),
					
					 ),$curr_status_filter); 

				?>
			</li>	
			<li>
				<br />
				<button type="submit" value="Search" class="shopbutton button-rounded button-flat-action"> search</button>
			</li>						
		</ul>
		<?php echo form_close(); ?>
	</fieldset>
