<?php
session_start();
	$type=$_POST['jsa'];
	//echo "second time";
    if(isset($_SESSION["allrestaurant"]))
		{
			$datapl=$_SESSION["allrestaurant"];
			$i = 0;
			for ($i; $i < 15; $i++)
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
						          
							//echo $datapl->results[$i]->geometry->location->lat."<br/>";
							//echo $datapl->results[$i]->geometry->location->lng."<br/>";
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
								}
						}
				}			
			
		}
	
	exit;	


?>