<?php
session_start();
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
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false"></script>
</head>
<body>
<div id="wrapper">
	<div id="header">
	<div id="logo">
			<h1><a href="#">HangoutStreet</a></h1>
		</div>

	<div id="menu">
			
		</div>
	</div>
	<div id="page">
		<div id="content style="width:auto;">
		
<div id="googleMap" style="height:200px;">


<?php
//include_once "php_files/guser.php";

$client_secret="rfYdhTBNqVH2jeOvYauuV7H_";
$client_id="471696679867-dhcad4dvahabbr902jdibg3dcscfkj81.apps.googleusercontent.com";
$redirect_uri="http://localhost/Hangoutstreet/index1.php";
//$api_key='AIzaSyCO49t4xpkdJp-3nJxyZx2WSM4skEl6H94';

//req and recieves auth code 

if(isset($_REQUEST['code'])){
    $_SESSION['accessToken'] = get_oauth2_token($_REQUEST['code']);
    header("Location:dem.php");
    
}
else
{
	echo '<center><a href =  "https://accounts.google.com/o/oauth2/auth?state=profile&
scope=https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/latitude.current.best&
redirect_uri='.$redirect_uri.'&
response_type=code&access_type=offline&
client_id='.$client_id.'"><img src = "gsignin.png"/></a></center>';
} 


//returns session token for calls to API using oauth 2.0

function get_oauth2_token($code) {
    global $client_id;
    global $client_secret;
    global $redirect_uri;
    global $lat;
    global $long;
    global $access_token;
 
    $oauth2token_url = "https://accounts.google.com/o/oauth2/token";//Request for authorization code exchange URL
    $clienttoken_post = array(
    "code" => $code,
    "client_id" => $client_id,
    "client_secret" => $client_secret,
    "redirect_uri" => $redirect_uri,
    "grant_type" => "authorization_code"
    );
     
    $curl = curl_init($oauth2token_url);
 
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $clienttoken_post);
    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 
    $data = curl_exec($curl);
    //echo $data;
    curl_close($curl);
    $data = json_decode($data);
	//$access_token = $data->access_token;
	return $data;
	}
	
?>
</div>	
			<p>
		
			
		</div>
	</div>
	<div id="footer">
		<p>Copyright (c) 2013 hangoutstreet.com. All rights reserved.</p>
	</div>
</div>
</body>
</html>
