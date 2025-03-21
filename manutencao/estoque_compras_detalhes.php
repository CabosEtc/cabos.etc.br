<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Estoque</title>
</head>
<link href="../cabos.css" rel="stylesheet" type="text/css" />




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

$query="SELECT cdestoque FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$cdestoque=mysql_result($resultado,0,0);

?>

<? include("../manutencao/menu.php");

$cdproduto=$_REQUEST["cdproduto"];

$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto."'";
$resultado = mysql_query($query,$conexao);
$nome_produto=mysql_result($resultado,0,0);

?>
<br />
<table width="960" border="0" align="center">
  <tr>
    <td><h3>Detalhes de compra do produto  <? echo "[".$cdproduto." - ".$nome_produto."]"; ?>
      <br />
      <br />
    </h3>      
<?




// seleciona o produto no banco de dados
$query="SELECT compras_detalhes.cdproduto, compras_detalhes.quantidade, 
compras.dtcompra, 
compras.moeda,  
compras_detalhes.cdrastreamento,
transportadoras.link_rastreamento,
compras_detalhes.custo_lote,
compras_detalhes.custo_frete,
compras_detalhes.custo_imposto,
compras.cotacao_us
FROM compras, compras_detalhes, transportadoras
WHERE compras_detalhes.cdproduto = '".$cdproduto."'
AND compras.cdtransportadora=transportadoras.cdtransportadora
AND compras.cdloja = '".$cdestoque."'
AND compras_detalhes.idcompra = compras.idcompra
AND compras.cdstatus='0'
ORDER BY compras.dtcompra";

//echo $query;

$resultado = mysql_query($query,$conexao);

	echo "<table width='600' align='center'>";
	echo "<tr><td width='100' align='right'>Data da compra</td><td width='100' align='right'>Quantidade</td><td width='100' align='right'>Valor Unitário</td><td width='100' align='right'>Link rastreamento</td></tr>";

$quantidade_total=0; // irá receber a soma	
while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	$cdproduto=$row[0]; 
	$quantidade=$row[1];
	$vlproduto=$row[2];
	$dtcompra_eua=$row[2];
	$dtcompra=substr($dtcompra_eua,8,2)."/".substr($dtcompra_eua,5,2)."/".substr($dtcompra_eua,0,4);
	$moeda=$row[3];
	$cdrastreamento=$row[4];
	$link_rastreamento=$row[5];
	$custo_lote=$row[6];
	$custo_frete=$row[7];
	$custo_imposto=$row[8];	
	$cotacao_us=$row[9];
	if ($moeda=='2'){
	$vlproduto=($custo_lote+$custo_frete+$custo_imposto)*$cotacao_us/$quantidade;}
	if ($moeda=='1'){
		$vlproduto=($custo_lote+$custo_frete+$custo_imposto)/$quantidade;
		}
		$vlproduto=number_format($vlproduto,2,',','');
	$quantidade_total=$quantidade_total+$quantidade;
	
	
	$linha="impar";
	$cor="#CCCCCC";
	$cor_estoque='#FFA54F';
	$cor_estoque_loja='#FFC0CB';

	

	

	
		
		echo "<tr bgcolor='".$cor."'><td>".$dtcompra."</td><td align='right'>".$quantidade."</td><td align='right'>".$vlproduto."</td><td align='right'><a href='".$link_rastreamento.$cdrastreamento."' target='_blank'>".$cdrastreamento."</a></td></tr>";

if ($linha=="par"){
		$linha="impar";
		$cor="#CCCCCC";
		$cor_estoque='#FFA54F';
		$cor_estoque_loja='#FFC0CB';
		}
		else {
			$linha="par";
			$cor="#FFFFFF";
			$cor_estoque='#FFFFFF';
			$cor_estoque_loja='#FFFFFF';

			}
		
	}
	
			echo "<tr bgcolor='".$cor."'><td align='right'>Total</td><td align='right'>".$quantidade_total."</td><td colspan='3'>&nbsp;</td></tr>";
	echo "</table>";
	echo "<br>";


?>
</td>
</tr>
</table>
</body>
</html>
