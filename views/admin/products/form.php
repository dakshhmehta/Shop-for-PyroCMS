
<input type="hidden" name="static_product_id" id="static_product_id" data-pid="<?php echo $id;?>" />



<section class="title">
	<h4> <?php echo lang('shop:common:'. $this->method) . " <strong> <span id='title_product_name'> " .$name ."</span></strong> ( ". $id  . ")"; ?>  </h4>
</section>

<section class="item">
	<div class="content">
		<fieldset>

			<div style="float:right;">
				<?php $this->load->view('admin/products/partials/infobar'); ?>
			</div>	

			<div id="cover_container" class="input">
				<?php 

				$c_image = hlp_product_cover($id);

				$src = ( $c_image == NULL )? '' : $c_image->src ;

				echo "<div class='container'><img id='prod_cover' src='".$src."' height='100' width='100'>"; 
				echo "</div>";
				?>
			</div> 

		</fieldset>
		
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		<div class="tabs">		

			<ul class="tab-menu">
				<?php $this->load->view('admin/products/partials/tabs'); ?>
			</ul>

			<div class="form_inputs" id="start-tab">
				<?php $this->load->view('admin/products/partials/start'); ?>
			</div>

			<div class="form_inputs" id="product-tab">
				<div class='not-loaded'></div>
				<?php //$this->load->view('admin/products/partials/product'); ?>
			</div>

			<div class="form_inputs" id="description-tab">
				<div class='not-loaded'></div>			
				<?php //$this->load->view('admin/products/partials/description'); ?>
			</div>		

			<div class="form_inputs" id="price-tab">
				<div class='not-loaded'></div>			
				<?php //$this->load->view('admin/products/partials/price'); ?>
			</div>	

			<div class="form_inputs" id="discounts-tab">
				<div class='not-loaded'></div>			
				 <?php //$this->load->view('admin/products/partials/discounts'); ?>	
			</div>	


			<div class="form_inputs" id="images-tab">
				<div class='not-loaded'></div>			
				 <?php //$this->load->view('admin/products/partials/images'); ?>	
			</div>

			<div class="form_inputs" id="attributes-tab">
				<div class='not-loaded'></div>			
				<?php //$this->load->view('admin/products/partials/attributes'); ?>		 
			</div>


			<div class="form_inputs" id="related-tab">
				<div class='not-loaded'></div>			
				 <?php //$this->load->view('admin/products/partials/related'); ?>	
			</div>


			<?php if(group_has_role('shop', 'admin_product_options')): ?>

				<div class="form_inputs" id="options-tab">
					<div class='not-loaded'></div>			
					 <?php //$this->load->view('admin/products/partials/options'); ?>	
				</div>
				
			<?php endif; ?>





			<div class="form_inputs" id="inventory-tab">
				<div class='not-loaded'></div>
				<?php //$this->load->view('admin/products/partials/inventory'); ?>		
			</div>

			<?php if(group_has_role('shop', 'admin_product_seo')): ?>
				<div class="form_inputs" id="seo-tab">
					<div class='not-loaded'></div>
					<?php //$this->load->view('admin/products/partials/seo'); ?>		
				</div>		
			<?php endif; ?>



			<div class="form_inputs" id="shipping-tab">
				<div class='not-loaded'></div>
				<?php //$this->load->view('admin/products/partials/shipping'); ?>		
			</div>

			<div class="form_inputs" id="files-tab">
				<div class='not-loaded'></div>
				<?php //$this->load->view('admin/products/partials/shipping'); ?>		
			</div>			

			<div class="form_inputs" id="design-tab">
				<div class='not-loaded'></div>
				<?php //$this->load->view('admin/products/partials/shipping'); ?>		
			</div>

			<div class="form_inputs" id="console-tab">
				<?php $this->load->view('admin/products/partials/console'); ?>		
			</div>	



		</div>
		

		<div class="buttons">

			<?php $this->load->view('shop/admin/fragments/product_actions', array('id' => $id) ); ?>

		</div>

		<?php echo form_close(); ?>

	</div>
</section>
