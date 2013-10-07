
<input type="hidden" name="static_product_id" id="static_product_id" data-pid="<?php echo $id;?>" />



<section class="title">
	<h4> <?php echo shop_lang('shop:products:method_'. $this->method, 'method_') . "<span id='title_product_name'> " .$page_banner_title ."</span> "; ?>  </h4>
	
</section>

<section class="item">
	<div class="content">
		<fieldset>

			<div style="float:right;">
				<?php $this->load->view('admin/products/partials/infobar'); ?>
			</div>	

			<div id="cover_container" class="input">
				<?php 
				if ( $cover_id == NULL )
				{
					$src = ''; /*put no image here*/
				}
				else
				{
					$src = site_url()."files/thumb/" . $cover_id . "/100";
				}
				
				echo "<div class='container'><img id='prod_cover' src='".$src."'>"; 
				echo "<a href='javascript:set_cover(0, 0)'  class='img_icon img_delete gall_cover'></a></div>";
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

			<?php if(group_has_role('shop', 'developer_fields')): ?>
				<div class="form_inputs" id="console-tab">
				<?php $this->load->view('admin/products/partials/console'); ?>		
				</div>	
			<?php endif; ?>


		</div>
		


		<div class="buttons">
			<button class="btn blue" value="save_exit" name="btnAction" type="submit">
				<span><?php echo shop_lang('shop:products:save_and_exit');?></span>
			</button>	
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
		</div>


		<?php echo form_close(); ?>

	</div>
</section>
