<!--- FILE.START:VIEW.PRODUCTS.STANDARD.SINGLE.PHP --->
<div itemscope itemtype="http://schema.org/Product">

	<?php echo form_open('shop/cart/add'); ?>
	<?php echo form_hidden('id', $product->id); ?>
	
			<!-- Product Detail -->
			<article>
			
			
				<div>
					<label>
						<?php echo lang('name'); ?>
					</label>
					<small>
						<h2><span itemprop="name"><?php echo $product->name; ?></span></h2>
					</small>
				</div>
				
				
				<div>
					<label>
						<?php echo lang('details'); ?>
					</label>
					<small>
						<span><?php echo $product->short_desc;?></span>
					</small>
				</div>				
				
				
				
				<?php  if ( $product->brand != NULL): ?>
				<div>
					<label>
						<?php echo lang('brand'); ?>
					</label>
					<small>
						<div itemprop="brand" itemscope itemtype="http://schema.org/Organization">
							<span itemprop="name"><?php echo $product->brand->name;?></span>
						</div>
					</small>
				</div>				
				<?php endif; ?>

				
				<div>
					<label>
						<?php echo lang('category'); ?>
					</label>
					<small>
						<span><?php echo anchor('shop/category/'.$product->category->slug, $product->category->name); ?></span>
					</small>
				</div>			
				
				
				<div>
					<label>
						<?php echo lang('status'); ?>
					</label>
					<small>
						<span><?php echo lang('stock_status_' .  $product->status) ?></span>
					</small>
				</div>			
				
				
				<?php if (($product->inventory_on_hand <= $product->inventory_low_qty) && ($product->status=='in_stock')):?>
				<div>
					<label>
						<?php echo lang('info_alert'); ?>
					</label>
					<small>
						<span><?php echo lang('info_almost_gone'); ?></span>
					</small>
				</div>			
				<?php endif; ?>	
				
				
				
				<?php if ($display_views):?>
				<div>
					<label>
						<?php echo lang('views'); ?>
					</label>
					<small>
						<span><?php echo $product->views; ?></span>
					</small>
				</div>	
				<?php endif; ?>
				

				
				{{ shop:options id="<?php echo $product->id;?>"  txtBoxClass="txtForms" }}	
					<div style="margin-top:10px;">
						<label>{{ title }}</label>
						
						{{ if has_values }}							
							{{ values}}
								{{display}}{{label}}<br />
							{{/values}}
								
						{{ else }}
								
							{{display}}
									
						{{ endif }}
								
						<br />

					</div>
				{{ /shop:options }}
				
				
				
				

				<div>
					<label>
						<?php /* show from or price */ ?>
						<?php if($product->price_base > 0): ?>
							<?php echo lang('from'); ?>
						<?php else: ?>	
							
						<?php endif; ?>	
					</label>
					<small itemprop="offers" itemscope itemtype="http://schema.org/Offer">
						<span itemprop="price"><?php echo nc_format_price($product->price + $product->price_base); ?></span>
						<meta itemprop="priceCurrency" content="<?php echo Settings::get('nc_currency_code');?>" />
					</small>
				</div>	

				
				
				<?php if($product->rrp > ($product->price + $product->price_base) ): ?>
				<div>
					<label>
						<?php /* show from or price */ ?>
						<?php if($product->price_base > 0): ?>
							<?php echo lang('from'); ?>
						<?php else: ?>	
						<?php endif; ?>	
					</label>
					<small itemprop="offers" itemscope itemtype="http://schema.org/Offer">
						<em><span itemprop="price"><?php echo lang('rrp'); ?><?php echo nc_format_price($product->rrp); ?></span></em>
					</small>
				</div>	
				<?php endif; ?>
				
				
				
				
				<?php  if ($product->status == 'in_stock'):?>
				<div>
					<label>
					</label>
					<small>
						<span><input name="quantity" id="quantity" data-max="0" data-min="" maxlength="12" size="4" title="Qty" value="1" /></span>
					</small>
				</div>	
				<?php endif; ?>			


				
				<?php  if ($product->status == 'in_stock'):?>
				<div>
					<label>
					</label>
					<small>
						<span><input type="submit" value='<?php echo lang('add_to_cart');?>' /> </span>
					</small>
				</div>	
				<?php endif; ?>					
				
				
				
				<div>
					<label>
					</label>
					<small>
						<span>
							<a href="{{ url:site }}shop/my/wishlist/add/{{ product:id }}" >
							<input type='button' value='<?php echo lang('add_to_wishlist'); ?>' />
							</a>
						</span>
					</small>
				</div>

				<?php if($product->description != ""):?>
				<div>
					<label>
						<?php echo lang('product_description'); ?>
					</label>
					<small>
						<span itemprop="description">
							<?php echo $product->description;?>
						</span>
					</small>
				</div>
				<?php endif;?>
				
				
				<?php if ($product->keywords != null): ?>
				<div>
					<label>
						<?php echo lang('tags'); ?> :
					</label>
					<small>
						<span>
							<?php foreach ($product->keywords as $keyword): ?>
								<?php echo $keyword;?>
							<?php endforeach; ?>
						</span>
					</small>
				</div>
				<?php endif;?>
				
				
				<div>
					<label>
						<?php echo lang('properties'); ?> :
					</label>
					<small>
						<span>
							<?php foreach ($product->properties as $atr): ?>
									<?php echo $atr->name; ?> :
									<?php echo $atr->value; ?><br />
							<?php endforeach; ?>
						</span>
					</small>
				</div>

				<?php if($product->code != ""):?>
				<div>
					<label>
						<?php echo lang('product_code'); ?>
					</label>
					<small>
						<span>
							<span itemprop="sku"><?php echo $product->code; ?></span>
						</span>
					</small>
				</div>
				<?php endif;?>
				

			</article>
			<!-- /End of Product Detail -->
			
			<!-- Start Product Images -->
			<div>
				<ul>
					<?php foreach ($product->images as $img): ?>
					
						<li><img itemprop="image" src="{{ url:site }}files/thumb/<?php echo $img->file_id; ?>/285/" alt="" /></li>
							
					<?php endforeach; ?>
				</ul>
			</div>
			<!-- /End Product Images -->
			

</div>
<?php echo form_close(); ?>

<!--- FILE.END:VIEW.PRODUCTS.STANDARD.SINGLE.PHP --->