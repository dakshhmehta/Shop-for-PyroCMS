
function view(id) {
	
	var senddata = { txn_id:id  };

	$('#txn_panel').html("loading..");
	
	$.post('shop/admin/orders/viewtx', senddata )
	
		.done(function(data) 
		{			
			var obj = jQuery.parseJSON(data);

			
			var _content = "";

			_content += "<table>";
			_content += "<tr>";
			
			_content += "<tr><td width='20%'>Status:</td><td class='sf_val2'>" + obj.status + "</td></tr>" ;
			_content += "<tr><td>Message:</td><td class='sf_val2'>" +  obj.message + "" + "</td></tr>" ;
			_content += "<tr><td>User:</td><td class='sf_val2'>" +  obj.user + "" + "</td></tr>" ;
			_content += "<tr><td>SYS TXN ID:</td><td class='sf_val2'>" +  obj.id + "" + "</td></tr>" ;
			_content += "<tr><td>Order ID:</td><td class='sf_val2'>" +  obj.order_id + "" + "</td></tr>" ;
			_content += "<tr><td>GTW TXN ID:</td><td class='sf_val2'>" +  obj.txn_id + "" + "</td></tr>" ;
			_content += "<tr><td>GTW TXN Status:</td><td class='sf_val2'>" +  obj.txn_status + "" + "</td></tr>" ;
			_content += "<tr><td>Amount:</td><td class='sf_val2'>" +  obj.amount + "" + "</td></tr>" ;
			_content += "<tr><td>Refunded:</td><td class='sf_val2'>" +  obj.refund + "" + "</td></tr>" ;
			_content += "<tr><td>TimeStamp:</td><td class='sf_val2'>" +  obj.timestamp + "" + "</td></tr>" ;

			//if we have a nested json object in the data
			if (obj.data != "") {
				var json_data = jQuery.parseJSON(obj.data);
				
				if (typeof json_data === 'object') 
				{
					
					jQuery.each(json_data, function(i, val) {
						
						_content += "<tr><td>" + i + "</td><td class='sf_val'>" +  val + "" + "</td></tr>" ;
		
					});
				}
			}
			
			_content += "</table>";

			$('#txn_panel').html(_content);
			
		}
	);

}

jQuery(function($){


        //Move Up
		$('.add_to_blacklist').live('click', function(e) 
		{
			

			/* Get the values to send to the server */
			val = $('#ip_of_order').html();

			var senddata = { ip:val  };
			
			$.post('shop/admin/blacklist/block_ip', senddata )

			.done(function(data) 
			{
				alert(data);
				
			});
			
			return false;			
            
		});


});
