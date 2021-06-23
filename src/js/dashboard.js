(function($) {

	$(document).ready( function () {

        $("#password_status").click(function () {
            if ($(this).is(":checked")) {
                $("#password").show();
                // $("#default_password").hide();
            } else {
                $("#password").hide();
                // $("#default_password").show();
            }
        });

		var table = $('#list_table').DataTable( {
			"language": {
                url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Persian.json"
            },
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"dom": '<"top"i>rt<"bottom"p><"clear">'
		});
		$(document).on( 'keyup click','#search_text, #search_text', function () {
			table.search($('#search_text').val()).draw();
		});
	    $('.openqr').on('click',function(){
	        var dataURL = $(this).attr('data-href');
	        $('.modal-body').load(dataURL,function(){
	            $('#qrcode').modal({show:true});
	        });
	    }); 
		$('.custom-file-input').on('change',function(){
			var fileName = document.getElementById("select_logo").files[0].name;
			$(".custom-file-label").html(fileName);
			$(".custom-file-label").addClass("border-success");
		})

		$('#ptc_module').on('change', function() {
			if($(this).is(':checked')) {
				$(".ptc_prices :input").attr("disabled", false);
				$("#site_ptc_mode").val(1);
			} else {
				$(".ptc_prices :input").attr("disabled", true);
				$("#site_ptc_mode").val(0);
			}
		});



	});
		// $('form').ajaxForm({
		//     target: '#testajax'
		// });	
	$(document).on('click', '[data-bjax]', function(e){
	    new Bjax(this);
	    e.preventDefault();
	});
})(jQuery);