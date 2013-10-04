
<?php if ($cart): ?>

	<div id="cart-widget"  onclick="sf_show_minicart()">
		
		<a class="cart-w-btn">
			Your Cart
		</a>
		
		<span>
				Items: {{ shop:total cart="items" }}
				Sub-Total :<?php  echo nc_format_price($total_cost); /*{{ shop:total cart="sub-total" }}*/ ?>
		</span>
		
		<ul id="mini-cart" style="display:none;">
		
			 <?php foreach ($cart as $item): ?>
			 
				<li class='cart-item'>

					<a href="<?php echo site_url('shop/product/' . $item['slug']); ?>">
						<?php echo sf_get_product_cover( $item['id'] ,50,50 ); ?>
						<?php echo $item['qty'].'&times;'; ?> <?php echo $item['name']; ?>
					</a>
					<span class="quantity">
						<span class="price"><?php echo nc_format_price($item['price']);?></span>
					</span>		
					
				</li>
				
			<?php endforeach; ?>
			

		  <li class="buttons">
		  
			<a class="cart" href="{{ url:site }}shop/cart">
				<?php echo lang('shop:show_cart');?> 
			</a>
			
			<a class="checkout" href="{{ url:site }}shop/checkout">
			  Checkout &rarr;
			</a>
			
		  </li>	

		</ul>
	</div>
	
<?php endif; ?>


