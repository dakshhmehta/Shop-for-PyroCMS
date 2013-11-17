
<h2><?php echo lang('wishlist'); ?></h2>

		<ul>
		{{ shop:mylinks remove='shop' active='wishlist' }}
			{{link}}
		{{ /shop:mylinks }}
		</ul>

<div id="">
	<div>	

		<table>
			<thead>
				<tr>
					<th class="image"></th>
					<th class="description">Item</th>
					<th class="subtotal">Price</th>
					<th></th>
				</tr>
			</thead>
			{{items}}
				<tr>
					<td><img src="{{url:site}}files/thumb/{{cover_id}}/100/100"></td>
					<td><a href="{{ url:site }}shop/product/{{slug}}">{{name}}</a></td>
					<td>{{price_at}}</td>
					<td><a class="DeleteButton" href="{{ url:site }}shop/my/wishlist/delete/{{id}}">remove</a></td>
				</tr>
			{{/items}}
		</table>

		<p>
			<a href="{{ url:site }}shop/my"><?php echo lang('dashboard'); ?></a>
		</p>

	</div>
</div>