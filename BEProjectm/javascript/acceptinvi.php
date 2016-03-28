<?php
	session_start();
	include_once('../common_classes/functions.php');
	$id=$_POST['jsa'];
	echo $id;
	$con = getconnection();
	$query1="UPDATE restnotify SET type='accept' WHERE uid='".$id."' AND fid='".$_SESSION['userid']."'";
	$result = mysql_query($query1);	
	echo $query1;
?>