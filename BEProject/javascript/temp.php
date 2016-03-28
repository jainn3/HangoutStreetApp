
<!--script>
function acceptfriend()
{
  alert("heloo");
<?php
if(isset($_POST['name']))
{
	echo "<script> alert('added')</script>";
	$con = getconnection();
	$query = "INSERT INTO friend VALUES ('".$_POST['name']."','".$_SESSION['userid']."')";
	$result = mysql_query($query);	
	echo "<script> alert('added to friend db')</script>";
	$query1="UPDATE request SET type='accept' WHERE uid='".$_POST['name']."' AND fid='".$_SESSION['userid']."'";
	$result = mysql_query($query1);	
	echo $query1;
	echo "<script> alert('request updated')</script>";
}
?>
}
function rejectfriend()
{
	<?php
	if(isset($_POST['reject']))
	{
	$con = getconnection();
    $query = "DELETE FROM request WHERE uid='".$_POST['reject']."' AND fid='".$_SESSION['userid']."'";
	$result = mysql_query($query1);	
	echo "<script> alert('friend deleted')</script>";
	}
	?>
}


</script-->
*/