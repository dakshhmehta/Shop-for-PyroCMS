function set_img(o) {
	
		// Get the brand ID
		bid = $('#bid').attr('value');
		
		$.post('shop/admin/brands/set_cover', { image_id:o.value, brand_id:bid } )
		
			.done(function(data) 
			{			
				var obj = jQuery.parseJSON(data);
	
				//alert(obj.html);
				if (obj.status == 'success') {
					$("#cover_img").html(obj.html);
				}
			}
		);

}


jQuery(function($){

	$('#load_folder').click(function() {
		
		/* Get the values to send to the server */
		f_id = $('#folder_id').val();
		
		var senddata = { folder_id:f_id  };
		
		$.post('shop/admin/images/get_folder_contents', senddata )

		.done(function(data) 
		{
			var obj = jQuery.parseJSON(data);
			
			str = '';
			for (var i = 0; i < obj.length; i++) {
				
				str += "<div class='container'>";
				str += "   <img src='" + obj.url + 'files/thumb/' + obj.content[i] + "/100/100' alt='' style='float:left'>";
				str += "   <input onclick='set_img(this)' type='radio' class='gall_checkbox' id='images[]' name='images[]' value='" + obj.content[i] + "' />";
				str += "</div>";
			}

			$('#img_view').html(str);
			
		});
		
		return false;
	
	});

	$("#folder_id").chosen().change(function() {
		$('#load_folder').click();
	});

});
