<section class="title">
	<h4><?php echo shop_lang('shop:options:options'); ?></h4>
	<h4 style="float:right">
	<a title='<?php echo shop_lang('shop:options:new'); ?>' href="admin/shop/options/create" class='tooltip-s modal img_icon_title img_create'></a>
	</h4>
</section>
<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
<section class="item">
	<div class="content">
		<?php if (empty($options)): ?>
			<div class="no_data">
				<p>
					<?php echo shop_lang('shop:options:description'); ?>
				</p>
				<?php echo shop_lang('shop:options:no_data'); ?>
			</div>
		</section>
	<?php else: ?>
		<table>			
			<thead>
				<tr>
					<th><input type="checkbox" name="action_to_all" value="" class="check-all" /></th>
					<th></th>
					<th><?php echo shop_lang('shop:options:title'); ?></th>
					<th><?php echo shop_lang('shop:options:name'); ?></th>
					<th><?php echo shop_lang('shop:options:type'); ?></th>
					<th style="width: 120px"></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($options AS $item): ?>
					<tr class="<?php echo alternator('even', ''); ?>">
						<td><input type="checkbox" name="action_to[]" value="<?php echo $item->id; ?>"  /></td>
						<td>

							<div class="img_48 img_groups"></div>
							
						</td>							
						<td><?php echo $item->title; ?></td>
						<td><?php echo $item->name; ?></td>
						<td><?php echo $item->type; ?></td>
						<td>

							<span style="float:right;">

								<span class="button-dropdown" data-buttons="dropdown">
								
										<a href="#" class="shopbutton button-rounded button-flat-primary"> 
											<?php echo shop_lang('shop:options:actions');?> 
											<i class="icon-caret-down"></i>
										</a>
										 
										<!-- Dropdown Below Button -->
										<ul class="button-dropdown-menu-below">

											<li class=''><a title='<?php echo shop_lang('shop:options:edit'); ?>' class="" href="<?php echo site_url('admin/shop/options/edit/' . $item->id); ?>"> <?php echo shop_lang('shop:options:edit');?>  </a></li>
											<li class=''><a title='<?php echo shop_lang('shop:options:copy'); ?>' class="" href="<?php echo site_url('admin/shop/options/duplicate/' . $item->id); ?>"> <?php echo shop_lang('shop:options:copy');?> </a></li>
											<li class='button-dropdown-divider delete'><a title='<?php echo shop_lang('shop:options:are_you_sure'); ?>' class="tooltip-e confirm" href="<?php echo site_url('admin/shop/options/delete/' . $item->id); ?>"><?php echo shop_lang('shop:options:delete');?>  </a></li>

										</ul>

								</span>

							</span>



						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="9">
					<div style="">
						<?php echo $pagination['links'];?>
						
					</div></td>
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

