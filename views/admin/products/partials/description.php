<?php
 
/* VIEW SECTION
 *
 * 
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * 
 */
 ?>
	
<fieldset>	
	<ul>
		<li class="<?php echo alternator('', 'even'); ?>">
			<label for=""><?php echo lang('shop:products:description'); ?><span></span>
				<small>
				 <?php echo lang('shop:products:description_description'); ?>
				</small>
			</label>
		</li>
		<li class="<?php echo alternator('', 'even'); ?>">
			<div class="">
				<?php echo form_textarea('description', set_value('description', $description), 'class="wysiwyg-simple"'); ?> 
			</div>
		</li>					
	</ul>			
	   
	
</fieldset>




<?php
 
/* SCRIPT SECTION
 *
 * 
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * 
 */
 ?>

<script type="text/javascript">

	var instance;

	function update_instance()
	{
		instance = CKEDITOR.currentInstance;
	}

	(function($) {
		$(function(){

			pyro.init_ckeditor = function(){
				<?php echo $this->parser->parse_string(Settings::get('ckeditor_config'), $this, TRUE); ?>
				pyro.init_ckeditor_maximize();
			};
			pyro.init_ckeditor();

		});
	})(jQuery);

</script>
			