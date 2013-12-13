
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
					<td>
					
							{{shop:images id="{{id}}" include_cover='YES' include_gallery='NO' }}
							
									{{if local}}
										<img itemprop="image" src="{{ url:site }}files/thumb/{{file_id}}/100/100/" width="100" height="100" alt="{{alt}}" />
									{{else}}
										<img itemprop="image" src="{{src}}" width="100" height="100" alt="{{alt}}" />
									{{endif}}
							
							{{/shop:images}}

					</td>
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