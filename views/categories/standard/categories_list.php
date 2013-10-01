<!--- FILE.START:VIEW.CATEGORIES.CATEGORIES_LIST --->
<div>
<div class="error"><?php echo $this->session->flashdata('feedback');?></div>
	<?php if (count($categories) == 0): ?>
				<p><?php lang('no_items'); ?></p>
	<?php else: ?>
		
	<?php foreach ($categories as $item): ?>
		<div>
			<div class="product-image">
				<a href="{{ url:site }}shop/category/<?php echo $item->slug; ?>">
					<img src="{{ url:site }}files/thumb/<?php echo $item->image_id; ?>" />
				</a>
			</div>
			<div>
				<h2>
					<a href="{{ url:site }}shop/category/<?php echo $item->slug; ?>"><?php echo $item->name; ?></a>
				</h2>
			</div>
		
	  </div>
	<?php endforeach; ?>
<?php endif; ?>
</div>
<!--- FILE.END:VIEW.CATEGORIES.CATEGORIES_LIST --->