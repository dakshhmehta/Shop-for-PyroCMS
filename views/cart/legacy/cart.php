<!--- FILE.START:VIEW.CART.CART --->
<div id="NC_Master" >
	<div id="NC_Cart" >
	  <?php echo form_open('shop/cart/update'); ?>



  


		<div class="page-title">
			<h2><?php echo lang('cart'); ?>
			  <span>your shopping cart summary</span>
			</h2>
		</div>

	  
	  
	  
	  
	  
		<!-- Cart Info-Bar -->
		<div class="cart-info">
			<div class="item-count">
				<?php echo lang('total_items'); ?>
				<span class="info"><?php echo $this->sfcart->total_items(); ?></span>
			</div>
			<div class="cart-subtotal">
				<?php echo lang('subtotal'); ?>
				<span class="price"><?php echo nc_format_price($this->sfcart->total()); ?></span>
			</div>
		</div>	  
		<!-- END:Cart Info-Bar -->
		
		

	  
	  

		
		<!-- Start Shopping Cart Table -->
		
		  <table id="cart-table" class="cart-table">
		  
			<thead>
			  <tr>
				<th class='tcollapse first'><?php echo lang('image'); ?></th>
				<th><?php echo lang('item'); ?></th>
				<th class='tcollapse'><?php echo lang('price'); ?></th>
				<th class='tcollapse'><?php echo lang('qty'); ?></th>
				<th class=''><?php echo lang('subtotal'); ?></th>
				<th class='last'></th>				
			  </tr>
			</thead>
			
			<tbody>
			
			
			<?php 
				//
				// Shopping Cart Line item
				//
				$this->load->view('cart/'.$cart_layout.'/cart_line_item'); 
			?>
			
			
			<?php 
				//
				// Shopping Cart Action buttons (update, checkout etc)
				//
				$this->load->view('cart/'.$cart_layout.'/cart_actions'); 
			?>


 

			</tbody>
			
		  </table>


		

			<?php 
					//
					// Shopping Cart Totals
					//
					$this->load->view('cart/'.$cart_layout.'/cart_totals'); 
			?>
				


		<?php echo form_close(); ?>
	</div>
</div>
<!--- FILE.END:VIEW.CART.CART --->