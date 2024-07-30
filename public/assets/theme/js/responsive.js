let show = false;

$('#search_filter').click(function () {
	if (show === true) {
		$('.search_filter_options').hide();
		$('body').css({
			overflow: 'auto',
			height: '100%',
		});

		show = false;
	} else {
		show = true;
	}
});

if ($('.payment-area').length) {
	$('meta[name="viewport"]').attr('content', 'width=1000, initial-scale=1.0');
}
