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
								  {{ shop:price id="{{prod_id}}" }}
								  
								 		{{if min_qty == '1' }}
								 				${{price}} for 1 <br />
								 		{{ else }}
								 				${{price}} for {{min_qty}} or more <br />
								 		{{ endif }}
								 		
								   {{ /shop:price }}
					</span>
				
				</div>
				
			</div>

	</div>


{{ /items }}

