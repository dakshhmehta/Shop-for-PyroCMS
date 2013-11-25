<section class="title">
	<h4>
		<?php echo lang('shop:brands:brands');?>
	</h4>
	<h4 style="float:right">
		<a href="admin/shop/brands/create" title="<?php echo lang('shop:brands:new');?>" class='tooltip-s img_icon_title img_create'>
		</a>
	</h4>
</section>
<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
<section class="item"><div class="content">
	<?php if (empty($brands)): ?>
		<div class="no_data">
			<p>
				<?php echo lang('shop:brands:description');?>
			</p>
			<?php echo lang('shop:brands:no_data');?>
		</div>
	</div></section>
<?php else: ?>
	<table>			
		<thead>
			<tr>
				<th><input type="checkbox" name="action_to_all" value="" class="check-all" /></th>
				<th><?php echo lang('shop:brands:image');?></th>
				<th><?php echo lang('shop:brands:brand_name');?></th>
				<th style="width: 120px"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($brands AS $brand): ?>
				<tr class="<?php echo alternator('even', ''); ?>">
					<td><input type="checkbox" name="action_to[]" value="<?php echo $brand->id; ?>"  /></td>
					<td>
						<?php if ($brand->image_id != NULL): ?>
							<img src="files/thumb/<?php echo $brand->image_id;?>/50/50" alt="<?php echo $brand->name." logo";?>" />
						<?php else: ?>
							<div class="img_noimg"></div>
						<?php endif; ?>
					</td>							
					<td><?php echo $brand->name; ?></td>
					<td>
						<span style="float:right;">
							<a class="tooltip-s img_icon img_edit"  title="<?php echo lang('shop:admin:edit');?>" href="<?php echo site_url('admin/shop/brands/edit/' . $brand->id); ?>"> </a>
							<a class="tooltip-s img_icon img_delete confirm" title="<?php echo lang('shop:admin:delete');?>" href="<?php echo site_url('admin/shop/brands/delete/' . $brand->id); ?>"> </a>	
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
	</div>
	</section>
<?php endif; ?>

<?php echo form_close(); ?>

<?php if (isset($pagination)): ?>
	<?php echo $pagination; ?>
<?php endif; ?>