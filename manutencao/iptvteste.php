<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title>Teste IPTV</title>





</head>

<!-- Este comentario desabilita o contator provisoriamente (por causa da rotina cron no servidor, em advanced, cron server)
<body onload='timedCount()'>
-->

<body>


<?

/*

$dthoje_eua=date("Y-m-d",strtotime("now"));
$hora=date("h:i:s",strtotime("now"));



$cdproduto=$_REQUEST["cdproduto"];

function Verificar( $url ) {
$curl = curl_init();
curl_setopt( $curl , CURLOPT_CUSTOMREQUEST, 'HEAD' );
curl_setopt( $curl , CURLOPT_URL , $url );
curl_setopt( $curl , CURLOPT_FOLLOWLOCATION , true );
curl_setopt( $curl , CURLOPT_RETURNTRANSFER , true );
curl_exec( $curl );
$httpCode = curl_getinfo( $curl , CURLINFO_HTTP_CODE );
curl_close( $curl );
return $httpCode >= 200 && $httpCode < 400;
}

$link="http://infinity.quor8.com:8000/live/Naynan/x4sgHnxf5d/8667.ts";

if(Verificar($link)=="1") {
echo "O arquivo existe";	
} else {
echo "O arquivo não existe";
}
*/
// permite que pagina externas sejam lidas
// permite que pagina externas sejam lidas
ini_set('allow_url_fopen', 1);
//$url="http://infinity.quor8.com:8000/live/Coqueiros/KcoxxdELul/12664.ts";
$url="http://infinity.quor8.com:8000/live/Zezinho/cXSzs7eZcl/9456.ts";

// lê o conteúdo do arquivo para uma string

/*
$ch = curl_init();
$timeout = 20;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$conteudo = curl_exec ($ch);

$info = curl_getinfo($ch);

curl_close($ch);
*/


function url_exists($url) { 
    $hdrs = @get_headers($url); 
    return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false; 
} 
    
	
	?>








</body>
</html>
