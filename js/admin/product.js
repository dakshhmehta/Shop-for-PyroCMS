/*
 * Mode 'set' to set an image, 'clear' to clear the cover
 * @param INT       i     product id
 * @param char(15)  iid   image id 
 */
function set_cover(iid, mode='set')
{
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


jQuery(function($){
	

	$(function() {
		//will set in the db
		$('#btn_add_images').click(function() {
			
			imgs = $('input:checkbox[name="images"]:checked').map(function() { return this.value; }).get();
			
			// Get the product ID
			pid = $('#btn_add_images').attr('pid');
			
			var senddata = { images:imgs, product_id:pid  };

			
			$.post('shop/admin/products/gallery_add/', senddata )

			.done(function(data) 
			{

				var obj = jQuery.parseJSON(data);

				//Uncheck the boxes
				$('input:checkbox[name="images"]:checked').removeAttr("checked"); // uncheck the checkbox or radio
			
				//show the image action buttons	
				var current_images = $('#scrollable_images_panel').html();	
				
				for (var i = 0; i < obj.added.length; i++) {

					//Generate a unique (ish) id for jQ to remove the image when needed
					dom_id = 'js_img_id_' + obj.added[i];
					
					current_images += "<div class='container' id='" + dom_id + "'>";
					current_images += "<a class='img_icon img_delete remove_image gall_cover' data-image='" + obj.added[i] + "' data-parent='" + dom_id + "'></a>";
					current_images += "<a href='javascript:set_cover(\"" + obj.added[i] + "\")' class='img_icon img_home gall_cover'></a>";


					current_images += "<img class='tooltip-s' title='" + obj.name + "' src='" + obj.url + "files/thumb/" + obj.added[i] + "/100/100' alt='' style=''>";
					current_images += "</div>";
				}
				
				$('#scrollable_images_panel').html(current_images);	

			});
			
			return false;
		
		});	 

        

        
		//
        //
        // Remove image from gallery
        //
        //
		$('.remove_image').click(function() {
			

            img = $(this).attr('data-image');
            var parent = $(this).attr('data-parent');               /*get the parent container id - this is what we remove*/  
            var pid = $("#static_product_id").attr('data-pid');     /*get the product id*/
            

            $.post('shop/admin/products/gallery_remove', { image:img, product_id:pid  } ).done(function(data) 
            {			
                var obj = jQuery.parseJSON(data);
                
                if (obj.status == 'success') 
                {
                    $('#' + parent).remove();
                }

            });
            
			return false;
		
		});		
		
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
				for (var i = 0; i < obj.length; i++) 
				{
					
					var imgObj = obj.content[i];


					str += "<div class='gall_container'>";
					str += "   <img class='tooltip-s' title='" + imgObj.name + "' src='" + obj.url + 'files/thumb/' + imgObj.id + "/100/100' alt='' style='float:left'>";
					str += "   <input type='checkbox'  class='gall_checkbox' name='images' id='images' value='" + imgObj.id + "' />";
					str += "</div>";
				}

				$('#img_view').html(str);
				
			});
			
			return false;
		
		});		

		$("#folder_id").chosen().change(function() {
			$('#load_folder').click();
		});
	   
		
		$('#keywords').tagsInput({
			autocomplete_url: 'admin/keywords/autocomplete'
		});


		//Check all images
		$('#btn_select_all_images').click(function() {
            
            $('input:checkbox[name=images]').attr('checked', true);
            
			return false;

		});   
		//Check all images
		$('#btn_select_none_images').click(function() {
            
            $('input:checkbox[name=images]').attr('checked', false);

			return false;

		});   
		
		$('#add-discounts').click(function() {
			var id = $("#discounts-list tr").length;
			var content = '';
			content += '<tr id="item_'+id+'">';
			content += '   <td><input type="text" class="disc_qty" value="" name="discounts['+id+'][min_qty]"></td>';
			content += '   <td><input type="text" class="disc_price" value="" name="discounts['+id+'][price]"></td>';		
			content += '   <td><a class="img_delete img_icon remove" data-row="item_'+id+'"></a></td>';
			content += '</tr>';
			$('#discounts-list').append(content);
			return false;
		});
        

    
        
		$('#discounts-list .remove').live('click', function(e) {
			var item = $(this).attr('data-row');
			var test = confirm('Please confirm action');
			if (test) {
				$('#'+item).remove();
			}
			return false;
		});
        

		/**
		 * 
		 * @param  {[type]} e [description]
		 * @return {[type]}   [description]
		 */
		$('input[name="name"]').live('change', function(e) {

			var new_name = $(this).val();

			$("#title_product_name").html(new_name);
			
			return false;
		}); 


		//will set in the db
		$('#add-property').click(function() {
			
			var i = $("#static_product_id").attr('data-pid'); /*Get the product ID*/
			var n = $("input[name='add_attrib_label']").val();  /*need this to help remove from the UI*/
			var v =  $("input[name='add_attrib_value']").val();  /*need this to help remove from the UI*/
			var a = 'add'; /*data to send*/

			var senddata = { action:a, id:i, name:n, value:v };
			
			$.post('shop/admin/products/ajax_product_attributes', senddata )

			.done(function(data) 
			{
				var obj = jQuery.parseJSON(data);
				
				if(obj.status == 'success')
				{
					var content = build_li_attribute_html( n, v, obj.id);
					$('#properties-list').append(content);

					/*clear the values*/
					$("input[name='add_attrib_label']").val(''); 
					$("input[name='add_attrib_value']").val('');


				}
				else
				{
					alert(obj.status);
				}

			});
			
			return false;
		
		});	


        
		//will set in the db
		$('#properties-list .remove').live('click',function() {
		
			var item = $(this).attr('data-row'); /*need this to help remove from the UI*/
			var i = $(this).attr('data-id'); /*data to send*/
			var a = 'delete'; /*data to send*/

	
			var senddata = { action:a, id:i };

			$.post('shop/admin/products/ajax_product_attributes', senddata )

			.done(function(data) 
			{
				var obj = jQuery.parseJSON(data);
				
				if(obj.status == 'success')
				{
					$('#properties-list #' + item ).remove();

				}
				else
				{
					alert(obj.status);
				}
				
			});
			
			return false;
		
		});	
        



        
        /* Create Option Assignment
         *
         * Creates a new assignment
         * Returns the new id and creates the new html to inject in the DOM
         *
         */
		$('#add-option').click(function() {
        
			//var length = $("#options-list li").length;
            
            var product_id = $("#static_product_id").attr('data-pid');
            //get the current option value/id
            var o_id = $("select[name=option_id]").val();
            
            //make sure something is selected
            if (o_id == 0) { alert('Please select an option'); return false; }
            
            
            var key = "select[name=option_id] option[value='" + o_id + "']";
            
            //Name for the display
            var option_name = $(key).text();
            
            postto = "admin/shop/options/product_option/";
            
            $.post(postto, {p:product_id , o:o_id, a:'add'} ).done(function(data) 
            {			
                var obj = jQuery.parseJSON(data);
                
                if (obj.status == 'success') 
                {
                    
                    var content = build_li_option_html( obj.assign_id,  option_name);
                    
                    $('#options-list').append(content);
                    
                }

            });
                

			return false;
            
		});	 
        
        
        
        /* Delete Option Assignment
         *
         *
         * Call delete of product option assignment
         * Delete via ajax and update(remove) from list
         *
         *
         */
		$('#options-list .remove').live('click', function(e) {
        
	
			var option_id = $(this).attr('data-option-id');

            
            postto = "admin/shop/options/product_option/";

			var test = confirm('Please confirm action');
            
			if (test) {
             
                $.post(postto, {o:option_id,a:'delete'} ).done(function(data) 
                {			
                    var obj = jQuery.parseJSON(data);
                    
                    if (obj.status == 'success') 
                    {
                        // remove from list (UI)
                        $('#option_assign_'+option_id).remove();
                    }

                });
            
				
			}
			return false;
		});
        
        
        
        //Move Up
		$('#OptionButtons .img_up').live('click', function(e) {
			
            // move_option(  PROD_OPTION_ID  , DIRECTION );
            move_option(  $(this).attr('data-option-id')  , 'up' );
            
			return false;
            
		});
        
        //Move Down
		$('#OptionButtons .img_down').live('click', function(e) {

            // move_option(  PROD_OPTION_ID  , DIRECTION );
            move_option(  $(this).attr('data-option-id')  , 'down' );
            
			return false;
            
		});
        

	});

});

//#end2
