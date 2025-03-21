<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<?
//Prepara conexao ao db
include("../conectadb.php");
?>

<?
// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
  $cdloja = fgets($ponteiro, 4096);
}
fclose ($ponteiro);

$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);

$query="SELECT cdestoque FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$cdestoque=mysql_result($resultado,0,0);

?>

<?
$data=$_REQUEST["data"];
$data_eua=substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);

echo "<title>Lista de compras - ".$data." (ordem cronologica)</title>";

?>


</head>

<body>

<?
//Prepara conexao ao db
//include("../conectadb.php");

$query="SELECT compras.dtcompra,  produtos.nome, compras_detalhes.cdproduto, compras_detalhes.quantidade, transportadoras.link_rastreamento, compras_detalhes.cdrastreamento, compras_detalhes.observacao FROM compras, compras_detalhes, produtos, transportadoras WHERE compras.idcompra=compras_detalhes.idcompra AND compras_detalhes.cdproduto=produtos.cdproduto AND compras.cdloja='".$cdestoque."' AND compras.cdstatus='0' AND transportadoras.cdtransportadora=compras.cdtransportadora ORDER BY compras.dtcompra desc";
$resultado = mysql_query($query,$conexao);
//echo $query;



	echo "<h3>Listagem de Compras ".$nomeloja.")</h3><br>";
	
	echo "<table>";
	echo "<tr><td width='250'>Data compra</td><td width='250'>Nome do produto</td><td width='120' align='right'>codigo</td><td width='150' align='right'>Quantidade</td><td width='150' align='right'>Cd rastreamento</td><td width='150' align='right'>Observacao</td></tr>";	

	while ($sub_row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		$dtcompra=$sub_row[0]; // nome do produto
		$nomeproduto=$sub_row[1]; // nome do produto
		$cdproduto=$sub_row[2]; // nome do produto
		$quantidade=$sub_row[3]; // nome do produto
		$link_rastreamento=$sub_row[4]; // nome do produto
		$cdrastreamento=$sub_row[5]; // nome do produt
		$observacao=$sub_row[6]; // nome do produto
			
			
			
			echo "<tr><td>".$dtcompra."</td><td width='250'>".$nomeproduto."</td><td width='120' align='right'>".$cdproduto."</td><td width='150' align='right'><a href='estoque_compras_detalhes.php?cdproduto=".$cdproduto."' target='_blank'>".$quantidade."</a></td><td width='150' align='right'><a href='".$link_rastreamento.$cdrastreamento."' target='_blank'>".$cdrastreamento."</a></td><t><td>".$observacao."</tr>";
			}
			
		echo "</table>";
 


?>


</body>
</html>
