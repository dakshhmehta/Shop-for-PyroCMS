<!--- FILE.START:VIEW.CART.STANDARD.CART --->
<div>

		<?php echo form_open('shop/cart/update'); ?>


		<div>
			<h2><?php echo lang('cart'); ?></h2>
		</div>

	  


		<!-- Start Shopping Cart Table -->
		
		  <table>
		  
			<thead>
			  <tr>
				<th><?php echo lang('image'); ?></th>
				<th><?php echo lang('item'); ?></th>
				<th><?php echo lang('price'); ?></th>
				<th><?php echo lang('qty'); ?></th>
				<th><?php echo lang('subtotal'); ?></th>
				<th></th>				
			  </tr>
			</thead>
			
			<tbody>

			<?php 
			
				//
				// Shopping Cart Line items
				//
				$this->load->view('cart/'.$cart_layout.'/cart_line_item'); 

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
<!--- FILE.END:VIEW.CART.STANDARD.CART --->