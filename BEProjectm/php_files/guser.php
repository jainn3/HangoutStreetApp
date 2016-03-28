<?php 
include_once "../common_classes/functions.php";

function get_picture($gid)
{
	$url = "https://www.googleapis.com/plus/v1/people/".$gid."?key=AIzaSyCO49t4xpkdJp-3nJxyZx2WSM4skEl6H94";
	$ch = curl_init();
	curl_setopt($ch , CURLOPT_URL , $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data2 = curl_exec($ch);
	curl_close($ch);
	$datap = json_decode($data2);
	return $datap;

}

function insertguser($gdata)
{
	$con = getconnection();
	$query = "SELECT uid FROM guser WHERE gid = '".$gdata->id."';";
	$result = mysql_query($query);
	echo $query.$result."hi<br/>";
	if(mysql_num_rows($result) == 0)
	{
		if(isset($gdata->gender))
		$gender = $gdata->gender;
		else
		$gender = "";
		$query1 = "INSERT INTO guser VALUES ('','".$gdata->id."','{$gdata->displayName}','{$gender}','1','".$_SESSION['accessToken']->refresh_token."')";
		echo $query1;
		$result1 = mysql_query($query1);
		
		if($result1 == NULL)
			return NULL;
		else
		{
			$result2 = mysql_query($query);
			$row = mysql_fetch_row($result2);
		}
	}
	else
	{
		$row = mysql_fetch_row($result);
		$_SESSION["userid"] = $row[0];
	}
}

function getfriendlist($gid)//refresh token for friend data
{
	$con = getconnection();
	$query = "SELECT refresh_token from guser WHERE uid IN (SELECT fid FROM friend WHERE uid = (SELECT uid FROM guser WHERE gid = '".$gid."')) OR uid IN (SELECT uid FROM friend WHERE fid = (SELECT uid FROM guser WHERE gid = '".$gid."'))";
	//echo $query;
	$result = mysql_query($query);
	
	return $result;
}

function onlinefriend()
{
     $con = getconnection();
	 //$query="SELECT fid from friend WHERE friend.uid='".$_SESSION['userid']."'";
	 $query="SELECT guser.uid,guser.gname,guser.gid from guser WHERE guser.uid in(SELECT fid from friend WHERE friend.uid='".$_SESSION['userid']."') OR guser.uid in(SELECT uid from friend WHERE friend.fid='".$_SESSION['userid']."') AND guser.status=1 AND guser.uid!='".$_SESSION['userid']."'";
	 $result = mysql_query($query);
	 return $result;
	 //echo $query;
	 while($row = mysql_fetch_row($result))
	 {
		echo "<b>".$row[0]."</b>"; 
	 }


}

function offlinefriend()
{
     $con = getconnection();
	 //$query="SELECT fid from friend WHERE friend.uid='".$_SESSION['userid']."'";
	 $query="SELECT guser.uid,guser.gname,guser.gid from guser WHERE guser.uid in(SELECT fid from friend WHERE friend.uid='".$_SESSION['userid']."') OR guser.uid in(SELECT uid from friend WHERE friend.fid='".$_SESSION['userid']."') AND guser.status!=1 AND guser.uid!='".$_SESSION['userid']."'";
	 $result = mysql_query($query);
	 //echo $query;
	 return $result;
	 while($row = mysql_fetch_row($result))
	 {
		echo "<b>".$row[0]."</b>"; 
	 }


}


function getfriendnotifications()
{
	$con = getconnection();
    $query = "SELECT guser.uid,guser.gname,request.type,request.uid,request.fid FROM guser,request WHERE guser.uid IN(SELECT uid FROM request WHERE fid = '".$_SESSION['userid']."') OR guser.uid IN(SELECT fid FROM request WHERE uid = '".$_SESSION['userid']."') ";
    //echo $query;
	$result = mysql_query($query);
	while($row = mysql_fetch_row($result))
	{
	          
	     if($row[2]=="accept" AND $row[3]==$_SESSION['userid'])
			   {			   
			   	echo "<b>".$row[1]."</b> has accepted your friend request";
			   }
		 else if($row[2]=="request" AND $row[4]==$_SESSION['userid'])
			   {
					   echo "<div id='".$row[0]."' style='visibility:visible;'><b>You have been invited by".$row[1]."</b> </div>";
			           echo "<button id='".$row[0]."' name='name' value='".$row[0]."' onclick='acceptfriend(\"".$row[0]."\")'>Accept</button>";
			           echo "<button id='".$row[0]."' name='reject' value='".$row[0]."'>Reject</button>";
					  		
					  		if(isset($_POST['name']) OR isset($_POST['reject']))
					  		  {
					  			    $id=$_POST['name'];
					  			    echo "<script>document.getElementById('".$id."').style.visibility='hidden';</script>";
					  		  }

			  }          
	}
}

function getuserlist()
{
	$con = getconnection();
	$query = "SELECT guser.uid,guser.gname,guser.gid FROM guser WHERE guser.uid!='".$_SESSION['userid']."' AND guser.uid NOT IN(SELECT friend.fid from friend WHERE friend.uid='".$_SESSION['userid']."') AND guser.uid NOT IN(SELECT friend.uid from friend WHERE friend.fid='".$_SESSION['userid']."') AND guser.uid NOT IN(SELECT request.fid from request WHERE request.uid='".$_SESSION['userid']."') AND guser.uid NOT IN(SELECT request.uid from request WHERE request.fid='".$_SESSION['userid']."')";
    $result = mysql_query($query);
    //echo $query;
    return $result;
}

function getrestnotifications()
{
	$con = getconnection();
    $query = "SELECT guser.uid,guser.gname,restnotify.type,restnotify.uid,restnotify.fid,restnotify.rest_name FROM guser,restnotify WHERE guser.uid IN(SELECT uid FROM restnotify WHERE fid = '".$_SESSION['userid']."') OR guser.uid IN(SELECT fid FROM restnotify WHERE uid = '".$_SESSION['userid']."') ";
    //echo $query;
	$result = mysql_query($query);
	while($row = mysql_fetch_row($result))
	{
	          
	     if($row[2]=="accept" AND $row[3]==$_SESSION['userid'])
			   {			   
			   	echo "<b>".$row[1]."</b> has accepted your invitation! ";
			   }
		 else if($row[2]=="request" AND $row[4]==$_SESSION['userid'])
			   {
					   echo "<div id='".$row[0]."' style='visibility:visible;'><b>You have been invited by".$row[1]."for".$row[5]."</b> </div>";
			           echo "<button id='".$row[0]."' name='name' value='".$row[0]."' onclick='acceptinvi(\"".$row[0]."\")'>M coming!</button>";
			           echo "<button id='".$row[0]."' name='reject' value='".$row[0]."'>Not interested</button>";
					  		
					  		if(isset($_POST['name']) OR isset($_POST['reject']))
					  		  {
					  			    $id=$_POST['name'];
					  			    echo "<script>document.getElementById('".$id."').style.visibility='hidden';</script>";
					  		  }

			  }          
	}
}
?>
