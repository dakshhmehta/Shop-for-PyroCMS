
<h2><?php echo lang('shop:label:wishlist'); ?></h2>

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
					<th class="description"><?php echo lang('shop:label:item'); ?></th>
					<th class="subtotal"><?php echo lang('shop:label:price'); ?></th>
					<th></th>
				</tr>
			</thead>
			{{items}}
				<tr>
					<td><img src="{{url:site}}files/thumb/{{cover_id}}/100/100"></td>
					<td><a href="{{ url:site }}shop/products/product/{{slug}}">{{name}}</a></td>
					<td>{{price_or}}</td>
					<td><a class="DeleteButton" href="{{ url:site }}shop/my/wishlist/delete/{{id}}"><?php echo lang('shop:label:remove'); ?></a></td>
				</tr>
			{{/items}}
		</table>

		<p>
			<a href="{{ url:site }}shop/my"><?php echo lang('shop:label:dashboard'); ?></a>
		</p>

	</div>
</div>