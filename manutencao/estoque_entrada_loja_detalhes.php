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
    <td><h3>Detalhes de entradas na loja do produto  <? echo "[".$cdproduto." - ".$nome_produto."]"; ?>
      <br />
      <br />
    </h3>      
<?




// seleciona o produto no banco de dados
$query="SELECT estoque.cdproduto,
estoque.quantidade, estoque.historico, estoque_historicos.descricao_historico,
estoque.dtmovimento
FROM estoque, estoque_historicos
WHERE estoque.cdproduto = '".$cdproduto."'
AND estoque.cdloja = '".$cdloja."'
AND estoque.historico=estoque_historicos.historico
ORDER BY estoque.dtmovimento";

//echo $query;

$resultado = mysql_query($query,$conexao);

	echo "<table width='600' align='center'>";
	echo "<tr><td width='100' align='right'>Data da entrada</td><td width='100' align='right'>Quantidade</td><td width='100' align='right'>Historico</td></tr>";

$quantidade_total=0; // irá receber a soma	
while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	$cdproduto=$row[0]; 
	$quantidade=$row[1];
	$historico=$row[2];
	$descricao_historico=$row[3];
	$dtmovimento=$row[4];
	
	
	$linha="impar";
	$cor="#CCCCCC";
	$cor_estoque='#FFA54F';
	$cor_estoque_loja='#FFC0CB';

	

	

	
		
		echo "<tr bgcolor='".$cor."'><td>".$dtmovimento."</td><td align='right'>".$quantidade."</td>><td align='right'>".$descricao_historico."</td></tr>";

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
