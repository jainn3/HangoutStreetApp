<?php
session_start();
include_once("../php_files/guser.php");
$olfriend=onlinefriend();
if($olfriend === NULL) {
    die("You have no buddies online"); // TODO: better error handling
}
echo "<table id='sametable'>";
 while($row = mysql_fetch_row($olfriend))
	 {echo "<tr><td style='padding-left: 10px; padding-right: 10px;'>";
		echo "<b>".$row[1]."</b></td><td style='padding-left: 10px; padding-right: 10px;'>"; 
		$image1 = get_picture($row[2]);
	$img= $image1->image->url;
     echo "<img src ='".$img."' /></td>";
	 echo "<td style='padding-left: 10px; padding-right: 10px;'><img src='online.png'/></td></tr>";

	 }

$offriend=offlinefriend();
if(empty($offriend)) {
    echo "You have no buddies offline"; // TODO: better error handling
}
while($row = mysql_fetch_row($offriend))
{	
	echo "<tr><td style='padding-left: 10px; padding-right: 10px;'>";
	echo "<b>".$row[1]."</b></td><td style='padding-left: 10px; padding-right: 10px;'>"; 
	$image1 = get_picture($row[2]);
	$img= $image1->image->url;
    echo "<img src ='".$img."' /></td><td style='padding-left: 10px; padding-right: 10px;'>";
	echo "<img src='offline.png'/></td></tr>";
}
echo "</table>";
exit;
?>