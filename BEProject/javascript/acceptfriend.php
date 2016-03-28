<?php
	session_start();
	include_once('../common_classes/functions.php');
	$id=$_POST['jsa'];
	echo $id;
	$con = getconnection();
	$query = "INSERT INTO friend VALUES ('".$id."','".$_SESSION['userid']."')";
	$result = mysql_query($query);	
	$query1="UPDATE request SET type='accept' WHERE uid='".$id."' AND fid='".$_SESSION['userid']."'";
	$result = mysql_query($query1);	
	echo $query1;
?>