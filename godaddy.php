#!/usr/bin/php -d open_basedir=/usr/syno/bin/ddns
<?php

if ($argc !== 5) {
    echo 'badparam';
    exit();
}

// account field is for the Domain Name
$account = (string)$argv[1];
// password format is GoDaddy api_key:key_secret
$pwd = (string)$argv[2];
// This field is for the record
$hostname = (string)$argv[3];
$ip = (string)$argv[4];

// only for IPv4 format
if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
    echo "badparam";
    exit();
}

$url = 'https://api.godaddy.com/v1/domains/'.$account.'/records/A/'.$hostname;

$req = curl_init();
curl_setopt($req, CURLOPT_URL, $url);
curl_setopt($req, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($req, CURLOPT_HTTPHEADER, array("Authorization: sso-key $pwd", "Content-Type: application/json"));
curl_setopt($req, CURLOPT_POSTFIELDS, json_encode(array(array("data" => $ip))));
curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($req);
curl_close($req);

$httpCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
// Check the response status code
if ($httpCode == 200) {  // Assuming 200 means success
    // If API response is successful but body is empty, create the expected response
    echo "good $ip";
} else {
    // If the API call failed or returned a different status code, handle accordingly
    echo "error";  // You can also log or display the actual HTTP code or message
}


