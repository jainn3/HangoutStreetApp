<?php
session_start();
include_once('../common_classes/functions.php');
$lat = $_POST['latitude'];
$lon = $_POST['longitude'];
$_SESSION['latitude'] = $lat;
$_SESSION['longitude'] = $lon;
$con = getconnection();
$query = "UPDATE guser SET latitude = ".$lat.",longitude = ".$lon." WHERE uid = ".$_SESSION['userid'].";";
//echo $query;
$result = mysql_query($query);
exit;
?>