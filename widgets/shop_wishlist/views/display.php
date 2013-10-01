<?php if (count($items)): ?>

	<?php if ($options['display'] == 'list'): ?>
	
		<ul class="wishlist-items">
		
			<?php foreach ($items as $item): ?>
				<li>
					<a href="<?php echo site_url('shop/product/' . $item->slug); ?>">
						<?php echo $item->name; ?>
					</a>
					<?php echo ' - ' . nc_format_price( $item->price_at ); ?> 
				</li>
			<?php endforeach; ?>
		</ul>
		
	<?php else: ?>
	
		<?php foreach ($items as $item): ?>
			<div class="wishlist-item">
				<span class="image"><?php echo $item->cover_id ? img('files/thumb/' . $item->cover_id. '/140/') : ''; ?></span>
				<span class="name"><?php echo anchor('shop/product/' . $item->slug, $item->name); ?></span>
				<span class="price"><?php echo ' - ' . nc_format_price ($item->price_at ); ?> </span>
			</div>
			
		<?php endforeach; ?>
		
	<?php endif; ?>
	
<?php else: ?>
	<p><?php echo lang('no_items'); ?></p>
<?php endif; ?>


<a class="show_wishlist" href="{{ url:site }}shop/my/wishlist"><?php echo lang('goto_wishlist'); ?></a>