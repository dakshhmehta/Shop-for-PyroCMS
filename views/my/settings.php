<!--- FILE.START:VIEW.MY.SETTINGS --->
<h2 id="nc-view-title"><?php echo lang('settings'); ?></h2>
<?php $this->load->view('my/mymenu'); ?>
<div id="SF_CustomerPage">
	<div class="my-dashboard">
		<table>
			<thead>
				<tr>
					<th><?php echo lang('id'); ?></th>
					<th><?php echo lang('description'); ?></th>
					<th><?php echo lang('action'); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td><?php echo lang('enable_email_notifications'); ?></td>
					<td><?php echo anchor("#","on"); ?></td>
				</tr>
				<tr>
					<td>2</td>
					<td><?php echo lang('enable_mini_cart'); ?></td>
					<td><?php echo anchor("#","off"); ?></td>
				</tr>
				<tr>
					<td>3</td>
					<td><?php echo lang('profile');?></td>
					<td><?php echo anchor('users/edit', lang('edit')); ?></td>
				</tr>
			   
			</tbody>
		</table>
		<p>
			<a href="{{ url:site }}shop/my"><?php echo lang('dashboard'); ?></a>
		</p>
	</div>
</div>
<!--- FILE.END:VIEW.MY.SETTINGS --->