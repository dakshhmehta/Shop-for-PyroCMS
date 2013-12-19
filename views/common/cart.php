<div id="CartView">

		<form action="{{url:site}}shop/cart/update" method="POST">

			<div id="cart-title">
				<h2>In the cart</h2>
				<p>please review below</p>
			</div>

			<!-- Start Shopping Cart Table -->
			  <table class="cart-table">
			  
				<thead>
				  <tr>
					<th class="image">item</th>
					<th class="description">description</th>
					<th class="price">price</th>
					<th class="qty">quantity</th>
					<th class="subtotal">total</th>
					<th class="remove"></th>				
				  </tr>
				</thead>
				
			<tbody>

				{{shop:cart}}
				  <tr>
					<input type="hidden" name="{{rowid}}[rowid]" value="{{rowid}}">
					<input type="hidden" name="{{rowid}}[id]" value="{{id}}">				  
					<th class="image">
							{{shop:images id="{{ id }}" include_cover='YES' include_gallery='NO' }}

									{{if local}}
										<img itemprop="image" src="{{ url:site }}files/thumb/{{file_id}}/100/100/" width="100" height="100" alt="{{alt}}" />
									{{else}}
										<img itemprop="image" src="{{src}}" width="100" height="100" alt="{{alt}}" />
									{{endif}}
				
							{{/shop:images}}
					</th>
					<th class="description">{{name}}</th>
					<th class="price">{{price}}</th>
					<th class="qty">
							<input type="text" name="{{rowid}}[qty]" value="{{qty}}" maxlength="4">
					</th>
					<th class="subtotal">{{subtotal}}</th>
					<th class="remove">
						<a class="" href="{{ url:site }}shop/cart/delete/{{rowid}}">
							&times;
						</a>
					</th>				
				  </tr>
				{{/shop:cart}}

				<tr class="cart-actions">
					<td colspan="6">			
						<span>
							{{shop:currency}} {{shop:total cart="sub-total"}} sub total 

							<input class=""  name="update_cart" type="submit" value="update cart" />

							<a class="" href="{{url:site}}shop/checkout/">checkout</a>
						</span>
					</td>
				</tr>
			</tbody>
			
		  </table>

		</form>

</div>