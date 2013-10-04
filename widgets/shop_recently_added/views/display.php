{{ items }}

	<div class="product">
		 
			<div class="product-image">

				<a href="{{ url:site }}shop/product/{{ slug }}">
					<img src="{{ url:site }}files/thumb/{{ cover_id }}/245/" />
				</a>

			</div>
			
			<div class="product-details">
			
				<h2>
					<a href="{{ url:site }}shop/product/{{ slug }}">{{ name }}</a>
				</h2>

				<div class="product-detail">

					<span class='meta_desc'>
						{{ meta_desc }}
					</span>

					<span class='price-tag'>
						{{shop:pricer price="{{ price_at }}" base="{{ price_base }}" }} 
					</span>
				
				</div>
				
			</div>

	</div>


{{ /items }}

