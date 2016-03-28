<?php 
session_start();

include_once "../php_files/guser.php";
/*
$access_token = $_SESSION['accessToken']->access_token;

	
	//echo $refresh_token;
	$url = "https://www.googleapis.com/plus/v1/people/me?access_token=".$access_token."&key=AIzaSyCO49t4xpkdJp-3nJxyZx2WSM4skEl6H94";
	//echo $url;
	$ch = curl_init();
	curl_setopt($ch , CURLOPT_URL , $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($data);
	if(isset($_SESSION['accessToken']->refresh_token)&&isset($data->id))
	{
		$refresh_token  = $_SESSION['accessToken']->refresh_token;
		checkrefreshtoken($_SESSION['accessToken'],$data);
		?>
	
        <img src =" <?php echo $data->image->url; ?>" /><br/>
        
        <?php 
        //echo $data->displayName;
        
        $insertguser = insertguser($data);
        //echo $insertguser."<br/>";
        
        //echo "<h2>".$_SESSION['userid']."</h2><br>";
        $friendlist = getfriendlist($data->id);
            
	}
	else if(isset($data->id))
	{
		?>
	
        <img src =" <?php  echo $data->image->url; ?>" /><br/>
        
        <?php 
        //echo $data->displayName;
        
        $insertguser = insertguser($data);
        //echo $insertguser."<br/>";
        
        //echo "<h2>".$_SESSION['userid']."</h2><br>";
        $friendlist = getfriendlist($data->id);
	}
	else
	{
		header("Location:gplus.php");		
		echo "NOT A GPLUS USER";
	}

	//echo $data->image->url;
	
	//echo $friendlist;
	//PROFILE INFO	
	// END OF GOOGLE PLUS PROFILE
	$i=0;
	$latarr = array();
	$longarr = array();
	$gname = array();
	$status = array();
	$gid = array();
	while($row = mysql_fetch_row($friendlist))
	{
		
		/*if($row[0]!=NULL)
		{
			$access_token = genaccess_token($row[0]);
		    echo $access_token;
		    $url = "https://www.googleapis.com/latitude/v1/currentLocation?granularity=best&access_token=".$access_token."&key=AIzaSyCO49t4xpkdJp-3nJxyZx2WSM4skEl6H94";
			//echo $url."</br>";
			$ch = curl_init();
			curl_setopt($ch , CURLOPT_URL , $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$data1 = curl_exec($ch);
			//echo $data;
			curl_close($ch);
			//echo $data1;
			$datal = json_decode($data1);
			//echo $datal->data->latitude."<br/>";
			$lat=$datal->data->latitude;
			$long=$datal->data->longitude;
			$latarr[$i] = $lat;
			$longarr[$i] = $long;
			echo $latarr[$i]."<br>".$i."<br>";
			$i++;
						
			//
		}*/
		/*
		if($row[0]!=NULL)
		{
			$latarr[$i] = $row[2];
			$longarr[$i] = $row[3];
			$gname[$i] = $row[6];
			if($row[4]==0)
			$status[$i] = "offline";
			else
			$status[$i] = "online";
			$gid[$i] = $row[5];
			//echo $latarr[$i]."<br>".$i."<br>";
			$i++;
		}
	}
    */
	?>
	
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
              #map_canvas { height: 100% }
            </style>
<title></title>
<link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css" />
<link href="default1.css" rel="stylesheet" type="text/css" media="all" />
<!--[if IE 6]>
<link href="default_ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->
<link href="style4.css" rel="stylesheet" type="text/css" />
 <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script> <script type="text/javascript">
 var map;
var lat,lon;
  function yourinit()
  {
	 drawMap("51.3879120942,-0.15028294518"); 
  }
