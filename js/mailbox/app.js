var domaine = 'https://scandin-africa.com';

var interval = 30000;
var k        = 0;
var auto     = setInterval(autoSave,30000);

function autoSave(){
	if(k==0){k++; return;}
      var message  = $('#new-layout textarea').val();
	  var mrecever = $('#new-layout .mrecever').val();
	  var mobject  = $('#new-layout .mobject').val();
	  var mtoken   = $('#new-layout .mtoken').val();
	  var token    = $('#token').val();
      
		$.ajax({
			type : "POST",
			url : domaine+"/mailbox/auto-save-message.php",
			data : {'message':message,'mrecever':mrecever,'mobject':mobject,'mtoken':mtoken,'token':token},
			dataType : "json",
			cache : false,
			success : function(resultats){
				
			}
		});
	k++;
	if(k==10) clearInterval(auto);
}

function asReadBulder(){
  $("body").on("click",".as-read",function(e){
      e.preventDefault();
      var $this = $(this);
      var mtoken = $this.data("token");
	  
	  var loader   = $('div#ajaxloader');
	  loader.removeClass('error').removeClass('success');
      
	  $.ajax({
			type : "POST",
			url : domaine+"/mailbox/asRead.php",
			beforeSend : function(){loader.html("Loading...")},
			data : 'token='+mtoken,
			dataType : "json",
			cache : false,
			success : function(resultats){
				
				if(resultats[0] == 1){
		            $this.css("backgroundColor","#3498db");
		            $("#mailbox .msg-preview").each(function(index,element){

                        if($(element).data('token') == mtoken){
                        	$(element).removeClass('new').addClass('old');

                        }
                        
		            });
			    }
				else {
					loader.addClass('error').html(resultats[1]); 
				}
				
				loader.delay(5000).fadeOut(500);
				
				
			},

		});
  });
}
function asUnreadBulder(){
  $("body").on("click",".as-unread",function(e){
      e.preventDefault();
      var $this = $(this);
      var mtoken = $this.data("token");
	  
	  var loader   = $('div#ajaxloader');
	  loader.removeClass('error').removeClass('success');
      
	  $.ajax({
			type : "POST",
			url : domaine+"/mailbox/asUnread.php",
			beforeSend : function(){loader.html("Loading...")},
			data : 'token='+mtoken,
			dataType : "json",
			cache : false,
			success : function(resultats){
				
				if(resultats[0] == 1){
		            $this.css("backgroundColor","#3498db");
		            $("#mailbox .msg-preview").each(function(index,element){

                        if($(element).data('token') == mtoken){
                        	$(element).removeClass('new').addClass('old');

                        }
                        
		            });
			    }
				else {
					loader.addClass('error').html(resultats[1]); 
				}
				
				loader.delay(5000).fadeOut(500);
				
			},

		});
  });
}
function deletedSingleMessages(){

	$("body").on("click",".delete",function(e){
		e.preventDefault();
		var $this = $(this);
       //recuperer les tokens des msg a supprimes
       var token = $this.data("token");

	   if(!confirm('Do you confirm the suppression of this message?')) return;
	   
	  var loader   = $('div#ajaxloader');
	  loader.removeClass('error').removeClass('success');
   
       loader.fadeIn(500);
       	$.ajax({
				type : "POST",
				url : domaine+"/mailbox/delete.php",
				beforeSend : function(){loader.html("deleted...")},
				data : 'token0='+token,
				dataType : "json",
				cache : false,
				success : function(resultats){
					
					if(resultats[0] == 1){
						loader.addClass('success').html(resultats[1]); 

					    $('.active').parents('.msg').delay(10000).fadeOut(500).remove();
	                     $this.parents(".ibloc").empty();
						loadMessage('mailbox');
				    }
					else {
						loader.addClass('error').html(resultats[1]); 
					}
					
					loader.delay(5000).fadeOut(500);
				},
	
			});
	});
}

$('body').on('click','.todelete',function(){
	if($('.todelete:checked').length > 0) $(".delete-msg").show();
	else                                  $(".delete-msg").hide();
});
	
