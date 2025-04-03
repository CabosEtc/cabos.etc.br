<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Estoque 40d</title>
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

$today=new DateTime("now");
$hoje=$today->format('Y-m-d');
$q40diasatras=date('Y-m-d', strtotime("-40 days",strtotime($hoje))); 


?>

<? include("../manutencao/menu.php");?>
<br>
<table width="960" border="0" align="center">
  <tr>
    <td><h3>Produtos em estoque (somente material com venda nos ultimos 40 dias) <? echo "(".$nomeloja.")"; ?>
      <br>
      <br>
    </h3>      
<?

//$favorito=$_REQUEST["favorito"];


// seleciona o produto no banco de dados
	$query="SELECT categoria, cdcategoria from categoria where cdloja='".$cdloja."'ORDER BY cdcategoria";

$resultado = mysql_query($query,$conexao);
$soma_estoque=0; // receberá a soma total de todos os produtos (estoque atual) * valor de venda
$soma_estoque_a_chegar=0; // receberá a soma total de todos os produtos (estoque a chegar) * valor de venda

while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	$categoria=$row[0]; // nome da categoria
	$cdcategoria=$row[1]; // nome da categoria
	echo "<b>".$categoria."</b><br><br>";

//	if ($favorito=="1"){
		$sub_query="SELECT produtos.nome, precos.cdproduto, precos.quant_estoque_min FROM precos, produtos WHERE precos.cdproduto=produtos.cdproduto AND cdcategoria='".$cdcategoria."' AND precos.cdloja='".$cdloja."' ORDER BY produtos.nome";
//	}
//		else {
//			$sub_query="SELECT nome, cdproduto, vlvenda, chavepesquisa, link1, link2, link3, vlvenda from produtos WHERE cdcategoria='".$cdcategoria."' ORDER BY nome";
//			}

//	echo $sub_query;
	$sub_resultado = mysql_query($sub_query,$conexao);
	
		$linha="impar";
	$cor="#CCCCCC";
	$cor_estoque='#FFA54F';
	$cor_estoque_loja='#FFC0CB';

	
	echo "<table width='960' align='center'>";
	echo "<tr><td colspan='2' bgcolor='#FFFF00'>Produto</td><td colspan='4' bgcolor='#FFA500' align='center'>Movimento do Estoque</td><td colspan='4' bgcolor='#FF66FF' align='center'>Movimento da Loja</td><td bgcolor='#00FF00' align='center'>Total</td><td bgcolor='#FFC125' align='center'>Vendas</td></tr>";
	
