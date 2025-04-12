<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title></title>
</head>
<body>
<!--
$config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';

curl_setopt($curl, CURLOPT_USERAGENT, $config['useragent']);
curl_setopt($curl, CURLOPT_REFERER, 'https://www.domain.com/');

NO PHP 

$ip = $_SERVER["REMOTE_ADDR"];
$navegador=$_SERVER['HTTP_USER_AGENT'];
-->

<script>
var array = [{
    "NAME": "Mark",
    "ID": "159753",
},
{
    "NAME": "Steve",
    "ID": "088421",
}];

var contador = 20;
for(var i=0;i<array.length;i++){
    alert(array[i].NAME);
}

console.log(contador);
</script>
</body>
</html>