$("body").on("click",".delete-msg",function(e){
	e.preventDefault();
	
   //recuperer les tokens des msg a supprimes
   var tokens   = "";
   var checkbox =  ".todelete:checked";

  var loader   = $('div#ajaxloader');
  loader.removeClass('error').removeClass('success');

   $(checkbox).each(function(i,e){
	 var t = $(checkbox).eq(i).data('token');
	 // alert(i+' '+t);
	 // console.log($(checkbox).eq(i));
	 tokens += "token"+i+"="+t+"&";
	 
   });
   // alert(tokens);
   if(!confirm('Do you confirm the suppression of this messages?')) return;
   
   loader.fadeIn(500);
	$.ajax({
			type : "POST",
			url : domaine+"/mailbox/delete.php",
			beforeSend : function(){loader.html("deleting...")},
			data : tokens,
			dataType : "json",
			cache : false,
			success : function(resultats){
				
				if(resultats[0] == 1){
					loader.addClass('success').html(resultats[1]);
					
					loadMessage('mailbox');
					$(".delete-msg").hide();
				}
				else {
					loader.addClass('error').html(resultats[1]); 
				}
				
				loader.delay(5000).fadeOut(500);
			},

		});
});

function deletedMultipleMessages(kind){
	$(".checkbox-td input").off();
	$(".delete-msg").off();
	var check = 0;
	$("body").on("change",".checkbox-td input",function(){
       
       var $this = $(this);
       var i = 1;
       var cible = "#"+kind+" .delete-msg";
       if($this.is(":checked")){
          check++;
       }else{
         check--;
       }

       if (check>0 && i == 1) {
          $(cible).css("display","inline");
          i = 0;
       }else if (check == 0) {
         $("#"+kind+" .delete-msg").css("display","none");
         i = 1;
       };

	});

	$("body").on("click",".delete-msg",function(e){
		e.preventDefault();
		
       //recuperer les tokens des msg a supprimes
       var tokens = "";
       var checkbox =  "#"+kind+" input:checked";

	  var loader   = $('div#ajaxloader');
	  loader.removeClass('error').removeClass('success');

       $(checkbox).each(function(index,element){
		   // alert('ok');
       	 tokens += "token"+index + "=" +$(this).parent().data("token")+"&";
       	 
       });
       loader.fadeIn(500);
       	$.ajax({
				type : "POST",
				url : domaine+"/mailbox/delete.php",
				beforeSend : function(){loader.html("deleted...")},
				data : tokens,
				dataType : "json",
				cache : false,
				success : function(resultats){
					
					if(resultats[0] == 1){
						loader.addClass('success').html(resultats[1]); 
					    $(checkbox).each(function(index,element){
					    	 $(this).parents('.msg').delay(10000).fadeOut(500).remove();
					       	 
					       });
					    $(".preview-"+kind).empty();
				    }
					else {
						loader.addClass('error').html(resultats[1]); 
					}
					
					loader.delay(5000).fadeOut(500);
				},
	
			});
	});
}


function readMessage(token,cible){
	var url;
	if(cible == "mailbox"){
       url = domaine+"/mailbox/readerMailbox.php";
	}else if (cible == "sent"){
	   url = domaine+"/mailbox/readerSent.php";
	}else if(cible == "deleted"){
		url = domaine+"/mailbox/readerDeleted.php";
	}
	
	$.ajax({
		type : "GET",
		url : url,
		beforeSend : function(){$("#preview").html("Loading...")},
		data : {'token':token},
		dataType : "html",
		cache : false,
		success : function(resultats){

			cible = ".preview-mailbox";

		   $(cible).html(resultats);
		   
		}
	});

	return messagePreview;
}

function messagePreview(){
	
	$('body').on('click','.msg-preview',function(e){
		$this     = $(this);
		var token = $this.attr('data-token');
		var cible = $this.data('preview');
		
		var prt   = $this.parent().closest('table');
		
		var tar   = 'mailbox';
		
		if(prt.hasClass('sent'))    tar = 'sent';
		if(prt.hasClass('deleted')) tar = 'deleted';
		
		$("#new, #sent, #deleted").hide();
		$("#mailbox").show();
		
		$('aside ul li a.active').removeClass('active');
		$('aside ul li a[href="#'+tar+'"]').addClass('active');
		
		$('.msg-preview').parent().closest('table.active').removeClass('active');
		prt.addClass('active');
	    readMessage(token,cible);
		
		$('body').animate({
			scrollTop : 0
		},500);

	});

}

