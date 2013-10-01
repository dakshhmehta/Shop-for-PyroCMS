





jQuery(function($){
	

	$(function() 
	{



		





		$('#add-price').click(function() 
		{

			var id = $("#price-list tr").length;
			var content = '';
			content += '<tr id="item_'+id+'">';
			content += '   <td><input type="text" class="disc_qty" value="" name="prices['+id+'][min_qty]"></td>';
			content += '   <td><input type="text" class="disc_price" value="" name="prices['+id+'][price]"></td>';		
			content += '   <td><a class="img_delete img_icon remove" data-row="item_'+id+'"></a></td>';
			content += '</tr>';
			$('#price-list').append(content);
			return false;

		});
        

    
        
		$('#price-list .remove').live('click', function(e) {
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

	});

});

//#end2
