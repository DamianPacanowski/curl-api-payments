<?php
$ch = curl_init();
$clientId = '300746';
$secret = '2ee86a66e5d97e3fadc400c9f19b065d';
curl_setopt($ch, CURLOPT_URL, 'https://secure.payu.com/pl/standard/user/oauth/authorize');
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $clientId . ':' . $secret);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
$result = curl_exec($ch);
if(empty($result)) 
{
    die('Error: No response.');
} 
else 
{
    $json=json_decode($result);
    var_dump($json);
    var_dump($json->access_token);
}
curl_close($ch);
?>
