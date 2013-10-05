			

			{{ shop:cart_contents }}

				<input type="hidden" name="{{counter}}[id]" value="{{ id }}" />
				<input type="hidden" name="{{counter}}[rowid]" value="{{ rowid }}" />
				<input type="hidden" name="{{counter}}[price]" value="{{ price }}" />
				<input type="hidden" name="{{counter}}[base]" value="{{ base }}" />
		
				<tr>
					<td>
						<a href="{{url:site}}shop/product/{{slug}}">
							{{ shop:coverimage id="{{ id }}" }}
						</a>
					</td>

					<td>
						<a href="{{url:site}}shop/product/{{slug}}">
							{{ name }}
						</a>
					</td>

					<td>
						<a href="{{url:site}}shop/product/{{slug}}">
							{{ price }}
						</a>
					</td>

					<td>
						<input type="text" name="{{counter}}[qty]" value="{{ qty }}" size="4" />
					</td>


					<td>
						<span>{{shop:pricer price="{{ subtotal }}" }}</span> *
					</td>

					<td>
						<a href="{{url:site}}shop/cart/delete/{{rowid}}">
							&times;
						</a>					
					</td>	
			</tr>
			{{ /shop:cart_contents }}


				


