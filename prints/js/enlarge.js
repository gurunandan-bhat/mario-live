$(document).ready(function() {
	
	$('#printholder').dialog({
		autoOpen: false,
	});
	
	$('a.enlarge').click(function() {
		
		var printid = $(this).attr('printid')
		var host = window.location.host;
		var url = 'http://' + host + '/prints/index.php/categories/enlarge';
		
		$.post(
			url, 
			{'printid': printid},
			function(data){
				
				var boxtxt = '<img src="' + data.src + '" width="' + data.width + '" height="' + data.height + '" />';
				$('#printholder').html(boxtxt);

				$('#printholder').dialog( 'option', {
					title : '<strong>' + data.title + '</strong><br />' + data.edition + ' from ' + data.theme + '<br /> Size: ' + data.dim + '; Cost: INR ' + data.cost,
					width: parseInt(data.width) + 30,
					height: parseInt(data.height) + 130,
					position: 'center',
					modal: true,
					buttons: {
						'Close': function() {
							$('#printholder').dialog('close');
						}
					}
				});
				$('#printholder').dialog('open');
			},
			'json'
		);
		return false;
	});
})
