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
echo "<tr><td colspan=7>Usuarios -------------------</td></tr>";
echo "<tr><td>Id do Usuario</td><td>Nome</td><td>Telefone</td><td>Data do Cadastro</td><td>Pwd</td><td>Adulto</td><td>Estatisticas</td></tr>";
$query_filmes="SELECT usuario, nome, telefone, dt_cadastro, pwd, adulto  FROM iptv_users ORDER BY usuario";
$resultado_filmes = mysql_query($query_filmes,$conexao);
  while ($row = mysql_fetch_array($resultado_filmes, MYSQL_NUM)) {
    $usuario=$row[0];
    $nome=$row[1];
    $telefone=$row[2];
    $dt_cadastro=$row[3];
    $pwd=$row[4];
    $adulto=$row[5];
    IF($adulto=='0'){
      $adulto="N";
    }
      Else {
        $adulto="S";
      }
    echo "<tr><td>".$usuario."</td><td>".$nome."</td><td>".$telefone."</td><td>".$dt_cadastro."</td><td>".$pwd."</td><td align='center'>".$adulto."</td><td align='center'><a href='iptv_usuarios_log.php?id=".$usuario."'><img src='../imagens/relatorio.gif'></a></td></tr>";
  }
  echo "</table>";
  
     



?>

</body>
</html>
