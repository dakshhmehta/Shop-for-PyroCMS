	
	<div class="one_half last" id="" >
	
		<section class="title">
				<h4><?php echo lang('shop:options:option_values'); ?></h4>
				<h4 style="float:right"><a class="modal img_icon img_create" href="shop/admin/options/addoption/<?php echo $id;?>"></a></h4>
		</section>
		
		<section class="item form_inputs">
			
			<div class="content">

				<fieldset>
				
					<br />


					<table id="options-values-list">

							<?php if(isset($values)):?>


									<?php 
										$first = 1; 
										$last = count($values);
									?>
									<?php foreach($values as $key => $option): ?>
										<!--- -->
										<tr id="option_value_<?php echo $option->id;?>">
											<td>
											

													<label id="LabelOptionValue_<?php echo $option->id;?>" class="toggle_edit" data-id="<?php echo $option->id;?>" >
														<?php echo $option->value;?>
													</label>

													<span id="OptionButtonList" class="input" style="float:right">
											
														<a href="#" id="btn_move_up" class="img_up img_icon" 		option-value-id="<?php echo $option->id;?>" data-id="<?php echo $id;?>"></a>
														<a href="#" id="btn_move_down" class="img_down img_icon" 	option-value-id="<?php echo $option->id;?>" data-id="<?php echo $id;?>"></a>		
										
														<a href="#" class="img_edit img_icon edit" 		data-id="<?php echo $option->id;?>"></a>
														<a href="#" class="img_delete img_icon remove" 	data-id="<?php echo $option->id;?>"></a>
												 
													</span> 
											
												<br />
												<div id="WorkingPanel_<?php echo $option->id;?>" style="display:none;" class="wphide">
													<div class='not-loaded'></div>
												</div>									
											</td>									
										</tr>


									<?php endforeach; ?>


							<?php endif; ?>				
					</table>			
				</fieldset>
				
			</div>
			
		</div>
	</div>


<script>

function toggle_view(id,method)
{
    panel = "#WorkingPanel_" + id;

    var closed = $(panel).has('.not-loaded').length;


    if( closed > 0 )
    {
        //alert('its closed so I will open');
        loadEditPanel(id); 
    }

    if(method=='td') 
    	return false;    

    if( closed == 0 )
    {
        //alert('its open so I will close now');
        closeEditPanel(id);

    }

    return false;    
}


function close_all()
{
	$('.wphide').hide(); //hide the panel
}

/*
 * When editing a option value
 * We can click cancel or the edit button again
 * This action will close the edit panel by first removing the html
 * And hiding the working panel
 */
function closeEditPanel(id)
{
    $('#WorkingPanel_' + id).html('<div class="not-loaded"></div>'); //clear the contents of the panel
    $('#WorkingPanel_' + id).hide(); //hide the panel
}


/**
 * Loads the edit panel on the fly for editing options
 * utilizes ajax to minimize HTML request and faster response times
 *
 */
function loadEditPanel(id)
{


    // Define path to loading image
    var loading_image = MOD_PATH + '/css/img/gif/ajax-loader.gif';
    
    // Built temp HTML
    str = '<center><img src="'+loading_image+'" /></center>';
    
    
    // Define the Panel Object
    var panel = '#WorkingPanel_' + id;
    
    // Display HTML
    $(panel).html(str); //clear the contents of the panel

    $(panel).show();

    arg = "load_panel("+id+")" ;

    window.setTimeout(  arg , 1800 ); // 5 seconds    

 
    // Now start loading ajax panel
   // $(panel).load('shop/admin/options/editoption/' + id);

    // Now start loading ajax panel
       



}

function load_panel(id)
{


    var panel = '#WorkingPanel_' + id;

    $(panel).hide();

    $(panel).load('shop/admin/options/editoption/' + id , function() 
    {
    	close_all();

        $(panel).show();


    });

   
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



jQuery(function($) 
{



        //
        // Move Up
        //
		$('#btn_move_up').live('click', function(e) 
        {

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
		$('#btn_move_down').live('click', function(e) 
        {
            
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
		$('.toggle_edit').on('click', function(e) 
        {
        
       
            var id = $(this).attr('data-id');

            toggle_view(id,'td');


            return false;            
               
            
		}); 


        //
        // Edit Option Value
        //
		$('#OptionButtonList .edit').on('click', function(e) 
        {
                   
            var id = $(this).attr('data-id');

            toggle_view(id,'btn');  

            return false;
            
		}); 
        
        
        

   		//
        // Edit->Cancel
        //
        $('#btn_cancel_edit').live('click', function(e) 
        {

            var id = $(this).attr('data-id');           
            closeEditPanel(id);
            return false;
        }); 

        
        
        //
        // Edit->Save() Option Value
        //
        $('#btn_save_edit').live('click', function(e) 
        {
        
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
		$('#options-values-list .remove').live('click', function(e) 
        {
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


</script>