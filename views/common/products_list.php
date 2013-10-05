		<div class="page-title">
			<h2>
			 {{shop_title}}
			</h2>
		</div>


		{{ if pagination:links }} 
		<div>
			<!-- Pagination -->
			<div class='pagination'> 
				{{ pagination:links }}
			</div>
		</div>
		{{ endif }}


		{{products}}

			<div class="product">
		 
				<div class="product-image">
					<a id="" class="" href="{{ url:site }}shop/product/{{slug}}">
						<img src="{{ url:site }}files/thumb/{{cover_id}}/245/" />
					</a>
				</div>
				
				<div class="product-details">
				
					<h2>
						<a id="" class="ItemName" href="{{ url:site }}shop/product/{{slug}}">{{name}}</a>
					</h2>
					
						<ul class="product-spec">

							<li>
								<span class='price-tag'>{{price_at}}</span>
							</li>					
							
							<li class='categories'>
								<span class='label'><?php echo lang('category'); ?></span>
								<a href="{{url:site}}shop/category/{{category_slug}}">{{category_name}}</a>
							</li>
						
							<li class='actions'>
								
								<a class="ncbtn list" href="{{ url:site }}shop/my/wishlist/add/{{id}}">
									<?php echo lang('add_to_wishlist'); ?>
								</a>
			
								<a class="ncbtn atc" href="{{ url:site }}shop/cart/add/{{id}}" >
									<?php echo lang('add_to_cart'); ?>
								</a>
						
							</li>

						</ul>
				</div>

		  	</div>
		{{/products}}

		<div class="products-filter">
			<!-- Pagination -->
			<div class='pagination'> 
				{{ pagination:links }}
			</div>
		</div>

	
