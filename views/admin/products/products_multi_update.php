
				<tfoot>
					<tr>
						<td colspan="2">
							Action
						</td>
						<td colspan="8">
							<span style="padding-bottom:0px;bottom:0;vertical-align:top;">

								<?php echo form_dropdown('multi_edit_option', array(

																				'noaction' => lang('shop:products:take_no_action'), 
																				'delete' => lang('shop:products:delete_selected_products'),
																				'invisible' => lang('shop:products:make_all_invisible'),
																				'visible' =>  lang('shop:products:make_all_visible') )

															,"style='vertical-align:top;'");
														?>

								

							</span>
						</td>
					</tr>


					<tr>
						<td colspan="2">
							Set Layout
						</td>
						<td colspan="8">
							<span>
								<select name="page_design_layout" id="page_design_layout">
									<option value="products_single"><?php echo lang('shop:products:default'); ?></option>
									<?php echo $design_select; ?> hey
								</select>
							</span>
						</td>
					</tr>



					<tr>
						<td colspan="2">
							Confirm action
						</td>
						<td colspan="8">
							<span>
								<button class="shopbutton button-rounded green" value="multi_edit_option" name="btnAction" type="submit" style="vertical-align:top;">go</button>
							</span>
						</td>
					</tr>
					
				</tfoot>				