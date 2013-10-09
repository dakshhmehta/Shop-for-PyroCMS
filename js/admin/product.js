/*
 * Mode 'set' to set an image, 'clear' to clear the cover
 * @param INT       i     product id
 * @param char(15)  iid   image id 
 */
function set_cover(iid, mode)
{

	if(mode === undefined)
		mode = 'set';

	if(mode === null)
		mode = 'set';


    pid = $('#btn_add_images').attr('pid');
     
	$.post('shop/admin/products/cover_image', { id:pid ,file_id:iid } )
	
    .done(function(data) 
    {			
        var obj = jQuery.parseJSON(data);
        if (obj.status == 'success') 
        {
        
            if(mode=='set')
                $("#prod_cover").attr("src", obj.src);
            else
                $("#prod_cover").attr("src", '');
 
        }
        else
        {
     
        }
       
    });

}


/*
 * This changes the visibility
 *
 */
function sell(i)
{
	id = "#sf_ss_" + i;
    
	var a = $(id).attr("status"); 
    

	
	$.post('shop/admin/products/visibility', { id:i,action:a } ).done(function(data) 
	{			
		var obj = jQuery.parseJSON(data);

		switch(obj.status)
		{
			case 'Sell':
                $(id).attr("class", 'tooltip-s img_icon img_invisible');
				$(id).attr("status", 0);
				break;
			case 'Stop':       
                $(id).attr("class", 'tooltip-s img_icon img_visible');           
				$(id).attr("status", 1);
				break;		
			default:
				alert('Oops, something went wrong. Try refreshing the page');
                $(id).attr("class", 'img_icon img_warning');
				$(id).attr("status", 0);                 
				break;		
		}

	});
}



function move_option( option_id, direction )
{

    postto = "admin/shop/options/move_product_option/";
    
    return do_move_option_value( postto, { o:option_id, dir:direction } );
    
}

function do_move_option_value(postto, params )
{

    $.post(postto,  params )
    .done(function(data) 
    {		
	
        var obj = jQuery.parseJSON(data);

        if (obj.status == 'success') 
        {        
        
            //Select list where
            var a = '#option_assign_' + obj.items[0] ;
            var b = '#option_assign_' + obj.items[1] ;
        
            $(a).swap($(b));         
        }
        else
        {
            //only execute on error
        }
        


    });
    
    //Will fire code even if not completed ajax
    // be careful adding code here
    
}


function console_add(content)
{
	content = '<li>' + content + '</li>';

	$('#console-list').append(content);
}




jQuery(function($){
	

	$(function() {




        

        
		$('.tab-loader').click(function() {
			

			id = $('#static_product_id').attr('data-pid'); 

            val = $(this).attr('data-load');


		    // Define path to loading image
		    var loading_image = MOD_PATH + '/css/img/gif/ajax-loader.gif';

    
		    // Built temp HTML
		    var str = '<center><div class="loading_image_container"><img src="'+loading_image+'" /></div></center>';
		    
		    
		    // Define the Panel Object
		    var panel = '#' + val + '-tab';

			
			
		    if($(panel).has('.not-loaded').length)
		    {

			   // if($(panel).has('.wait-message').length)
			    //{
	    		//	wait_message = $.trim( $(panel).html() );
	    		//}

		    		// 
		    		// load
				    // Display HTML
				    // 
				    $(panel).html(str); //clear the contents of the panel


				    $(panel).load('shop/admin/product/load/' + id + '/'+ val , function() 
				    {
					    // This gets executed when the content is loaded
				    	$(panel).show();

					});


		    }
		    else
		    {
		    	//alert('this panel is alread loaded');
		    	console_add('ALREADY LOADED');
		    }



            
			return false;
		
		});	


		

	   

	});

});

//#end2
