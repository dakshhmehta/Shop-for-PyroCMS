<!--- FILE.START:VIEW.BRANDS.STANDARD.BRANDS --->
<div>  

		<div>
			<h2>
			  <?php echo (isset($shop_title))?$shop_title:""; ?>
			</h2>
		</div>	  
	  


		<?php

			$this->load->view('brands/'.$nc_layout.'/brands_list'); 

		?>

		
		
		{{ if pagination:links }} 
			<div> 
				{{ pagination:links }}
			</div>
		{{ endif}}
	
		
</div>
<!--- FILE.END:VIEW.BRANDS.STANDARD.BRANDS --->