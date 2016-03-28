<?php
session_start();
include_once "../php_files/guser.php";
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
		$insertguser = insertguser($data);
        $friendlist = getfriendlist($data->id);
    }
	else if(isset($data->id))
	{
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
	?>	
	
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css" />
<link href="default.css" rel="stylesheet" type="text/css" media="all" />
<!--[if IE 6]>
<link href="default_ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->
<link href="style4.css" rel="stylesheet" type="text/css" />
 <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
 <script type="text/javascript">
 var map;
var lat,lon;
function HomeControl(controlDiv, map) {

  // Set CSS styles for the DIV containing the control
  // Setting padding to 5 px will offset the control
  // from the edge of the map.
  controlDiv.style.padding = '5px';

  // Set CSS for the control border.
  var controlUI = document.createElement('div');
  controlUI.style.backgroundColor = 'white';
  controlUI.style.borderStyle = 'solid';
  controlUI.style.borderWidth = '2px';
  controlUI.style.cursor = 'pointer';
  controlUI.style.textAlign = 'center';
  controlUI.title = 'Click to set the map to Home';
  controlDiv.appendChild(controlUI);

  // Set CSS for the control interior.
  var controlText = document.createElement('div');
  controlText.style.fontFamily = 'Arial,sans-serif';
  controlText.style.fontSize = '12px';
  controlText.style.color = "black";
  controlText.style.paddingLeft = '4px';
  controlText.style.paddingRight = '4px';
  controlText.innerHTML = '<strong><font color = "black">Refresh</font></strong>';
  controlUI.appendChild(controlText);

  // Setup the click event listeners: simply set the map to Chicago.
  google.maps.event.addDomListener(controlUI, 'click', function() {
yourinit();  });
}
  function yourinit()
  {
  if (navigator.geolocation)
    {
 navigator.geolocation.getCurrentPosition(showPosition,showError);
    }
  else{x.innerHTML="Geolocation is not supported by this browser.";
		}
  }

   function showPosition(position)
  {
	   lat=position.coords.latitude;
   		lon=position.coords.longitude; 
   //x.innerHTML="hello"+p1+" "+p2;
		$.post("../javascript/location.php",{latitude:lat,longitude:lon},function(data){
			//alert(data);
	  });
  		map = new google.maps.Map(document.getElementById('googleMap'), {
		scrollwheel: false,
      zoom: 10,
      center: new google.maps.LatLng(lat,lon),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
	var homeControlDiv = document.createElement('div');
  var homeControl = new HomeControl(homeControlDiv, map);

  homeControlDiv.index = 1;
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(homeControlDiv);

	var marker,i;
    var infowindow = new google.maps.InfoWindow();
       marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat, lon),
        map: map,
		icon: 'http://maps.google.com/mapfiles/marker.png'
      });
      marker.setFlat(true);
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(<?php echo '"<h3>'.$data->displayName.'</h3>"'; ?>);
          infowindow.open(map, marker);
        }
      })(marker, i));
	  google.maps.event.addListener(marker, 'mouseover', function() {
		  this.setTitle(<?php echo '"'.$data->displayName.'"'; ?>);
	  });
	
	 <?php
			$i=0;
			$count = sizeof($latarr);
	
    for ($i = 0; $i < $count; $i++) { 
	$picturedata = get_picture($gid[$i]);
	$imageurl = $picturedata->image->url;
    ?> 
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(<?php echo $latarr[$i]; ?>, <?php echo $longarr[$i]; ?>),
        map: map,
		icon: 'http://maps.google.com/mapfiles/marker_green.png'
      });
		 marker.setFlat(true);
		 marker.html = "<div id = 'friendname'>"+<?php echo '"<h3>'.$gname[$i].'</h3></br>'.$status[$i].'"' ?>+"</div><div id = 'friendpic'><img src = '<?php echo $imageurl; ?>'/></div>";
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(this.html);
          infowindow.open(map, marker);
        }
      })(marker, i));
	   google.maps.event.addListener(marker, 'mouseover', function() {
		  this.setTitle(<?php echo '"'.$gname[$i].'"'; ?>);
	  });
   <?php } ?>
}
  
  function showError(error)
  {
  switch(error.code) 
    {
    case error.PERMISSION_DENIED:
      x.innerHTML="User denied the request for Geolocation."
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML="Location information is unavailable."
      break;
    case error.TIMEOUT:
      x.innerHTML="The request to get user location timed out."
      break;
    case error.UNKNOWN_ERROR:
      x.innerHTML="An unknown error occurred."
      break;
    }
  }   
  </script>
 <script type="text/javascript">
 		var count=0;
