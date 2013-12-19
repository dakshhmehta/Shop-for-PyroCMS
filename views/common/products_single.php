<div id="SingleProductView" itemscope itemtype="http://schema.org/Product">

	<div id="ProductImage" class="" style="">
		<img itemprop="image" src="{{ url:site }}files/thumb/{{product.cover_id}}/350/"  alt="product-image" />
	</div>
		
		
	<!-- Product Detail -->
	<article>

		<form action="{{url:site}}shop/cart/add" method="POST">
			<input type="hidden" name="id" value="{{product.id}}">

			<div>
				<h2>
					<span itemprop="name">
						{{product.name}}
					</span>
				</h2>
			</div>



			<div>
				<span class='description' itemprop="description">
					{{product:description}}
				</span>
			</div>
			
			
			
			<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" style="display:none;">
				<span itemprop="price">{{product.price}}</span>
				<meta itemprop="priceCurrency" content="{{shop:currency}}" />
			</div>

			<div class=''>
				<ul>
					{{shop:images id="{{product.id}}" include_cover='YES' include_gallery='YES' }}
						<li>
							{{if local}}
								<img itemprop="image" src="{{ url:site }}files/thumb/{{file_id}}/200/200/" width="200" height="200" alt="{{alt}}" />
							{{else}}
								<img itemprop="image" src="{{src}}" width="200" height="200" alt="{{alt}}" />
							{{endif}}
						</li>
					{{/shop:images}}
				</ul>
			</div>


			{{ shop:options id="{{product.id}}"  txtBoxClass="txtForms" }}	

				<div>

					<label>{{ title }}</label><br />

					{{ if type == "radio" }}	
						
						{{ values}}

							{{display}} {{label}} <br />

						{{/values}}

					{{ else }}
							
						{{display}}<br />

					{{ endif }}
							
				</div>

			{{ /shop:options }}


			
				{{if product.status == "in_stock" }}
					<div id="Add_to_Cart_Container" class="">
						<input type="hidden" name="quantity" id="quantity" data-max="0" data-min="" maxlength="5" title="qty" value="1" />
						<input class="" type="submit" value='add to cart'  />
					</div>	
				{{endif}}	

		</form>
	</article>
</div>