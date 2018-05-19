<?php include 'functions.php';
	
?>

<?php 
	
//////// Display any messages from the selected member in the mailer next to the chat list///////////////////////////
/*
/////// The Logic //////
    When the user is the sender the message is blue. When the user is the reciever the message is grey
*/

function showMessages(){   
    $conn = openDB();               
    $query = "SELECT message, senderid, receiverid FROM messages WHERE (senderid='".$_GET['sender']."' OR senderid='".$_GET['receiver']."') AND (receiverid='".$_GET['receiver']."' OR receiverid='".$_GET['sender']."')";
    $ds = $conn->query($query);
    $cnt = $ds->rowCount();
    if ($cnt == 0){
        echo "<span> Start a new conversation </span>";
        return; // No contacts 
    } 
    foreach ($ds as $row){
		if($_SESSION["user"]==$row['senderid']){echo "<div class='singleMsge clearfix'><h104>".$row["message"]."</h104></div>";}
		if($_SESSION["user"]!=$row['senderid']){echo "<div class='singleMsge clearfix'><div class='profileInMsg'></div><h105>".$row["message"]."</h105></div>";}          
    }    	    
}	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title> Displays chat messages </title> 
				
<style>
.mailer{
	position: fixed;
	width: 265px;
	height: 335px;
	right:230px;
	bottom: 0px;
	border-top:1px solid #EEE;
	border-left:1px solid #EEE;
	border-right:1px solid #EEE;
}
.messageInputField{
	position: absolute;
	bottom: 0;
}
</style>
	</head>
	
	
	<body>
		<?php showMessages(); ?>
		
	
	</body>
	
</html>

