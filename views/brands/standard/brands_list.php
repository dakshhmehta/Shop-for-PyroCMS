<!--- FILE.START:VIEW.PRODUCTS.PRODUCTS_LIST --->
<div>
	<div class="error"><?php echo $this->session->flashdata('feedback');?></div>

<?php if (count($brands) == 0): ?>
	<p><?php lang('shop:desc_no_categories'); ?></p>
<?php else: ?>
			
<?php foreach ($brands as $item): ?>
	
	<div>
	 
		<div>
			<a href="{{ url:site }}shop/brand/<?php echo $item->slug; ?>">
				<img src="{{ url:site }}files/thumb/<?php echo $item->image_id; ?>" />
			</a>
		</div>
		
		<div>
			<h2>
				<a href="{{ url:site }}shop/brand/<?php echo $item->slug; ?>"><?php echo $item->name; ?></a>
			</h2>
		</div>

	  </div>
<?php endforeach; ?>
<?php endif; ?>
</div>
<!--- FILE.END:VIEW.PRODUCTS.PRODUCTS_LIST --->