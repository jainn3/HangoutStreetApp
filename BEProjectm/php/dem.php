<?php
session_start();
$access_token = $_SESSION['accessToken']->access_token;
$refresh_token  = $_SESSION['accessToken']->refresh_token;
echo $refresh_token."</br>";
include_once "../php_files/guser.php";

//returns session token for calls to API using oauth 2.0


		//GOOGLE LATITUDE API LOCATION
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
	$selflat=$datal->data->latitude;
	 $selflong=$datal->data->longitude;
	//echo $datal->data->longitude."<br/>";
	//echo "lati n logi displyed";

//GOOGLE LATITUDE ENDS

//google plus info

	$url = "https://www.googleapis.com/plus/v1/people/me?access_token=".$access_token."&key=AIzaSyCO49t4xpkdJp-3nJxyZx2WSM4skEl6H94";
	//echo $url."</br>";
	$ch = curl_init();
	curl_setopt($ch , CURLOPT_URL , $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data2 = curl_exec($ch);
	//echo $data;
	curl_close($ch);
	//echo $data2;
	$datap = json_decode($data2);
	//echo $data->image->url;
	?>
	
	<img src =" <?php echo $datap->image->url; ?>" /><br/>
	
	<?php
	echo $datap->displayName;
	
	$insertguser = insertguser($datap);
	//echo $insertguser."<br/>";
	
	//echo "<h2>".$_SESSION['userid']."</h2><br>";
	$friendlist = getfriendlist($datap->id);
	//echo $friendlist;
	
	// END OF GOOGLE PLUS PROFILE
	$i=0;
	$latarr = array();
	$longarr = array();
	while($row = mysql_fetch_row($friendlist))
	{
		
		if($row[0]!=NULL)
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
		}
	}
	// ALL LATI AND PLUS INFO REMOVED
	?>	
	
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
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
 	function yourinit(){
 	//alert("hii");
    var lat = <?php echo $selflat; ?>;
	var lon = <?php echo $selflong; ?>;

  		 map = new google.maps.Map(document.getElementById('googleMap'), {
      zoom: 10,
      center: new google.maps.LatLng(lat,lon),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
	var marker,i;
    var infowindow = new google.maps.InfoWindow();
       marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat, lon),
        map: map
      });
      marker.setFlat(true);
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(""+lat+"");
          infowindow.open(map, marker);
        }
      })(marker, i));


	<?php
			$i=0;
			$count = sizeof($latarr);
			
		
    for ($i = 0; $i < $count; $i++) { 
    ?> 
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(<?php echo $latarr[$i]; ?>, <?php echo $longarr[$i]; ?>),
        map: map
      });
		 marker.setFlat(true);
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(<?php echo '"'.$latarr[$i].'"'; ?>);
          infowindow.open(map, marker);
        }
      })(marker, i));
   <?php } ?>
   }
  </script>
 <script type="text/javascript">
 function viewrestfriend(reference)
{	
	$.post("../javascript/viewrestfriend.php",{ref:reference},function(data){
	document.getElementById("viewfriend").innerHTML = data;
	});
	showdiv("viewfriend")
	hidediv("content");
	hidediv("googleMap");
	hidediv("addfriend");		
}

function addrestnotify(id,rest)
{
	alert(id);
	alert(rest)
	$.post("../javascript/addrestnotify.php",{jsa:id,ref:rest},function(data){
		alert(data);});
	alert("hello");
	document.getElementById(id).style.visibility='hidden';
}

function acceptinvi(id)
{
	alert(id);
	$.post("../javascript/acceptinvi.php",{jsa:id},function(data){
	document.getElementById("sidebar").innerHTML += data;  });
}
		
function getreview(reference){
//alert(reference);
$.post("../javascript/test.php",{ref:reference},function(data){
	document.getElementById("restreviews").innerHTML += data;  });}

