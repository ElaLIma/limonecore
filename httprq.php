
<?php

function httpRQ($URL){

//Http request headers
$userAgent = "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:55.0) Gecko/20100101 Firefox/55.0";
$accept = "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
$acceptLanguage	= "en-US,en;q=0.5";
$acceptEncoding	= "gzip,defalte";
$cookie = "_ga=GA1.2.213956746.1491166474; lang=es; lang=es; _gid=GA1.2.991961595.1504104476; PHPSESSID=b96237e2ebcf7dd687866ff36aa88b85; cookieCensoElectoral2017=1; pub=11";
$connection = "keep-alive";
$upgradeInsecureRequests = "1";
$cacheControl = "max-age=0";
  
$curl = curl_init($URL);

curl_setopt_array($curl, array(
  CURLOPT_URL => $URL,
  CURLOPT_USERAGENT => $userAgent,
  CURLOPT_RETURNTRANSFER => TRUE,
  CURLOPT_FOLLOWLOCATION => TRUE,
  CURLOPT_COOKIE => $cookie,
  CURLOPT_ACCEPT_ENCODING => $acceptEncoding,
));

$headers = [
  'Accept: '. $accept,
  'Accept-Language: ' . $acceptLanguage,
  'Cache-Control: '. $cacheControl,
  'Upgrade-Insecure-Requests: ' . $upgradeInsecureRequests,
  'Connection: ' . $connection,
];

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$content = curl_exec($curl);
curl_close($curl);
return $content;

}

