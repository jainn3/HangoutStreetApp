<?php
session_start();
include_once("../php_files/guser.php");
$ref = $_POST['ref'];
$olfriend=onlinefriend();

echo "<form name='' method='post' action=''>";
echo "<table id='sametable'>";
 while($row = mysql_fetch_row($olfriend))
	 {echo "<div id='".$row[0]."'>";
		 echo "<tr><td>";
		echo "<b>".$row[1]."</b></td><td>"; 
		$image1 = get_picture($row[2]);
	$img= $image1->image->url;
     echo "<img src ='".$img."' /></td><td>";
	 echo "<button class='butt' id='".$row[0]."' name='name1' value='".$row[0]."' type='submit' onclick='addrestnotify(\"".$row[0]."\",\"".$ref."\")'>Invite</button></td></tr>";
	 echo "</div>";
	 
	 if(isset($_POST['name1']))
         {
		  unset($_POST['name1']);	 
			 
		 }
	  
      }
	  echo "</table></form>";
/*
$offriend=offlinefriend();
while($row = mysql_fetch_row($offriend))
	 {echo "<table border='1' cellpadding='10'><tr><td>";
		echo "<b>".$row[0]."</b></td><td>"; 
		$image1 = get_picture($row[1]);
	$img= $image1->image->url;
     echo "<img src ='".$img."' /></td><td>";
	 echo "<button class='butt' id='".$row[0]."' name='name1' value='".$row[0]."' type='submit' onclick='adddb(\"".$row[0]."\")'>Invite</button></td></tr></table>";

	 }
*/

exit;
?>