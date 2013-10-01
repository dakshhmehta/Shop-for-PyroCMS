function sell(i)
{
	id = "#sf_ss_" + i;
    pii = "#sf_img_" + i;
    
	var a = $(id).attr("status"); 
    

	
	$.post('shop/admin/products/visibility', { id:i,action:a } ).done(function(data) 
	{			
		var obj = jQuery.parseJSON(data);

		switch(obj.status)
		{
			case 'Sell':
                $(id).attr("class", 'tooltip-s img_icon img_invisible');
                $(pii).attr("class", '_hidden');
				$(id).attr("status", 0);
				break;
			case 'Stop':       
                $(id).attr("class", 'tooltip-s img_icon img_visible');
                $(pii).attr("class", '');                
				$(id).attr("status", 1);
				break;		
			default:
				alert('Oops, something went wrong. Try refreshing the page');
                $(id).attr("class", 'img_icon img_warning');
                $(pii).attr("class", '_hidden');
				$(id).attr("status", 0);                 
				break;		
	
		}

	});
}


function toggle_filter() 
{
	var e = document.getElementById('hideable_filters');
    //var e = document.getElementById('filters_group');
    var o = document.getElementById('flink');
    
    

	if (e.style.display =='none') 
    {
        o.className  = 'img_icon_title img_filter selected';
        e.style.display = 'block'; 
    }
    else
    {

        o.className  = 'img_icon_title img_filter';
        e.style.display = 'none'; 
    }
    
}


jQuery(function($)
{
	
 
	$(function() 
    {
		

	  
	});

});