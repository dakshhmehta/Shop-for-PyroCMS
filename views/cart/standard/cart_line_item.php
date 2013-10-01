			<?php 
			
				$i = 1;  
			
				foreach ($this->sfcart->contents() as $items): ?>
			
				<?php echo form_hidden($i .'[rowid]', $items['rowid']); ?>
				<?php echo form_hidden($i .'[id]', $items['id']); ?>
				<?php echo form_hidden($i .'[price]', $items['price']); ?>
				<?php echo form_hidden($i .'[base]', $items['base']); ?>
				
				<tr>
					<td>
						<a href="{{url:site}}shop/product/<?php echo $items['slug'];?>">
							<?php echo sf_get_product_cover($items['id']) ;?>
						</a>
					</td>
					<td>
					
						<a href="{{url:site}}shop/product/<?php echo $items['slug'];?>">
						
					
							<?php echo $items['name'];  
							
							if ($items['base'] > 0 ) 
							{
								echo ' @ '.nc_format_price($items['price']) . ' &plus; ' . nc_format_price( $items['base'] );
								echo ' base cost';
							}
							
							?> 
						</a>
						<?php $options = $items['options'] ; if ($options !=NULL):?>
						<ul>
						<?php foreach ($options as $key => $option):?>
								<li>
									<a href="{{url:site}}shop/product/<?php echo $items['slug'];?>">
										<?php echo $options[$key]['name']; ?> : <?php echo $options[$key]['value'];?>
									</a>
								</li>
						<?php endforeach; ?>
						</ul>
						<?php endif; ?>
					</td>
					<td>
						<span><?php echo nc_format_price($items['price']); ?></span>
					</td>
					<td>
						 <?php
							echo form_input(array(
								'name' => $i.'[qty]',
								'value' => $items['qty'],
								'maxlength' => '3',
								'class' => '',
								'size' => '4'));
							?>
					</td>
					<td>
						<span><?php echo nc_format_price(($items['subtotal'])); ?></span> *
					</td>
					<td>
						<a href="{{ url:site }}shop/cart/delete/<?php echo $items['rowid']; ?>">&times;</a>
					</td>					
				</tr>

			<?php $i++; endforeach; ?>		
