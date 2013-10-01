<!--- FILE.START:VIEW.CATEGORIES.CATEGORIES --->
<div id="SF_ProductsPage">  

		<!-- PAGE-TITLE -->
		<div class="products-page-title">
			<h2>
			  <?php echo $shop_title; ?>
			</h2>
		</div>	  
	  		

		<?php

		$this->load->view('categories/'.$nc_layout.'/categories_list'); 	

		?>

		
		<div class="product-spacer"></div>
		
		
		<div class="products-filter">
			<!-- Pagination -->
			<div class='pagination'> 
				{{ pagination:links }}
			</div>
		</div>


		
</div>
<!--- FILE.END:VIEW.CATEGORIES.CATEGORIES --->