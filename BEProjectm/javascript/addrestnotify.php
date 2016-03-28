<?php
	session_start();  
	include_once('../common_classes/functions.php');
	$id=$_POST['jsa'];
	$ref=$_POST['ref'];
	echo $id;
	$con = getconnection();
	$query = "INSERT INTO restnotify VALUES ('".$_SESSION['userid']."','".$id."','request','".$ref."')";
	$result = mysql_query($query);	
	echo $query;

?>