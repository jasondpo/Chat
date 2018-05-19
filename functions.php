<?php
session_start();
		
function openDB(){
    //$servername = "jasondpo.ipowermysql.com"; live host
	//$username = "jasoncode"; live host
	//$password = "codebank"; live host
	$username = "root";
	$password = "root";
	$dbname = "chatTest";	

	//$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); live host
   $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
	if ($conn != true){
    die("Unable to open DB ");
    }
    return($conn);             
}

function createTables(){
   $conn=openDB();
    		
	    $sql ="DROP TABLE IF EXISTS user, messages";
	      $result =$conn->query($sql);
	            If ( $result != true){
	            	die("Unable to drop answers tables");
	            }
	            else{
	            	ECHO "<br>Tables Dropped<br>";                
	            }            	     
	     
	     $sql="CREATE TABLE user ("
	    ."id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,"
	    ."name VARCHAR(50) NOT NULL,"
	    ."password VARCHAR(50) NOT NULL,"
	    ."storedMsgCnt VARCHAR(50) NOT NULL);"
	    ."INSERT INTO user (id, name, storedMsgCnt)"
		." VALUES"."('1', 'Jason','3'),
					('2', 'Sami','0'),
					('3', 'Sarah','0'),
					('4', 'Aaiden','0'),
					('5', 'Yael','0'),
					('6', 'Aliah','0'),
					('7', 'Justin','0'),
					('8', 'Olive','0'),
					('9', 'Iida','0'),
					('10', 'David','5');";  
	   
		$result=$conn->query($sql);
	    if($result != true){
	        die("<br>Unable to create user table");
	   }
	   else{
	        ECHO "<br> User Table Created<br>";                
	     }     
	     
	     
		$sql="CREATE TABLE messages ("
	    ."id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,"
	    ."message TEXT NOT NULL,"
	    ."time VARCHAR(50) NOT NULL,"
	    ."senderid VARCHAR(50) NOT NULL,"
	    ."receiverid VARCHAR(50) NOT NULL);"
	    ."INSERT INTO messages (message, time, senderid, receiverid)"
		." VALUES"."('Sami first message sent to Jason', 'May 15 at 2:23pm', 'Sami', 'Jason'),
					('Sarah first message sent to Jason', 'May 15 at 1:23pm', 'Sarah', 'Jason'),
					('Aaiden first message sent to Jason', 'May 15 at 12:23pm', 'Aaiden', 'Jason'),
					('Jason first message sent to Sami', 'May 15 at 12:12pm', 'Jason', 'Sami'),
					('Sami first message sent to David', 'May 14 at 11:34am', 'Sami', 'David'),
					('David first message sent to Sami', 'May 14 at 11:34am', 'David', 'Sami'),					
					('Yael first message sent to David', 'May 14 at 10:43am', 'Yael', 'David'),
					('Aliah first message sent to Jason', 'May 13 at 7:05am', 'Aliah', 'Jason'),
					('Iida first message sent to David', 'May 13 at 7:05am', 'Iida', 'David'),
					('Jason first message sent to David', 'May 13 at 4:36am', 'Jason', 'David'),
					('Olive first message sent to Jason', 'May 13 at 2:22am', 'Olive', 'Jason'),
					('Iida SECOND message sent to David', 'May 12 at 1:25am', 'Iida', 'David');";  
	   
		$result=$conn->query($sql);
	    if($result != true){
	        die("<br>Unable to messages user table");
	   }
	   else{
	        ECHO "<br>Messages Table Created<br>";                
	     }            
	}

	
/////////////// Register users and validate logon process ///////////////

