<?php
	session_start();
	include_once('../common_classes/functions.php');
	$id=$_POST['jsa'];	
	$con = getconnection();
    $query = "DELETE FROM request WHERE uid='".$id."' AND fid='".$_SESSION['userid']."'";
	$result = mysql_query($query1);	
	
	?>