<div>
		
		{{# Fields available for categories  #}}
		{{#  #}}
		{{# - id #}}
		{{# - slug #}}
		{{# - image_id #}}
		{{# - description #}}
		{{# - parent_id #}}
		{{# - order #}}


		<div class="products-page-title">
			<h2>
			  {{ shop_title }}
			</h2>
		</div>	  
	  		


		<div class="error">
			<?php echo $this->session->flashdata('feedback');?>
		</div>

			
		{{ categories }}

			<div class="product">
			
			 <div class="product-inner">
			
					<div>
						<a class="ShopClean" href="{{ url:site }}shop/category/{{slug}}">
							<img src="{{ url:site }}files/thumb/{{image_id}}/245/" />
						</a>
					</div>
					<div>
						<h2>
							<a id="" class="" href="{{ url:site }}shop/category/{{slug}}">{{name}}</a>
						</h2>
					</div>
				</div>
			  </div>

		{{ /categories }}


		
		<div class="product-spacer"></div>
		
		
		<div class="products-filter">
			<!-- Pagination -->
			<div class='pagination'> 
				{{ pagination:links }}
			</div>
		</div>
		
</div>