function getreview(reference){
//alert(reference);
$.post("../javascript/test.php",{ref:reference},function(data){
	document.getElementById("review").innerHTML = "<center><h4>REVIEW</h4></center>"+data; 
	 });}

function showgooglemap()
{
	showdiv("content");
	showdiv("sidebar");
	showdiv("restnotify");
	showdiv("googleMap");
	showdiv("review");
	hidediv("addfriend");
	hidediv("viewfriend");
	hidediv("youhavebeen");
	
}
function acceptfriend(id)
{
	//alert(id);
	$.post("../javascript/acceptfriend.php",{jsa:id},function(data){
	document.getElementById("sidebar").innerHTML += data;  });
	document.getElementById(id).style.visibility='hidden';
}
	function view()
{	
	$.post("../javascript/viewfriend.php",function(data){
	document.getElementById("viewfriend").innerHTML = data;
	});
	showdiv("viewfriend");
	showdiv("youhavebeen");
	hidediv("content");
	//hidediv("googleMap");
	hidediv("addfriend");
	hidediv("sidebar");
	hidediv("restnotify");
	hidediv("review");		
}
function addfriend()
{
	hidediv("viewfriend");
	hidediv("content");
	hidediv("sidebar");
	hidediv("restnotify");
	hidediv("review");
	//hidediv("googleMap");
	$.post("../javascript/addfriend.php",function(data)
	{
		document.getElementById("addfriend").innerHTML = data;
	});
	showdiv("addfriend");
	showdiv("youhavebeen");
}
function adddb(id)
{
	//alert(id);
	$.post("../javascript/adddb.php",{jsa:id},function(data){
		//alert(data);
		});
	//alert("hello");
	document.getElementById(id).style.display='none';
}

function showdiv(id)
{
	document.getElementById(id).style.display = 'block';
}
function hidediv(id)
{
	document.getElementById(id).style.display = 'none';			
			
}        
var bool=true;
var restomarker = new Array();
var cafemarker = new Array();

