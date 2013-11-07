
<div>  

	{{if categories}}

		{{categories}}
			<div class="products_list_item">
			
				<div class="product-image">
					<a href="{{ url:site }}shop/categories/category/{{slug}}">
						<img src="{{ url:site }}files/thumb/{{image_id}}" />
					</a>
				</div>
				
				<div>
					<h2>
						<a href="{{ url:site }}shop/categories/category/{{slug}}">{{name}}</a>
					</h2>
				</div>
			
		  </div>
		{{/categories}}

	{{else}}

		No categories to display

	{{endif}}

		<div>
			<!-- Pagination -->
			<div class='pagination'> 
				{{ pagination:links }}
			</div>
		</div>


</div>
