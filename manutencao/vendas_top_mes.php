<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?
$periodo=$_REQUEST["periodo"];
echo ("<title>Vendas ".$periodo."</title>");
?>
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
  $cdloja = fgets($ponteiro, 4096);
}
fclose ($ponteiro);

$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);

session_start();
//if (!isset($_SESSION["usuario"])){
//			echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
//	}
	
	

?>

<?
$mes=substr($periodo,0,2);
$ano=substr($periodo,3,4);

$query="SELECT cotacao_us FROM parametros WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$cotacao_dolar=mysql_result($resultado,0,0);

$query="SELECT moeda_compra FROM parametros WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$moeda_compra=mysql_result($resultado,0,0);

	echo "<h3>Listagem de Produtos TOP - vendidos no mes ".$periodo.", agrupadas por produto, por ordem de lucro total de determinado produto.</h3><br>";
	echo "<h3>Loja: ".$nomeloja."</h3><br>";
	if ($moeda_compra=="US"){
		echo "Moeda de compra: Dolar, cotacao utilizada: ".$cotacao_dolar."<br><br>";
	} else {
			echo "Moeda de compra: Reais"."<br><br>";
		}
	
	// seleciona o produto no banco de dados
	//	$query="SELECT SUM(notas_detalhes.quantidade) AS quantidade_total, notas_detalhes.cdproduto, produtos.nome, SUM(notas.vlnota) AS valor_total, SUM(notas_detalhes.vlproduto*notas_detalhes.quantidade) AS vltotaldoproduto, SUM(produtos.vlcompra*notas_detalhes.quantidade*parametros.cotacao_us) AS vlcustototaldoproduto, produtos.vlcompra*parametros.cotacao_us AS custo_do_produto FROM notas_detalhes,produtos,notas,parametros WHERE notas_detalhes.cdproduto=produtos.cdproduto AND notas_detalhes.nrnota=notas.nrnota AND notas.cdloja=notas_detalhes.cdloja AND notas.cdloja='".$cdloja."'AND MONTH(notas.dtnota)='".$mes."' AND YEAR(notas.dtnota)='".$ano."' GROUP BY notas_detalhes.cdproduto ORDER BY vltotaldoproduto DESC";
	
	// New query
	
/* $query="SELECT SUM( notas_detalhes.quantidade ) AS quantidade_total, 
notas_detalhes.cdproduto, 
produtos.nome, 
SUM(notas_detalhes.vlproduto*notas_detalhes.quantidade) AS vltotaldoproduto, 
SUM(precos.vlcompra*notas_detalhes.quantidade) AS vlcustototaldoproduto,
precos.vlcompra AS custo_do_produto,
SUM(notas_detalhes.vlproduto*notas_detalhes.quantidade)-SUM(precos.vlcompra*notas_detalhes.quantidade) AS vllucrototaldoproduto 
FROM notas_detalhes, produtos, notas, precos
WHERE produtos.cdproduto = notas_detalhes.cdproduto
AND precos.cdproduto=notas_detalhes.cdproduto 
AND notas_detalhes.idnota = notas.idnota
AND notas.cdloja = '".$cdloja."'
AND MONTH( notas.dtnota ) = '".$mes."'
AND YEAR( notas.dtnota ) = '".$ano."'
GROUP BY produtos.cdproduto ORDER BY vllucrototaldoproduto DESC";
*/


$query="SELECT notas_detalhes.cdproduto, produtos.nome
FROM notas_detalhes, produtos, precos, notas
WHERE produtos.cdproduto = notas_detalhes.cdproduto
AND precos.cdproduto=produtos.cdproduto
AND notas_detalhes.idnota = notas.idnota
AND notas.cdloja = '".$cdloja."'
AND MONTH( notas.dtnota ) = '".$mes."'
AND YEAR( notas.dtnota ) = '".$ano."'
GROUP BY produtos.cdproduto";



	//echo $query;
	
	$resultado = mysql_query($query,$conexao);
