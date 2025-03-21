<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Produtos</title>
</head>


<body>

<?
session_start();
if (!isset($_SESSION["usuario"])){
			echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
	}

//Prepara conexao ao db
include("../conectadb.php");

/*
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
*/

echo "<br>";
echo "<table width='960' align='center'><tr><td>"; // tabela estrutural externa



echo "<h3>Relatório para conferência de estoque em ____ / ____ / ____ (ordem alfabetica) - ".$nomeloja."</h3><br>";


$modo=$_REQUEST["modo"];
if ($_SESSION["nivel"]<3){
			echo "<meta http-equiv='refresh' content='0; url=../manutencao/mensagem.php?cdmensagem=1'>";
	}


// seleciona o produto no banco de dados

// Escreve todas as categorias no inicio da pagina com link

/*
$query="SELECT categoria, cdcategoria from categoria WHERE cdloja=".$cdloja."ORDER BY cdcategoria";
$resultado = mysql_query($query,$conexao);
while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	$categoria=$row[0]; // nome da categoria
	$cdcategoria=$row[1]; // nome da categoria
	//echo "<a href='../manutencao/produtos.php#".$categoria."'>".$categoria."</a><br>";
}
echo "<br><br>";
*/

// Pesquisa novamente pelas categorias e começa a apresentar os produtos, por categoria

$query="SELECT categoria, cdcategoria FROM categoria WHERE cdloja=".$cdloja." ORDER BY cdcategoria";
$resultado = mysql_query($query,$conexao);
//echo $query;
while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	$categoria=$row[0]; // nome da categoria
	$cdcategoria=$row[1]; // nome da categoria
	echo "<b>".$categoria."</b><br><br>";

	$sub_query="SELECT produtos.nome, produtos.cdproduto, precos.vlvenda, .precos.vlcompra from produtos, precos WHERE produtos.cdproduto=precos.cdproduto and produtos.cdcategoria='".$cdcategoria."' AND precos.cdloja='".$cdloja."' ORDER BY produtos.nome";
	
	//echo $sub_query;
	
	$sub_resultado = mysql_query($sub_query,$conexao);
	echo "<table width='960' align='center'>";
	echo "<tr><td width='350'>Nome do Produto</td><td width='30'>Código</td><td align='right' width='100'>Loja (sistema)</td><td align='left' style='padding-left:20px' width='150'>Loja (real)</td></tr>";

$linha_contador="impar";
	while ($sub_row = mysql_fetch_array($sub_resultado, MYSQL_NUM)) {
			$nome=$sub_row[0]; // nome do produto
			$cdproduto=$sub_row[1]; // codigo do produto
			$vlvenda_ponto=$sub_row[2]; // valor
			$vlvenda=str_replace(".",",",$vlvenda_ponto);
			$vlcompra_ponto=$sub_row[3]; // valor
			$vlcompra_us=number_format($vlcompra_ponto,2,",","");
			$vlcompra_ponto=$vlcompra_ponto*$cotacao_us; // valor
			$vlcompra=number_format($vlcompra_ponto,2,",","");
			$imagem=$cdproduto.".jpg";
						


		$sub_query3="SELECT sum(quantidade) as entrada from estoque WHERE cdproduto='".$cdproduto."' and (historico>'50') and cdloja='".$cdloja."'"; // codigo maiores que 50 sao de entrada
		//echo $sub_query;
		$sub_resultado3 = mysql_query($sub_query3,$conexao);
		$entrada_estoque=mysql_result($sub_resultado3,0,0);
		
		$sub_query4="SELECT sum(notas_detalhes.quantidade) as vendidos from notas_detalhes, notas WHERE notas_detalhes.idnota=notas.idnota AND notas_detalhes.cdproduto='".$cdproduto."' and notas.cdloja='".$cdloja."'";
		//echo $sub_query4;
		$sub_resultado4 = mysql_query($sub_query4,$conexao);
		$vendidos=mysql_result($sub_resultado4,0,0);

		$sub_query5="SELECT sum(quantidade) as perdas from estoque WHERE cdproduto='".$cdproduto."' and (historico=2) and cdloja='".$cdloja."'"; // historico 2 = perda
		//echo $sub_query;
		$sub_resultado5 = mysql_query($sub_query5,$conexao);
		$perdas=mysql_result($sub_resultado5,0,0);

		//$sub_query6="SELECT sum(quantidade) as transferencias from estoque_filiais WHERE cdproduto='".$cdproduto."' and (cdmovimento>=1 and cdmovimento<=4) and cdloja='".$cdloja."'";
		//echo $sub_query;
		//$sub_resultado6 = mysql_query($sub_query6,$conexao);
		//$transferencias=mysql_result($sub_resultado6,0,0);

		$estoque=$entrada_estoque-$perdas-$vendidos;

		if ($linha_contador=="impar"){
			$cor_linha="#CCCCCC";
			$linha_contador="par";
			}
				else {
					$cor_linha="#FFFFFF";
					$linha_contador="impar";
					}


			echo "<tr bgcolor='".$cor_linha."'><td>".$nome."</td><td>".$cdproduto."</td><td align='right'>".$estoque."</td><td align='left' style='padding-left:20px'>____________________________________________</td></tr>";

		
					
	} // fim do while sub-resultado

echo "</table>";
echo "<br>";

} // fim do while resultado
echo "</td></tr></table>"; // fim da tabela estrutural

?>



</body>
</html>
