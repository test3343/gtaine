$(document).ready(function () {
	

	

	$("form").submit(function(event) {
		
		event.preventDefault();



		$.ajax({
			type: $(this).attr('method'),
			url: $(this).attr('action'),
			data: new FormData(this),
			contentType: false,
			cache: false,
		
			processData: false,
			success: function(result) {
				
				//alert(result);
				json = jQuery.parseJSON(result);
				
				if (json.url) setTimeout(redirect, 2000, json.url);

				
				swal({   

					title: json.header,
					text: json.message, 
					icon: json.status,  
		              
		        });
				
				
				
				
				
			}

		});
	});
	
});

function DeleteNews(NewsID) {

    var dataString = 'action=delete_news&n_id='+NewsID;
    //alert(dataString);
    $.ajax({
        type: "POST",
        url: "/engine/obr/admin.php",
        data: dataString,
        cache: false,
        success: function(data){
            json = jQuery.parseJSON(data);
				
			if (json.url) setTimeout(redirect, 2000, json.url);

				
			swal({   

				title: json.header,
				text: json.message, 
				icon: json.status,  
	              
	        });
	
        }
    });
}

function redirect(url) {
	  	window.location.href = url;
	}