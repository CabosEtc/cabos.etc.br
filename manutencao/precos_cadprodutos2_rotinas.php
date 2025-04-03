<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manuten&ccedil;&atilde;o</title>
</head>

<link href="../lojas.css" rel="stylesheet" type="text/css" />
<body>

<?
//Prepara conexao ao db
include("../conectadb.php");
?>

<?
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

?>

<?
session_start();
/*
if (!isset($_SESSION["usuario"])){
			echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
	}
	*/
		$_SESSION["usuario"]="flavio";
	$_SESSION["nivel"]="4";
include("../manutencao/menu.php");

$modo2=$_REQUEST["modo2"];
$cdproduto=$_REQUEST["cdproduto"];
$vlcompra=$_REQUEST["vlcompra"];
$vlvenda=$_REQUEST["vlvenda"];
$garantia=$_REQUEST["garantia"];

$query="SELECT produtos.nome FROM produtos WHERE produtos.cdproduto='".$cdproduto."'";
	   // echo $query;
		$resultado = mysql_query($query,$conexao);
		while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
			$nomeproduto=$row[0]; // nome da categoria
		}
		
$query="INSERT INTO precos (cdproduto, cdloja, vlcompra, vlvenda, garantia, ativo) VALUES ('$cdproduto', $cdloja, $vlcompra, $vlvenda, $garantia, '1')";
	$resultado = mysql_query($query,$conexao);

echo "Produto: ".$cdproduto." - ".$nomeproduto." incluido com sucesso";

?>
<br>
<a href="../manutencao/precos_cadprodutos.php?fabricante=1&modo=Enviar?fabricante=1&modo=Enviar?fabricante=1&modo=Enviar">Cadastrar novo produto Cia dos Cabos</a>
</body>
</html>
