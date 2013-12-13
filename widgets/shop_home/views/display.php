<div class="product_box">
	<span class="sticker"></span>
	<h4><?php echo lang('shop:label:featured'); ?></h4>
	<div class="product_outer">
		<?php
		if(!empty($featured) and !empty($featured['total'])):
			foreach($featured['data'] as $row):
		?>
		<p>
			<span class="product_image">
				<a class="head" href="<?php echo site_url('shop/products/product/'.$row->slug); ?>">
				<img src="<?php echo $no_image; ?>" />
				</a>
			</span>
			<span class="product_info">
				<a class="head" href="<?php echo site_url('shop/products/product/'.$row->slug); ?>"><?php echo $row->name; ?></a>
				<span class="price">
					<?php echo $row->price; ?>
				</span>
				<button class="_addcart" product-value="<?php echo $row->id; ?>"><?php echo lang('shop:label:add'); ?></button>
			</span>
		</p>
		<?php
			endforeach;
		else: ?>
		<div class="fullinfo"><?php echo lang('shop:messages:no_items'); ?></div>
		<?php endif; ?>
	</div>
</div>
<div class="product_box">
	<span class="sticker"></span>
	<h4><?php echo lang('shop:label:recent'); ?></h4>
	<div class="product_outer">
		<?php
		if(!empty($recent) and !empty($recent['total'])):
			foreach($recent['data'] as $row):
		?>
		<p>
			<span class="product_image">
				<a class="head" href="<?php echo site_url('shop/products/product/'.$row->slug); ?>">
				<img src="<?php echo $no_image; ?>" />
				</a>
			</span>
			<span class="product_info">
				<a class="head" href="<?php echo site_url('shop/products/product/'.$row->slug); ?>"><?php echo $row->name; ?></a>
				<span class="price">
					<?php echo $row->price; ?>
				</span>
				<?php if(!empty($row->options)): ?>
				<span class="options"><?php echo lang('other_type'); ?></span>
				<?php endif; ?>
				<button class="_addcart" product-value="<?php echo $row->id; ?>"><?php echo lang('shop:label:add'); ?></button>
			</span>
		</p>
		<?php
			endforeach;
		else: ?>
		<div class="fullinfo"><?php echo lang('shop:messages:no_items'); ?></div>
		<?php endif; ?>
	</div>
</div>
<div class="product_box">
	<span class="sticker"></span>
	<h4><?php echo lang('shop:label:bestsellers'); ?></h4>
	<div class="product_outer">
		<?php
		if(!empty($bestsellers) and !empty($bestsellers['total'])):
			foreach($bestsellers['data'] as $row):
		?>
		<p>
			<span class="product_image">
				<a class="head" href="<?php echo site_url('shop/products/product/'.$row->slug); ?>">
				<img src="<?php echo $no_image; ?>" />
				</a>
			</span>
			<span class="product_info">
				<a class="head" href="<?php echo site_url('shop/products/product/'.$row->slug); ?>"><?php echo $row->name; ?></a>
				<span class="price">
					<?php echo $row->price; ?>
				</span>
				<button class="_addcart" product-value="<?php echo $row->id; ?>"><?php echo lang('shop:label:add'); ?></button>
			</span>
		</p>
		<?php
			endforeach;
		else: ?>
		<div class="fullinfo"><?php echo lang('shop:messages:no_items'); ?></div>
		<?php endif; ?>
	</div>
</div>
<input type="hidden" id="cartShopURL" value="<?php echo site_url();?>" />
<div id="progressCart" style="display: none;">
	<img src="<?php echo $module_path.'img/progress_green.gif';?>"/><br/><?php echo lang('shop:label:inprogress'); ?>
</div>