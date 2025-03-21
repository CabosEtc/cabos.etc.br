<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8">
<title>Precos BD - Produtos acompanhados no sistema</title>


</head>


<body>





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



$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);

$dthoje_eua=date("Y-m-d",strtotime("now"));
$dtpesquisa=date("Ymd",strtotime("now"));


echo "<br>";



echo "<h3>Relatório de produtos cadastrados para pesquisa no Boadica</h3><br>";




// seleciona os produtos no banco de dados links_boadica

// Escreve todas as categorias no inicio da pagina com link

$query="SELECT DISTINCT links_boadica.cdproduto, produtos.nome FROM links_boadica, produtos WHERE links_boadica.cdproduto=produtos.cdproduto ORDER BY produtos.nome";

$resultado = mysql_query($query,$conexao);

$resultado_quant=mysql_num_rows($resultado);
echo "<br>Quantidade de produtos listados: ".$resultado_quant."<br>";
//echo $query;
echo "<table>";
echo "<tr><td>Cd Produto</td><td>Produto</td></tr>";
while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	$cdproduto=$row[0]; 
	$produto=$row[1]; 
		echo "<tr><td><a href='precos_bd.php?cdproduto=".$cdproduto."' TARGET='_blank'>".$cdproduto."</a></td><td>".$produto."</td></tr>";
	}
echo "</table>";

?>



</body>
</html>
