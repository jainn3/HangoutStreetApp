<?php 
session_start();
include_once "../php_files/guser.php";

	$result = getuserlist();
	echo "<form name='' method='post' action=''>";
    
    while($row = mysql_fetch_row($result))
    {
    
	  echo "<div id='".$row[0]."'>";
	  echo "<table border='2' cellpadding='10'><tr><td>";
      echo "<b>".$row[1]."</b></td><td>";
	 $image1 = get_picture($row[2]);
	$img= $image1->image->url;
     echo "<img src ='".$img."' /></td><td>";
      echo "<button class='butt' id='".$row[0]."' name='name1' value='".$row[0]."' type='submit' onclick='adddb(\"".$row[0]."\")'>Addfriend</button>";
	  echo "</td></tr></table>";
	  echo "<br>";
	  
	  echo "</div>";
	  if(isset($_POST['name1']))
         {
		  unset($_POST['name1']);	 
			 
		 }
	  
      }
echo "</form>";
exit;
?>
