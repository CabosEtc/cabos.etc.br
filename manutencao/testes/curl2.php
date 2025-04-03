<?php


$filename = "http://www.cabos.etc.br/manutencao/index.php";
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$filename);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1');

curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 500);

curl_setopt($ch, CURLOPT_HEADER, true);

curl_exec($ch);
curl_close($ch);

?>