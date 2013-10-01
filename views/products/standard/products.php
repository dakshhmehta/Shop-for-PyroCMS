<!--- FILE.START:VIEW.PRODUCTS --->
<div>

		<div>
			<h2>
			  <?php echo (isset($shop_title))?$shop_title:""; ?>
			</h2>
		</div>


		
		{{ if pagination:links }} 
			<div> 
				{{ pagination:links }}
			</div>
		{{ endif}}
		
			
		<div style="clear:both;" />


		<div>
		
			<div><?php echo $this->session->flashdata('feedback');?></div>
		
			<?php 
				if (isset($items) && count($items) > 0 ) 
				{
					$this->load->view('products/'.$nc_layout.'/line_item');
				} 
			?>
		</div>

		
		{{ if pagination:links }} 
			<div> 
				{{ pagination:links }}
			</div>
		{{ endif}}


</div>
<!--- FILE.END:VIEW.PRODUCTS --->