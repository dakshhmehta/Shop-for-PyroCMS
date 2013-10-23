
<section class="title">
	<h4><?php echo shop_lang('shop:orders:order'); ?> - ( <?php echo shop_lang('shop:orders:account'); ?>: <?php echo  $customer->display_name; ?> )</h4>
	<h4 style="float:right">
		<a href="{{ url:site }}shop/" class='button'><?php echo shop_lang('shop:orders:new'); ?></a>
		<?php echo anchor('admin/shop/orders', shop_lang('shop:orders:view_all'), 'class="button"'); ?>
	</h4>		
</section>
<section class="item">
<div class="content">
<fieldset>
	<div id="order-tab" class="form_inputs">
		<ul>
			<li>
				<label>
					<?php echo shop_lang('shop:orders:order_id'); ?>:
					<small>
						<?php echo shop_lang('shop:orders:order_id_description'); ?>:
					</small>
				</label>
				<div class="value">
					<?php  echo $order->id; ?>
				</div>
			</li>   
			<li>
				<label>
					<?php echo shop_lang('shop:orders:order_status'); ?>:
					<small>
						<?php echo shop_lang('shop:orders:order_status_'.$order->status.'_description'); ?>:
					</small>
				</label>

				<div class="value">
						<?php $class_name = 's_'.$order->status.''; ?>
						<div class='s_status <?php echo $class_name;?>'><?php echo shop_lang('shop:orders:'.$order->status); ?></div>
				</div>
			</li>					  
		 </ul>	
	</div>	
</fieldset>
	<div class="tabs">

		<ul class="tab-menu">

			<?php $this->load->view('admin/orders/partials/tabs'); ?>

		</ul>

		<div id="order-tab" class="form_inputs">
				<?php $this->load->view('admin/orders/partials/details'); ?>
		</div>

		<div id="billing-tab" class="form_inputs">

			<?php $this->load->view('admin/orders/partials/billing'); ?>

		</div>
		
		<div id="delivery-tab" class="form_inputs">

			<?php $this->load->view('admin/orders/partials/shipping'); ?>

		</div>
		
		<div id="contents-tab" class="form_inputs">

			<?php $this->load->view('admin/orders/partials/items'); ?>
		
		</div>


		<div id="message-tab" class="form_inputs">

			<?php $this->load->view('admin/orders/partials/messages'); ?>

		</div>


		<div id="transactions-tab" class="form_inputs">
			<?php $this->load->view('admin/orders/partials/transactions'); ?>
		</div>


		<div id="notes-tab" class="form_inputs">
			
			<?php $this->load->view('admin/orders/partials/notes'); ?>

		</div>		


		<div id="actions-tab" class="form_inputs">
			<?php $this->load->view('admin/orders/partials/actions'); ?>
		</div>		

	</div>
	
</div>
</section>
