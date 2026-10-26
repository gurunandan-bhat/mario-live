$(document).ready(function () {
	
	//Homepage Banner Slider
	$('.cartoon-slider').owlCarousel({
		loop:true,
		margin:0,
		items:1,
		autoplay:true,
		autoplayTimeout: 2000,
		smartSpeed: 800,
		autoplayHoverPause:true,
		nav:false,
  		dots:true,
	});
	//Color Validation
	$('.prod-color').on('click',function(){
		$('.color ul li a').css('border-color','#eee');
		$(this).css('border-color','#fdbe19');
		var colorId = $(this).attr('id');
		$('.prod-color-order').val($(this).attr('name')+'|'+colorId);
	});
	//Size Validation
	$('.prod-size').on('click',function(){
		$('.size ul li a').css('border-color','#eee');
		$(this).css('border-color','#fdbe19');
		var sizeId = $(this).attr('id');
		$('.prod-size-order').val($(this).text()+'|'+sizeId);
	});
	//Cart Count Adjustment
	if($('.total-count').text() == 0)
		$('.total-count').css('display','none');
	else
		$('.total-count').css('display','block');
	//Cart Count Adjustment On change in cart list 
	$('.total-count').on('DOMSubtreeModified',function(){
		if($('.total-count').text() == 0)
			$('.total-count').css('display','none');
		else
			$('.total-count').css('display','block');
	})
	//Selected Greeting
	if ( $('.selected-greeting').val() != '' ) {
		$('#greeting-select-'+$('.selected-greeting').val()).children('img').css('border','4px solid #fdbe19');
	}
	//Greeting Value
	if( parseInt($('.gift-wrap-total').text().replace('₹ ',''),10) == 0 ) {
		$('.gift-wrap-line').css('display','none');
	}
	checkGiftWraps();
});
	
	//Add Item to Cart
	$('.add-to-cart-btn').on('click',function(){
		if(($(this).text()).includes('Go To Cart'))
			window.location.href = $('.add-to-cart-btn').attr('onclick');
		else {
			var color  = $('.prod-color-order').val();
			var size   = $('.prod-size-order').val();
			var quant  = $('.input-number').val();
			var prodId = $('.productid').val();
			var prodCatId = $('.productcatid').val();
			var price = $('.discount').text().replace('₹ ','');
			$('.color ul').css('border','1px solid white');
			$('.size ul').css('border','1px solid white');
			if(color == '' || size == '')	{
				if(color == '')
					$('.color ul').css('border','1px solid red');
				if(size == '')
					$('.size ul').css('border','1px solid red');
				return false;
			}
			var datastring = 'color='+ color + '&size=' + size + '&quant=' + quant + '&productid=' + prodId + '&productcatid=' + prodCatId + '&price=' + price;
			$.ajax({
				type: "POST",
				url: 'processcart',
				data: datastring,
				cache: false,
				success: function(response) { 
					$('.total-count').html(response);
					$('.add-to-cart-btn').html('Go To Cart');
					$('.add-to-cart-btn').attr('onclick', 'cart');
				},
				error: function(response){
					alert("Something went wrong, Please try again after sometime!");
				}
			});
			return true;
		}
	});

	$('.sub-add-to-cart-btn').on('click',function(){
		if(($(this).text()).includes('Go To Cart'))
			window.location.href = $('.sub-add-to-cart-btn').attr('onclick');
		else {
			var color  = $('.sub-prod-color-order').val();
			var size   = $('.sub-prod-size-order').val();
			var quant  = 1;
			var prodId = $(this).attr('name');
			var prodCatId = $('.productcatid').val();
			var price = $('.sub-discount-'+prodId).text().replace('₹ ','');
			var datastring = 'color='+ color + '&size=' + size + '&quant=' + quant + '&productid=' + prodId + '&productcatid=' + prodCatId + '&price=' + price;
			$.ajax({
				type: "POST",
				url: 'processcart',
				data: datastring,
				cache: false,
				success: function(response) { 
					$('.total-count').html(response);
					$("button[name='"+prodId+"']").html('Go To Cart');
					$("button[name='"+prodId+"']").attr('onclick', 'cart');
				},
				error: function(response){
					alert("Something went wrong, Please try again after sometime!");
				}
			});
			return true;
		}
	});

	//Cart Quantity Addition
	$('.cart-item-add').on('click', function () {
		var prodId  = $(this).attr('name').split('|')[0];
		var cartKey = $(this).attr('name').split('|')[1];
		var qty     = parseInt($('.item-qty-'+prodId).val(), 10);
		var price   = parseInt($('.item-price-'+prodId).text().replace('₹ ',''),10);
		var stotal  = parseInt($('.cart-subtotal').text().replace('₹ ',''),10);
		var giftwp = (isNaN(parseInt($('.gift-wrap-total').text().replace('₹ ',''),10)))? 0 : parseInt($('.gift-wrap-total').text().replace('₹ ',''),10);
		$('.total-amount-'+prodId).html('<b>&#8377; '+qty*price+'</b>');
		$('.cart-subtotal').html('<b>&#8377; '+(stotal+price)+'</b>');
		var discount = parseInt($('.cart-discount').text().replace('- ₹ ',''),10);
		$('.cart-total').html('<b>&#8377; '+ (stotal+price+giftwp-discount) + '</b>');
		var datastring = 'operation=UPD&cartkey=' + cartKey + '&quantity=' + qty + '&productid=' + prodId;
		$.ajax({
			type: "POST",
			url: 'processcart',
			data: datastring,
			cache: false,
			success: function(response) {
			},
			error: function(response){
				alert("Something went wrong, Please try again after sometime!");
			}
		});
	});

	//Cart Quantity Reduction
	$('.cart-item-minus').on('click', function () {
		var prodId  = $(this).attr('name').split('|')[0];
		var cartKey = $(this).attr('name').split('|')[1];
		var qty     = parseInt($('.item-qty-'+prodId).val(), 10);
		var price   = parseInt($('.item-price-'+prodId).text().replace('₹ ',''),10);
		var stotal  = parseInt($('.cart-subtotal').text().replace('₹ ',''),10);
		var giftwp = (isNaN(parseInt($('.gift-wrap-total').text().replace('₹ ',''),10)))? 0 : parseInt($('.gift-wrap-total').text().replace('₹ ',''),10);
		$('.total-amount-'+prodId).html('<b>&#8377; '+qty*price+'</b>');
		$('.cart-subtotal').html('<b>&#8377; '+(stotal-price)+'</b>');
		var discount = parseInt($('.cart-discount').text().replace('- ₹ ',''),10);
		$('.cart-total').html('<b>&#8377; '+ (stotal-price+giftwp-discount) + '</b>');
		var datastring = 'operation=UPD&cartkey=' + cartKey + '&quantity=' + qty + '&productid=' + prodId;
		if($('.coupon-mini').val() > (stotal-price)){
			$('.cart-discount').html('<b>- &#8377; 0 </b>');
			$('.coupon-code').val('');
		}
		$.ajax({
			type: "POST",
			url: 'processcart',
			data: datastring,
			cache: false,
			success: function(response) {
			},
			error: function(response){
				alert("Something went wrong, Please try again after sometime!");
			}
		});
	});

	//Cart Item Delete
	$('.cart-item-delete').on('click',function(){
		var prodId  = $(this).attr('name').split('|')[0];
		var cartKey = $(this).attr('name').split('|')[1];
		var qty     = parseInt($('.item-qty-'+prodId).val(), 10);
		var price   = parseInt($('.item-price-'+prodId).text().replace('₹ ',''),10);
		var stotal  = parseInt($('.cart-subtotal').text().replace('₹ ',''),10);
		var giftwp = (isNaN(parseInt($('.gift-wrap-total').text().replace('₹ ',''),10)))? 0 : parseInt($('.gift-wrap-total').text().replace('₹ ',''),10);
		stotal      = stotal - (qty*price);
		$('.cart-subtotal').html('<b>&#8377; '+stotal+'</b>');
		var discount = parseInt($('.cart-discount').text().replace('- ₹ ',''),10);
		$('.cart-total').html('<b>&#8377; '+ (stotal+giftwp-discount) + '</b>');
		var datastring = 'operation=DEL&cartkey=' + cartKey + '&productid=' + prodId;
		$.ajax({
			type: "POST",
			url: 'processcart',
			data: datastring,
			cache: false,
			success: function(response) {
				$('.cart-item-'+prodId).css('display','none');
				$('.cart-item-'+prodId).remove();
				$('.total-count').html(response);
				checkGiftWraps();
				emptyCartCheck();
			},
			error: function(response){
				alert("Something went wrong, Please try again after sometime!");
			}
		});
	});

	//Cart Gift Wrap
	$('.greeting-btn').click( function() {
		event.preventDefault();
		if ( $('.selected-greeting').val() == '' ) {
			$('.owl-stage-outer').css('border','3px solid red');
		} else {
			var greetingId  = $('.selected-greeting').val();
			var greetingMsg = $('.greeting-message').val();
			var datastring  = 'greetingid=' + greetingId + '&greetingmessage=' + greetingMsg;
			$.ajax({
				type: "POST",
				url: 'processcart',
				data: datastring,
				cache: false,
				success: function(response) {
					$('.greeting-btn').html('Edit Message');
				},
				error: function(response){
					alert("Something went wrong, Please try again after sometime!");
				}
			});
		}
	});

	$('.gift-wrap').click( function() {
		var productId = $(this).attr('name');
		var giftcharge = parseInt(45,10);
		var operation;
		if( $('.cart-item-gift-wrap-'+ $(this).attr('name')).is(':checked') ) { 
			var stotal  = parseInt($('.cart-subtotal').text().replace('₹ ',''),10);
			var giftwp = (isNaN(parseInt($('.gift-wrap-total').text().replace('₹ ',''),10)))? 0 : (parseInt($('.gift-wrap-total').text().replace('₹ ',''),10));
			giftwp += giftcharge;
			var discount = parseInt($('.cart-discount').text().replace('- ₹ ',''),10);
			$('.cart-total').html('<b>&#8377; '+ (stotal+giftwp-discount) + '</b>');
			operation = 'Y';
		}	else {
			var stotal  = parseInt($('.cart-subtotal').text().replace('₹ ',''),10);
			var giftwp = (isNaN(parseInt($('.gift-wrap-total').text().replace('₹ ',''),10)))? 0 : (parseInt($('.gift-wrap-total').text().replace('₹ ',''),10));
			giftwp -= giftcharge;
			var discount = parseInt($('.cart-discount').text().replace('- ₹ ',''),10);
			$('.cart-total').html('<b>&#8377; '+ (stotal+giftwp-discount) + '</b>');
			operation = 'N';
		}
		$('.gift-wrap-total').html('<b>&#8377; '+ (giftwp) + '</b>');
		( giftwp > 0 )?	$('.gift-wrap-line').css('display','block') : $('.gift-wrap-line').css('display','none');
		var datastring  = 'productid=' + productId + '&greetingstatus=' + operation;
		$.ajax({
			type: "POST",
			url: 'processcart',
			data: datastring,
			cache: false,
			success: function(response) {
				checkGiftWraps();
			},
			error: function(response){
				alert("Something went wrong, Please try again after sometime!");
			}
		});
	});

	$('.greeting-select').click(function() {
		$('.greeting-select').children('img').css('border','none');
		$(this).children('img').css('border','4px solid #fdbe19');
		var greetingId = $(this).attr('name');
		$('.selected-greeting').val(greetingId);
	});

	function checkGiftWraps() {
		var inputElems = document.getElementsByTagName("input"),
		count = 0;
		for (var i=0; i<inputElems.length; i++) {
			if (inputElems[i].type === "checkbox" && inputElems[i].checked === true){
				count++;
			}
		}
		if( count == 0) 
			$('.greeting-section').css('display','none');
		else
			$('.greeting-section').css('display','block');
	}

	function emptyCartCheck() {
		var inputElems = document.getElementsByClassName("product-des"),
		count = inputElems.length;
		if( count == 0)
			location.reload();
	}

	//Coupon Functionality
	$('.coupon-btn').on('click',function(){
		var couponCode = $('.coupon-code').val();
		$('.coupon-error').css('display','block');
		var stotal     = parseInt($('.cart-subtotal').text().replace('₹ ',''),10);
		var datastring = 'coupon=' + couponCode;
		if(couponCode != '') {
			$.ajax({
				type: "GET",
				url: 'config/api.php',
				data: datastring,
				cache: false,
				success: function(response) {
					if(response == 'NF')	{
						$('.coupon-error').html('Coupon is Invalid!');
						$('.coupon-error').css('display','block');
					} else {
						var discount  = response.split('|')[0];
						var minamount = response.split('|')[1];
						if(minamount > stotal){
							$('.coupon-error').css('display','block');
							$('.coupon-code').val('');
							$('.coupon-error').html('Coupon is applicable on minimum purchase of &#8377; '+minamount);
						} else {
							$('.coupon-mini').val(minamount);						
							$('.cart-discount').html('<b>- &#8377; '+ discount + '</b>');
							$('.cart-total').html('<b>&#8377; '+ (stotal-discount) + '</b>');
							$('.coupon-error').css('display','none');
							//Setting coupon in session
							$.ajax({
								type: "POST",
								url: 'processcart',
								data: datastring,
								cache: false,
								success: function(response) {
								},error: function(response){
									alert("Something went wrong, Please try again after sometime!");
								}
							});
						}
					}
				},
				error: function(response){
					alert("Something went wrong, Please try again after sometime!");
				}
			});
		}
	});

	//Add Product to Wishlist
	$('.add-wishlist').on('click', function() {
		var prodid = $('.productid').val();
		var userid = $('.userid').val();
		if( userid == "NULL" )
			window.location.href = "login";
		else {
			datastring = "prod="+prodid+"&user="+userid;
			$.ajax({
				type: "POST",
				url: 'config/api.php',
				data: datastring,
				cache: false,
				success: function(response) {
					$('.add-wishlist').css('background-color','#fdbe19');
				},
				error: function(response){
					alert("Something went wrong, Please try again after sometime!");
				}
			});
		}
	});

	//Checkout Redirection
	$('.order-checkout-btn').on('click',function()	{
		var user = $('.user-data').val();
		if(user == 'GUEST'){
			$('#exampleModal').modal('toggle');
			$('#exampleModal').modal('show');
		} else {
			window.location.href = "checkout";
		}
	});

	//Address Edit Redirection
	$('.edit-address').on('click',function()	{
		$('#exampleModal').modal('toggle');
		$('#exampleModal').modal('show');
	});

	//Checkout Form Validation
	$('.final-checkout-btn').on('click',function()	{
		var flowType = $('.selected-address').val();
		if( flowType == 'GUEST' )	{
			$('input').css('border','none');
			var name    = $('#name').val();
			var email   = $('#email').val();
			var contact = $('#contact').val();
			var address = $('#address').val();
			var city    = $('#city').val();
			var state   = $('#state').val();
			var country = $('#country :selected').val();
			var pincode = $('#pincode').val();
			const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(name == '')
				$('#name').css('border','1px solid red');
			if(email == '' || !re.test(String(email).toLowerCase()))
				$('#email').css('border','1px solid red');
			if(contact == '')
				$('#contact').css('border','1px solid red');
			if(address == '')
				$('#address').css('border','1px solid red');
			if(city == '')
				$('#city').css('border','1px solid red');
			if(state == '')
				$('#state').css('border','1px solid red');
			if(country == '')
				$('#country').css('border','1px solid red');
			if(pincode == '')
				$('#pincode').css('border','1px solid red');
			if( name != '' && email != '' && contact != '' && address != '' && city != '' && state != '' && country != '' && pincode != '' ) {
				var datastring = 'guestdata='+name+'|'+email+'|'+contact+'|'+address+'|'+city+'|'+state+'|'+country+'|'+pincode;
				$.ajax({
					type: "POST",
					url: 'place-order.php',
					data: datastring,
					cache: false,
					success: function(response) {
						window.location.href = response;
					},
					error: function(response){
						alert("Something went wrong, Please try again after sometime!");
					}
				});
			}
		} else if( flowType == 'NOT_SELECTED' ) {			
			alert('Please choose a address to proceed further!');
		} else {
			window.location.href = "place-order/"+flowType;
		}
	});

	//Checkout Address Selection
	$('.customer-address').on('click',function() {
		$('tr').css('border','none');
		$(this).css('border','2px solid #f6931d');
		var addressId = $(this).attr('id').split('|')[0];
		var countryId = $(this).attr('id').split('|')[1];
		var pincode   = $(this).attr('id').split('|')[2];
		var cart      = $('.cart-data').val();
		$('.selected-address').val(addressId);
		datastring = "shippingcountry="+countryId+"&cartdump="+cart;
			$.ajax({
				type: "POST",
				url: 'config/api.php',
				data: datastring,
				cache: false,
				success: function(response) {
					if(response > 0) {
						var subtotal = parseInt($('.cart-subtotal').text().replace('₹ ',''),10);
						if(isNaN(parseInt($('.cart-gift-wrap').text().replace('₹ ',''),10)))
							var giftWrap = 0;
						else
							var giftWrap = parseInt($('.cart-gift-wrap').text().replace('₹ ',''),10);
						if(isNaN(parseInt($('.cart-discount').text().replace('₹ ',''),10)))
							var cartDisc = 0;
						else
							var cartDisc = parseInt($('.cart-discount').text().replace('₹ ',''),10);
						if(isNaN(parseInt($('.cart-offer-discount').text().replace('₹ ',''),10)))
							var offrDisc = 0;
						else
							var offrDisc = parseInt($('.cart-offer-discount').text().replace('₹ ',''),10);
						var shipping = parseInt(response,10);
						var totalAmt = parseInt((subtotal + giftWrap + shipping - cartDisc - offrDisc),10);
						$('.cart-shipping').html('&#8377; '+response);
						$('.cart-total').html('&#8377; '+totalAmt);
					}
				},
				error: function(response){
					alert("Something went wrong, Please try again after sometime!");
				}
			});
	});

	//Toggle Display
	function toggleDisplay(d, b) {
		var c = document.getElementById(d);
		if (c.style.display == "block") {
			c.style.display = "none";
			if (b) {
				b.innerHTML = "Read more..."
			}
		} else {
			c.style.display = "block";
			if (b) {
				b.innerHTML = "Read less..."
			}
		}
	};