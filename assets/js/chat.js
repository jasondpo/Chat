


function chatToggleBtn(){
    var b = document.getElementById("chatListWrapper");
    if(b.style.display == "block" && b.style.display !="none"){
	   $('#chatListWrapper').fadeOut('fast');
    }else{
	   $('#chatListWrapper').fadeIn('fast');
    }
}



$(".showPersonInList").click(function(){
	var selectedName=$(".artistNames").val();
	var theList=$(".chatList li");
	
	var getName = [];
	
	$('.chatList li .aHorizontal').each(function(){
	    getName.push($(this).html());
	});
	
	for (i = 0; i < getName.length; i++) {
	    if(getName[i]==selectedName){
		   theList[i].style.display="block"; 
	    }else{
		   theList[i].style.display="none"; 
	    }
	} 
		if(selectedName==""){
		showEntireList();
	}
});

function showEntireList(){
	var theList=$(".chatList li");
	var selectedName=$(".artistNames").val();
	if(selectedName==""){
		for (i = 0; i < theList.length; i++) {
			theList[i].style.display="block"; 
		}
	} 	
}

// When user clicks on name on right column
$(".chatList li").click(function(){
	var artistName=$(this).find(".aHorizontal").html().split('<br>')[0];
	$('.recipientName').html(artistName); // Goes into header area
	$('.theReceiverId').val(artistName); // Goes into text field inside form
	$('.mailer').show();
	location.hash = artistName;
	getMessageWindowPage();
});

setInterval(function(){getMessageWindowPage();}, 1000)

function getMessageWindowPage(){
	var theSender=$('.theSenderId').val();
	var theReceiver=$('.theReceiverId').val();
	$(".seeMessagesContainer").load("senderWindow.php?sender="+theSender+"&receiver="+theReceiver);
	setTimeout(function(){var h=$(".seeMessagesContainer").height();$(".messageWrapper").scrollTop(h);},10); 	
}

window.onload=function(){
	setProfileFirstInitial();
	var url= window.location.href;
	if(url.indexOf("sender")!=-1 && url.indexOf("hide")==-1 && url.indexOf("#")==-1){  // If "sender" is present and url DOES NOT say "hide" and # IS NOT THERE then show mailer
		// if there is a name after the # in url then use that name instead of "receiver"
		var receiver=url.split('=').pop();
		var sender=url.split('&')[0];
		var sender=sender.split('=').pop();
		$('.recipientName').html(receiver);
		$('.theReceiverId').val(receiver);
		$('.mailer').show();
		$(".seeMessagesContainer").load("senderWindow.php?sender="+sender+"&receiver="+receiver);
	}if(url.indexOf("sender")!=-1 && url.indexOf("hide")==-1 && url.indexOf("#")!=-1){ // If the # is present then use the new "receiver"
		var receiver2=url.split('#').pop();
		var sender=url.split('&')[0];
		var sender=sender.split('=').pop();
		$('.recipientName').html(receiver2);
		$('.theReceiverId').val(receiver2);
		$('.mailer').show();
		$(".seeMessagesContainer").load("senderWindow.php?sender="+sender+"&receiver="+receiver2);
	}
	setTimeout(function(){var h=$(".seeMessagesContainer").height();$(".messageWrapper").scrollTop(h);},20); 			
}


$(".mailerClose").click(function(){
	location.hash = "&hide";
	$('.mailer').hide();
});	


// Gather names in right sidebar list and display first letter in profile pic circle
function setProfileFirstInitial(){
	var nameList = [];
	
	var theList=$('.chatList li .aHorizontal').each(function(){
	    nameList.push($(this).html());
	});    
	
	var theProfile=$('.profilePicList') 
	 
	for(var i = 0; i < theProfile.length; i++){
    	$(theProfile[i]).find(".v-centered").html(nameList[i].charAt(0));
	}
}	
	
	