var coords = [];
var geocoder;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;
function initialize() {
  directionsDisplay = new google.maps.DirectionsRenderer();
  //var chicago = new google.maps.LatLng(41.850033, -87.6500523);
  var mapOptions = {
    zoom:7,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    //center: chicago
  }
  map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
  directionsDisplay.setMap(map);
}
function someFunction(addresses, callback) 
{
	//alert("hiii" + addresses.length);
for(var i = 0; i < addresses.length; i++) 
	{
			//alert(i);
        currAddress = addresses[i];
       // var geocoder = new google.maps.Geocoder();
        //if (geocoder) 
			//{						alert("ok1");
				geocoder = new google.maps.Geocoder();
				
				geocoder.geocode({'address':currAddress}, function (results, status) 
					{
						//alert("ok");
						//alert(currAddress);
						if (status == google.maps.GeocoderStatus.OK)
							 {
								 //alert("statis");
								 //alert(results[0].geometry.location.lat());
								coords.push(results[0].geometry.location);
									if(coords.length == addresses.length) 
										{
											//alert(coords.length);
											if( typeof callback == 'function' )
											   {
													callback();
												}
										}
							} 
               		 else 
					 {
						 alert("no" + status);
                    throw('No results found: ' + status);
               		 }
            });
        //}
     }//end of for loop
}
//
/*

function codeAddress() {
  var address = document.getElementById('start_address').value;
    geocoder = new google.maps.Geocoder();

  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
     // map.setCenter(results[0].geometry.location);
     // var marker = new google.maps.Marker({
        //  map: map,
         // position: results[0].geometry.location
      //});
	  coords[0]= results[0].geometry.location;
	  //alert("hi" + "   " + coords[0].lat());
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}*/
var exploded;
var explodeagain = new Array(new Array());
var bool1 = false;
var start1;
var end1;
function onSubmit()
{
//Usage
document.getElementById("input").style.display = 'none';
var addresses = new Array();
addresses[0]= document.getElementById("start_address").value;
addresses[1]= document.getElementById("end_address").value;
//alert(addresses[0]);
//alert(addresses[1]);
someFunction(addresses, function() {
	/*
	alert(coords[0].lat());
		alert(coords[0].lng());
	alert(coords[1].lat());

	alert(coords[1].lng());*/

    // Do something after getting done with Geocoding of multiple addresses
	$.post("../javascript/add3.php",{jsa:coords[0].lat(),jsa1:coords[0].lng(),jsa2:coords[1].lat(),jsa3:coords[1].lng()},function(data){
		//alert(data);
		if(data=='false')
		{
					
					//alert("false");
					initialize();
					var start = document.getElementById("start_address").value;
					var end = document.getElementById("end_address").value;
					var request = {
											origin:start,
											destination:end,
											provideRouteAlternatives: true,
											travelMode: google.maps.TravelMode.DRIVING
								 };
			  directionsService.route(request, function(result, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					var rendererOptions = getRendererOptions(true);
				for (var i = 0; i < result.routes.length; i++)
				{
						renderDirections(result, rendererOptions, i);
				}

				  //directionsDisplay.setDirections(result);
				}
			  });
					
					
								
		}
		else
		{
			//document.getElementById("category").innerHTML+=data;
			bool1 = true;
			alert("true");
			//var exploded=data.split('@');			
			exploded=data.split('@');
			//var explodeagain = new Array(new Array());
			var z;	
			for(z=0;z<exploded.length;z++)
			{	
				explodeagain[z] = exploded[z].split('^');
									
			}
			//alert("exploded.length" + exploded.length +"and " + explodeagain[0].length);
			initialize();
					 var start = new google.maps.LatLng(explodeagain[0][2],explodeagain[0][3]);
 					 var end = new google.maps.LatLng(explodeagain[0][4],explodeagain[0][5]);		
					 start1=start;
					 end1=end;		 
					var request = {
											origin:start,
											destination:end,
											provideRouteAlternatives: true,
											travelMode: google.maps.TravelMode.DRIVING
								 };
			  directionsService.route(request, function(result, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					var rendererOptions = getRendererOptions(true);
					//alert(explodeagain[0][2]+"q  "+explodeagain[0][3]+"q  "+explodeagain[0][4]+"q  "+explodeagain[0][5]);
				//for (var i = 0; i < exploded.length-1; i++)
				for (var i = 0; i < 1; i++)
				{						
				 renderDirections(result, rendererOptions, i);					
				  googletype();
				}
			
				  //directionsDisplay.setDirections(result);				  
				}
			  });
			 //googletype();

			
			
		}
			
});
});
}
var exploded1;
var explodeagain1 = new Array(new Array());
var t = 0;
var cc = 0 ;

