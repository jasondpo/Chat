<?php include 'functions.php'; ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Counter Alert Page</title> 
		
		<!-- Normalize CSS Stylesheet -->
		<link rel="stylesheet" src="//normalize-css.googlecode.com/svn/trunk/normalize.css" />
		
		<!-- Custom Stylesheet -->
		<link rel="stylesheet" href="assets/css/cssBasic.css">
		
		<!-- jQuery Library-->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		
		<!-- Custom jQuery -->
		<script src="assets/js/   .js"></script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>	
	<body>
		
<form method="post">		
	<input type="text" class="newCnt" name="newCnt" value="<?php countMessages();?>">
	<input type="text" class="storedCnt" name="storedCnt" value="<?php storedMsgCnt();?>"> 
	<input type="submit" class="updateCnt" name="updateCnt" value="submit" /> 
</form>	
	
<script>
	window.onload=function(){
		var newCount=$(".newCnt").val();
		var oldCount=$(".storedCnt").val();
		var newNum=newCount-oldCount;
		if(newNum!=0){
		window.parent.passMe(newNum);  
		}else{
			window.parent.passMe("0");  
		}
	}
// 	New message count gets stored in the storedMsgCnt when user clicks on the "alertCnt" button
	function updateUserCnter(){
		$(".updateCnt").click();
	}
      	
</script>

	</body>	
</html>