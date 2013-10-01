			<?php 
			
				$i = 1;  
			
				foreach ($this->sfcart->contents() as $items): ?>
			
				<?php echo form_hidden($i .'[rowid]', $items['rowid']); ?>
				<?php echo form_hidden($i .'[id]', $items['id']); ?>
				<?php echo form_hidden($i .'[price]', $items['price']); ?>
				<?php echo form_hidden($i .'[base]', $items['base']); ?>
				
				<tr>
					<td class="tcollapse cart-product-thumbnail">
						<a href="{{url:site}}shop/product/<?php echo $items['slug'];?>">
							<?php echo sf_get_product_cover($items['id']) ;?>
						</a>
					</td>
					<td class="cart-product-name ">
					
						<a href="{{url:site}}shop/product/<?php echo $items['slug'];?>">
						
							<span style="float:left">
								<?php echo $items['name'].'</span>';  
							
							if ($items['base'] > 0 ) 
							{
								echo ' <span style="float:left"><em>@ '.nc_format_price($items['price']) . ' &plus; ' . nc_format_price( $items['base'] );
								echo ' base cost</em></span>';
							}
							
							?> 
						</a>
					</td>
					<td class="tcollapse cart-product-price">
						<span class="amount"><?php echo nc_format_price($items['price']); ?></span>
					</td>
					<td class="tcollapse cart-product-quantity">
						<div class="quantity">
						 <?php
							echo form_input(array(
								'name' => $i.'[qty]',
								'value' => $items['qty'],
								'maxlength' => '3', /*letsmake this variable based on user settings*/
								'class' => 'input-text qty text',
								'size' => '4'));
							?>
						</div>
					</td>
					<td class="cart-product-subtotal">
						<span class="amount"><?php echo nc_format_price(($items['subtotal'])); ?></span> *
					</td>
					<td class="cart-product-remove">
						<a class="remove" href="{{ url:site }}shop/cart/delete/<?php echo $items['rowid']; ?>">&times;</a>
					</td>					
				</tr>
				
				<?php $options = $items['options'] ; if ($options !=NULL):?>
				<?php //var_dump($options);?>
				
				<?php foreach ($options as $key => $option):?>
			 
				<tr>
					<td colspan='6' class="cart-product-thumbnail">
						<a href="{{url:site}}shop/product/<?php echo $items['slug'];?>">
							<?php echo $options[$key]['name']; ?> : <?php echo $options[$key]['value'];?>
						</a>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
			<?php $i++; endforeach; ?>		
