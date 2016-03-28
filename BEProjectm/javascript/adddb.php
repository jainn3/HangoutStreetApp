<?php
	session_start();  
	include_once('../common_classes/functions.php');
	$id=$_POST['jsa'];
	echo $id;
	$con = getconnection();
	$query = "INSERT INTO request VALUES ('".$_SESSION['userid']."','".$id."','request')";
	$result = mysql_query($query);	
	echo $query;

?>