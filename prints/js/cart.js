$(document).ready(function() {

	$('form.cartholder').submit(function() {

		var copies = parseInt($(this).children('input[name=copies]').val());
		var oldcopies = parseInt($(this).children('input[name=oldcopies]').val());
		var printid = parseInt($(this).children('input[name=printid]').val());

		if (copies == oldcopies) {
			alert('Please change the number of copies you want to order. You have currently ordered ' + oldcopies + ' copies');
			return false;
		}

		var host = window.location.host;
		var url = 'http://' + host + '/prints/index.php/categories/addtocart';
		$(this).children('input[type=image]').before('Adding. Please Wait....');

		$.post(url, {
				printid: printid,
				copies: copies,
				oldcopies: oldcopies
			},
			function(data) {
				if (parseInt(data) == 1) {
					window.location.reload(true);
				}
				return false;
			},
			'html'
		);

		return false;
	});
})
