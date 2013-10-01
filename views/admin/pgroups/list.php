<section class="title">
	<h4><?php echo lang('product_groups'); ?></h4>
	<h4 style="float:right"><a href="admin/shop/pgroups/create" class='img_icon_title img_create'></a></h4>
</section>
<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
<section class="item">
	<div class="content">
	<?php if (empty($productgroups)): ?>
		<div class="no_data">
		<?php echo lang('no_items'); ?></div>
	</div></section>
<?php else: ?>
	<table>			
		<thead>
			<tr>
				<th><input type="checkbox" name="action_to_all" value="" class="check-all" /></th>
				<th></th>
				<th><?php echo lang('product_group'); ?></th>
				<th style="width: 120px"></th>
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
							<a class="tooltip-s img_icon img_edit" href="<?php echo site_url('admin/shop/pgroups/edit/' . $group->id); ?>"> </a>
							<a class="tooltip-s img_icon img_delete confirm" href="<?php echo site_url('admin/shop/pgroups/delete/' . $group->id); ?>"> </a>
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