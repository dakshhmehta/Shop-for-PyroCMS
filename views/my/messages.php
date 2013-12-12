<div>
<h2>Messages</h2>

	<ul id="menu">
		{{ shop:mylinks remove='shop messages' active='messages' }}
			{{link}}
		{{ /shop:mylinks }}	
	</ul>



		<div>
			<table>
				<thead>
					<tr>
						<td><?php echo lang('shop:label:id'); ?></td>
						<td><?php echo lang('shop:label:user_id'); ?></td>
						<td><?php echo lang('shop:label:order_id'); ?></td>
						<td><?php echo lang('shop:label:message'); ?></td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					{{messages}}
					<tr>
						<td>{{id}}</td>
						<td>{{order_id}}</td>
						<td>{{message}}</td>
						<td>{{user_id}}</td>
						<td><a href="{{ url:site }}shop/my/orders/order/{{order_id}}" class="button">View order</a></td>
					</tr>
					{{/messages}}
				</tbody>
			</table>
			<p>
				<a href="{{ url:site }}shop/my"><?php echo lang('dashboard'); ?></a>
			</p>
	</div>
	
</div>
