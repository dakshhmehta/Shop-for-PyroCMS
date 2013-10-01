<!--- FILE.START:VIEW.BRANDS.LEGACY.BRANDS_LIST --->



<div class="products-list">

<div class="error"><?php echo $this->session->flashdata('feedback');?></div>

<?php if (count($brands) == 0): ?>
			<p class='shop_notice'><?php lang('shop:desc_no_categories'); ?></p>
<?php else: ?>
			
<?php foreach ($brands as $item): ?>
	
	<div class="product">
	 
	 <div class="product-inner">
			 
			<div class="product-image">
				<a id="ShopClean" class="ShopClean" href="{{ url:site }}shop/brand/<?php echo $item->slug; ?>">
					<img src="{{ url:site }}files/thumb/<?php echo $item->image_id; ?>/245/" />
				</a>
			</div>
			
			<div class="product-details">
			
				<h2>
					<a id="SF_ProductName" class="ItemName" href="{{ url:site }}shop/brand/<?php echo $item->slug; ?>"><?php echo $item->name; ?></a>
				</h2>

					<ul class="product-spec">
						<li>
							<span class='label'></span>
							<span class=''></span>
							
						</li>
						
					</ul>

			</div>
		  
		</div>
	  </div>
<?php endforeach; ?>
<?php endif; ?>
</div>
<!--- FILE.END:VIEW.BRANDS.LEGACY.BRANDS_LIST --->