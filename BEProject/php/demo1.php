<?php
$client_secret="CE21ab-yxkoG3Wv7QjCerW4S";
$client_id="471696679867-dhcad4dvahabbr902jdibg3dcscfkj81.apps.googleusercontent.com";
$redirect_uri="http://www.nirmaanthefest.com/demo1.php";
//$api_key='AIzaSyCO49t4xpkdJp-3nJxyZx2WSM4skEl6H94';


if(isset($_REQUEST['code'])){
    $_SESSION['accessToken'] = get_oauth2_token($_REQUEST['code']);
    
}
else
{
	echo '<a href =  "https://accounts.google.com/o/oauth2/auth?state=profile&
scope=https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/latitude.current.best&
redirect_uri=http://www.nirmaanthefest.com/demo1.php&
response_type=code&
client_id='.$client_id.'&approval_prompt=force">HELLO</a>';
} 
//returns session token for calls to API using oauth 2.0
function get_oauth2_token($code) {
    global $client_id;
    global $client_secret;
    global $redirect_uri;
     
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
	$access_token = $data->access_token;
		//google latitude api location
	$url = "https://www.googleapis.com/latitude/v1/currentLocation?granularity=best&access_token=".$access_token."&key=AIzaSyCO49t4xpkdJp-3nJxyZx2WSM4skEl6H94";
	//echo $url."</br>";
	$ch = curl_init();
	curl_setopt($ch , CURLOPT_URL , $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	//echo $data;
	curl_close($ch);
	$data = json_decode($data);
	echo $data->data->latitude."<br/>";
	echo $data->data->longitude."<br/>";
	
	//end of latitude
	
	//PROFILE INFO
	$url = "https://www.googleapis.com/plus/v1/people/me?access_token=".$access_token."&key=AIzaSyCO49t4xpkdJp-3nJxyZx2WSM4skEl6H94";
	//echo $url."</br>";
	$ch = curl_init();
	curl_setopt($ch , CURLOPT_URL , $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	//echo $data;
	curl_close($ch);
	echo $data;
	$data = json_decode($data);
	//echo $data->image->url;
	?>
	
	<img src =" <?php echo $data->image->url; ?>"/></br>
	<?php echo $data->displayName;

	//echo $data->data->latitude;
	//end
	//echo $data->image->url;
	}
?>