
<section class="title">
	<h4><?php echo shop_lang('shop:orders:orders'); ?></h4>
	<h4 style="float:right">
		
	</h4>	
</section>

<section class="item">
<div class="content">
<?php $this->load->view('admin/orders/filter'); ?>

	<?php if (empty($items)): ?>
		<div class="no_data"><?php echo shop_lang('shop:orders:no_data'); ?></div>
	<?php else: ?>
		<table>
			<thead class='title'>		
				<tr>
					<th class="collapse" style="width:35px">ID</th>
					<th class="collapse"><?php echo shop_lang('shop:orders:pmt_status'); ?></th>
					<th class="collapse"></th>
					<th class="collapse"><?php echo shop_lang('shop:orders:customer'); ?></th>
					<th class="collapse"><?php echo shop_lang('shop:orders:date'); ?></th>
					<th class="collapse"><?php echo shop_lang('shop:orders:total'); ?></th>
					<th class="collapse"><?php echo shop_lang('shop:orders:score'); ?></th>
					<th class="collapse"><?php echo shop_lang('shop:orders:progress_status'); ?></th>
					<th style="text-align:right"><?php echo shop_lang('shop:orders:actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<div id="filter-stage" class="">
					<?php $this->load->view('admin/orders/line_item'); ?>
				</div>			
			</tbody>
			<tfoot>
				<tr>
					<td colspan="8">
						<div class="inner"><?php echo $pagination['links'];?></div>
					</td>
				</tr>
			</tfoot>			
		</table>
		<div class="table_action_buttons">

		</div>
	<?php endif; ?>
			</div>
</section>