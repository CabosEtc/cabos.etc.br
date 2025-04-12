<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<title>IPTV</title>


</head>


<body onload='timedCount()'>




<?
session_start();
//if (!isset($_SESSION["usuario"])){
//			echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
//	}

//Prepara conexao ao db
//include("conectadb.php");

// Ajusta hora do servidor
date_default_timezone_set('America/Sao_Paulo');





//$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
//$resultado = mysql_query($query,$conexao);
//$nomeloja=mysql_result($resultado,0,0);


$horahoje_eua=date("Y-m-d H:i:s",strtotime("now"));
$minutosatras=date("Y-m-d H:i:s",strtotime("now")-300);



echo "hora de hoje: $horahoje_eua<br>";
echo "5 minutos atras: $minutosatras";




?>

    
    
    
    





</body>
</html>
