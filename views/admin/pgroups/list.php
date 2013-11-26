<section class="title">
	<h4><?php echo lang('shop:pgroups:price_groups'); ?></h4>
	<h4 style="float:right"><a href="admin/shop/pgroups/create" class='img_icon_title img_create'></a></h4>
</section>
<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
<section class="item">
	<div class="content">
	<?php if (empty($productgroups)): ?>
		<div class="no_data">
		<?php echo lang('shop:pgroups:no_data'); ?></div>
	</div></section>
<?php else: ?>
	<table>			
		<thead>
			<tr>
				<th><input type="checkbox" name="action_to_all" value="" class="check-all" /></th>
				<th><?php echo lang('shop:pgroups:name'); ?></th>
				<th><?php echo lang('shop:pgroups:price_group'); ?></th>
				<th style=""><?php echo lang('shop:pgroups:actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($productgroups AS $group): ?>
				<tr class="<?php echo alternator('even', ''); ?>">
					<td><input type="checkbox" name="action_to[]" value="<?php echo $group->id; ?>"  /></td>
					<td>

						<div class="img_48 img_groups"></div>
						
					</td>							
					<td><?php echo $group->name; ?></td>
					<td>
						<span style="float:right;">
						</span>

								<span style="float:right;">
									
									<a class="tooltip-s shopbutton button-rounded" href="<?php echo site_url('admin/shop/pgroups/edit/' . $group->id); ?>"><?php echo lang('shop:pgroups:edit');?></a>
								
									<span class="button-dropdown" data-buttons="dropdown">
										<a href="#" class="shopbutton button-rounded button-flat-primary"> 
											<?php echo lang('shop:pgroups:actions');?> 
											<i class="icon-caret-down"></i>
										</a>
										 
										<!-- Dropdown Below Button -->
										<ul class="button-dropdown">

											<li class=''><a class="tooltip-s" href="<?php echo site_url('admin/shop/pgroups/edit/' . $group->id); ?>"><?php echo lang('shop:pgroups:edit');?></a></li>
											<li class='button-dropdown-divider delete'><a class="tooltip-s confirm" href="<?php echo site_url('admin/shop/pgroups/delete/' . $group->id); ?>"><?php echo lang('shop:pgroups:delete');?></a></li>
												 
										</ul>

									</span>



								</span>						
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="9"><div style="float:right;"></div></td>
			</tr>
		</tfoot>
	</table>

	<div class="buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
	</div>
	</div></section>
<?php endif; ?>

<?php echo form_close(); ?>

<?php if (isset($pagination)): ?>
	<?php echo $pagination; ?>
<?php endif; ?>