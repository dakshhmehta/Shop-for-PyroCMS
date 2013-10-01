
/*
 * clears the current form
 * to make adding multiple 
 * many items quick.
 */
function clearForm(form)
{
    $(":input", form).each(function()
    {
    var type = this.type;
    var tag = this.tagName.toLowerCase();
    	if (type == 'text')
    	{
            this.value = "";
    	}
    });
};








/*
 * When editing a option value
 * We can click cancel or the edit button again
 * This action will close the edit panel by first removing the html
 * And hiding the working panel
 */
function closeEditPanel(id)
{
    $('#WorkingPanel_' + id).html(''); //clear the contents of the panel
    $('#WorkingPanel_' + id).hide(); //hide the panel
}


/**
 * Loads the edit panel on the fly for editing options
 * utilizes ajax to minimize HTML request and faster response times
 *
 */
function loadEditPanell(id)
{

    // Define path to loading image
    var loading_image = MOD_PATH + '/css/img/gif/ajax-loader.gif';
    
    // Built temp HTML
    str = '<center><img src="'+loading_image+'" /></center>';
    
    
    // Define the Panel Object
    var panel = '#WorkingPanel_' + id;
    
    // Display HTML
    $(panel).html(str); //clear the contents of the panel

    // Now start loading ajax panel
    $(panel).load('shop/admin/options/editoption/' + id);
    
    // Display
    $(panel).show();

}




function do_move_option_value(postto, params )
{

    $.post(postto,  params )
    .done(function(data) 
    {		
	
        var obj = jQuery.parseJSON(data);

        var a = '#option_value_' + obj.items[0];
        var b = '#option_value_' + obj.items[1];
        
        if (obj.status == 'success') 
        {        
            $(a).swap($(b));         
        }
        else
        {

        }

    });
    
}



jQuery(function($){



        //
        // Move Up
        //
		$('#btn_move_up').live('click', function(e) {

            //var option_id = $('input[name=id]').val();  
            var option_value_id = $(this).attr('option-value-id');   
            var postto = 'admin/shop/options/move_item_up/';   
            
            //do ajax call
            do_move_option_value(postto, { v:option_value_id} );
            
            return false;
		}); 
        
  
  
        //
        // Move Down
        //
		$('#btn_move_down').live('click', function(e) {
            
            //var option_id = $('input[name=id]').val();            
            var option_value_id = $(this).attr('option-value-id');   
            var postto = 'admin/shop/options/move_item_down/';   
            
            //do ajax call 
            do_move_option_value(postto, { v:option_value_id} );
            
            return false;
            
		}); 
        
        
       
        //
        // Edit Option Value
        //
		$('#OptionButtonList .edit').live('click', function(e) {
        
        
            var id = $(this).attr('data-id');
            
            //var panel = '#WorkingPanel_' + id;
            
            loadEditPanell(id);
            
            return false;    
            
		}); 
        
        
        
        //
        // Edit->Cancel
        //
		$('#btn_cancel_edit').live('click', function(e) {
            var id = $(this).attr('data-id');           
            closeEditPanel(id);
            return false;
		}); 

        
        
        //
        // Edit->Save() Option Value
        //
		$('#btn_save_edit').live('click', function(e) {
        
            var id = $(this).attr('data-id');   
            var postto = 'admin/shop/options/ajax_edit_value/';  
            var myform = $('#myform_' + id ).serialize();
            
            $.post( postto,  myform )
            
                .done(function(data) 
                {			
                    var obj = jQuery.parseJSON(data);
                    if (obj.status == 'success') 
                    {
                        // Update the name label
                        $('#LabelOptionValue_'+id).html(obj.value);
                        
                    }
                    
                    // Close the working panel
                    closeEditPanel(id);
                    
                });

                

            
            // Suppress
            return false;
		}); 
        
        

        //
        // Delete()
        //
		$('#options-values-list .remove').live('click', function(e) {
            var id = $(this).attr('data-id');
			var test = confirm('Are you sure you want to delete this Option value: ' + id +'?');
			if (test) 
            {
                //do ajax call to delete instantly
                $.post('shop/admin/options/ajax_delete_value/', { ovid:id } )
   
                    .done(function(data) 
                    {			
                        var obj = jQuery.parseJSON(data);
                        if (obj.status == 'success') 
                        {
                            $('#option_value_'+id).remove();
                        }
                        else
                        {
                            alert(obj.message);
                        }

                    });

			}
			return false;
            
		});
        
        
});
