
				<fieldset>
					<ul>
						<li>
							<label>
								<?php echo lang('shop:products:files'); ?>
								<small>
									<?php echo lang('shop:products:files_description'); ?>
								</small>
							</label>

							<div class="input">
								<input type='file' name='digital_downloads_1' > <br />
							</div>
						</li>	
					</ul>
				</fieldset>

				<fieldset>
					<ul>
						<li>
							<label>
								<?php echo lang('shop:products:linked_files'); ?>
								<small>
									<?php echo lang('shop:products:linked_files_description'); ?>
								</small>
							</label>

							<div class="input">
							
							</div>
						</li>	

						<?php foreach($digital_files as $file): ?>

								<li data-id="<?php echo $file->id;?>">
									<label>
										<?php echo "Filename"; ?>
										<small>
											<?php echo $file->filename; ?>
										</small>
									</label>

									<div class="input">
										<a href='#' class='shopbutton button-flat red delete_digital_file' data-id="<?php echo $file->id;?>">[X] Delete</a>
									</div>
								</li>	

						<?php endforeach;?>

					</ul>
				</fieldset>			

				<script>



				$(".delete_digital_file").live('click', function(e)  {	


					if(confirm('Are you sure you want to delete this file ?'))
					{

					}
					else
					{
						return false;
					}
					

		            id = $(this).attr('data-id');        

		            $.post('shop/admin/product/delete_file/' + id).done(function(data) 
		            {			

		                var obj = jQuery.parseJSON(data);
		                
		                if (obj.status == 'success') 
		                {
		                    //$('li["data-id=' + id +'"]').remove();
		                    $('li[data-id="' + id +'"]').remove();
		                }

		            });
		            
					return false;
				
				});	
				</script	
			