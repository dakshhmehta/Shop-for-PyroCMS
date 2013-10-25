



jQuery(function($){
	

	$(function() 
	{



	
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
