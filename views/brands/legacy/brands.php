<div>
		
		{{# Fields available for brands  #}}
		{{#  #}}
		{{# - id #}}
		{{# - slug #}}
		{{# - image_id #}}
		{{# - dates_changed #}}
		{{# - notes #}}

		<h2>
		  {{ shop_title }}
		</h2>
  
		<div class="error">
			<?php echo $this->session->flashdata('feedback');?>
		</div>

			
		{{ brands }}

			<div>
				<a href="{{ url:site }}shop/category/{{slug}}">
					<img src="{{ url:site }}files/thumb/{{image_id}}/245/" />
				</a>
			</div>

			<div>
				<h2>
					<a id="" class="" href="{{ url:site }}shop/brands/{{slug}}">{{name}}</a>
				</h2>
			</div>


		{{ /brands }}

		<!-- Pagination -->
		<div class='pagination'> 
			{{ pagination:links }}
		</div>
	
		
</div>
