<?php
function getconnection()
{
	 	$con = mysql_connect("localhost","root","");
		if (!$con)
 		{
 			die('Could not connect: ' . mysql_error());
  		}
		mysql_select_db("hangoutbe", $con);
		return $con;
}

function genaccess_token($refresh_token)
{
	$oauth2token_url = "https://accounts.google.com/o/oauth2/token";//Request for authorization code exchange URL
		    $clienttoken_post = array(
		 	"client_id" => "471696679867-dhcad4dvahabbr902jdibg3dcscfkj81.apps.googleusercontent.com",
		    "client_secret" => "CE21ab-yxkoG3Wv7QjCerW4S",
		    "refresh_token" => $refresh_token,
		    "grant_type" => "refresh_token"
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
		    $access_token = $data->access_token;
		    return $access_token;
}
?>