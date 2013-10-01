<!--- FILE.START:VIEW.PRODUCTS --->
<div id="NC_Master" >
<div id="SF_ProductsPage">  

		<!-- PAGE-TITLE -->
		<div class="products-page-title">
			<h2>
			  <?php echo (isset($shop_title))?$shop_title:""; ?>
			</h2>
		</div>

		{{ if pagination:links }} 
		<div class="products-filter" style="margin-bottom:30px;">
			<!-- Pagination -->
			<div class='pagination'> 
				{{ pagination:links }}
			</div>
		</div>
		{{ endif}}
		
		<div class="clear" style="clear:both;" />


			<div class="">
			
				<div class="error"><?php echo $this->session->flashdata('feedback');?></div>
			
				<?php 

					if (isset($items) && count($items) > 0 ) {
						$this->load->view('products/'.$nc_layout.'/line_item');
					} 
				?>
			</div>


		<div class="product-spacer"></div>
		
		
		<div class="products-filter">
			<!-- Pagination -->
			<div class='pagination'> 
				{{ pagination:links }}
			</div>
		</div>

		
</div>
</div>
<!--- FILE.END:VIEW.PRODUCTS --->