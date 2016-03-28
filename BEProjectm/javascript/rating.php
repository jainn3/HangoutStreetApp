<?php
	//$cnt_rest=count($temp);	
	//echo "here".$cnt_rest."</br> ";
	//	$temp=$datapl->results;
//echo "<script>alert("rating");  </script>";
		
			session_start();
			//echo "hiiiiiiiiiiiiiiiiiii";
			//$type=$_POST['jsa'];
			$datapl=$_SESSION["allrestaurant"];
			$cnt=count($datapl->results);
			//echo "there".$cnt."</br>";
			$temp_cnt=$cnt;
			$i=0;
			$bool=false;

			for ($i; $i < $cnt-1; $i++)
				{
					$max=$i;
				if(isset($datapl->results[$i]->rating))
					{
								for ($j=$i+1; $j < $cnt; $j++)
									{
									  if(isset($datapl->results[$j]->rating))
											{
											if($datapl->results[$j]->rating > $datapl->results[$max]->rating)
											   {
												$max=$j;									
											   }
												
											}

									}
					}
				else
					{
									$max = 	$temp_cnt-1;
									$temp_cnt=$temp_cnt-1;
									$bool=true;
					}
					
						$t=$datapl->results[$max];
						$datapl->results[$max]=$datapl->results[$i];
						$datapl->results[$i]=$t;
					if($temp_cnt==$i)
					{
						break;
					}
					if($bool)
					{
						$i=$i-1;
						$bool=false;
					}

			}
							
							
			$_SESSION["allrestaurant"]=$datapl;			
									
			/*						
			$i=0;
			for ($i; $i < $cnt; $i++)
						{
							
					echo "name is"; echo $datapl->results[$i]->name;
						if(isset($datapl->results[$i]->rating))
							{
							echo "rating is:"; echo $datapl->results[$i]->rating;
							}
							echo "</br>";
				
						}
						*/
	 
	?>