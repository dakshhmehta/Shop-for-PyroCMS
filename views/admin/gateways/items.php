<section class="title">
	<h4><?php echo shop_lang('shop:gateways:gateways'); ?></h4>
	<a class="tooltip-s toggle" title="Toggle this element"></a>
</section>

<section class="item">

	<div class="content">

		<p><?php echo shop_lang('shop:gateways:main_description'); ?></p>

		<div class="tabs">
			  <ul class="tab-menu">
				<li><a href="#installed"><?php echo shop_lang('shop:gateways:installed'); ?></a></li>
				<li><a href="#available"><?php echo shop_lang('shop:gateways:available'); ?></a></li>
			  </ul>
				<div id="installed" class="form_inputs">
					<fieldset>
							<?php if (!empty($installed)): ?>

								<table>
									<thead>
										<tr>
											<th><?php echo shop_lang('shop:gateways:name'); ?></th>
											<th><?php echo shop_lang('shop:gateways:image'); ?></th>
											<th><?php echo shop_lang('shop:gateways:description'); ?></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($installed as $item): ?>
											<tr>
												<td><?php echo $item->title; ?></td>
												<td><?php echo $item->image ? img($item->image) : ''; ?></td>
												<td><?php echo $item->desc; ?></td>
												<td class="actions">
													<?php if ($item->enabled) {
														echo anchor('admin/shop/gateways/enable/' . $item->id.'/0', ' ' , 'class="img_icon img_visible"');
													} else {
														echo anchor('admin/shop/gateways/enable/' . $item->id.'/1',' ', 'class="img_icon img_invisible"');
													}; ?>
													<?php
													echo
													anchor('admin/shop/gateways/edit/' . $item->id, ' ', 'class="img_icon img_edit"') . ' ' .
													anchor('admin/shop/gateways/uninstall/' . $item->id, ' ', array('class' => 'img_icon img_delete confirm'));
													?>
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
								<div class="no_data"><?php echo shop_lang('shop:gateways:no_data'); ?></div>
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
											<th><?php echo shop_lang('shop:gateways:name'); ?></th>
											<th><?php echo shop_lang('shop:gateways:image'); ?></th>
											<th><?php echo shop_lang('shop:gateways:description'); ?></th>
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
													<?php echo anchor('admin/shop/gateways/install/' . $item->slug, lang('global:install'), 'class="button"'); ?>
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
								<div class="no_data"><?php echo shop_lang('shop:gateways:no_data'); ?></div>
							<?php endif; ?>
							<?php echo form_close(); ?>
					</fieldset>
				</div>	
				
			</div>
	</div>
</section>
