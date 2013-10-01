<!--- FILE.START:VIEW.ADMIN.ORDERS.FILTER -->

	<fieldset id="filters">			
		<legend></legend>

		<?php echo form_open('admin/shop/orders'); ?>

		<?php echo form_hidden('f_module', $module_details['slug']); ?>
		<ul>  
			<li>
				Status<br />
				<?php echo form_dropdown('f_order_status',  array(
						
						
					'all'=> lang('all'),
					'all_closed'=> lang('all_closed'),
					'all_open'=> lang('all_open'),
					'placed'=> lang('placed'),
					'pending'=> lang('pending'),
					'paid'=> lang('paid'),
					'processing'=> lang('processing'),
					'shipped'=> lang('shipped'),
					'returned'=> lang('returned'),
					'cancelled'=> lang('cancelled'),
					'closed'=> lang('closed'),
					
					 ),$curr_status_filter); 

				?>
			</li>	
			<li>
				<br /><input type="submit" value="Search">
			</li>						
		</ul>
		<?php echo form_close(); ?>
	</fieldset>

<!--- FILE.END:VIEW.ADMIN.ORDERS.FILTER --->