//	$valor_total_compras=0;
	$query2="SELECT SUM(notas.vlnota) AS valor_total FROM notas WHERE MONTH(notas.dtnota)='".$mes."' AND YEAR(notas.dtnota)='".$ano."' AND notas.cdloja = '".$cdloja."' ";
	//echo $query2;
	$resultado2 = mysql_query($query2,$conexao);
	$valor_total=mysql_result($resultado2,0,0);
	
	echo "<table>";
	echo "<tr><td width='300'>Nome do produto</td><td width='120'>Codigo</td><td width='100'>Quantidade</td><td>Custo individual</td><td>Moeda</td><td>Custo BRL</td><td>Custo total itens</td><td>Valor total Venda</td><td>Lucro total do produto</td></tr>";
	$valor_total_custo=0;
	while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		$cdproduto=$row[0]; // nome da categoria
		$nome=$row[1]; // nome da categoria
		
    // Rotina alterada em Marco 2020, agora considera o valor vindo da tabela de entrada em estoque
    
		//$query4="SELECT vlcompra, cdmoeda FROM precos WHERE cdproduto='".$cdproduto."' AND cdloja = '".$cdloja."'";
    $query4="SELECT vlindividual FROM estoque WHERE cdproduto='$cdproduto' AND cdloja = '$cdloja' AND historico = 51 ORDER BY dtmovimento DESC";
    
		//echo $query4;
		$resultado4 = mysql_query($query4,$conexao);
		$vlcompra=mysql_result($resultado4,0,0);
		//$cdmoeda=mysql_result($resultado4,0,1);

		$vlcusto_do_produto_brl=number_format($vlcompra,2,".",""); // nome da categoria
    
		//if ($cdmoeda=="USD"){
		//	$vlcusto_do_produto_brl=number_format($vlcompra*$cotacao_dolar,2,".",""); // nome da categoria
		//	}
		//	else {$vlcusto_do_produto_brl=$vlcusto_do_produto;
		//		}
		//$quantidade_total=$row[0]; // nome da categoria
		
		$query3="SELECT SUM(notas_detalhes.quantidade) as quantidade_total FROM notas_detalhes, notas WHERE cdproduto='".$cdproduto."' and notas.idnota=notas_detalhes.idnota AND MONTH(notas.dtnota)='".$mes."' AND YEAR(notas.dtnota)='".$ano."' AND notas.cdloja = '".$cdloja."' ";
		//echo $query3;
		$resultado3 = mysql_query($query3,$conexao);
		$quantidade_total=mysql_result($resultado3,0,0);
		
		$query4="SELECT SUM(notas_detalhes.quantidade*notas_detalhes.vlproduto) as vlvendatotaldoproduto FROM notas_detalhes, notas WHERE cdproduto='".$cdproduto."' and notas.idnota=notas_detalhes.idnota AND MONTH(notas.dtnota)='".$mes."' AND YEAR(notas.dtnota)='".$ano."' AND notas.cdloja = '".$cdloja."' ";
		//echo $query4;
		$resultado4 = mysql_query($query4,$conexao);
		$vltotaldoproduto=mysql_result($resultado4,0,0);
		$vlvendatotaldoproduto=number_format($vltotaldoproduto,2,".","");

		$vlcustototaldoproduto=number_format($vlcusto_do_produto_brl*$quantidade_total,2,".","");

		$vllucrototaldoproduto=number_format($vlvendatotaldoproduto-$vlcustototaldoproduto,2,".","");

		$valor_total_custo=$valor_total_custo+$vlcustototaldoproduto;

		echo "<tr><td>".$nome."</td><td><a href='../manutencao/produtos_editar.php?cdproduto=".$cdproduto."'>".$cdproduto."</a></td><td><a href='../manutencao/estoque_venda_detalhes.php?cdproduto=".$cdproduto."'>".$quantidade_total."</a></td>";
		//if (($_SESSION["nivel"]>=4)){
    if (1==1){
			echo "<td align='right'>".$vlcusto_do_produto."</td>";	
			}
			else
				{
				echo "<td align='right'>&nbsp;</td>";	
				}
		
		if (($_SESSION["nivel"]>=4)){
			echo "<td align='right'>".$cdmoeda."</td>";	
			}
			else
				{
				echo "<td align='right'>&nbsp;</td>";	
				}
		
		//if (($_SESSION["nivel"]>=4)){
    if (1==1){
			echo "<td align='right'>".$vlcusto_do_produto_brl."</td>";	
			}
			else
				{
				echo "<td align='right'>&nbsp;</td>";	
				}
		
		//if (($_SESSION["nivel"]>=4)){
    if (1==1){
			echo "<td align='right'>".$vlcustototaldoproduto."</td>";	
			}
			else
				{
				echo "<td align='right'>&nbsp;</td>";	
				}

		// Este é o valor total de venda do produto (exibido para todos)		
		echo "<td align='right'>".$vltotaldoproduto."</td>";	
		
		//if (($_SESSION["nivel"]>=4)){
    if (1==1){
			echo "<td align='right'>".$vllucrototaldoproduto."</td></tr>";	
			}
			else
				{
				echo "<td align='right'>&nbsp;</td></tr>";	
				}
		
		// echo "<tr><td colspan='7'>".$valor_total_custo."</td></tr>";

	}
		echo "<tr><td colspan='5'>&nbsp;</td><td colspan='2'> Valor das vendas: </td><td align='right'>".number_format($valor_total,2,".","")."</td></tr>";

		//if (($_SESSION["nivel"]>=4)){
    if (1==1){
			echo "<tr><td colspan='5'>&nbsp;</td><td colspan='2'> Valor dos custos: </td><td align='right'>".number_format($valor_total_custo,2,".","")."</td></tr>";
		}
		//if (($_SESSION["nivel"]>=4)){
    if (1==1){
			echo "<tr><td colspan='5'>&nbsp;</td><td colspan='2'> Lucro presumido no Mes: </td><td align='right'>".number_format($valor_total-$valor_total_custo,2,",","")."</td></tr>";
		}
	
		echo "</table>";
?>
</body>
</html>