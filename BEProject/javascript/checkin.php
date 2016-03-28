<?php
session_start();
include_once('../common_classes/functions.php');
include_once("../php_files/guser.php");
$ref = $_POST['ref'];
$con = getconnection();
$query = "SELECT amount FROM checkin WHERE uid = ".$_SESSION['userid']." AND rest_name = '".$ref."'";
$result = mysql_query($query);
if(mysql_num_rows($result) > 0)
{
	$row = mysql_fetch_row($result);
	$query1 = "UPDATE checkin SET amount = ".($row[0]+1)." WHERE uid = ".$_SESSION['userid']." AND rest_name = '".$ref."'";
	mysql_query($query1);
}
else
{
	$query1 = "INSERT INTO checkin VALUES ('".$_SESSION['userid']."','".$ref."',1)";
	$result1 = mysql_query($query1);	
}
echo "You are checked into ";
?>
