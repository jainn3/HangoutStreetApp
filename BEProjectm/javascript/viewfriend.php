<?php
session_start();
include_once("../php_files/guser.php");
$olfriend=onlinefriend();
 while($row = mysql_fetch_row($olfriend))
	 {echo "<table id='sametable' border='1' cellpadding='10'><tr><td>";
		echo "<b>".$row[0]."</b></td><td>"; 
		$image1 = get_picture($row[1]);
	$img= $image1->image->url;
     echo "<img src ='".$img."' /></td></tr></table>";

	 }

$offriend=offlinefriend();
while($row = mysql_fetch_row($offriend))
	 {echo "<table border='1' cellpadding='10'><tr><td>";
		echo "<b>".$row[0]."</b></td><td>"; 
		$image1 = get_picture($row[1]);
	$img= $image1->image->url;
     echo "<img src ='".$img."' /></td></tr></table>";

	 }


exit;
?>