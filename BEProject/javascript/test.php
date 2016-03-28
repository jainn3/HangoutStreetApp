<?php
session_start();
$ref = $_POST['ref'];
$url ="https://maps.googleapis.com/maps/api/place/details/json?reference=".$ref."&sensor=false&key=AIzaSyAEv3hJQ2znKTtMeZ3X5LX4Z1vo-uWlT0E";
$ch = curl_init();
//echo $url;
curl_setopt($ch , CURLOPT_URL , $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data11 = curl_exec($ch);
curl_close($ch);
$data11 = json_decode($data11);
echo "<h4><u>".$data11->result->name."</u></h4>";
if(isset($data11->result->reviews[0]->text)&&($data11->result->reviews[0]->text!=""))
{
	for ($j=0; $j < 3; $j++)
	{
		if(isset($data11->result->reviews[$j]->text)&&($data11->result->reviews[$j]->text!=""))
		{
			echo "<b>REVIEW ".($j+1)." : </b>".$data11->result->reviews[$j]->text."</br>";
		}
	}
}
else
{
	echo "<b>NO Reviews Available</b>";
}
exit;
?>