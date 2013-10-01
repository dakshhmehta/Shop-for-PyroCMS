<section class="title">
	<h4><?php echo lang('categories'); ?></h4>
	<h4 style="float:right"><a href="admin/shop/categories/create" title="<?php echo lang('new');?>" class='tooltip-s img_icon_title img_create'></a></h4>
</section>
<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
<section class="item">
	<div class="content">
	<?php if (empty($categories)): ?>
		<div class="no_data">
		<p><?php echo lang('categoriy_description'); ?></p>
		<?php echo lang('no_items'); ?></div>
		</div>
	</section>
<?php else: ?>
	<table>			
		<thead>
			<tr>
				<th><input type="checkbox" name="action_to_all" value="" class="check-all" /></th>
				<th><?php echo lang('image'); ?></th>
				<th><?php echo lang('category'); ?></th>
				<th style="width: 120px"></th>
			</tr>
		</thead>
		<tbody>




			<?php foreach ($categories AS $category): ?>

				<?php 

					//init the data field
					$data->category = $category;

				?>

				<?php $this->load->view('admin/categories/line_item',$data); ?>
					

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