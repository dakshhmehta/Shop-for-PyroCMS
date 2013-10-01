<section class="title">
	<h4>Blacklist</h4>
	<h4 style="float:right"><a href="admin/shop/blacklist/create" title="<?php echo lang('new');?>" class='tooltip-s img_icon_title img_create'></a></h4>
</section>
<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
<section class="item"><div class="content">
	<?php if (empty($blacklist)): ?>
		<div class="no_data">
		<p>Blacklist help you manage your store</p>
		<?php echo lang('no_items'); ?></div>
	</div></section>
<?php else: ?>
	<table>			
		<thead>
			<tr>
				<th><input type="checkbox" name="action_to_all" value="" class="check-all" /></th>
				<th>Name</th>
				<th>Method</th>
				<th>Value</th>
				<th>Enabled</th>
				<th style="width: 120px"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($blacklist AS $item): ?>
				<tr class="<?php echo alternator('even', ''); ?>">

					<td>
						<input type="checkbox" name="action_to[]" value="<?php echo $item->id; ?>"  />
					</td>						
					<td><?php echo $item->name; ?></td>
					<td><?php echo fraud_method($item->method);?></td>
					<td><?php echo $item->value;?></td>		
					<td><?php  echo ($item->enabled)? 'YES' : 'NO' ;  ?></td>							
					<td>
						<span style="float:right;">
							<a class="tooltip-s img_icon img_edit"  title="<?php echo lang('edit');?>" href="<?php echo site_url('admin/shop/blacklist/edit/' . $item->id); ?>"> </a>
							<a class="tooltip-s img_icon img_delete confirm" title="<?php echo lang('delete');?>" href="<?php echo site_url('admin/shop/blacklist/delete/' . $item->id); ?>"> </a>	
						</span>
					</td>
				
				</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6"><div style="float:right;"></div></td>
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