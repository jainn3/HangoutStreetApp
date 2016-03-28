<!DOCTYPE html>
<html>
<head>
<script
src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false">
</script>
<?php
//$url='https://www.googleapis.com/latitude/v1/currentLocation?granularity=best&key={AIzaSyCO49t4xpkdJp-3nJxyZx2WSM4skEl6H94}';
$url = 'http://maps.google.com/maps/geo?q=andheri,mumbai&output=csv&sensor=false';
$url1 = 'http://maps.google.com/maps/geo?q=Bandra,mumbai&output=csv&sensor=false';

$data = @file_get_contents($url);
$data1 = @file_get_contents($url1);

$result = explode(",", $data);
$result1 = explode(",", $data1);
 
?>
<script>
var lat = <?php echo $result[2]; ?>;
var lon = <?php echo $result[3]; ?>;
var myCenter=new google.maps.LatLng(lat,lon);
var myCenter1=new google.maps.LatLng(<?php echo $result1[2]; ?>,<?php echo $result1[3]; ?>);


function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:11,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };
var mapProp1 = {
  center:myCenter1,
  zoom:16,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
//var map1=new google.maps.Map(document.getElementById("googleMap"),mapProp1);


var marker=new google.maps.Marker({
  position:myCenter,
  });
var marker1=new google.maps.Marker({
  position:myCenter1,
  });
var trafficLayer = new google.maps.TrafficLayer({position:myCenter});
trafficLayer.setMap(map);
marker.setMap(map);
marker1.setMap(map)
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>
<body>
<div id="googleMap" style="width:500px;height:380px;"></div>
</body>
</html>
<strong></strong>