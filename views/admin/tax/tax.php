<!--- FILE.START:VIEW.ADMIN.TAX.TAX --->
<section class="title">
	<h4><?php echo lang('tax'); ?></h4>
	<h4 style="float:right"><a href="admin/shop/tax/create/" class='tooltip-s img_icon_title img_create' title='<?php echo lang('new'); ?>'></a></h4>
</section>
<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
<section class="item">
	<div class="content">
		<?php if (empty($taxes)): ?>
			<div class="no_data">
			<p><?php echo lang('tax_description'); ?></p>
			<?php echo lang('no_items'); ?>	
			</div>
		<?php else: ?>
		<table>			
			<thead>
				<tr>
					<th><input type="checkbox" name="action_to_all" value="" class="check-all" /></th>
					<th><?php echo lang('id'); ?></th>
					<th><?php echo lang('name'); ?></th>
					<th><?php echo lang('rate'); ?></th>
					<th style="width: 120px"></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($taxes AS $tax): ?>
					<tr>
						<td><input type="checkbox" name="action_to[]" value="<?php echo $tax->id; ?>"  /></td>
						<td><?php echo $tax->id; ?></td>
						<td><?php echo $tax->name; ?></td>
						<td><?php echo $tax->rate; ?> %</td>
						<td>
							<a class="tooltip-s img_icon img_edit" href="<?php echo site_url('admin/shop/tax/edit/' . $tax->id); ?>"></a>
							<a title= '<?php echo lang('delete'); ?>' class="tooltip-s img_icon img_delete confirm" href="<?php echo site_url('admin/shop/tax/delete/' . $tax->id); ?>"></a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7"><div style="float:right;"></div></td>
				</tr>
			</tfoot>
		</table>
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
		</div>
	<?php endif; ?>
	</div>
</section>
<?php echo form_close(); ?>
<?php if (isset($pagination)): ?>
	<?php echo $pagination; ?>
<?php endif; ?>
<!--- FILE.END:VIEW.ADMIN.TAX.TAX --->