function restaurant(type)
{
	
	//alert(selflat);
	//alert(selflong);
	//alert(type);
	//alert(bool);
	
				
    if(bool)
	{
	$.post("../javascript/restaurant.php",{jsa:type,jsa1:lat,jsa2:lon	},function(data){
	var exploded=data.split('@');
	var explodeagain = new Array(new Array());
		var z,image;
		if(type == 'restaurant')
			image = "resto.png";
		else if(type == 'cafe')
			image = "cafe.png"
		else image = "bar.png";	
		for(z=0;z<exploded.length;z++)
		{	
			explodeagain[z] = exploded[z].split('^');
			var infowindow = new google.maps.InfoWindow({
            maxWidth: 300
        });
        var i;		
				restomarker[z] = new google.maps.Marker({
        position: new google.maps.LatLng(explodeagain[z][0] , explodeagain[z][1]),
        map: map,
        icon: new google.maps.MarkerImage(
		    image,
		    null, 
		    null,
		    null,
		    new google.maps.Size(30, 30))   });
		restomarker[z].html = "<div id='restname'><h4><b>"+explodeagain[z][2]+
        					"</b></h4>"+explodeagain[z][3]+
        					"<br/>RATING: "+explodeagain[z][5]+
							"</div><div id='friendpic'><img src='"+explodeagain[z][6]+"'/></div><div>"+
							"</br><button name='review' class='butt' value='"+explodeagain[z][7]+"' onclick='getreview(\""+explodeagain[z][7]+"\");'>REVIEW</button>"+
							"<button name='' class='butt' value='' onclick='viewrestfriend(\""+explodeagain[z][2]+"\");'>INVITE</button><button name='' class='butt' onclick='checkin(\""+explodeagain[z][0]+"\",\""+explodeagain[z][1]+"\",\""+explodeagain[z][2]+"\");'>CHECKIN</button></div>";
				
      		google.maps.event.addListener(restomarker[z], "click", function() {
          	infowindow.setContent(this.html);
          	infowindow.open(map, this);
          });
		}
	 });
	bool=false;
	}
	else
	{
	//alert(restomarker.length);
	//alert(cafemarker.length);
	for(var i=0; i < restomarker.length; i++){
		restomarker[i].setMap(null);
		}
	for(var i=0; i < cafemarker.length; i++){
		cafemarker[i].setMap(null);
		}
		cafemarker.length = 0;
		restomarker.length = 0;
	//alert("hi second time");
    //document.getElementById("googleMap").style.visibility = 'hidden';
	$.post("../javascript/restaurant2.php",{jsa:type},function(data){
	var exploded=data.split('@');
	var explodeagain = new Array(new Array());
	//alert(data);
		var z,image;
		if(type == 'restaurant')
			image = "resto.png";
		else if(type == 'cafe')
			image = "cafe.png"
		else image = "bar.png";
		for(z=0;z<exploded.length;z++)
		{	
			explodeagain[z] = exploded[z].split('^');
			var infowindow = new google.maps.InfoWindow({
            maxWidth: 300
        });
       var i;
				cafemarker[z] = new google.maps.Marker({
        position: new google.maps.LatLng(explodeagain[z][0] , explodeagain[z][1]),
        map: map,
        icon: new google.maps.MarkerImage(
		    image,
		    null, 
		    null,
		    null,
		    new google.maps.Size(30, 30)),
		 html: "<div id='restname'><h4><b>"+explodeagain[z][2]+
        					"</b></h4>"+explodeagain[z][3]+
        					"<br/>RATING: "+explodeagain[z][5]+
							"</div><div id='friendpic'><img src='"+explodeagain[z][6]+"'/></div>"+
							"<div></br><button name='review' class='butt' value='"+explodeagain[z][7]+"' onclick='getreview(\""+explodeagain[z][7]+"\");'>REVIEW</button>"+
							"<button name='' class='butt' value='' onclick='viewrestfriend(\""+explodeagain[z][2]+"\");'>INVITE</button><button name='' class='butt' onclick='checkin(\""+explodeagain[z][0]+"\",\""+explodeagain[z][1]+"\",\""+explodeagain[z][2]+"\");'>CHECKIN</button></div>"    });
			
				
      		google.maps.event.addListener(cafemarker[z], "click", function() {
          	infowindow.setContent(this.html);
          	infowindow.open(map, this);
      });
	
		}
	 });

		
	}
	//alert("over....");
}

 function viewrestfriend(reference)
{	
	$.post("../javascript/viewrestfriend.php",{ref:reference},function(data){
	document.getElementById("viewfriend").innerHTML = data;
	});
	showdiv("viewfriend")
	hidediv("content");
	hidediv("googleMap");
	hidediv("addfriend");
	hidediv("sidebar");
	hidediv("restnotify");
	hidediv("review");
	hidediv("youhavebeen");	
}

function addrestnotify(id,rest)
{
	//alert(id);
	//alert(rest)
	$.post("../javascript/addrestnotify.php",{jsa:id,ref:rest},function(data){
		//alert(data);
		});
	//alert("hello");
	document.getElementById(id).style.visibility='hidden';
}

