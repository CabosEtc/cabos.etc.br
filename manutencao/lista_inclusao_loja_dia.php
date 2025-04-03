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
$data=$_REQUEST["dtmovimento"];
$data_eua=substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);

echo "<title>Lista de entradas  - ".$data."</title>";

?>


</head>

<body>

<?
//Prepara conexao ao db
//include("../conectadb.php");

$query="SELECT estoque.dtmovimento,  estoque.historico, estoque.quantidade, produtos.nome, estoque.cdproduto FROM estoque,produtos WHERE estoque.cdloja='".$cdloja."' AND estoque.dtmovimento='".$data_eua."' AND estoque.cdproduto=produtos.cdproduto ORDER BY estoque.cdproduto";
$resultado = mysql_query($query,$conexao);
//echo $query;



	echo "<h3>Listagem de entradas no estoque da loja ".$nomeloja." em ".$data."</h3><br>";
	
	echo "<table>";
	echo "<tr><td width='350'>Nome do produto</td><td width='120' align='right'>codigo</td><td width='150' align='right'>Quantidade</td><td width='150' align='right'>Total na loja</td></tr>";	

	while ($sub_row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		$dtmovimento=$sub_row[0]; // nome do produto
		$historico=$sub_row[1]; // nome do produto
		$quantidade=$sub_row[2]; // nome do produto
		$nome=$sub_row[3]; // nome do produto
		$cdproduto=$sub_row[4]; // nome do produto
			
			
			
			echo "<tr><td width='250'>".$nome."</td><td width='120' align='right'>".$cdproduto."</td><td width='150' align='right'><a href='estoque_compras_detalhes.php?cdproduto=".$cdproduto."' target='_blank'>".$quantidade."</a></td><td width='150' align='right'><a href='".$link_rastreamento.$cdrastreamento."' target='_blank'>".""."</a></td></tr>";
			}
			
		echo "</table>";
 


?>

</body>
</html>
