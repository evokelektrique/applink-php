(function($) {
	$(document).on('click', '[data-bjax]', function(e){
	    new Bjax(this);
	    e.preventDefault();
	});
})(jQuery);