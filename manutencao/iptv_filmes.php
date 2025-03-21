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
include("../conectadb.php");

// Ajusta hora do servidor
date_default_timezone_set('America/Sao_Paulo');

include("../manutencao/menu.php");



echo "<table width='960' border='0' align='center'>";
echo "<tr><td>Filmes -------------------</td></tr>";
echo "<tr><td>&nbsp</td></tr>";
$query_filmes="SELECT titulo, categoria, url, logo FROM iptv_filmes  WHERE categoria<'99' ORDER BY titulo";
$resultado_filmes = mysql_query($query_filmes,$conexao);
  while ($row = mysql_fetch_array($resultado_filmes, MYSQL_NUM)) {
    $titulo=$row[0];
    $categoria=$row[1];
    $url=$row[2];
    $logo=$row[3];
    echo "<tr><td>".$titulo."</td></tr>";
  }
  echo "</table>";
  
     



?>

</body>
</html>
