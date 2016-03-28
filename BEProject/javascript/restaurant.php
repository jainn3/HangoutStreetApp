<?php
session_start();
	include_once('../common_classes/functions.php');
	$selflat=$_POST['jsa1'];
	$selflong=$_POST['jsa2'];
	$type=$_POST['jsa'];
	//echo $type;
	//echo $selflat;
	//GOOGLE PLACES API
	$url ="https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$selflat.",".$selflong."&radius=5000&types=food|restaurant|cafe|bar&keyword=restaurant|cafe|bar&sensor=false&key=AIzaSyAEv3hJQ2znKTtMeZ3X5LX4Z1vo-uWlT0E";
	//echo $url."</br>";
	$ch = curl_init();
	curl_setopt($ch , CURLOPT_URL , $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$datap1 = curl_exec($ch);
	//echo $data;
	curl_close($ch);
    $datapl = json_decode($datap1);
	$cnt=count($datapl->results);
			//echo "there".$cnt."</br>";
			$temp_cnt=$cnt;
			$i=0;
			$bool=false;
			for ($i; $i < $cnt; $i++)
			{
				if(isset($datapl->results[$i]->rating)==false)
				{
					$datapl->results[$i]->rating = 0;
				}
			}
			$i=0;
			for ($i; $i < $cnt-1; $i++)
				{
					$max=$i;
					for ($j=$i+1; $j < $cnt; $j++)
					{
						  
							if($datapl->results[$j]->rating >= $datapl->results[$max]->rating)
						   {
								$max=$j;									
						   }
						
					}
				/*else
					{
									
									$max = 	$temp_cnt-1;
									$temp_cnt=$temp_cnt-1;
									//echo $max."hii".$i;
									$bool=true;
					}*/
					//secho $datapl->results[$max]->rating."<br>";
						$t=$datapl->results[$max];
						$datapl->results[$max]=$datapl->results[$i];
						$datapl->results[$i]=$t;
				

			}
	$_SESSION["allrestaurant"]=$datapl;				
	$i = 0;
	for ($i; $i < 50; $i++)
				{
					$j=0;
					if(isset( $datapl->results[$i]))
						{
							$bool=false;;
							for ($j=0; $j < 5; $j++)
                                {
									if(isset( $datapl->results[$i]->types[$j]))
											if($datapl->results[$i]->types[$j]==$type)
												{
													$bool=true;
													break;
			
												}
								
								}
						          
							//
							if($bool)
								{
									echo $datapl->results[$i]->geometry->location->lat."^";
									echo $datapl->results[$i]->geometry->location->lng."^";
									echo $datapl->results[$i]->name."^";
									echo $datapl->results[$i]->vicinity."^";
									echo $datapl->results[$i]->types[$j]."^";
									//echo $datapl->results[$i]->reference."<br/>";
									$ref= $datapl->results[$i]->reference;
									$photourl="";
									if(isset($datapl->results[$i]->photos))
									{
										//$photourl="heello";
										$picref = $datapl->results[$i]->photos[0]->photo_reference;
										$photourl = "https://maps.googleapis.com/maps/api/place/photo?photoreference=".$picref."&maxwidth=75&maxheight=75&sensor=false&key=AIzaSyAEv3hJQ2znKTtMeZ3X5LX4Z1vo-uWlT0E";
									}
									
									$rating = "NA";
									if($datapl->results[$i]->rating!=0)
									{
										$rating = $datapl->results[$i]->rating;
									}
									echo $rating."^";
									echo $photourl."^";
									echo $ref."@";
								// GOOGLE PLACES API END
								}
						}
				}
	exit;
?>