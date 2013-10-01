<!--- FILE.START:VIEW.PRODUCTS.STANDARD.LINE_ITEM -->
<?php foreach ($items as $item): ?>	

		<div itemscope itemtype="http://schema.org/Product">

			<img itemprop="image" src="{{ url:site }}files/thumb/<?php echo $item->cover_id; ?>" />
			
			<a itemprop="url" href="{{ url:site }}shop/product/<?php echo $item->slug; ?>">
			
				<div itemprop="name">
						<?php echo $item->name; ?>
				</div>
			</a>
			
			<div itemprop="description"><?php echo $item->short_desc; ?></div>
						
			<div>
				<?php echo lang('code'); ?> <span itemprop="model"><?php echo $item->code; ?></span>
			</div>
			
			<div>
				<?php echo lang('id'); ?> <span itemprop="productID"><?php echo $item->id; ?></span>
			</div>
			
			<div>
				<?php if($item->price_base > 0): ?>
					<span><?php echo lang('from'); ?></span>
				<?php else: ?>	
					<span><?php echo lang('price'); ?></span>
				<?php endif; ?>	
								
				<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					<span itemprop="price"><?php echo nc_format_price($item->price + $item->price_base); ?></span>
				</div>
			</div>
			
			
			<div>
				<span><?php echo lang('category'); ?></span>
				<a href="{{url:site}}shop/category/<?php echo $item->category_slug;?>"><?php echo $item->category_name;?></a>
			</div>

			<a href="{{ url:site }}shop/my/wishlist/add/<?php echo $item->id; ?>">
				<?php echo lang('add_to_wishlist'); ?>
			</a>
			
			<?php  if ($item->status == 'in_stock'):?>
				<a href="{{ url:site }}shop/cart/add/<?php echo $item->id; ?>" >
					<?php echo lang('add_to_cart'); ?>
				</a>
			<?php  endif; ?>
			
		</div>

<?php endforeach;?>	
<!--- FILE.END:VIEW.PRODUCTS.STANDARD.LINE_ITEM -->