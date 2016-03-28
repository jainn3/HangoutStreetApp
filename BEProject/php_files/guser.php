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

function logout()
{
	$con = getconnection();
	$query = "UPDATE guser SET status = 0 WHERE guser.uid = ".$_SESSION['userid'].";";
	$result = mysql_query($query);
	return $result;
}

function checkguserdb($gdata)
{
	$con = getconnection();
	$query = "SELECT uid FROM guser WHERE gid = '".$gdata->id."';";
	//echo $query."</br>";
	$result = mysql_query($query);
	return $result;
}

function checkrefreshtoken($accessdata,$gdata)
{
	$result = checkguserdb($gdata);
	if(mysql_num_rows($result) > 0)
	{
		$query = "UPDATE guser SET refresh_token = '".$accessdata->refresh_token."' WHERE gid = '".$gdata->id."';";
		//echo $query."</br>";
		$result1 = mysql_query($query);
	}
	
}

function insertguser($gdata)
{
	$result = checkguserdb($gdata);	//echo $query.$result."hi<br/>";
	if(mysql_num_rows($result) == 0)
	{
		if(isset($gdata->gender))
		$gender = $gdata->gender;
		else
		$gender = "";
		$query1 = "INSERT INTO guser VALUES ('','".$gdata->id."','{$gdata->displayName}','{$gender}','1','".$_SESSION['accessToken']->refresh_token."','','')";
		//echo $query1;
		$result1 = mysql_query($query1);
		if($result1 == NULL)
			return NULL;
		else
		{
			$result2 = checkguserdb($gdata);
			if(mysql_num_rows($result2)>0)
			{
				$row = mysql_fetch_row($result2);
				$_SESSION["userid"] = $row[0];
			}
		}
	}
	else
	{
		$row = mysql_fetch_row($result);
		$_SESSION["userid"] = $row[0];
		$query2 = "UPDATE guser SET status = 1 WHERE guser.uid = ".$_SESSION['userid'].";";
		$result2 = mysql_query($query2);
		return $result2;
	}
}

function getfriendlist($gid)//refresh token for friend data
{
	$con = getconnection();
	$query = "SELECT refresh_token,uid,latitude,longitude,status,gid,gname from guser WHERE uid IN (SELECT fid FROM friend WHERE uid = (SELECT uid FROM guser WHERE gid = '".$gid."')) OR uid IN (SELECT uid FROM friend WHERE fid = (SELECT uid FROM guser WHERE gid = '".$gid."'))";
	//echo $query;
	$result = mysql_query($query);
	return $result;
}

function onlinefriend()
{
     $con = getconnection();
	 //$query="SELECT fid from friend WHERE friend.uid='".$_SESSION['userid']."'";
	 $query="SELECT guser.uid,guser.gname,guser.gid from guser WHERE (guser.uid in(SELECT fid from friend WHERE friend.uid='".$_SESSION['userid']."') OR guser.uid in(SELECT uid from friend WHERE friend.fid='".$_SESSION['userid']."')) AND guser.status=1 AND guser.uid!='".$_SESSION['userid']."'";
	 $result = mysql_query($query);
	 //echo $query;
	 return $result;
	 
}

function offlinefriend()
{
     $con = getconnection();
	 //$query="SELECT fid from friend WHERE friend.uid='".$_SESSION['userid']."'";
	 $query="SELECT guser.uid,guser.gname,guser.gid from guser WHERE (guser.uid in(SELECT fid from friend WHERE friend.uid='".$_SESSION['userid']."') OR guser.uid in(SELECT uid from friend WHERE friend.fid='".$_SESSION['userid']."')) AND guser.status!=1 AND guser.uid!='".$_SESSION['userid']."'";
	 $result = mysql_query($query);
	 //echo $query;
	 return $result;
}


function getfriendnotifications()
{
	$con = getconnection();
    $query = "SELECT guser.uid,guser.gname,request.type,request.uid,request.fid FROM guser,request WHERE guser.uid=request.uid AND request.fid = '".$_SESSION['userid']."' AND type='request' OR guser.uid =request.fid AND request.uid = '".$_SESSION['userid']."' AND type='accept' ";
    //echo $query;
	$result = mysql_query($query);
	while($row = mysql_fetch_row($result))
	{
	          
	     if($row[2]=="accept" AND $row[3]==$_SESSION['userid'])
			   {			   
			   	echo "<b>".$row[1]."</b> has accepted your friend request.....<br>";
			   }
		 else if($row[2]=="request" AND $row[4]==$_SESSION['userid'])
			   {
					   echo "<div id='".$row[0]."' style='visibility:visible;'><b>You have been invited by....".$row[1]."</b><br> ";
			           echo "<button class='butt' id='".$row[0]."' name='name' value='".$row[0]."' onclick='acceptfriend(\"".$row[0]."\")'>Accept</button>";
			           echo "<button class='butt' id='".$row[0]."' name='reject' value='".$row[0]."'>Reject</button><br>";
			           echo "</div>";
					  		
					  		if(isset($_POST['name']) OR isset($_POST['reject']))
					  		  {
					  			    $id=$_POST['name'];
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
    $query = "SELECT guser.uid,guser.gname,restnotify.type,restnotify.uid,restnotify.fid,restnotify.rest_name FROM guser,restnotify WHERE (guser.uid =restnotify.uid AND restnotify.fid = '".$_SESSION['userid']."') OR (guser.uid = restnotify.fid AND restnotify.uid = '".$_SESSION['userid']."')";
    //echo $query;
	$result = mysql_query($query);
	while($row = mysql_fetch_row($result))
	{
	          
	     if($row[2]=="accept" AND $row[3]==$_SESSION['userid'])
			   {			   
			   	echo "<b>".$row[1]."</b> has accepted your restaurant invitation! <br> ";
			   }
		 else if($row[2]=="request" AND $row[4]==$_SESSION['userid'])
			   {
					   echo "<div id='".$row[0]."' style='visibility:visible;'><b>You have been invited by ".$row[1]." for ".$row[5]." </b> <br> </div>";
			           echo "<button class='butt' id='".$row[0]."' name='name' value='".$row[0]."' onclick='acceptinvi(\"".$row[0]."\",\"".$row[5]."\")'>M coming!</button>";
			           echo "<button class='butt' id='".$row[0]."' name='reject' value='".$row[0]."'>Not interested</button><br>";
					  		
					  		if(isset($_POST['name']) OR isset($_POST['reject']))
					  		  {
					  			    $id=$_POST['name'];
					  			    echo "<script>document.getElementById('".$id."').style.visibility='hidden';</script>";
					  		  }

			  }          
	}
}

function getrestsuggestions()
{
	$con = getconnection();
    $query = "SELECT checkin.uid,checkin.rest_name,checkin.amount FROM checkin WHERE checkin.uid IN(SELECT uid FROM friend WHERE fid = '".$_SESSION['userid']."') OR checkin.uid IN(SELECT fid FROM friend WHERE uid = '".$_SESSION['userid']."') ";
   // echo $query;
   
	$result = mysql_query($query);
    
    
    while($row = mysql_fetch_row($result))
	{
    $query1="SELECT guser.gname FROM guser WHERE uid = '".$row[0]."'";
   // echo $query1;
    $result1 = mysql_query($query1);
    $row1 = mysql_fetch_row($result1);
	echo "<b>".$row1[0]."</b> has visited ".$row[1]." ".$row[2]." times.<br>";
    }
}
?>
