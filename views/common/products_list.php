<div id="MultipleItemListView">


		{{# This can be used to change the display format from grid|list #}}
		<div id="List">
		
			{{ products }}


				{{ if searchable != '1' }}
					{{# Do not list searchable items in main list #}}
				{{ else }}

					<div itemscope itemtype="http://schema.org/Product" id="ProductItem">
						
							<div itemprop="name" style="">
								{{ name }}
							</div>

							<a itemprop="url" href="{{ url:site }}shop/products/product/{{ slug }}">
								<img itemprop="image" src="{{ url:site }}files/thumb/{{ cover_id }}/200/200" />
							</a>
							
							<br />
			
							<form action="{{url:site}}shop/cart/add" name="" method="post">
							
								<input type="hidden" name="id" value="{{ id }}">

									{{ if status != "in_stock" }}
										<a class="" href="{{ url:site }}shop/products/product/{{ slug }}">view</a>
									{{ else }}
										

												{{ if category:user_data == 'prints' }}

															{{ shop:options id="{{id}}" }}	

																	 	{{display}}
																											
															{{ /shop:options }}	

															<div id="Add_to_Cart_Container" class="cards">
																<label class="quantity movedown">quantity</label>
																<input class="quantity" name="quantity" id="quantity" data-max="0" data-min="" maxlength="5" title="Qty" value="1" />
																<input type="submit" value='add to cart' class="" />
															</div>


												{{ else }}

															<div id="Add_to_Cart_Container" class="cards">
																<label class="quantity movedown">quantity</label>
																<input class="quantity" name="quantity" id="quantity" data-max="0" data-min="" maxlength="5" title="Qty" value="1" />
																<input type="submit" value='add to cart' class="" />
															</div>

												{{ endif }}			
									

									{{ endif }}



							</form>	
										
					</div>

				{{endif}}

					
			{{ /products }}
				
					

		</div>

		{{ if pagination:links }} 
			<div class="pagination"> 
				{{ pagination:links }}
			</div>
		{{ endif}} 


</div>