// function newMessage(){
 $('#new .submit').on('click',function(e){
 	    $this  = $(this);
		$this.attr('disabled', true);
		
	  var loader   = $('div#ajaxloader');
	  loader.removeClass('error').removeClass('success');

      var data = $('#new .form').serialize();
      loader.fadeIn(500);
      var message = $('#new textarea').val();
     
      if(message != ''){    
      
			$.ajax({
				type : "POST",
				url : domaine+"/mailbox/send.php",
				beforeSend : function(){loader.html("Sending...")},
				data : data,
				dataType : "json",
				cache : false,
				success : function(resultats){
					
					if(resultats[0] == 1){
						loader.addClass('success').html(resultats[1]); 
					    $('#token').val(resultats[2]);
					    $('#new .mrecever').val('');
					    $('#new .mobject').val('');
					    $('#new textarea').val('');
					    $this.attr('disabled', false);
						clearInterval(auto);
						$('#lightbox').fadeOut(500);
				    }
					else {
						loader.addClass('error').html(resultats[1]); 
						$this.attr('disabled', false);
					}
					
					loader.delay(5000).fadeOut(500);
				},
				error:function(){
					
				}
			});

		}else{
			loader.addClass('error').html('Please enter your message');
			$this.attr('disabled', false);
		}
  
 });
// }


function loadMessage(kind){
	var file = 'mailbox';
		
	  var loader   = $('div#ajaxloader');
	  loader.removeClass('error').removeClass('success');

      loader.fadeIn();

	switch(kind){
		case('mailbox'):
			file = 'mailbox';
		break;
		case('deleted'):
			file = 'deleted';
		break;
		case('sent'):
			file = 'sent';
		break;
		default:
			file = 'mailbox';
		break;
	}
	
	$.ajax({
		type : "POST",
		url : domaine+"/mailbox/"+file+".php",
		beforeSend : function(){$("#ajaxloader").html("Loading...")},
		data : {},
		dataType : "html",
		cache : false,
		success : function(resultats){
			// var cible = ".list-"+kind;
			var cible = ".list-mailbox";
			$(cible).html(resultats);
			loader.fadeOut();
		}
	});
}


$(function(){
	$('#new, div#ajaxloader,#sent,#deleted').hide();
	// deletedMultipleMessages('mailbox');
	deletedSingleMessages();
	asReadBulder();
	asUnreadBulder();
	// deletedMultiple();
	loadMessage('mailbox');
	messagePreview();
});

$('aside ul li a').on('click',function(){
	
	$this        = $(this);
	
	var target   = $this.attr('href');
	
	$('aside ul li a.active').removeClass('active');
	$this.addClass('active');
	$(".delete-msg").css("display","none");
	
	switch(target){
		case('#new'):
		
			$("#mailbox").hide();
			$("#new").show();
			$("#sent").hide();
			$("#deleted").hide();
			// newMessage();
			autoSave();
		break;
		case('#mailbox'):
            asReadBulder();
			$("#mailbox").show();
			$("#new").hide();
			$("#sent").hide();
			$("#deleted").hide();
			deletedMultipleMessages('mailbox');
			loadMessage('mailbox');
		break;
		case('#sent'):

			// $("#sent").show();
			// $("#new").hide();
			$("#mailbox").show();
			// $("#deleted").hide();
			deletedMultipleMessages('sent');
			loadMessage('sent');
			
		break;
		case('#deleted'):

			// $("#deleted").show();
			$("#mailbox").show();
			// $("#new").hide();
			// $("#sent").hide();
			loadMessage('deleted');
		break;
	}
	
	
	return false;
	
});


$('input#attachments').on('change',function(){
	$this = $(this);
	
	var loader   = $('div#ajaxloader');
	  loader.removeClass('error').removeClass('success');
	
	if($this.val() != ""){
		loader.fadeIn(500);
		
		var token  = $('#token').val();
		
		loader.html("Saving files...");
		
		var files    = $this[0].files; // fichiers sélectionnés
		var formData = new FormData();
		// console.log($this);
		// alert(files.length);
		// Loop through each of the selected files.
		for (var i = 0; i < files.length; i++) {
		  var file = files[i];

		  // Add the file to the request.
		  formData.append('attachments[]', file, file.name);
		  // alert(file.name);
		}
		  
		  var xhr = new XMLHttpRequest();
		  xhr.open('POST', 'mailbox/upload.php?ajax=1&token='+token, true);
		  xhr.onload = function () {
			  reponse = JSON.parse(xhr.response);
			  
			  if (xhr.status === 200 && reponse[0] == 1) {
				loader.addClass('success').html(reponse[1]);
				loader.delay(5000).fadeOut(500);
			  } else {
				loader.addClass('error').html(reponse[1]);
				loader.delay(5000).fadeOut(500);
			  }
			};
			xhr.send(formData);
			
	}
});