function acceptinvi(id,restname)
{
	//alert(id);
	$.post("../javascript/acceptinvi.php",{jsa:id,jsa1:restname},function(data){
		hidediv(id);
	//document.getElementById("sidebar").innerHTML += data; 
	 });
}

function checkin(rest_lat,rest_long,rest_name)
{ 
	if(Math.abs(lat-rest_lat)>0.001 && Math.abs(lon-rest_long)>0.001)
	{alert("You are not Checked-In");
	count=0;
	}
	else
	{
		count=count+1;
		if(count==4)
		insertcheck(rest_name);
		else
	setTimeout(function() {checkin(rest_lat,rest_long,rest_name);}, 1*60*1000);

	}
	
   
} 

function insertcheck(reference)
{ 
	$.post("../javascript/checkin.php",{ref:reference},function(data){
	alert(data+reference);});
	count=0;
}
</script>

</head>

<body onLoad="yourinit();">
<div id="wrapper">
	<div id="header">
	<div id="logo">
			<h1><a href="#">HangoutStreet</a></h1>
            
		</div>

	<div id="menu">
     <div id="welcome" style="position:relative; float:right; color:#000">
         <center>Welcome </br>
		 <?php
        echo "<font size='-1'><b>".strtoupper($data->displayName)."</b></font>";
	?>
    </br>
        <img src =" <?php echo $data->image->url; ?>" /><br/>
        </center>
       
         </div>
    			<ul>
				<li><a href="#" accesskey="1" title="" onClick="showgooglemap()">Homepage</a></li>
				<li><a href="#" accesskey="2" title="" onClick="addfriend()">Addfriend</a></li>
				<li><a href="#" accesskey="3" title="" onClick="view()">ViewFriend</a></li>
				<li><a href="logout.php" accesskey="4" title="">logout</a></li>
				<li><a href="temp_traffic.php" accesskey="5" title="">Traffic</a></li>
			</ul>
        
		</div>
        		   </div>
	<div id="page">
	
		<div id="content">
		
	
			
<div id="googleMap" style="width:700px;height:380px;"></div>

			<p>
		</div>
		
		<div id="viewfriend"></div>
	<div id="addfriend"></div>
		<div id="sidebar">

				
             <div id="category"> 
              
					<button class="a-btn"    onClick="restaurant('restaurant')"><span class="a-btn-text">Restaurant</span> 
    <span class="a-btn-slide-text"><img src="resto.png" alt="Explore!" width="40"  /></span>
    <span class="a-btn-icon-right"><span></span></span></button><br>
                
				<button class="a-btn" title="" onClick="restaurant('cafe')"><span class="a-btn-text">Cafes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
    <span class="a-btn-slide-text"><img src="cafe.png" alt="Explore!" width="40"  /></span>
    <span class="a-btn-icon-right"><span></span></span></button><br>
                
				<button class="a-btn" title="" onClick="restaurant('bar')"><span class="a-btn-text">Bars&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
    <span class="a-btn-slide-text"><img src="bar.png" alt="Explore!" width="40"  /></span>
    <span class="a-btn-icon-right"><span></span></span></button><br>    
    	    
                </div>
                
			<div id="restnotify"><center><h4>NOTIFICATIONS</h4></center>
		<?php	getrestnotifications();
			echo "<br>";
			getrestsuggestions();
	//echo $data1->result[0]->geometry->location->lng."<br/>";
?></div>
<div id="review">

</div>
		</div>
        <div id="youhavebeen"><center><h4>NOTIFICATIONS</h4></center>
<?php		// GOOGLE PLACES API END
			getfriendnotifications();
			echo "<br>";?>
            </div>
        
	</div>
	
	<div id="footer">
		<p>Copyright (c) 2013 hangoutstreet.com. All rights reserved.</p>
	</div>
</div>
</body>
</html>
