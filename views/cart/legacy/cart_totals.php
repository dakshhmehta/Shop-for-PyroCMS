
	   <div>
			<div>
				<h2><?php echo lang('cart_totals'); ?></h2>
				<table>
				  <tbody>			  
					<tr>
					  <th>
						<strong><?php echo lang('items'); ?></strong>
					  </th>
					  <td>
					  	{{ shop:total cart="sub-total" format='YES' }}
					  </td>
					</tr>				
					<tr>
					  <th>
						<strong><?php echo lang('order_total'); ?></strong>
					  </th>
					  <td>
						<strong>
						  <span>
						  		{{ shop:total cart="total" format='YES' }}
						  </span>
						</strong>
					  </td>
					</tr>
				  </tbody>
				</table>
			</div>
		</div>			
	