<!--- FILE.START:VIEW.PRODUCTS --->
<div id="SF_ProductsPage">  

		<!-- PAGE-TITLE -->
		<div class="products-page-title">
			<h2>
			  <?php echo 'Shop Title'; ?>
			</h2>
		</div>	  
	  


		<?php


		$this->load->view('brands/'.$nc_layout.'/brands_list'); 


		?>



		
		<div class="product-spacer"></div>
		
		
		<div class="products-filter">
			<!-- Pagination -->
			<div class='pagination'> 
				{{ pagination:links }}
			</div>
		</div>

		
		
</div>
<!--- FILE.END:VIEW.PRODUCTS --->