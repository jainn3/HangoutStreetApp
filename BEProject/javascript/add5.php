<?php
session_start();
$con = mysql_connect("localhost","root","");
                if (!$con)
                {
                        die('Could not connect: ' . mysql_error());
                }
                mysql_select_db("hangout", $con);
				// $slat=$_POST['jsa'];
               // $slong=$_POST['jsa1'];
				//$dlat = $_POST['jsa2'];
				//$dlong=$_POST['jsa3'];
				date_default_timezone_set("Asia/Calcutta");
				$thestime=date("Y-m-d H:i");
				$datetime_from = date("Y-m-d H:i",strtotime("-30 minutes",strtotime($thestime)));

				//$query = "SELECT round(avg(indi)),slat,slon,dlat,dlon FROM final1 WHERE uid = '1' AND timedate between '".$thestime."' and  '".$datetime_from."' group by(slat) order by(slat) desc";

				$query = "SELECT round(avg(indi)),slat,slon,dlat,dlon FROM final1 WHERE uid = '1' group by(slat) order by(order1) desc";
				//echo $query;

				
		$result = mysql_query($query);
		$count = mysql_num_rows($result);	
		if($count==0)
			echo 'false';
		else
			{			
				while($row = mysql_fetch_row($result))
				{
				echo $row [0]."^";
				echo $row [1]."^";
				echo $row [2]."^";
				echo $row [3]."^";
				echo $row [4]."^";
				echo "@";
				}				
			}
?>