function acceptfriend(id)
{
	alert(id);
	$.post("../javascript/acceptfriend.php",{jsa:id},function(data){
	document.getElementById("sidebar").innerHTML += data;  });
}
	function view()
{	
	$.post("../javascript/viewfriend.php",function(data){
	document.getElementById("viewfriend").innerHTML = data;
	});
	
	hidediv("content");
	hidediv("googleMap");
	hidediv("addfriend");
	hidediv("sidebar");
	//hidediv("category");
	showdiv("viewfriend");		
}
function addfriend()
{
	hidediv("viewfriend");
	hidediv("content");
	hidediv("googleMap");
	hidediv("sidebar");
	//hidediv("category");
	$.post("../javascript/addfriend.php",function(data)
	{
		document.getElementById("addfriend").innerHTML = data;
	});
	showdiv("addfriend");
}
function adddb(id)
{
	alert(id);
	$.post("../javascript/adddb.php",{jsa:id},function(data){
		alert(data);});
	alert("hello");
	document.getElementById(id).style.visibility='hidden';
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

function restaurant(selflat,selflong,type)
{
	
	//alert(selflat);
	//alert(selflong);
	//alert(type);
	//alert(bool);
	
				
    if(bool)
	{
	$.post("../javascript/restaurant.php",{jsa:type,jsa1:selflat,jsa2:selflong},function(data){
	var exploded=data.split('@');
	var explodeagain = new Array(new Array());
	//alert(data);
		var z;	
		for(z=0;z<exploded.length;z++)
		{	
			explodeagain[z] = exploded[z].split('^');
			var infowindow = new google.maps.InfoWindow({
            maxWidth: 200
        });
        var i;
				restomarker[z] = new google.maps.Marker({
        position: new google.maps.LatLng(explodeagain[z][0] , explodeagain[z][1]),
        map: map,
        icon: new google.maps.MarkerImage(
		    "resto.jpeg",
		    null, 
		    null,
		    null,
		    new google.maps.Size(25, 25))   });
		restomarker[z].html = "<div id='infowindow'><h4><b>"+explodeagain[z][2]+
        					"</b></h4>"+explodeagain[z][3]+
        					"<br/>RATING: "+explodeagain[z][5]+
							"<button name='review' class='butt' value='"+explodeagain[z][6]+"' onclick='getreview(\""+explodeagain[z][6]+"\");'>REVIEW</button>"+
							"<button name='' class='butt' value='' onclick='viewrestfriend(\""+explodeagain[z][2]+"\");'>Invite</button></div>";
				
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
	alert(restomarker.length);
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
		var z;	
		for(z=0;z<exploded.length;z++)
		{	
			explodeagain[z] = exploded[z].split('^');
			var infowindow = new google.maps.InfoWindow({
            maxWidth: 200
        });
        var i;
				cafemarker[z] = new google.maps.Marker({
        position: new google.maps.LatLng(explodeagain[z][0] , explodeagain[z][1]),
        map: map,
        icon: new google.maps.MarkerImage(
		    "resto.jpeg",
		    null, 
		    null,
		    null,
		    new google.maps.Size(25, 25)),
		 html: "<div id='infowindow'><h4><b>"+explodeagain[z][2]+
        					"</b></h4>"+explodeagain[z][3]+
        					"<br/>RATING: "+explodeagain[z][5]+
							"<button name='review' class='butt' value='"+explodeagain[z][6]+"' onclick='getreview(\""+explodeagain[z][6]+"\");'>REVIEW</button>"+
							"<button name='' class='butt' value='' onclick='viewrestfriend(\""+explodeagain[z][2]+"\");'>Invite</button></div>"    });
			
				
      		google.maps.event.addListener(cafemarker[z], "click", function() {
          	infowindow.setContent(this.html);
          	infowindow.open(map, this);
      });
	
		}
	 });

		
	}
	//alert("over....");
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
    
			<ul>
				<li><a href="#" accesskey="1" title="">Homepage</a></li><br>
				<li><a href="#" accesskey="2" title="" onClick="addfriend()">Addfriend</a></li><br>
				<li><a href="#" accesskey="3" title="" onClick="view()">ViewFriend</a></li><br>
				<li><a href="logout.php" accesskey="4" title="">logout</a></li><br>
				<li><a href="#" accesskey="5" title="">Contact Us</a></li><br>
			</ul>
		</div>
		   </div>
	<div id="page">
    

	<div id="viewfriend"></div>
	<div id="addfriend"></div>
		<div id="content">
		
	
			<h3>google map</h3>
<div id="googleMap" style="width:400px;height:300px;"></div>

			<p>
		</div>
        		
		<div id="sidebar">

				<h3>restaurants reviews</h3>
          <!--   <div id="category">  -->
					<button class="a-btn"    onClick="restaurant('<?php echo $selflat ; ?>','<?php echo $selflong ; ?>','restaurant')"><span class="a-btn-text">Restaurant</span> 
    <span class="a-btn-slide-text"><img src="resto.jpeg" alt="Explore!" width="40"  /></span>
    <span class="a-btn-icon-right"><span></span></span></button><br>
                
				<button class="a-btn" title="" onClick="restaurant('<?php echo $selflat ; ?>','<?php echo $selflong ; ?>','cafe')"><span class="a-btn-text">Cafes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
    <span class="a-btn-slide-text"><img src="resto.jpeg" alt="Explore!" width="40"  /></span>
    <span class="a-btn-icon-right"><span></span></span></button><br>
                
				<button class="a-btn" title="" onClick="restaurant('<?php echo $selflat ; ?>','<?php echo $selflong ; ?>','bar')"><span class="a-btn-text">Bars&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
    <span class="a-btn-slide-text"><img src="resto.jpeg" alt="Explore!" width="40"  /></span>
    <span class="a-btn-icon-right"><span></span></span></button>
                </div>
                <div id="youhavebeen">
<?php		// GOOGLE PLACES API END
			//getfriendnotifications();
			getrestnotifications();	//echo $data1->result[0]->geometry->location->lng."<br/>";
?></div>
<div id="restreviews">
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
