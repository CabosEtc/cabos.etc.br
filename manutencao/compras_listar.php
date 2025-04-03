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

echo "<title>Lista de compras - ".$data."</title>";

?>


</head>

<body>

<?
//Prepara conexao ao db
//include("../conectadb.php");

$query="SELECT compras.dtcompra,  produtos.nome, compras_detalhes.cdproduto, compras_detalhes.quantidade FROM compras, compras_detalhes, produtos WHERE compras.idcompra=compras_detalhes.idcompra AND compras_detalhes.cdproduto=produtos.cdproduto AND compras.cdloja='".$cdestoque."' AND compras.cdstatus='0' ORDER BY compras.dtcompra";
$resultado = mysql_query($query,$conexao);

// Ordena a lista de compras e colhe o resumo de cada produto

$produtos_array=array();

while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		$cdproduto=$row[2]; // cd do produto
		$produtos_array[] = $cdproduto; // Acrescante um elemento ao array
	}
	
		sort($produtos_array); // poe em ordem.
		
	echo "<h3>Listagem de Compras ".$nomeloja.")</h3><br>";
	
	echo "<table>";
	echo "<tr><td width='250'>Nome do produto</td><td width='120' align='right'>codigo</td><td width='150' align='right'>Quantidade</td></tr>";	
	$unique_array = array_unique($produtos_array);
		foreach ($unique_array as $pesquisa_produto)
			{$query2="SELECT produtos.nome, compras_detalhes.cdproduto, sum(compras_detalhes.quantidade) AS quantidade_total FROM compras, compras_detalhes, produtos WHERE compras.idcompra=compras_detalhes.idcompra AND compras_detalhes.cdproduto=produtos.cdproduto AND compras.cdloja='".$cdestoque."' AND compras.cdstatus='0' AND compras_detalhes.cdproduto='".$pesquisa_produto."' ORDER BY compras_detalhes.cdproduto";
			$resultado2 = mysql_query($query2,$conexao);
			//echo $query2;
			$nomeproduto=mysql_result($resultado2,0,0);
			$cdproduto=mysql_result($resultado2,0,1);
			$quantidade_total=mysql_result($resultado2,0,2);
			echo "<tr><td width='250'>".$nomeproduto."</td><td width='120' align='right'>".$cdproduto."</td><td width='150' align='right'><a href='estoque_compras_detalhes.php?cdproduto=".$cdproduto."' target='_blank'>".$quantidade_total."</a></td></tr>";
			}
		echo "</table>";
 


?>

</body>
</html>
