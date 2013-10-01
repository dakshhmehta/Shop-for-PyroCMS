<!--- FILE.START:VIEW.PRODUCTS.SINGLE.PHP --->
<div id="NC_Master" itemscope itemtype="http://schema.org/Product">
	<div id="NC_ProductDetail">	
	<?php echo form_open('shop/cart/add'); ?>
	<?php echo form_hidden('id', $product->id); ?>

		<div class="sidebar">
			<!-- Start Product Images -->
			<div id="image-wrap" class="product-images">
			
					<ul id="carousel">
					
						<?php foreach ($product->images as $img): ?>
								<li data-plusshift-thumbnail="{{ url:site }}files/thumb/<?php echo $img->file_id; ?>/285/">
										<img itemprop="image" src="{{ url:site }}files/large/<?php echo $img->file_id; ?>/285/" alt="" />
								</li>
						<?php endforeach; ?>
					</ul>
			</div>
			<!-- /End Product Images -->
		</div>

			<!-- Product Detail -->
			<article class="product">
			
				<div class="product-wrapper <?php echo ($product->featured)?'featured':'';?>">

					<i class="item_icon"></i>

					<div class="content-group-master">
					
						<div class="content-group">

							<h2>
								<span itemprop="name"><?php echo $product->name; ?></span>
							</h2>
													
							<table>
									<tr>
										<th><?php echo lang('details'); ?></th>
										<td><?php echo $product->short_desc;?></td>
									</tr>	
									
									<?php if ( $product->brand != NULL): ?>
									<tr>
										<th><?php echo lang('brand'); ?></th>
										<td><?php echo $product->brand->name;?></td>
									</tr>									
									<?php  endif; ?>
									
									<tr>
										<th><?php echo lang('category'); ?>:</th>
										<td><?php echo anchor('shop/category/'.$product->category->slug, $product->category->name); ?></td>
								
									</tr>						
									<tr>
										<th><?php echo lang('status');?> :</th>
										<td><?php echo lang('stock_status_' .  $product->status) ?></td>
									</tr>
									
									
									<?php if (($product->inventory_on_hand <= $product->inventory_low_qty) && ($product->status=='in_stock')):?>
									<tr>
										<th><?php echo lang('info_alert'); ?></th>
										<td><?php echo lang('info_almost_gone'); ?></td>
									</tr>	
									<?php endif; ?>							
									<?php if ($display_views):?>
									<tr>
										<th><?php echo lang('views');?> :</th>
										<td><?php echo $product->views; ?></td>
									</tr>			
									<?php endif; ?>

									
									{{ shop:options id="<?php echo $product->id;?>"  txtBoxClass="txtForms" }}	
									<tr>
										<th>{{ title }}</th>
										
										{{ if has_values }}							
											<td>
											{{ values}}
												{{display}} {{label}}<br />
											{{/values}}
											</td>	
										{{ else }}
											<td>	
											{{display}}
											</td>		
										{{ endif }}
												
										<br />

									</tr>
									{{ /shop:options }}
										
							</table>
							
						</div>
						
						
						<div class="content-group">
						

							<em>
								<?php if($product->price_base > 0): ?>
									<?php echo lang('from'); ?>
								<?php else: ?>	
									
								<?php endif; ?>	
							</em>
							
							<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
								<p class='price'>
									<span itemprop="price"><?php echo nc_format_price($product->price + $product->price_base); ?></span>
								</p>
							</div>

							<?php if($product->rrp > ($product->price + $product->price_base) ): ?>
							<em>
									<?php echo lang('rrp'); ?><p class='rrp'><?php echo nc_format_price($product->rrp); ?></p>
							</em>
							<?php endif; ?>
							
						
							<div class="action-buttons">
								<?php  if ($product->status == 'in_stock'):?>
									<input name="quantity" id="quantity" class="input-text qty text" data-max="0" data-min="" maxlength="12" size="4" title="Qty" value="1" />
								<?php endif;?>
								<div class="button-wrapper">

									<?php  if ($product->status == 'in_stock'):?>
									<input class="ncbtn addtocart" type="submit" value='<?php echo lang('add_to_cart');?>' /> 
									<?php endif;?>
									
									<a href="{{ url:site }}shop/my/wishlist/add/{{ product:id }}" >
									<input type='button' class='ncbtn addtowishlist' value='<?php echo lang('add_to_wishlist'); ?>' />
									</a>
								</div>
							</div>
							
						</div>
						<div class="content-group">
						
							<?php if($product->description != ""):?>
						   <h4><?php echo lang('product_description'); ?></h4>
							<table>
									<tr>
										<td>
											<span itemprop="description">
												<?php echo $product->description;?>
											</span>
										</td>
									</tr>	
							</table>
							<?php endif;?>
							
						   <table>
						   
								<?php if ($product->keywords != null): ?>
								<tr>
									<th><?php echo lang('tags'); ?> :</th>
									<td>
										<?php foreach ($product->keywords as $keyword): ?>
											<?php echo $keyword;?>
										<?php endforeach; ?>
									</td>
								</tr>
								<?php endif; ?>
								

								<?php foreach ($product->properties as $atr): ?>
								<tr>
									<th><?php echo $atr->name; ?> :</th>
									<td><?php echo $atr->value; ?></td>
								</tr>
								<?php endforeach; ?>
								
								<?php if($product->code != ""):?>
								<tr>
									<th><?php echo lang('product_code'); ?></th>
									<td><span itemprop="sku"><?php echo $product->code; ?></span></td>
								</tr>
								<?php endif;?>
						   </table>
						</div>
					</div>
			  </div>
			</article>
			<!-- /End of Product Detail -->

</div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
$(window).load(function(){ 

	$('#carousel').plusShift({
		createPagination: true,
		prevText: '',
		nextText: '',
	});
});
</script>
<!--- FILE.END:VIEW.PRODUCTS.SINGLE.PHP --->