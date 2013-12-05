<div id="sortable">

	<div class="" id="">
		<section class="draggable title">
			<h4><?php echo lang('shop:packages:manage_packages'); ?></h4>
			<a class="tooltip-s toggle" title="Toggle this element"></a>
		</section>
		
		<section class="item">
			<div class="content">

			<div class="tabs">

				  <ul class="tab-menu">
					<li><a href="#installed"><?php echo lang('shop:common:installed'); ?></a></li>
					<li><a href="#available"><?php echo lang('shop:common:available'); ?></a></li>
				  </ul>
					<div id="installed" class="form_inputs">
						<fieldset>
								<?php if (!empty($installed)): ?>

									<table>
										<thead>
											<tr>
												<th><?php echo lang('shop:common:name');; ?></th>
												<th><?php echo lang('shop:common:image');; ?></th>
												<th><?php echo lang('shop:packages:dimentions'); ?></th>
												<th><?php echo lang('shop:packages:type'); ?></th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($installed as $item): ?>
												<tr>
													<td><?php echo $item->title; ?></td>
													<td><?php echo $item->image ? img($item->image) : ''; ?></td>
													
				
													<td><?php echo ''.$item->height.' x '.$item->width.' (mm)'; ?></td>
													<td><?php echo $item->type; ?></td>
													<td class="">


															<span style="float:right;">

																<span class="button-dropdown" data-buttons="dropdown">
															
																	<a href="#" class="shopbutton button-rounded button-flat-primary"> 
																		<?php echo lang('shop:common:actions');?> 
																		<i class="icon-caret-down"></i>
																	</a>
																	 
																	<!-- Dropdown Below Button -->
																	<ul class="button-dropdown">
																		<li class=''><a class="" href="<?php echo site_url('admin/shop/packages/edit/' . $item->id); ?>"><?php echo lang('shop:common:edit');?></a></li>
																		<li class='button-dropdown-divider delete'><a class="confirm" href="<?php echo site_url('admin/shop/packages/uninstall/' . $item->id); ?>"><?php echo lang('shop:packages:uninstall');?></a></li>
																	</ul>
																</span>

															</span>
									
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="5">
													<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
												</td>
											</tr>
										</tfoot>
									</table>


								<?php else: ?>
									<div class="no_data"><?php echo lang('shop:packages:no_data'); ?></div>
								<?php endif; ?>

								<?php echo form_close(); ?>
						</fieldset>
					</div>	
					<div id="available" class="form_inputs">
						<fieldset>
								<?php if (!empty($uninstalled)): ?>

									<table>
										<thead>
											<tr>
												<th><?php echo lang('shop:common:name'); ?></th>
												<th><?php echo lang('shop:common:image'); ?></th>
												<th><?php echo lang('shop:common:description'); ?></th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($uninstalled as $item): ?>
												<tr>
													<td><?php echo $item->title; ?></td>
													<td><?php echo $item->image ? img($item->image) : ''; ?></td>
													<td><?php echo $item->desc; ?></td>
													<td class="actions">
														<?php echo anchor('admin/shop/packages/install/' . $item->slug, lang('shop:packages:install'), 'class="button"'); ?>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="4">
													<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
												</td>
											</tr>
										</tfoot>
									</table>

								<?php else: ?>
									<div class="no_data"><?php echo lang('shop:packages:no_data'); ?></div>
								<?php endif; ?>

								<?php echo form_close(); ?>
						</fieldset>
					</div>	
					
				</div>
			</div>
		</section>
	</div>

</div>