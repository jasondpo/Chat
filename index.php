<?php include 'functions.php'; ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Chat index</title> 
		
		<!-- Normalize CSS Stylesheet -->
		<link rel="stylesheet" src="//normalize-css.googlecode.com/svn/trunk/normalize.css" />
		
		<!-- Custom Stylesheet -->
		<link rel="stylesheet" href="assets/styles/chat.css">
		
		<!-- jQuery Library-->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		
		<!-- Google Fonts-->
		<link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,600,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

	</head>
	
	<?php 	if($_SESSION['user'] != ""){ echo "You user name is ".$_SESSION['user'].".";} ?>
	<body>
		
<!-- 		This section is just for testing purposes -->
		<form method="post" action="index.php">
		<select name="chooseName">
			<option value="----">-------</option>
			<option value="Jason">Jason</option>
			<option value="Sami">Sami</option>
			<option value="Sarah">Sarah</option>
			<option value="Aaiden">Aaiden</option>
			<option value="Yael">Yael</option>
			<option value="Aliah">Aliah</option>
			<option value="Justin">Justin</option>
			<option value="Olive">Olive</option>
			<option value="Iida">Iida</option>
			<option value="David">David</option>
		</select>
		<br>
		<br>  
			<input type="submit" name="setUser" value="Set Name" />				
		</form>
<!-- Testing section ends-->		
		
		<iframe class="alertIframeBox" src="counterAlertPage.php" allowtransparency="true" frameborder="1" scrolling="yes" width="100%" height="900px"></iframe>

		<div class="alertCnt"></div>
	<div id="chatListWrapper">
			<div class="chatListSearchWrapper">
				
			  <input class="artistNames" list="browsers" onblur="showEntireList()">
			  <datalist id="browsers">
			  	<?php showMembersForSearch(); ?>
			  </datalist>
			  <button class="showPersonInList" type="button">Search</button> 
				  
			</div>
			<ul class="chatList">
				<?php showMembers(); ?>
			</ul>
		</div>
		
		<div class="chatListBtn" onclick="chatToggleBtn();"><h101>Mail List</h101></div>


		
	<div class="mailer">
		<div class="mailerClose"></div>
		<h102 class="recipientName"></h102>	
		<div class="messageWrapper clearfix"> <!-- This provides the scrollbar -->
			<div class="seeMessagesContainer"></div>   <!-- This window.onload function in the chat.js loads the senderWindow.php into this div -->	
		<div>
		<div class="messageInputField">
			<form method="post" autocomplete='off' action="index.php" onsubmit="">
				 <input type="text" style="display: none;" class="theSenderId" value="<?php echo $_SESSION["user"]?>" name="theSenderId">
				 <input type="text" style="display: none;" class="theReceiverId" name="theReceiverId">
				 <input type="text" name="mailFromList" class="mailFromList" placeholder="Send a message">   
				 <input type="submit" name="submitMessageBtn" value="Send" />	  
			</form>
		</div>
		
	</div> <!-- ENDS -->

	<script>
		// Receives data from the "counterAlertPage" through the iframe
		function passMe(theMessage){
			if(theMessage!=0){
				$(".alertCnt").show();
				$(".alertCnt").text(theMessage);
			}else{
				$(".alertCnt").hide();
				$(".alertCnt").text("");
			}
		}
		
		$(".alertCnt").click(function(){
			$('.alertIframeBox')[0].contentWindow.updateUserCnter();
		})
		
		
	</script>
	</body>
	
	<!-- Custom jQuery -->
	<script src="assets/js/chat.js"></script>	
</html>