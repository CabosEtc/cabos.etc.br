<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Nota</title>
</head>
<link href="../cabos.css" rel="stylesheet" type="text/css" />

<body>

<p>
<?
//Prepara conexao ao db
include("../conectadb.php");

$nrnota=$_REQUEST["nrnota"];
$nrnota_formatado=substr($nrnota+100000,1,5);

$query="SELECT dtnota, vlnota, desconto, garantia, formapagamento FROM notas WHERE nrnota='".$nrnota."'";
$resultado = mysql_query($query,$conexao);
$dtnota=mysql_result($resultado,0,0);
$dtnota=substr($dtnota,8,2)."/".substr($dtnota,5,2)."/".substr($dtnota,0,4);
$vlnota=mysql_result($resultado,0,1);
$desconto=mysql_result($resultado,0,2);
$desconto_formatado=number_format($desconto,2,",","");
$garantia=mysql_result($resultado,0,3);
$idformapagamento=mysql_result($resultado,0,4);

$query="SELECT formapagamento FROM formas_pagamento WHERE idformapagamento=".$idformapagamento;
$resultado = mysql_query($query,$conexao);
$formapagamento=mysql_result($resultado,0,0);


/*
$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto1."'";
$resultado = mysql_query($query,$conexao);
$discriminacao1=mysql_result($resultado,0,0);
*/

?>
  
  
  
</p>
<table width="490" align="center">
  <tr>
    <td><img src="../imagens/logo_nota2.gif" /></td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="../manutencao/vendas_rotinas.php">
  <table width="490" border="0" align="center">
  <tr>
    <td width="300">&nbsp;</td>
    <td align="right" style="padding-right:40px"><h2>N&ordm;<? echo(": ".$nrnota_formatado); ?></h2></td>
  </tr>
  <tr>
    <td>Data de emiss&atilde;o: <? echo($dtnota); ?>
      <input name="dtnota" type="hidden" id="dtnota" <? echo("value='".$dtnota."'"); ?> /></td>
    <td>Garantia: <? echo($garantia." dias.");?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Forma pgto: <? echo($formapagamento);?></td>
    </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<table width="490" border="1" align="center" cellspacing="0">
  <tr>
    <td width="50">Quant</td>
    <td width="100">C&oacute;digo</td>
    <td>Discrimina&ccedil;&atilde;o do produto</td>
    <td>Pre&ccedil;o Unit.</td>
    <td>Total</td>
  </tr>


<?
	$query="SELECT  notas_detalhes.quantidade, notas_detalhes.cdproduto, notas_detalhes.vlproduto, produtos.nome FROM notas_detalhes, notas, produtos WHERE notas_detalhes.cdproduto=produtos.cdproduto AND notas.nrnota=".$nrnota." AND notas.idnota=notas_detalhes.idnota ORDER BY notas_detalhes.iddetalhe";
	$resultado = mysql_query($query,$conexao);
    $contador_linhas=0;
	$total_compras=0;
	while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		$quantidade=$row[0]; // nome da categoria
		$cdproduto=$row[1]; // nome da categoria
		$vlproduto=$row[2]; // nome da categoria
		$discriminacao=$row[3]; // nome da categoria
		
		$vlproduto_formatado=number_format($vlproduto,2,",","");
		$total_linha=number_format($quantidade*$vlproduto,2,",","");
		
		$contador_linhas=$contador_linhas+1;
		$total_compras=$total_compras+($vlproduto*$quantidade);
		echo "<tr><td>".$quantidade."</td><td>".$cdproduto."</td><td>".$discriminacao."</td><td align='right'>".$vlproduto_formatado."</td><td align='right'>".$total_linha."</td></tr>";
	}
	
		$total_nota=$total_compras-$desconto;
		$total_nota_formatado=number_format($total_nota,2,",","");
	
	while ($contador_linhas<10) {
		$contador_linhas=$contador_linhas+1;
		echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
	}
	

?>



<?
  $vlnota=number_format(($quant1*$vlunitario1)+($quant2*$vlunitario2)+($quant3*$vlunitario3)+($quant4*$vlunitario4)+($quant5*$vlunitario5)+($quant6*$vlunitario6)+($quant7*$vlunitario7)+($quant8*$vlunitario8)+($quant9*$vlunitario9)+($quant10*$vlunitario10)-$desconto,2,",","");
?>
  <tr class="tabela_1px">
    <td colspan="4" align="right">Descontos</td>
    <td align="right"><? echo($desconto_formatado); ?></td>
  </tr>
  <tr>
    <td colspan="4" align="right">Total da nota</td>
    <td align="right"><? echo($total_nota_formatado); ?></td>
  </tr>
  </table>
<p>&nbsp;</p>
</form>
<p>&nbsp;</p>
</body>
</html>
