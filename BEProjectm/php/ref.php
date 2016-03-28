<?php 
session_start();
include_once "php_files/guser.php";
$con = getconnection();
$query = "INSERT INTO request VALUES ('".$_SESSION['userid']."','".$_POST['4']."')";
echo $query;
$result = mysql_query($query);

?>