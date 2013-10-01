<!--- FILE.START:VIEW.CATEGORIES.CATEGORIES --->
<div>  

		<div>
			<h2>
			  <?php echo $shop_title; ?>
			</h2>
		</div>

		<?php

		$this->load->view('categories/'.$nc_layout.'/categories_list'); 		

		?>


		<div></div>
	

		<div>
			<!-- Pagination -->
			<div class='pagination'> 
				{{ pagination:links }}
			</div>
		</div>


</div>
<!--- FILE.END:VIEW.CATEGORIES.CATEGORIES --->