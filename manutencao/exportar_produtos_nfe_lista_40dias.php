<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Exportacao NFE 40d</title>
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

<?
//include("../manutencao/menu.php");?>
<br>
<table width="960" border="0" align="center">
  <tr>
    <td><h3>Lista de exportacao para sistema NFE (somente material com venda nos ultimos 40 dias)
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

// abre o arquivo para escrita
$name = 'produtos.txt';
$file = fopen($name, 'w'); // w zera o arquivo antes de comecar a escrever

while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	$nomecategoria=$row[0]; // nome da categoria
	$cdcategoria=$row[1]; // nome da categoria
	echo "<b>".$nomecategoria."</b><br><br>";

//	if ($favorito=="1"){

$sub_query="SELECT produtos.nome, produtos.cdproduto, produtos.modelo, produtos.cdcategoria, produtos.cdsubcategoria, fabricantes.nome, precos.vlvenda FROM produtos,precos,fabricantes WHERE precos.cdproduto=produtos.cdproduto AND produtos.cdfabricante=fabricantes.cdfabricante AND produtos.cdcategoria='$cdcategoria' AND precos.cdloja='1' order by produtos.nome";


// linha para fazer os ajustes
// UPDATE `produtos` SET `cdcategoria` = '01' WHERE `produtos`.`cdproduto` = '01040';


	//echo $sub_query;
	$sub_resultado = mysql_query($sub_query,$conexao);
	
		$linha="impar";
	$cor="#CCCCCC";
	$cor_estoque='#FFA54F';
	$cor_estoque_loja='#FFC0CB';

	
	echo "<table width='960' align='center'>";
	//echo "<tr><td colspan='2' bgcolor='#FFFF00'>Produto</td><td colspan='4' bgcolor='#FFA500' align='center'>Movimento do Estoque</td><td colspan='4' bgcolor='#FF66FF' align='center'>Movimento da Loja</td><td bgcolor='#00FF00' align='center'>Total</td><td bgcolor='#FFC125' align='center'>Vendas</td></tr>";
	
//	echo "<tr><td width='300'>Nome do Produto</td><td width='30'>Código</td><td width='60' align='right'>Entradas</td><td width='60' align='right'>Transf.</td><td width='60' align='right'>Perdas</td><td width='90' align='right'>Estoque</td><td width='90' align='right'>Entradas</td><td width='90' align='right'>Vendidos</td><td width='90' align='right'>Estoque</td><td width='50' align='right'>Valor</td><td width='60' align='right'>Estoque</td><td width='60' align='right'>E\$toque</td><td width='70' align='right'>A chegar</td><td align='center'>Comprar</td></tr>";
	
	echo "<tr><td width='300'>Nome do Produto</td><td width='30'>Codigo</td><td>Modelo</td><td>subgrupo</td><td>fabricante</td><td>garantia</td><td>compra</td><td>venda</td></tr>";




	while ($sub_row = mysql_fetch_array($sub_resultado, MYSQL_NUM)) {
		$nome=$sub_row[0]; // nome do produto
		$cdproduto=$sub_row[1]; // codigo do produto
		//$quant_estoque_min=$sub_row[2];
    $modelo="CB".$sub_row[1];
    $categoria=$sub_row[3];
    $subcategoria="Diversos";
    $fabricante=$sub_row[5];
    $vlvenda=str_replace(".", ",",$sub_row[6]);
    $garantia="3M";
    $precocusto="1,00";
    $especificacoes="";


echo "<tr><td>".$nome."</td><td>".$cdproduto."</td><td>".$modelo."</td><td>".$subcategoria."</td><td>".$fabricante."</td><td>3M</td>
<td>1,00</a><td>".$vlvenda."</td></tr>";


// Escreve no arquivo texto
IF($categoria<"98"){
  $texto=$nome.";".$nomecategoria.";".$subcategoria.";".$modelo.";".$fabricante.";".$garantia.";".$precocusto.";".$vlvenda.";".$especificacoes."\r";
  fwrite($file, $texto);
}


}
	echo "</table>";
	echo "<br>";

}

// fecha o arquivo		
	fclose($file);
	
  
//	echo "Soma do estoque (produtos em estoque na loja x preço de venda) ".number_format($soma_estoque,2,',','')."<br/>";
//	echo "Soma do estoque (produtos a chegar x preço de venda) ".number_format($soma_estoque_a_chegar,2,',','')."<br/>";


?>
</td>
</tr>
</table>
</body>
</html>
