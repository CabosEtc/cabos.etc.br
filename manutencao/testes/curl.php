<?php
$ch = curl_init("http://infinity.quor8.com:8000/live/Naynan/x4sgHnxf5d/");
curl_setopt($ch,CURLOPT_TIMEOUT,10);
$ret = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

var_dump($ret, $err);
?>