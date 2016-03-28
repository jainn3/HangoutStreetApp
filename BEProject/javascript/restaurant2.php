<?php
session_start();
	$type=$_POST['jsa'];
	//echo "second time";
    if(isset($_SESSION["allrestaurant"]))
		{
			$datapl=$_SESSION["allrestaurant"];
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
									if($datapl->results[$i]->rating!=0)
									{
										$rating = $datapl->results[$i]->rating;
									}
									$phoneno = "NA";
									if(isset($datap1->results[$i]->international_phone_number))
									{
										$phoneno = $datap1->results[$i]->international_phone_number;
									}
									$photourl="";
									if(isset($datapl->results[$i]->photos))
									{
										$picref = $datapl->results[$i]->photos[0]->photo_reference;
										$photourl = "https://maps.googleapis.com/maps/api/place/photo?photoreference=".$picref."&maxwidth=75&maxheight=75&sensor=false&key=AIzaSyAEv3hJQ2znKTtMeZ3X5LX4Z1vo-uWlT0E";
									}
									echo $rating."^";
									echo $photourl."^";
									echo $ref."@";
								}
						}
				}			
			
		}
	
	exit;	


?>