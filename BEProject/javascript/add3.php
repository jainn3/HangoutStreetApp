<?php
session_start();
$con = mysql_connect("localhost","root","");
                if (!$con)
                {
                        die('Could not connect: ' . mysql_error());
                }
                mysql_select_db("hangout", $con);
				 $slat=$_POST['jsa'];
                $slong=$_POST['jsa1'];
				$dlat = $_POST['jsa2'];
				$dlong=$_POST['jsa3'];
				date_default_timezone_set("Asia/Calcutta");

				$thestime=date("Y-m-d H:i");
				$datetime_from = date("Y-m-d H:i",strtotime("-30 minutes",strtotime($thestime)));
				//$query = "SELECT * FROM final WHERE slat='".$slat."' AND timedate between '".$thestime."' and  '".$datetime_from."' ";
				//$query = "SELECT * FROM final";
				//$query = "SELECT route,avg(timer),slat,slong,dlat,dlong FROM final WHERE slat like CONCAT( SUBSTRING('".$slat."', 1, 5), '%' AND timedate between '".$datetime_from."' and '".$thestime."' group by(route)";
				$query = "SELECT route,avg(timer),slat,slong,dlat,dlong FROM final WHERE slat like CONCAT( SUBSTRING('".$slat."', 1, 5), '%') AND slong like CONCAT( SUBSTRING('".$slong."', 1, 5), '%') AND dlat like CONCAT( SUBSTRING('".$dlat."', 1, 5), '%') AND dlong like CONCAT( SUBSTRING('".$dlong."', 1, 4), '%') group by(route)";
				//echo $query;

				
		$result = mysql_query($query);
		$count = mysql_num_rows($result);	
		if($count==0)
			echo 'false';
		else
			{
				/*while($row = mysql_fetch_row($result))
				{
					$avg = $avg + $row [2];
				}
				$avg = $avg/$count;
				echo $avg;
				*/
				while($row = mysql_fetch_row($result))
				{
				echo $row [0]."^";
				echo $row [1]."^";
				echo $row [2]."^";
				echo $row [3]."^";
				echo $row [4]."^";
				echo $row [5]."^";
				echo "@";
				}				
			}
?>