function googletype()
{
$.post("../javascript/add5.php",{},function(data)
{
	alert(data);

	exploded1=data.split('@');
			var z;	
			for(z=0;z<exploded1.length;z++)
			{	
				explodeagain1[z] = exploded1[z].split('^');									
			}
				/*var l = exploded1.length;
				exploded1[z]=new Array();
				//exploded1[z+1]=new Array();
				explodeagain1[z-1][0]=-1;
				explodeagain1[z-1][1]=explodeagain[0][2];
				explodeagain1[z-1][2]=explodeagain[0][3];
				explodeagain1[z-1][3]=explodeagain1[1][2];
				explodeagain1[z-1][4]=explodeagain1[1][3];
				
				explodeagain1[z][0]=-1;
				explodeagain1[z][1]=explodeagain1[z-2][2];
				explodeagain1[z][2]=explodeagain1[z-2][3];
				explodeagain1[z][3]=explodeagain[0][3];
				explodeagain1[z][4]=explodeagain[0][4];
				
*/
				
			alert("exploded.length" + exploded1.length +"and " + explodeagain1[0].length);
			
			var i;
			var b = true;
			for (i = 0; i < exploded1.length; i++)
			{
				/*if(i==-2)
				{
				var start = start1;
				var end = new google.maps.LatLng(explodeagain1[0][1],explodeagain1[0][2]);
				t = -1;
				}
				else if (i==-1)
				{
					var ind = exploded1.length-2;
					var start = end1; //new google.maps.LatLng(explodeagain1[ind][1],explodeagain1[ind][2]);
					var end = end1;
					t = -1;
				}
				else
				{*/
				t = explodeagain1[i][0];
			 var start = new google.maps.LatLng(explodeagain1[i][1],explodeagain1[i][2]);
 			 var end = new google.maps.LatLng(explodeagain1[i][3],explodeagain1[i][4]);
				
			 var request = {
							origin:start,
							destination:end,
							provideRouteAlternatives: true,
							travelMode: google.maps.TravelMode.DRIVING
							};
							
	 directionsService.route(request, function(result, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					var rendererOptions = getRendererOptions(true);	
					//var t = explodeagain[i][0];
					//alert("t is" + explodeagain1[i][0]);	
						 renderDirections1(result, rendererOptions, t);
						 
						
				  //directionsDisplay.setDirections(result);				  
				}
			  });
			}
	
});	//end of post query
}
var a = 0;
function renderDirections1(result, rendererOptions, routeToDisplay)
{
	try
	{
	routeToDisplay = explodeagain1[a++][0];
	}
	catch(exception)
	{
		routeToDisplay = -1;
	}
alert(routeToDisplay);
	if(routeToDisplay==3)
	{
		var _colour = '#00458E';
		var _strokeWeight = 4;
		var _strokeOpacity = 1.0;
		var _suppressMarkers = false;
	}
	else if(routeToDisplay==1)
	{
		var _colour = '#8B0000';
		var _strokeWeight = 4;//#F0F8FF   #8A2BE2//high
		var _strokeOpacity = 0.7;
		var _suppressMarkers = false;
		
	}
	else if(routeToDisplay==2)
	{
		var _colour = '#000000';//slow black
		var _strokeWeight = 4;//#F0F8FF   #8A2BE2
		var _strokeOpacity = 0.7;
		var _suppressMarkers = false;
		
	}
	else 
	{
		var _colour = '#F8F8FF';  
		var _strokeWeight = 4;//#F0F8FF   #8A2BE2
		var _strokeOpacity = 0.7;
		var _suppressMarkers = false;
	}
			var directionsRenderer = new google.maps.DirectionsRenderer({
			draggable: false, 
			suppressMarkers: _suppressMarkers, 
			polylineOptions: { 
				strokeColor: _colour, 
				strokeWeight: _strokeWeight, 
				strokeOpacity: _strokeOpacity  
				}
			});
		directionsRenderer.setMap(map);
        directionsRenderer.setPanel(document.getElementById('directions_panel'));
		directionsRenderer.setDirections(result);
		directionsRenderer.setRouteIndex(0);		
}
function renderDirections(result, rendererOptions, routeToDisplay)
{
	alert("ii"+ routeToDisplay);

	if(routeToDisplay==0)
	{
		//var _colour = '#00458E';
		var _colour = '#F8F8FF';
		var _strokeWeight = 4;
		var _strokeOpacity = 1.0;
		var _suppressMarkers = false;
	}
	else if(routeToDisplay==1)
	{
		var _colour = '#ED1C24';
		var _strokeWeight = 4;//#F0F8FF   #8A2BE2
		var _strokeOpacity = 0.7;
		var _suppressMarkers = false;
		
	}
	else if(routeToDisplay==2)
	{
		var _colour = '#8A2BE2';
		var _strokeWeight = 4;//#F0F8FF   #8A2BE2
		var _strokeOpacity = 0.7;
		var _suppressMarkers = false;
		
	}
	else 
	{
		var _colour = '#000000 ';
		var _strokeWeight = 4;//#F0F8FF   #8A2BE2
		var _strokeOpacity = 0.7;
		var _suppressMarkers = false;
	}
	


		// create new renderer object
		var directionsRenderer = new google.maps.DirectionsRenderer({
			draggable: false, 
			suppressMarkers: _suppressMarkers, 
			polylineOptions: { 
				//strokeColor: _colour, 
				//strokeWeight: _strokeWeight, 
				//strokeOpacity: _strokeOpacity  
				}
			});
		//directionsRenderer.setMap(map);
        directionsRenderer.setPanel(document.getElementById('directions_panel'));
		directionsRenderer.setDirections(result);
		directionsRenderer.setRouteIndex(routeToDisplay);
		var s = document.getElementById("category");
		//alert("routeToDisplay" + routeToDisplay);
		  var myRoute = result.routes[routeToDisplay].legs[0];
		  
		  if(!bool1)
		  {
		 s.innerHTML+= "Duration " + "   " + myRoute.duration.text + "</br>"+"</br>";
		 s.innerHTML+= "Distance is  " + "   " + myRoute.distance.text + "</br>"+"</br>";

		  }
		  else
		  {
			  //bool1 = false;
			  var temp = explodeagain[routeToDisplay][1];
			  var hours = Math.floor(explodeagain[routeToDisplay][1]/3600);
			  temp = temp-hours*3600;
			  var minutes = Math.floor(temp/60);
			  var sec = Math.floor(temp-minutes*60); 
			  s.innerHTML+= "Duration: " + "   " + hours + " Hours  "  + minutes + " minutes " + sec + " seconds</br>"+"</br>";
		 	  s.innerHTML+= "Distance is  " + "   " + myRoute.distance.text + "</br>"+"</br>";
			
			  
			}
  
				for (var i = 0; i < myRoute.steps.length; i++)	
				{	
				s.innerHTML+= i+1 + "   " + myRoute.steps[i].instructions + "</br>"+"</br>";
				}

				
}


