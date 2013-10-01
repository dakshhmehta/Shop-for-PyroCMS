<div id="sortable">

	<div class="" id="">
		<section class="draggable title">
			<h4><?php echo lang('manage_packages'); ?></h4>
			<a class="tooltip-s toggle" title="Toggle this element"></a>
		</section>
		
		<section class="item">
			<div class="content">

			<div class="tabs">

				  <ul class="tab-menu">
					<li><a href="#installed"><?php echo lang('installed'); ?></a></li>
					<li><a href="#available"><?php echo lang('available'); ?></a></li>
				  </ul>
					<div id="installed" class="form_inputs">
						<fieldset>
								<?php if (!empty($installed)): ?>

									<table>
										<thead>
											<tr>
												<th><?php echo lang('name'); ?></th>
												<th><?php echo lang('image'); ?></th>
												<th><?php echo 'Dimentions'; ?></th>
												<th><?php echo lang('type'); ?></th>
												<th><?php echo lang('actions'); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($installed as $item): ?>
												<tr>
													<td><?php echo $item->title; ?></td>
													<td><?php echo $item->image ? img($item->image) : ''; ?></td>
													
				
													<td><?php echo ''.$item->height.' x '.$item->width.' (mm)'; ?></td>
													<td><?php echo $item->type; ?></td>
													<td class="actions">
														<?php
														echo
														anchor('admin/shop/packages/edit/' . $item->id, ' ', 'class="img_icon img_edit"') . ' ' .
														anchor('admin/shop/packages/uninstall/' . $item->id, ' ', array('class' => 'img_icon img_delete confirm'));
														?>
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
														<?php echo anchor('admin/shop/packages/install/' . $item->slug, lang('global:install'), 'class="button"'); ?>
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