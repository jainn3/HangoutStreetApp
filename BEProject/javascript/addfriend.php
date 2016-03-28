<?php 
session_start();
include_once "../php_files/guser.php";

	$result = getuserlist();
    echo "<table id='sametable'>";
    while($row = mysql_fetch_row($result))
    {
    	if($row[1]!="")
    	{
			echo "<tbody id='".$row[0]."'>";
			echo "<tr><td>";
		    echo "<b><font color = 'white'>".$row[1]."</b></font></td><td>";
			$image1 = get_picture($row[2]);
			$img= $image1->image->url;
		    echo "<img src ='".$img."' /></td><td>";
		    echo "<button class='butt' name='name1' value='".$row[0]."' onclick='adddb(\"".$row[0]."\")'>Addfriend</button>";
			echo "</td></tr>";	  
			echo "</tbody>";
		}
		/*if(isset($_POST['name1']))
	    {
			unset($_POST['name1']);	 
		}*/
	}
	echo "</table>";
exit;
?>