//	echo "<tr><td width='300'>Nome do Produto</td><td width='30'>Código</td><td width='60' align='right'>Entradas</td><td width='60' align='right'>Transf.</td><td width='60' align='right'>Perdas</td><td width='90' align='right'>Estoque</td><td width='90' align='right'>Entradas</td><td width='90' align='right'>Vendidos</td><td width='90' align='right'>Estoque</td><td width='50' align='right'>Valor</td><td width='60' align='right'>Estoque</td><td width='60' align='right'>E\$toque</td><td width='70' align='right'>A chegar</td><td align='center'>Comprar</td></tr>";
	
	echo "<tr><td width='300'>Nome do Produto</td><td width='30'>Código</td><td width='30'>Compras</td><td width='60' align='right'>Entradas</td>><td width='60' align='right'>Saidas</td><td width='60' align='right'>Estoque</td><td width='60' align='right'>Entradas</td><td width='60' align='right'>Saidas</td><td width='60' align='right'>Vendas</td><td width='60' align='right'>Estoque</td><td width='60' align='right'>Soma</td><td width='60' align='right'>40 dias</td></tr>";
	
	while ($sub_row = mysql_fetch_array($sub_resultado, MYSQL_NUM)) {
		$nome=$sub_row[0]; // nome do produto
		$cdproduto=$sub_row[1]; // codigo do produto
		$quant_estoque_min=$sub_row[2];


		$sub_query2="SELECT sum(quantidade) as quantidade_comprada from compras, compras_detalhes WHERE compras.idcompra=compras_detalhes.idcompra AND cdloja='".$cdestoque."' AND compras_detalhes.cdproduto='".$cdproduto."' and compras_detalhes.cdstatus='0'";
		//  echo $sub_query2;
		$sub_resultado2 = mysql_query($sub_query2,$conexao);
		$compras_estoque=mysql_result($sub_resultado2,0,0);

/*		$sub_query3="SELECT sum(quantidade) as entrada from estoque WHERE cdproduto='".$cdproduto."' and (cdstatus='1' OR cdstatus='2')"; // entrada via compra anterior ou entrada manual
		//	echo $sub_query;
		$sub_resultado3 = mysql_query($sub_query3,$conexao);
		$entrada=mysql_result($sub_resultado3,0,0);


		$sub_query4="SELECT sum(quantidade) as vendidos from notas_detalhes, notas WHERE cdproduto='".$cdproduto."' and notas.cdfilial='1' and (notas.nrnota=notas_detalhes.nrnota)";
		//	echo $sub_query;
		$sub_resultado4 = mysql_query($sub_query4,$conexao);
		$vendidos_matriz=mysql_result($sub_resultado4,0,0);

		$sub_query5="SELECT SUM(compras.quantidade*produtos.vlvenda) as soma_a_chegar from compras, produtos WHERE compras.cdproduto=produtos.cdproduto AND compras.cdproduto='".$cdproduto."' AND compras.cdstatus='0'";
		//	echo $sub_query;
		$sub_resultado5 = mysql_query($sub_query5,$conexao);
		$soma_a_chegar=mysql_result($sub_resultado5,0,0);

		$sub_query6="SELECT sum(quantidade) as entrada_matriz from estoque_filiais WHERE cdproduto='".$cdproduto."' and (cdmovimento<'5') and (cdfilial='1')"; 
		//echo $sub_query;
		$sub_resultado6 = mysql_query($sub_query6,$conexao);
		$entradas_matriz=mysql_result($sub_resultado6,0,0);

		$sub_query7="SELECT sum(quantidade) as transferencias from estoque_filiais WHERE cdproduto='".$cdproduto."' and (cdmovimento<'5')"; 
		//echo $sub_query;
		$sub_resultado7 = mysql_query($sub_query7,$conexao);
		$transferencias=mysql_result($sub_resultado7,0,0);

		$sub_query8="SELECT sum(quantidade) as entrada_matriz from estoque WHERE cdproduto='".$cdproduto."' and (cdstatus>='5' and cdstatus<='8')"; 
		//echo $sub_query;
		$sub_resultado8 = mysql_query($sub_query8,$conexao);
		$perdas=mysql_result($sub_resultado8,0,0);

		$estoque_matriz=$entradas_matriz-$vendidos_matriz;



		$estoque_atual=$entrada-$transferencias-$perdas;
		
		$total_estoque=$estoque_atual+$estoque_matriz;


		$soma_estoque=$soma_estoque+($total_estoque*$vlvenda);
		
		$soma_estoque_a_chegar=$soma_estoque_a_chegar+$soma_a_chegar;
		
		$vlestoque=number_format($vlvenda*($estoque_atual+$estoque_matriz),2,",","");
		

		
		echo "<tr bgcolor='".$cor."'><td>".$nome."</td><td><a href='produtos_editar.php?cdproduto=".$cdproduto."'>".$cdproduto."</a></td><td align='right'><a href='compras_listar.php?cdproduto=".$cdproduto."&cdstatus=1'>".$entrada."</a></td><td align='right'>".$transferencias."</td><td align='right'>".$perdas."</td><td align='right' bgcolor='".$cor_estoque."'>".$estoque_atual."</td><td align='right'>".$entradas_matriz."</td></td><td align='right'>".$vendidos_matriz."</td></td><td align='right' bgcolor='".$cor_estoque_loja."'>".$estoque_matriz."</td><td align='right'>".number_format($vlvenda,2,",","")."</td><td align='right'>".$total_estoque."</td><td align='right'>".$vlestoque."</td><td align='right'>"."<a href='compras_listar.php?cdproduto=".$cdproduto."&cdstatus=0'>".$a_chegar."</a>"."</td><td align='center'><a href='../manutencao/guiacompras_produto.php?cdproduto=".$cdproduto."'><img src='../imagens/cifrao.gif'></a></td></tr>";
*/

		$sub_query3="SELECT sum(estoque.quantidade) as entradas from estoque WHERE  estoque.cdproduto='".$cdproduto."' AND (historico>=50) AND estoque.cdloja='".$cdloja."' "; // entrada via compra anterior ou entrada manual
		//echo $sub_query3;
		$sub_resultado3 = mysql_query($sub_query3,$conexao);
		$entradas_loja=mysql_result($sub_resultado3,0,0);

		$sub_query4="SELECT sum(estoque.quantidade) as saidas from estoque WHERE  estoque.cdproduto='".$cdproduto."' AND (historico<50) AND estoque.cdloja='".$cdloja."' "; // entrada via compra anterior ou entrada manual
		//echo $sub_query3;
		$sub_resultado4 = mysql_query($sub_query4,$conexao);
		$saidas_loja=mysql_result($sub_resultado4,0,0);
		
		$sub_query5="SELECT sum(notas_detalhes.quantidade) as quantidade_vendida FROM notas, notas_detalhes WHERE  notas_detalhes.cdproduto='".$cdproduto."' AND notas.idnota=notas_detalhes.idnota AND notas.cdloja='".$cdloja."' "; // entrada via compra anterior ou entrada manual
		// echo $sub_query5;
		$sub_resultado5 = mysql_query($sub_query5,$conexao);
		$quantidade_vendida_loja=mysql_result($sub_resultado5,0,0);

		$sub_query6="SELECT vlvenda FROM precos WHERE  cdproduto='".$cdproduto."' AND cdloja='".$cdloja."' "; // entrada via compra anterior ou entrada manual
		// echo $sub_query5;
		$sub_resultado6 = mysql_query($sub_query6,$conexao);
		$vlvenda=mysql_result($sub_resultado6,0,0);
		
		
		$quantidade_estoque_loja=$entradas_loja-$saidas_loja-$quantidade_vendida_loja;
		$vltotalproduto=$vlvenda*$quantidade_estoque;
		$soma_estoque=$soma_estoque+$vltotalproduto;

// Contagem do estoque
		$sub_query7="SELECT sum(estoque.quantidade) as entradas from estoque WHERE  estoque.cdproduto='".$cdproduto."' AND (historico>=50) AND estoque.cdloja='".$cdestoque."' "; 
		
		$sub_resultado7 = mysql_query($sub_query7,$conexao);
		$entradas_estoque=mysql_result($sub_resultado7,0,0);
		
		
		$sub_query8="SELECT sum(estoque.quantidade) as saidas from estoque WHERE  estoque.cdproduto='".$cdproduto."' AND (historico<50) AND estoque.cdloja='".$cdestoque."' "; // entrada via compra anterior ou entrada manual
		//echo $sub_query3;
		$sub_resultado8 = mysql_query($sub_query8,$conexao);
		$saidas_estoque=mysql_result($sub_resultado8,0,0);	
		
		$quantidade_estoque_estoque=$entradas_estoque-$saidas_estoque;
		
		$quantidade_estoque_total=$quantidade_estoque_estoque+$quantidade_estoque_loja;
		
				$sub_query9="SELECT sum(notas_detalhes.quantidade) as quantidade_vendida FROM notas, notas_detalhes WHERE notas.dtnota>='".$q40diasatras."' AND  notas_detalhes.cdproduto='".$cdproduto."' AND notas.idnota=notas_detalhes.idnota AND notas.cdloja='".$cdloja."' "; // entrada via compra anterior ou entrada manual
		//echo $sub_query9;
		$sub_resultado9 = mysql_query($sub_query9,$conexao);
		$vendas40dias=mysql_result($sub_resultado9,0,0);
		
//Vermelho
if ($quantidade_estoque_total<$quant_estoque_min){
	$cor_fundo_quant_minima="#FF0000";
	}
//Amarelo
if (($quantidade_estoque_total>=$quant_estoque_min) and ($quantidade_estoque_estoque<=$quant_estoque_min*1.4)){
	$cor_fundo_quant_minima="#FFFF00";
	}
// Verde
if ($quantidade_estoque_total>$quant_estoque_min*1.4){
	$cor_fundo_quant_minima="#FF0000";
	}
	
	//$sub_query99="INSERT INTO `cabos_bd`.`estoque` (`iditem`, `cdloja`, `cdproduto`, `dtmovimento`, `historico`, `quantidade`, `vlindividual`, `idcompra`, `idnota`) VALUES (NULL, '1', '".$cdproduto."', '2014-04-05', '99', '".$quantidade_vendida_loja."', '', '', '')";
	//	$sub_resultado99 = mysql_query($sub_query99,$conexao);
	
		
if ($vendas40dias>0){
echo "<tr bgcolor='".$cor."'><td>".$nome."</td><td title='Preço venda=R$".$vlvenda."'><a href='produtos_editar.php?cdproduto=".$cdproduto."'>".$cdproduto."</a></td><td align='right'><a target='_blank' href='estoque_compras_detalhes.php?cdproduto=".$cdproduto."'>".$compras_estoque."</a></td><td align='right'>".$entradas_estoque."</td><td align='right'>".$saidas_estoque."</td><td align='right'>".$quantidade_estoque_estoque."</td>
<td align='right'><a href='estoque_entrada_loja_detalhes.php?cdproduto=".$cdproduto."' target='_blank'>".$entradas_loja."</a><td align='right'><a href='estoque_saida_loja_detalhes.php?cdproduto=".$cdproduto."' target='_blank'>".$saidas_loja."</a></td><td align='right'><a target='_blank' href='estoque_venda_detalhes.php?cdproduto=".$cdproduto."'>".$quantidade_vendida_loja."</a></td><td align='right'>".$quantidade_estoque_loja."</td><td title='Quant Min Estoque=".$quant_estoque_min."' bgcolor='".$cor_fundo_quant_minima."' align='right'>".$quantidade_estoque_total."</td><td align='right'>".$vendas40dias."</td></tr>";
}
// <td align='right'>".number_format($vlvenda,2,',','')."</td>
// <td align='right'>".number_format($vltotalproduto,2,',','')."</td>
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
	echo "</table>";
	echo "<br>";

}

	echo "Soma do estoque (produtos em estoque na loja x preço de venda) ".number_format($soma_estoque,2,',','')."<br/>";
//	echo "Soma do estoque (produtos a chegar x preço de venda) ".number_format($soma_estoque_a_chegar,2,',','')."<br/>";


?>
</td>
</tr>
</table>
</body>
</html>