function getRendererOptions(main_route)
{
	if(main_route)
	{
//		var _colour = '#00458E';
var _colour = '#F8F8FF';

		var _strokeWeight = 4;
		var _strokeOpacity = 1.0;
		var _suppressMarkers = false;
	}
	else
	{
		var _colour = '#ED1C24';
		var _strokeWeight = 2;
		var _strokeOpacity = 0.7;
		var _suppressMarkers = false;
	}

	var polylineOptions ={ strokeColor: _colour, strokeWeight: _strokeWeight, strokeOpacity: _strokeOpacity  };

  var rendererOptions = {draggable: false, suppressMarkers: _suppressMarkers, polylineOptions: polylineOptions};

	return rendererOptions;
}


function drawMap(midpoint) {
	var mid = midpoint.split(",");
	var start = new google.maps.LatLng(mid[0], mid[1]);
	var myOptions = {
		zoom:7,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		center: start,
   	mapTypeControl: false
	}
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
}
//drawMap("51.3879120942,-0.15028294518");
</script>

</head>

<body onLoad="yourinit();">
<div id="wrapper">
	<div id="header">
	<div id="logo">
			<h1><a href="#">HangoutStreet</a></h1>
            
		</div>

	<div id="menu">
    
			<ul>
				<li><a href="dem.php" accesskey="1" title="" onClick="">Homepage</a></li>
				<li><a href="temp_traffic.php" accesskey="2" title="" onClick="">Traffic</a></li>
			
				<li><a href="logout.php" accesskey="4" title="">logout</a></li>
				
			</ul>
		</div>
		   </div>
	<div id="page">
	
		<div id="content">
		
	
<div id="map_canvas" style="width:700px;height:380px;">
  
</div>

			<p>
		</div>
		
		<div id="viewfriend"></div>
	<div id="addfriend"></div>
		<div id="sidebar">

				<h2>traffic</h2>
	<div id="category" style = "overflow-y: scroll;"> 
	  <p>
     <img src="black.jpg" alt="some_text" width="18" height="21"> more traffic  </br>
         <img src="red.png" alt="some_text" width="18" height="21"> less traffic   </br>
        <img src="blue.png" alt="some_text" width="18" height="21"> no changes in traffic  </br>
        
      
<div id="input"> 
            origin :
	        <input id="start_address" type="text"  name="start"/>
          </p>
	  <p>destination  :
	    <input id="end_address" type="text"  name="end"/>
	    </p>
<button onClick="onSubmit()">Submit </button>
</div>

    </div>   
          </div>
                
			<div id="restnotify">
		<?php	//getrestnotifications();
			echo "<br>";
			//getrestsuggestions();
	//echo $data1->result[0]->geometry->location->lng."<br/>";
?></div>
<div id="review">
</div>
		</div>
        <div id="youhavebeen">
<?php		// GOOGLE PLACES API END
			//getfriendnotifications();
			echo "<br>";?>
            </div>
        
	</div>
	<div id="three-column">
		<div id="tbox1">
					</div>
		<div id="tbox2">
					</div>
		<div id="tbox3">
					</div>
	</div>
	<div id="footer">
		<p>Copyright (c) 2013 hangoutstreet.com. All rights reserved.<a href="http://www.nirmaanthefest.com/demo1.php">click here for trial</a></p>
	</div>
</div>
</body>
</html>
