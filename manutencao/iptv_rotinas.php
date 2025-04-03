<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<title>Precos BD - Rotinas</title>
</head>





<?
session_start();
//if (!isset($_SESSION["usuario"])){
//			echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
//	}

//Prepara conexao ao db
include("../conectadb.php");

// Ajusta hora do servidor
date_default_timezone_set('America/Sao_Paulo');

// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
  $linha = fgets($ponteiro, 4096);
  $cdloja=$linha;
}
fclose ($ponteiro);


$modo=$_REQUEST["modo"];
$usuario=$_REQUEST["id"];
$nome=$_REQUEST["nome"];
$telefone=$_REQUEST["telefone"];
$pwd=$_REQUEST["senha"];
$adulto=$_REQUEST["adulto"];

IF($modo=="cadastrar_usuario"){
     $query_incluir_link="INSERT INTO iptv_users(`usuario`, `nome`,`telefone`,`dt_cadastro`,`pwd`,`adulto`) VALUES ('$usuario', '$nome', '$telefone', null, '$pwd','$adulto')";
     $resultado_incluir_link = mysql_query($query_incluir_link,$conexao);
     //echo $query_incluir_link;
  }
  
echo"Clique <a href='http://www.cabos.etc.br/manutencao/index.php' target='_blank'>Aqui</a> para voltar";


// INSERT INTO `links_boadica` (`id`, `marca`, `produto`, `cdproduto`, `link`, `flag_ativo`, `flag_ativo_boadica`, `descricao`) VALUES (NULL, '3D Connexion', 'TV Box OTT Android 7.1.2', '17000', 'https://www.boadica.com.br/produtos/p156987', '1', '1', '');


?>


</body>
</html>
