<!DOCTYPE html>
<html>

<body>
<p id="demo">Click the button to get your coordinates:</p>

<button onclick="getLocation()">Try It</button>
<?php

?>
<script>
var x=document.getElementById("demo");
var i=0;
function getLocation()
  {
  if (navigator.geolocation)
    {
	
 navigator.geolocation.getCurrentPosition(showPosition,showError,{enableHighAccuracy: true,});

   
    }
  else{x.innerHTML="Geolocation is not supported by this browser.";}
  }
function showPosition(position)
  {
	  i++;
  x.innerHTML+="Latitude: " + position.coords.latitude + 
  "<br>Longitude: " + position.coords.longitude+"<br>Accuracy: " + position.coords.accuracy+"<br>Speed " + position.coords.speed;
  if(i==5)
  redundant();
  else
  navigator.geolocation.getCurrentPosition(showPosition,showError);
	
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
  function redundant()
  {
	  alert("done");
  }
</script>
</body>
</html>

