$(document).ready(function(){
    var urlBase = $('#cartShopURL').val();
    $('button._addcart').click(function(){
	$('#progressCart').fadeIn();
	var curProd = $(this).attr("product-value");
	var urlThis = urlBase+'/shop/cart/add';
	console.log(curProd);
	$.ajax({
	    url: urlThis,
	    type: "post",
	    data: "id="+curProd+"&quantity=1",
	    dataType: "json",
	    success: function(dt){
		console.log(dt);
		$('#progressCart').fadeOut();
	    },
	    error:function(dt){
		   $('#progressCart').fadeOut();
	    }
	});
    });
});
