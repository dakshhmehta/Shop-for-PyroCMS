<div id="">

	<h2>
		past orders
	</h2>


	<ul id="menu">
		{{ shop:mylinks remove='shop messages' active='orders' }}
			{{link}}
		{{ /shop:mylinks }}	
	</ul>


	<div>

			<table>
				<thead>
					<tr>
						<th>ID</th>
						<th>Date</th>

						<th>Total</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>

	
					{{items}}
					<tr>
						<td># {{id}}</td>
						<td>{{order_date}}</td>

						<td>{{cost_total}}</td>
						<td>{{status}}</td>
						<td>
								<a href="{{ url:site }}shop/my/order/{{id}}" class="">view</a>

								{{shop:order_is_unpaid id="{{id}}" }}
									<a href="{{ url:site }}shop/payment/order/{{id}}" class="">pay now</a>
								{{/shop:order_is_unpaid}}

								{{shop:order_is_paid id="{{id}}" }}
									Thank you for your payment
								{{/shop:order_is_paid}}
						 </td>

					</tr>
					{{/items}}

				</tbody>
				
			</table>

	</div>
</div>