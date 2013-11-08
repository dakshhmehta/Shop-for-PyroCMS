

{{# You you have full access to all the products fields using LEX tags #}}
{{#  #}}
{{#  #}}
{{#  #}}

<ul class="wishlist-items">

	{{items}}

		<li>

			<a href="{{url:site}}shop/product/{{slug}}">

				<img src="{{url:site}}files/thumb/{{cover_id}}/140" />
		
				{{ name }}

			</a>

		  {{ shop:price id="{{prod_id}}" }}
		  
		 		{{if min_qty == '1' }}
		 				${{price}} for 1,
		 		{{ else }}
		 				${{price}} for {{min_qty}} or more <br />
		 		{{ endif }}
		 		
		   {{ /shop:price }}

		</li>

	{{/items}}

</ul>


<a href="{{ url:site }}shop/my/wishlist"><?php echo shop_lang('shop:front:view_all_items');?></a>