	$('body').on('click','.mail_lightbox_trigger',function(e) {
		
		//prevent default action (hyperlink)
		e.preventDefault();
		
		$('#lightbox').fadeIn(500);
		$('#lightbox #new').show();
	
		return false;
	});
	
	$('body').on('click','.lightbox_trigger',function(e) {
		
		//prevent default action (hyperlink)
		e.preventDefault();
		
		//Get clicked link href
		var image_href = $(this).attr("href");
		
		/* 	
		If the lightbox window HTML already exists in document, 
		change the img src to to match the href of whatever link was clicked
		
		If the lightbox window HTML doesn't exists, create it and insert it.
		(This will only happen the first time around)
		*/
		
		if ($('#lightbox').length > 0) { // #lightbox exists
			
			//place href as img src value
			$('#content').html('<img src="' + image_href + '" /><br><a href="'+image_href+'" class="btn-download" target="_blank" download><i class="fa fa-download"></i> Download</a>');
		   	
			//show lightbox window - you could use .show('fast') for a transition
			$('#lightbox').fadeIn(500);
		}
		
		else { //#lightbox does not exist - create and insert (runs 1st time only)
			
			//create HTML markup for lightbox window
			var lightbox = 
			'<div id="lightbox">' +
				'<p>Click to close</p>' +
				'<div id="content">' + //insert clicked link's href into img src
					'<img src="' + image_href +'" />' +
				'</div>' +	
			'</div>';
				
			//insert lightbox HTML into page
			$('body').append(lightbox);
		}
		return false;
	});
	
	//Click anywhere on the page to get rid of lightbox window
	$('body').on('click', '.mail_lightbox *', function(e) { //must use live, as the lightbox element is inserted into the DOM
		e.stopPropagation();
	});
	//Click anywhere on the page to get rid of lightbox window
	$('body').on('click', '#lightbox', function() { //must use live, as the lightbox element is inserted into the DOM
		$('#lightbox').fadeOut(500);
	});