function registerUser(){ 
	$cnfrmPassword = strip_tags($_POST['confirmPassword']); 		
	$cnfrmPassword = stripslashes($cnfrmPassword);      
    if(isset($_POST["registerBtn"])){
	// User clicked register button
        if ($_POST["registerPassword"] != $cnfrmPassword){
            echo '<div class="alert" data-alert="yellow"><div class="closeAlert"></div>SORRY. Passwords do not match. <span>Try again</span>.</div>';
            exit();
        }
        
	// Both passwords match, see if user name already in use      
       $conn = openDB();
        $cnfrmName = strip_tags($_POST['registerName']); 		
	    $cnfrmName = stripslashes($cnfrmName);               
        $query = "SELECT password FROM user WHERE name='".$cnfrmName."' ;";
        $ds =$conn->query($query);
        $cnt = $ds->rowCount();
        if ($cnt == 1){	            
        	echo '<div class="alert" data-alert="yellow"><div class="closeAlert"></div>User name already registered, use different name. <span>Try again</span>.</div>';
            exit();              
        }

                    
        //Add to user table   
		$sql ="INSERT INTO `user` (`name`, `password`)"." VALUES " 
                ."( '"
                .$_POST['registerName']."','"
                .$_POST['registerPassword']."');"; 
        $result =$conn->query($sql);
        if ( $result != true){
        	echo "<script>alert('Registry failed');</script>";
        }else{
 	        echo '<div class="alert" data-alert="green"><div class="close-x"></div>Registry was successful! <span>Log in</span></div>';
				$last_id =$conn->lastInsertId();
				session_start();
				$_SESSION["granted"] = "open";
				$_SESSION["userName"] = $_POST['registername'];
				$_SESSION["userId"] = $last_id;
            exit();
        }

    }
  }   
//////// Returning user  ///////////////////////////
	if(isset($_POST["logIn"])){

		$conn = openDB();               
		$query = "SELECT password, id FROM user WHERE name='".$_POST['userName']."' ;";
		$ds =$conn->query($query);
		$cnt = $ds->rowCount();		
		if ($cnt == 1 ){
			
			$row = $ds->fetch(); // Get data row			
						
			if($row["password"]==$_POST['userPassword']){
				echo"<script>alert('Access granted')</script>";
				session_start();
				$_SESSION["granted"] = "open";
				$_SESSION["userName"] = $_POST['userName'];
				$_SESSION["userId"] = $row["id"];
				echo"<script>window.open('successPage.php','_self');</script>";
				exit();
			}else{
				echo"<script>alert('User name or password is incorrect.')</script>";
				echo"<script>window.open('loginPage.php','_self');</script>";
		        exit();
		    }
		
	}	
}


//////// Display members in right-side chat list  ///////////////////////////


/*
The goal is to retrieve all the members AND show the last conversation the 'user' had with each individual AND show who sent the last message
Goal 1: check. This is only a test
Goal 2:
Goal 3:
*/

function showMembers(){   
    $conn = openDB();               
	$query = "SELECT id, message, senderid, receiverid FROM messages WHERE id IN (SELECT MAX(id) FROM messages GROUP BY senderid) " ; // Groups members and shows last message per person
//  	$query = "SELECT user.id, user.name, messages.message, messages.senderid, messages.receiverid FROM user JOIN messages ON user.name=messages.senderid" ;      
    $ds = $conn->query($query);
    $cnt = $ds->rowCount();
    if ($cnt == 0){
        echo "<span> No members found </span>";
        return; // No contacts 
    } 
/*
    foreach ($ds as $row){
        if($row["senderid"]==$_SESSION["user"]){echo '';}
        if($row["senderid"]!=$_SESSION["user"]){echo '<li><div class="profilePicList"><h103 class="v-centered"></h103></div><h100 class="aHorizontal">',$row["senderid"],'<br>';}
	    if($row["senderid"]!=$_SESSION["user"]){echo '<span>',$row["message"],'</span></h100></li>';}
	}
*/
/*
	foreach ($ds as $row){
  		if($row["senderid"]==$_SESSION["user"]){echo '';}
        if($row["senderid"]!=$_SESSION["user"]){echo '<li><div class="profilePicList"><h103 class="v-centered"></h103></div><h100 class="aHorizontal">'.$row["senderid"].'<br>';}
        
	    if($row["senderid"]==$_SESSION["user"]){ echo '<span> You:'.$row["message"];}   //  this closing is hidden
		if($row["senderid"]!=$_SESSION["user"] && $row["senderid"]!="Jason"){ echo '<span>'.$row["message"];} // this closing is shown
	    echo '</span></h100></li>';
    } 
*/  
   foreach ($ds as $row){
        if($row["senderid"]==$_SESSION["user"]){echo '';}
        if($row["senderid"]!=$_SESSION["user"]){echo '<li><div class="profilePicList"><h103 class="v-centered"></h103></div><h100 class="aHorizontal">'.$row["name"].'<br>';}
	    if($row["senderid"]!=$_SESSION["user"]){echo '<span>'.$row["message"].'</span></h100></li>';}
	}   
}


