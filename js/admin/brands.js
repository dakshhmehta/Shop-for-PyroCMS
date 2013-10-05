/*
 * 
 */
function set_img(o) 
{
	
		// Get the brand ID
		image_id = o.value;

		//set the hidden field
		$('input[name="image_id"]').val(image_id);

		//set the tmp image
		var  img_path =  "<img src='" + SITE_URL +"files/thumb/" + o.value + "/100'>";
		
		$("#cover_img").html(img_path);

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
			for (var i = 0; i < obj.length; i++) 
			{	

				var imgObj = obj.content[i];
				
				str += "<div class='container'>";
				str += "   <img src='" + obj.url + 'files/thumb/' + imgObj.id + "/100/100' alt='' style='float:left'>";
				str += "   <input onclick='set_img(this)' type='radio' class='gall_checkbox' id='images[]' name='images[]' value='" + imgObj.id + "' />";
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
