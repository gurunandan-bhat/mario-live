$(document).ready(function() {

	var books = new Array();
	books[books.length] = "Mario's Best Cartoons Book 1";
	books[books.length] = "Mario's Best Cartoons Book 2";
	books[books.length] = "Mario's Goa";
	books[books.length] = "Mario's Travels";
	books[books.length] = "Mario's Bombay";
	
	
	$('form#mariobooks').submit(function() {
		
		for(var i = 1; i <= 5; ++i) {
			$('#err' + i).html('');
		}
		$('#errnone').html('');
		
		var count = 1;
		var sel = 0;
		var errs = 0;
		var intregexp = /^\d+$/;
		
		$('input[type=checkbox]').each(function() {
			
			if (this.checked) {
				
				var copies = $('#copies' + count).val();
				if (! intregexp.test(copies)) {
					var errstr = '<p class="error">Number of copies of "' + books[count-1] + '" is not a valid number. Please select one or more copies.</p>';
					$('#err' + count).html(errstr);
					++errs;
				}
				else if (parseInt(copies) < 1) {
					var errstr = '<p class="error">Number of copies of "<strong>' + books[count-1] + '</strong>" is not a valid number. Please select one or more copies</p>';
					$('#err' + count).html(errstr);
					++errs;
				}
				++sel;
			}
			++count;
		});
		if (! sel) {
			var errstr = '<p class="error">You must select at least one book if you want to Checkout!</p>';
			$('#errnone').html(errstr);
					++errs;
		}
		if (errs) {
			return false;
		}
	});

	
})
