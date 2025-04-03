<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

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
// recebe os dados 

$modo=$_REQUEST["modo"];
$iditem=$_REQUEST["iditem"];
$quantidade=$_REQUEST["quantidade"];
$cdproduto=$_REQUEST["cdproduto"];
$dtchegada=$_REQUEST["dtchegada"];
$dtchegada_eua=substr($dtchegada,6,4)."-".substr($dtchegada,3,2)."-".substr($dtchegada,0,2);
$dtentrada=$_REQUEST["dtentrada"]; // usado no modo de inclusão manual
$dtentrada_eua=substr($dtentrada,6,4)."-".substr($dtentrada,3,2)."-".substr($dtentrada,0,2);
$dados_nota=$_REQUEST["dados_nota"];

if ($modo=="incluir"){
	echo "Incluindo no estoque oficial o item: ".$iditem."<br><br>";
	echo "Código do produto: ".$cdproduto."<br>";
	echo "Quantidade: ".$quantidade."<br>";
	echo "Data da chegada: ".$dtchegada."<br>";
	echo "Dados da nota de entrada: ".$dados_nota."<br>";
	// incluir o produto no banco de dados do estoque
	$query="INSERT INTO estoque_oficial(iditem, cdproduto, historico, dtmovimento, quantidade, idcompra, cdloja) VALUES ('null', '$cdproduto', '51', '$dtchegada_eua', '$quantidade', '$iditem', '$cdloja')";
	// echo $query;
	$resultado = mysql_query($query,$conexao);

//	$query="UPDATE compras SET cdstatus='1', dtchegada='".$dtchegada_eua."' WHERE iditem='".$iditem."'";
//	$resultado = mysql_query($query,$conexao);
	echo "<a href='../manutencao/estoque_oficial_incluir_manual.php'>Incluir </a> novo produto no sistema a partir de compra anterior.";
}

if ($modo=="editar"){
	$query="UPDATE compras SET cdproduto='".$cdproduto."', cdstatus='".$cdstatus."', dtcompra='".$dtcompra."' , dtchegada='".$dtchegada."', cdrastreamento='".$cdrastreamento."', quantidade='".$quantidade."', custo_lote_us='".$custo_lote_us."', cotacao_us='".$cotacao_us."', taxa_lote_rs=".$taxa_lote_rs.", custo_total_individual_rs='".$custo_total_individual_rs."', idpaypal='".$idpaypal."', cartao='".$cartao."', observacao='".$observacao."' WHERE iditem='".$iditem."'";
$resultado = mysql_query($query,$conexao);
echo "Registro alterado com sucesso";
}
//echo $query;

if ($modo=="incluir_manual"){
	echo "Incluindo no estoque o produto<br><br>";
	echo "Código do produto: ".$cdproduto."<br>";
	echo "Quantidade: ".$quantidade."<br>";
	echo "Data da chegada: ".$dtentrada."<br>";
	echo "Dados da nota de entrada: ".$dados_nota."<br>";
	
	// incluir o produto no banco de dados do estoque
	$query="INSERT INTO estoque_oficial(iditem, cdproduto, historico, dtmovimento, quantidade, cdloja) VALUES ('null', '$cdproduto', '51', '$dtentrada_eua', '$quantidade', '$cdloja')";
	// echo $query;
	$resultado = mysql_query($query,$conexao);
	echo "<a href='../manutencao/estoque_oficial_incluir_manual.php'>Incluir </a> novo produto no sistema.";
}


?>


</body>
</html>
