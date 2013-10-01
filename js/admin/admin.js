/*
 * Simple swap function
 * Can swap any 2 elements in Jquery
 * Using a.swap(b);
 */
$.fn.swap = function(other) {
    $(this).replaceWith($(other).after($(this).clone(true)));
};



jQuery(function($){

	/*
	 * Generate Slug for Products,  Categories, Brands etc..
	 */  
	pyro.generate_slug('input[name="name"]', 'input[name="slug"]');

	/*
	 * Present jQuery Date Picker
	 */
	$(".datepicker").livequery(
		  function() 
          { 
			   // This function is called when a new object is found. 
			   $(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});
		  }, 
		  function() 
          { 
			   // This function is called when an existing item is being removed. 
               // I don't think you need this one so just leave it as an empty function.
		  }
	);   

});
