<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>

	<div class="one_half" id="">
	

		<section class="title">
			<?php if (isset($id) AND $id > 0): ?>
				<h4><?php echo sprintf(lang('shop:pgroups:edit'), $name); ?></h4>
			<?php else: ?>
				<h4><?php echo lang('shop:pgroups:new'); ?></h4>
			<?php endif; ?>
		</section>		
		


		
		<?php if (isset($id) AND $id > 0): ?>
			<?php echo form_hidden('id', $id); ?>
			<input type="hidden" name="bid" id="bid" value="<?php echo $id; ?>" > 
		<?php endif; ?>



			<section class="item form_inputs">
				<div class="content">
					<fieldset>
						<ul>
							<li class="<?php echo alternator('even', ''); ?>">
								<label for="name"><?php echo lang('shop:pgroups:name'); ?><span>*</span></label>
								<div class="input">
									<?php echo form_input('name', set_value('name', $name), 'id="name" '); ?>
								</div>
							</li>	  	
							<li class="<?php echo alternator('', 'even'); ?>">
								<label for="cover">
									<?php echo lang('shop:pgroups:description'); ?>
								</label>			
								<div class="input">
										<?php echo form_textarea('description', set_value('description', isset($description)?$description:""), 'class="wysiwyg-simple"'); ?>
								</div>
							</li>			
						</ul>
					</fieldset>
					



			</div>
			
		</section>
	

	</div>

	<div class="one_half last" id="">
	

		<section class="title">

				<h4><?php echo lang('shop:pgroups:actions')?></h4>

		</section>		
		


			<section class="item form_inputs">
				<div class="content">


					<div class="buttons">
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
					</div>





				</div>
			</section>

	</div>


	<?php if (isset($id) AND $id > 0): ?>

	<div class="one_full" id="" style="margin-top:30px;" >
	
		<section class="title">
				<h4><?php echo lang('shop:pgroups:mid_prices'); ?></h4>
				
				<h4 style="float:right"><a id="add-price" title="<?php echo lang('shop:pgroups:add_new_tier'); ?>" class="tooltip-s img_icon img_create" href="#"></a></h4>

		</section>
		
		<section class="item form_inputs">
			
			<div class="content">

				<fieldset>
					<div class="input">
							<h4><?php echo lang('shop:pgroups:mid_prices_description'); ?></h4>
					</div>
				
					<br />


					<table id="price-list">

						
						<tr>
							  <th class='tooltip-s' title="<?php echo lang('shop:pgroups:min_purchase_required');?>"><?php echo lang('shop:pgroups:min_qty'); ?></th>
							  <th class='tooltip-s' title="<?php echo lang('shop:pgroups:discounted_retail_price');?>"><?php echo lang('shop:pgroups:price'); ?></th>
							  <th class='tooltip-s' title="<?php echo lang('shop:pgroups:assign_to');?>"><?php echo lang('shop:pgroups:assign_to'); ?></th>
							  <th class='tooltip-s' title="<?php echo lang('shop:pgroups:remove');?>"><?php echo lang('shop:pgroups:actions'); ?></th>
						</tr>	


					

						<?php if(isset($prices)):?>		



							<?php $index = 0; ?>
							<?php foreach ($prices as $atr): ?>
								<tr id="item_<?php echo $index; ?>">
										<td><?php echo form_input('prices[' . $index . '][min_qty]', set_value('prices[' . $index . '][min_qty]', $atr->min_qty), 'style="width:30px" class="disc_qty"'); ?></td>
										<td><?php echo form_input('prices[' . $index . '][price]', set_value('prices[' . $index . '][price]', $atr->price), 'style="width:30px" class="disc_price"'); ?></td>
										<td><?php echo form_dropdown('prices[' . $index . '][ugroup_id]', $user_groups, set_value('prices[' . $index . '][ugroup_id]', $atr->ugroup_id)) ?></td>
										<td><a class="img_delete img_icon remove" data-row="item_<?php echo $index; ?>"></a></td>
								</tr>
								<?php $index++; ?>
							<?php endforeach; ?>



						<?php endif;?>
		
					</table>	

				</fieldset>
				
			</div>
			
		</div>

		<?php endif;?>


	</div>



<?php echo form_close(); ?>

<script>



		$('#add-price').click(function() 
		{

			var id = $("#price-list tr").length;
			var content = '';
			content += '<tr id="item_'+id+'">';
			content += '   <td><input type="text" style="width:30px" class="disc_qty" value="" name="prices['+id+'][min_qty]"></td>';
			content += '   <td><input type="text" style="width:30px" class="disc_price" value="" name="prices['+id+'][price]"></td>';		
			content += '   <td><select name="prices[' +id + '][ugroup_id]>'+ 


						<?php 
								$str = "'";
								foreach($user_groups as $key => $value)
								{
										$str .= "<option value=\"" . $key  . "\">" . $value . "</option>";
								}

							$str .= "</select>'";
								echo $str;
						?>

			content += '</td>';		
			content += '   <td><a class="img_delete img_icon remove" data-row="item_'+id+'"></a></td>';
			content += '</tr>';
			$('#price-list').append(content);
			return false;

		});
        
</script>