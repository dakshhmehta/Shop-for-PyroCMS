<div id="sortable">
	<div class="" id="">
		<section class="draggable title">
			<h4><?php echo lang('manage_shipping'); ?></h4>
			<a class="tooltip-s toggle" title="Toggle this element"></a>
		</section>
		<section class="item">
			<div class="content">

				<div class="tabs">
					  <ul class="tab-menu">
						<li><a href="#installed"><?php echo lang('installed'); ?></a></li>
						<li><a href="#available"><?php echo lang('available'); ?></a></li>
						<li><a href="#countries">Country List</a></li>
					  </ul>
						<div id="installed" class="form_inputs">
							<fieldset>
									<?php if (!empty($installed)): ?>
										<table>
											<thead>
												<tr>
													<th><?php echo lang('name'); ?></th>
													<th><?php echo lang('image'); ?></th>
													<th><?php echo lang('desc'); ?></th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($installed as $item): ?>
													<tr>
														<td><?php echo $item->title; ?></td>
														<td><?php echo $item->image ? img($item->image) : ''; ?></td>
														<td><?php echo wordwrap($item->desc, 50, "<br />\n"); ?></td>
														<td class="actions">
															<span style='float:right'>
															<?php if ($item->enabled) {
																echo anchor('admin/shop/shipping/disable/' . $item->id, ' ',  array('title' => lang('setinvisible') , 'class' => 'tooltip-s img_icon img_visible') );
															} else {
																echo anchor('admin/shop/shipping/enable/' . $item->id, ' ', array('title' => lang('setvisible') , 'class' => 'tooltip-s img_icon img_invisible') );
															}; ?>
															<?php
															echo
															anchor('admin/shop/shipping/edit/' . $item->id, ' ', array('title' => lang('edit') , 'class' => 'tooltip-s img_icon img_edit')) . ' ' .
															anchor('admin/shop/shipping/uninstall/' . $item->id, ' ', array('title'=>lang('uninstall'), 'class' => 'tooltip-s img_icon img_delete confirm'));
															?>
															</span>
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
										<div class="no_data"><?php echo lang('no_items'); ?></div>
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
													<th><?php echo lang('name'); ?></th>
													<th><?php echo lang('image'); ?></th>
													<th><?php echo lang('desc'); ?></th>
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
															<?php echo anchor('admin/shop/shipping/install/' . $item->slug, lang('global:install'), 'class="button"'); ?>
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
										<div class="no_data"><?php echo lang('no_items'); ?></div>
									<?php endif; ?>

									<?php echo form_close(); ?>
							</fieldset>
						</div>	
						<div id="countries" class="form_inputs">
							<fieldset>
									<?php if (!empty($countries)): ?>

										<table>
											<thead>
												<tr>
													<th><?php echo lang('id'); ?></th>
													<th><?php echo lang('name'); ?></th>
													<th>code</th>
													<th>Enabled</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($countries as $item): ?>
													<tr>
														<td><?php echo $item->id; ?></td>
														<td><?php echo $item->name; ?></td>
														<td><?php echo $item->code2; ?></td>
														<td class="actions">
															<?php if ($item->enabled) {
																echo anchor('admin/shop/shipping/country/0/' . $item->id, ' ',  array('title' => lang('setinvisible') , 'class' => 'tooltip-s img_icon img_visible') );
															} else {
																echo anchor('admin/shop/shipping/country/1/' . $item->id, ' ', array('title' => lang('setvisible') , 'class' => 'tooltip-s img_icon img_invisible') );
															}; ?>
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
										<div class="no_data"><?php echo lang('no_items'); ?></div>
									<?php endif; ?>

									<?php echo form_close(); ?>
							</fieldset>
						</div>	
					</div>
				</div>
		</section>
	</div>

</div>