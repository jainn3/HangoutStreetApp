<?php
session_start();
	include_once('../common_classes/functions.php');
	$selflat=$_POST['jsa1'];
	$selflong=$_POST['jsa2'];
	$type=$_POST['jsa'];
	//echo $type;
	//echo $selflat;
	//GOOGLE PLACES API
	$url ="https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$selflat.",".$selflong."&radius=1000&types=food|restaurant|cafe|bar&keyword=restaurant|cafe|bar&sensor=false&key=AIzaSyAEv3hJQ2znKTtMeZ3X5LX4Z1vo-uWlT0E";
	//echo $url."</br>";
	$ch = curl_init();
	curl_setopt($ch , CURLOPT_URL , $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$datap1 = curl_exec($ch);
	//echo $data;
	curl_close($ch);
    $datapl = json_decode($datap1);
	$_SESSION["allrestaurant"] = $datapl ;
	header('Location:rating.php');
	$datap1=$_SESSION["allrestaurant"] ;

	$i = 0;
	for ($i; $i < 5; $i++)
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
									
									$rating = "NA";
									if(isset($datapl->results[$i]->rating))
									{
										$rating = $datapl->results[$i]->rating;
									}
									echo $rating."^";
									echo $ref."@";
								// GOOGLE PLACES API END
								}
						}
				}
	exit;
?>