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

$idusuario=$_REQUEST["id"];

include("../manutencao/menu.php");


echo "<table width='960' border='0' align='center'>";


$query="SELECT iptv_log.id, iptv_users.usuario, iptv_log.data, iptv_log.last_list FROM iptv_log, iptv_users WHERE iptv_log.usuario=iptv_users.usuario AND iptv_log.usuario=".$idusuario." ORDER BY iptv_log.id DESC";
//echo $query;
$resultado = mysql_query($query,$conexao);
$quantidade_acessos=mysql_num_rows($resultado);
echo "<tr><td>Log do Usuario: ".$idusuario."</td><td colspan='6' align='left'>Quantidade de Acessos: ".$quantidade_acessos."</td></tr>";
echo "<tr><td>Data</td><td>Ultima lista</td></tr>";
echo "<tr><td colspan='2'>&nbsp</td></tr>";
  while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
    $id=$row[0];
    $nome=$row[1];
    $data=$row[2];
    $last_list=$row[3];
    echo "<tr><td>".$data."</td><td>".$last_list."</td></tr>";
  }
  echo "</table>";
  
     



?>

</body>
</html>