//////// Display members in search feild  ///////////////////////////

function showMembersForSearch(){   
    $conn = openDB();               
    $query = "SELECT name FROM user" ;
    $ds = $conn->query($query);
    $cnt = $ds->rowCount();
    if ($cnt == 0){
        echo "<span> No members found </span>";
        return; // No contacts 
    } 
    foreach ($ds as $row){
        echo '<option value="',$row["name"],'">';
    }    	    
}
/////////////////////////// Send email to member /////////////////////////////////
if (isset($_POST["submitMessageBtn"])){
	date_default_timezone_set('america/new_york');
	$conn = openDB();
	    	    
	    $sql ="INSERT INTO messages (message, time, senderid, receiverid)"
            ." VALUES " 
            ."(:themail, :thetime, :thesender, :thereceiver);";

	       $ps=$conn->prepare($sql);
		   $ps->bindParam(':themail',$_POST['mailFromList'],PDO::PARAM_STR);
		   $ps->bindParam(':thetime',date("n.j.y"),PDO::PARAM_STR);
		   $ps->bindParam(':thesender',$_POST['theSenderId'],PDO::PARAM_STR);
		   $ps->bindParam(':thereceiver',$_POST['theReceiverId'],PDO::PARAM_STR);
		   $ps->execute();                    
	
	    $result = $conn->query($sql);
	    if ( $result != true){         
//         echo "<div class='alertBoxWrapper'><div class='alertBox'><h102>Could not update project info</h102></div></div>";
	    }
	    else{
// 	    echo "<div class='alertBoxWrapper'><div class='alertBox'><h102>Project updated</h102></div></div>";
	    }
   header("Location:index.php?sender=".$_POST['theSenderId']."&receiver=".$_POST['theReceiverId'],true,303);
 }
 
 
/////////////////////////// Count number of times mail was sent to reciever ///////////////////////////////// 

function countMessages(){   
    $conn = openDB();               
    $query = "SELECT receiverid FROM messages WHERE receiverid='David';" ;
    $ds = $conn->query($query);
    $cnt = $ds->rowCount();
    if ($cnt == '' || $cnt == null){
        echo "0";
    } 
    if ($cnt != 0){
	    echo $cnt;
	}
}    	    


function storedMsgCnt(){   
    $conn = openDB();               
    $query = "SELECT storedMsgCnt FROM user WHERE name='David';" ;
    $ds = $conn->query($query);
    $cnt = $ds->rowCount(); 
    foreach ($ds as $row){
        echo $row["storedMsgCnt"];
    }    	  
} 

////////////////////////////////

if (isset($_POST["updateCnt"])){
    $conn = openDB();
        $sql ="UPDATE `user`"
                . " SET `storedMsgCnt` = '".$_POST['newCnt']."'"
                . "WHERE name = ". "'David'";               

        $result = $conn->query($sql);
        if ( $result != true){
            
//           ECHO "<div class='alertBoxWrapper'><div class='alertBox'><h102>Could not update user message count</h102></div></div>";
        }
        else{
//             ECHO "<div class='alertBoxWrapper'><div class='alertBox'><h102>Project updated</h102></div></div>";
        }
}

//////////////////// JUST FOR TESTING START ///////////////////////////////////
if (isset($_POST["setUser"])){
	$_SESSION["user"] = $_POST['chooseName'];
}

/////////////////////JUST FOR TESTING END////////////////////////


?>











