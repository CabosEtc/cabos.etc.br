<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Compras</title>
</head>



<body>

<?

$favorito=$_REQUEST["favorito"];

//Prepara conexao ao db
include("../conectadb.php");

$soma_estoque=0; // receberá a soma total de todos os produtos (estoque+a chegar) * valor de venda


// seleciona o produto no banco de dados
	$query="SELECT categoria, cdcategoria from categoria ORDER BY cdcategoria";

$resultado = mysql_query($query,$conexao);
while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	$categoria=$row[0]; // nome da categoria
	$cdcategoria=$row[1]; // nome da categoria
	echo "<b>".$categoria."</b><br><br>";

	if ($favorito=="1"){
		$sub_query="SELECT nome, cdproduto, vlvenda, chavepesquisa, link1, link2, link3, vlvenda from produtos WHERE cdcategoria='".$cdcategoria."' AND favorito='1' ORDER BY nome";
	}
		else {
			$sub_query="SELECT nome, cdproduto, vlvenda, chavepesquisa, link1, link2, link3, vlvenda from produtos WHERE cdcategoria='".$cdcategoria."' ORDER BY nome";
			}

//	echo $sub_query;
	$sub_resultado = mysql_query($sub_query,$conexao);
	
	
	echo "<table>";
	echo "<tr><td width='350'>Nome do Produto</td><td width='30'>Código</td><td colspan='4' width='10' align='center'>Links</td><td width='60'>Comprados</td><td width='60'>A chegar</td></tr>";
	while ($sub_row = mysql_fetch_array($sub_resultado, MYSQL_NUM)) {
		$nome=$sub_row[0]; // nome do produto
		$cdproduto=$sub_row[1]; // codigo do produto
		$vlvenda=$sub_row[2]; // valor
		$chavepesquisa=$sub_row[3];
		$link1=$sub_row[4];
		$link2=$sub_row[5];
		$link3=$sub_row[6];
		$vlvenda=$sub_row[7];
		$vlvenda_formatado=str_replace(".",",",$vlvenda);
		

		$sub_query2="SELECT sum(quantidade) as a_chegar from compras WHERE cdproduto='".$cdproduto."' and cdstatus='0'"; // 0= compra deu entrada no sistema
		//  echo $sub_query2;
		$sub_resultado2 = mysql_query($sub_query2,$conexao);
		$a_chegar=mysql_result($sub_resultado2,0,0);
		$soma_estoque=$soma_estoque+($a_chegar*$vlvenda);

		$sub_query3="SELECT sum(quantidade) as entrada from compras WHERE cdproduto='".$cdproduto."' and cdstatus='1'"; // 1= produto foi recebido e deu entrada no estoque
		//	echo $sub_query;
		$sub_resultado3 = mysql_query($sub_query3,$conexao);
		$entrada=mysql_result($sub_resultado3,0,0);
		$soma_estoque=$soma_estoque+($entrada*$vlvenda);
		
/*		$sub_query4="SELECT sum(quantidade) as vendidos from compras WHERE cdproduto='".$cdproduto."' and cdstatus='2'";
		//	echo $sub_query;
		$sub_resultado4 = mysql_query($sub_query4,$conexao);
		$vendidos=mysql_result($sub_resultado4,0,0);
		
		$estoque_atual=$entrada-$vendidos;
*/

		$sub_query5="SELECT  sum(custo_lote_us) as total_custo_lote_us, avg(cotacao_us) as total_cotacao_us, sum(taxa_lote_rs) as total_taxa_lote_rs, sum(quantidade) as quantidade_total from estoque WHERE cdproduto='".$cdproduto."' and (cdstatus='0' or cdstatus='1') ";
		//echo $sub_query5;
		$sub_resultado5 = mysql_query($sub_query5,$conexao);
		$total_custo_lote_us=mysql_result($sub_resultado5,0,0);
		$total_cotacao_us=mysql_result($sub_resultado5,0,1);
		$total_taxa_lote_rs=mysql_result($sub_resultado5,0,2);
		$quantidade_total=mysql_result($sub_resultado5,0,3);
		if ($quantidade_total==0){
			$quantidade_total=1;
			}
//		$preco_medio=(($total_custo_lote_us*$total_cotacao_us)+$total_taxa_lote_rs)/$quantidade_total;
		$preco_medio=($total_custo_lote_us*$total_cotacao_us)/$quantidade_total;
		$preco_medio_formatado=number_format($preco_medio,2,',','');
		
		if ($preco_medio>0){
			$percentual_lucro=$vlvenda/$preco_medio*100;
		}
			else {
				$percentual_lucro="nihil";

				}
			
		$percentual_lucro=number_format($percentual_lucro,2,',','')."%";
		
		echo "<tr><td>".$nome."</td><td><a href='produtos_editar.php?cdproduto=".$cdproduto."'>".$cdproduto."</a></td><td><a href='http://shop.ebay.com/i.html?LH_BIN=1&_nkw=".$chavepesquisa."&_dmpt=Mice&_fcid=31&_jgr=0&_localstpos=&_npmv=3&_sticky=1&_stpos=&_trksid=p3286.c0.m301&gbr=1'>G</a></td><td><a href='".$link1."'>1</a></td><td><a href='".$link2."'>2</a></td><td><a href='".$link3."'>3</a></td><td align='right'><a href='compras_listar.php?cdproduto=".$cdproduto."&cdstatus=1'>".$entrada."</a></td><td align='right'>"."<a href='compras_listar.php?cdproduto=".$cdproduto."&cdstatus=0'>".$a_chegar."</a>"."</td></tr>";
	}
	echo "</table>";
	echo "<br>";
}

	echo "Soma do estoque (produtos x preço de venda, considerando estoque loja + a chegar) ".number_format($soma_estoque,2,',','.');


?>


</body>
</html>
