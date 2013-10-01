<!--- FILE.START:VIEW.PRODUCTS.LINE_ITEM --->
<?php foreach ($items as $item): ?>	

	<div class="product">
	 
	 <div class="product-inner <?php echo ($item->featured)?'featured':'';?>">
			 
			<div class="product-image">
				<a id="ShopClean" class="ShopClean" href="{{ url:site }}shop/product/<?php echo $item->slug; ?>">
					<img src="{{ url:site }}files/thumb/<?php echo $item->cover_id; ?>/245/" />
				</a>
			</div>
			
			<div class="product-details">
			
				<h2>
					<a id="SF_ProductName" class="ItemName" href="{{ url:site }}shop/product/<?php echo $item->slug; ?>"><?php echo $item->name; ?></a>
				</h2>
				
					<ul class="product-spec">

						<li>
							<?php if($item->price_base > 0): ?>
								<span class='label'><?php echo lang('from'); ?></span>
							<?php else: ?>	
								<span class='label'><?php echo lang('price'); ?></span>
							<?php endif; ?>	
							<span class='<?php echo ($item->featured)?'featured':'';?> price-tag'><?php echo nc_format_price($item->price + $item->price_base); ?></span>
						</li>					
						
						<li class='categories'>
							<span class='label'><?php echo lang('category'); ?></span>
							<a href="{{url:site}}shop/category/<?php echo $item->category_slug;?>"><?php echo $item->category_name;?></a>
						</li>
					

						<?php $show_actions = true; if ($show_actions): ?>
						<li class='actions'>
							
								<a class="ncbtn list" href="{{ url:site }}shop/my/wishlist/add/<?php echo $item->id; ?>">
									<?php echo lang('add_to_wishlist'); ?>
								</a>
								<?php  if ($item->status == 'in_stock'):?>
									<a class="ncbtn atc" href="{{ url:site }}shop/cart/add/<?php echo $item->id; ?>" >
										<?php echo lang('add_to_cart'); ?>
									</a>
								<?php  endif; ?>
						
						</li>
						<?php endif; ?>
						
					</ul>
				

				<div class="product-footer">
				<?php /*
					<time class="datetime" datetime="2012-04-01">About 8 hours ago</time>
					
						<span class=rating>
							<span>&nbsp;</span>
							<span>&nbsp;</span>
							<span>&nbsp;</span>
						</span>
						*/
						?>
					
				</div>
			</div>
		</div>
	  </div>
<?php endforeach;?>	
<!--- FILE.END:VIEW.PRODUCTS.LINE_ITEM --->