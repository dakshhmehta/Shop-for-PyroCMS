function set_img(o) 
{

	id = '#ci_' + o.value;
	$('#image_id').val(  o.value  ); //set the form for update
	$('#cover_img').html(  $(id).html()  ); //set the image for display

}


jQuery(function($)
{

	//will set in the db
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
				str += "   <div id='ci_" + obj.content[i].id + "'><img src='" + obj.url + 'files/thumb/' + obj.content[i].id + "/100/100' alt='' style=''></div>";
				str += "   <input onclick='set_img(this)' type='radio' class='gall_checkbox' id='images[]' name='images[]' value='" + obj.content[i].id + "' />";
				str += "</div>";
			}

			$('#img_view').html(str);
			
		});
		
		return false;
	
	});

	$("#folder_id").chosen().change(function() 
	{
		$('#load_folder').click();
	});

});
