<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Vendas</title>
</head>

<body>

<p>
<?
//Prepara conexao ao db
include("../conectadb.php");
// Ajusta hora do servidor
date_default_timezone_set('America/Sao_Paulo');

$nrnota=$_REQUEST["nrnota"];
$cdloja=$_REQUEST["cdloja"];
$dtnota=$_REQUEST["dtnota"];
$garantia=$_REQUEST["garantia"];
$idusuario=$_REQUEST["idusuario"];

echo $idvendedor;

$query="SELECT nomeusuario FROM usuarios WHERE idusuario='".$idusuario."'";
$resultado = mysql_query($query,$conexao);
$nomevendedor=mysql_result($resultado,0,0);


$idformapagamento=$_REQUEST["formapagamento"];
$query="SELECT formapagamento FROM formas_pagamento WHERE idformapagamento='".$idformapagamento."'";
$resultado = mysql_query($query,$conexao);
$formapagamento=mysql_result($resultado,0,0);

$quant1=$_REQUEST["quant1"];
$quant2=$_REQUEST["quant2"];
$quant3=$_REQUEST["quant3"];
$quant4=$_REQUEST["quant4"];
$quant5=$_REQUEST["quant5"];
$quant6=$_REQUEST["quant6"];
$quant7=$_REQUEST["quant7"];
$quant8=$_REQUEST["quant8"];
$quant9=$_REQUEST["quant9"];
$quant10=$_REQUEST["quant10"];
$cdproduto1=$_REQUEST["cdproduto1"];
$cdproduto2=$_REQUEST["cdproduto2"];
$cdproduto3=$_REQUEST["cdproduto3"];
$cdproduto4=$_REQUEST["cdproduto4"];
$cdproduto5=$_REQUEST["cdproduto5"];
$cdproduto6=$_REQUEST["cdproduto6"];
$cdproduto7=$_REQUEST["cdproduto7"];
$cdproduto8=$_REQUEST["cdproduto8"];
$cdproduto9=$_REQUEST["cdproduto9"];
$cdproduto10=$_REQUEST["cdproduto10"];
$vlunitario1=$_REQUEST["vlunitario1"];
$vlunitario2=$_REQUEST["vlunitario2"];
$vlunitario3=$_REQUEST["vlunitario3"];
$vlunitario4=$_REQUEST["vlunitario4"];
$vlunitario5=$_REQUEST["vlunitario5"];
$vlunitario6=$_REQUEST["vlunitario6"];
$vlunitario7=$_REQUEST["vlunitario7"];
$vlunitario8=$_REQUEST["vlunitario8"];
$vlunitario9=$_REQUEST["vlunitario9"];
$vlunitario10=$_REQUEST["vlunitario10"];
$vlunitario1=str_replace(",",".",$vlunitario1);
$vlunitario2=str_replace(",",".",$vlunitario2);
$vlunitario3=str_replace(",",".",$vlunitario3);
$vlunitario4=str_replace(",",".",$vlunitario4);
$vlunitario5=str_replace(",",".",$vlunitario5);
$vlunitario6=str_replace(",",".",$vlunitario6);
$vlunitario7=str_replace(",",".",$vlunitario7);
$vlunitario8=str_replace(",",".",$vlunitario8);
$vlunitario9=str_replace(",",".",$vlunitario9);
$vlunitario10=str_replace(",",".",$vlunitario10);
$desconto=$_REQUEST["desconto"];
$desconto=str_replace(",",".",$desconto);

if ($desconto==""){
	$desconto=0;
	}



$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto1."'";
$resultado = mysql_query($query,$conexao);
$discriminacao1=mysql_result($resultado,0,0);

if ($cdproduto2<>""){
$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto2."'";
$resultado = mysql_query($query,$conexao);
$discriminacao2=mysql_result($resultado,0,0);
}

if ($cdproduto3<>""){
$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto3."'";
$resultado = mysql_query($query,$conexao);
$discriminacao3=mysql_result($resultado,0,0);
}

if ($cdproduto4<>""){
$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto4."'";
$resultado = mysql_query($query,$conexao);
$discriminacao4=mysql_result($resultado,0,0);
}

if ($cdproduto5<>""){
$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto5."'";
$resultado = mysql_query($query,$conexao);
$discriminacao5=mysql_result($resultado,0,0);
}

if ($cdproduto6<>""){
$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto6."'";
$resultado = mysql_query($query,$conexao);
$discriminacao6=mysql_result($resultado,0,0);
}

if ($cdproduto7<>""){
$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto7."'";
$resultado = mysql_query($query,$conexao);
$discriminacao7=mysql_result($resultado,0,0);
}

if ($cdproduto8<>""){
$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto8."'";
$resultado = mysql_query($query,$conexao);
$discriminacao8=mysql_result($resultado,0,0);
}

if ($cdproduto9<>""){
$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto9."'";
$resultado = mysql_query($query,$conexao);
$discriminacao9=mysql_result($resultado,0,0);
}

if ($cdproduto10<>""){
$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto10."'";
$resultado = mysql_query($query,$conexao);
$discriminacao10=mysql_result($resultado,0,0);
}

?>
  
  
  
</p>
<table width="960" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="../manutencao/vendas_rotinas.php">
  <table width="960" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td align="right" style="padding-right:40px"><h2>N&ordm;<? echo(": ".$nrnota); ?></h2><input name="nrnota" type="hidden" id="nrnota" <? echo("value='".$nrnota."'"); ?> /></td>
  </tr>
  <tr>
    <td width="600">Data de emiss&atilde;o: <? echo($dtnota); ?>
      <input name="dtnota" type="hidden" id="dtnota" <? echo("value='".$dtnota."'"); ?> /></td>
    <td>Garantia: <? echo($garantia." dias.");?>
      <input name="garantia" type="hidden" id="garantia" <? echo("value='".$garantia."'"); ?> /></td>
  </tr>
  <tr>
    <td>Forma pgto: <? echo($formapagamento);?> <input name="idformapagamento" type="hidden" id="idformapagamento" <? echo("value='".$idformapagamento."'"); ?> /></td>
    <td>Vendedor: <? echo("[".$idusuario."]".$nomevendedor);?> <input name="idusuario" type="hidden" id="idusuario" <? echo("value='".$idusuario."'"); ?> /></td>
    </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<table width="960" border="0" align="center">
  <tr>
    <td width="50">Quant</td>
    <td width="100">C&oacute;digo</td>
    <td>Discrimina&ccedil;&atilde;o do produto</td>
    <td>Pre&ccedil;o Unit.</td>
    <td>Total</td>
  </tr>
  <tr>
    <td><label>
      <input name="quant1" type="text" id="quant1" size="5" maxlength="4" readonly="readonly" <? echo("value='".$quant1."'")?>/>
      </label></td>
    <td><input name="cdproduto1" type="text" id="cdproduto1" size="10" maxlength="6" readonly="readonly" <? echo("value='".$cdproduto1."'")?>/></td>
    <td><input name="discriminacao1" type="text" id="discriminacao1" size="80" maxlength="80" <? echo("value='".$discriminacao1."'")?>  disabled="disabled"/></td>
    <td><input name="vlunitario1" type="text" id="vlunitario1" size="10" maxlength="7" readonly="readonly" <? echo("value='".$vlunitario1."'")?>/></td>
    <td><input name="total1" type="text" id="total1" size="10" maxlength="7" readonly="readonly" <? echo("value='".number_format($quant1*$vlunitario1,2,",","")."'")?>/></td>
  </tr>
  <tr>
    <td><input name="quant2" type="text" id="quant2" size="5" maxlength="4" readonly="readonly" <? echo("value='".$quant2."'")?>/></td>
    <td><input name="cdproduto2" type="text" id="cdproduto2" size="10" maxlength="6" readonly="readonly" <? echo("value='".$cdproduto2."'")?>/></td>
    <td><input name="discriminacao2" type="text" id="discriminacao2" size="80" maxlength="80" <? echo("value='".$discriminacao2."'")?>  disabled="disabled"/></td>
    <td><input name="vlunitario2" type="text" id="vlunitario2" size="10" maxlength="7" readonly="readonly" <? echo("value='".$vlunitario2."'")?>/></td>
    <td><input name="total2" type="text" id="total2" size="10" maxlength="7" readonly="readonly" <? echo("value='".number_format($quant2*$vlunitario2,2,",","")."'")?>/></td>
  </tr>
  <tr>
    <td><input name="quant3" type="text" id="quant3" size="5" maxlength="4" readonly="readonly" <? echo("value='".$quant3."'")?>/></td>
    <td><input name="cdproduto3" type="text" id="cdproduto3" size="10" maxlength="6" readonly="readonly" <? echo("value='".$cdproduto3."'")?>/></td>
    <td><input name="discriminacao3" type="text" id="discriminacao3" size="80" maxlength="80" <? echo("value='".$discriminacao3."'")?>  disabled="disabled"/></td>
    <td><input name="vlunitario3" type="text" id="vlunitario3" size="10" maxlength="7" readonly="readonly" <? echo("value='".$vlunitario3."'")?>/></td>
    <td><input name="total3" type="text" id="total3" size="10" maxlength="7" readonly="readonly" <? echo("value='".number_format($quant3*$vlunitario3,2,",","")."'")?>/></td>
  </tr>
  <tr>
    <td><input name="quant4" type="text" id="quant4" size="5" maxlength="4" readonly="readonly" <? echo("value='".$quant4."'")?>/></td>
    <td><input name="cdproduto4" type="text" id="cdproduto4" size="10" maxlength="6" readonly="readonly" <? echo("value='".$cdproduto4."'")?>/></td>
    <td><input name="discriminacao4" type="text" id="discriminacao4" size="80" maxlength="80" <? echo("value='".$discriminacao4."'")?>  disabled="disabled"/></td>
    <td><input name="vlunitario4" type="text" id="vlunitario4" size="10" maxlength="7" readonly="readonly" <? echo("value='".$vlunitario4."'")?>/></td>
    <td><input name="total4" type="text" id="total4" size="10" maxlength="7" readonly="readonly" <? echo("value='".number_format($quant4*$vlunitario4,2,",","")."'")?>/></td>
  </tr>
  <tr>
    <td><input name="quant5" type="text" id="quant5" size="5" maxlength="4" readonly="readonly" <? echo("value='".$quant5."'")?>/></td>
    <td><input name="cdproduto5" type="text" id="cdproduto5" size="10" maxlength="6" readonly="readonly" <? echo("value='".$cdproduto5."'")?>/></td>
    <td><input name="discriminacao5" type="text" id="discriminacao5" size="80" maxlength="80" <? echo("value='".$discriminacao5."'")?>  disabled="disabled"/></td>
    <td><input name="vlunitario5" type="text" id="vlunitario5" size="10" maxlength="7" readonly="readonly" <? echo("value='".$vlunitario5."'")?>/></td>
    <td><input name="total5" type="text" id="total5" size="10" maxlength="7" readonly="readonly" <? echo("value='".number_format($quant5*$vlunitario5,2,",","")."'")?>/></td>
  </tr>
  <tr>
    <td><input name="quant6" type="text" id="quant6" size="5" maxlength="4" readonly="readonly" <? echo("value='".$quant6."'")?>/></td>
    <td><input name="cdproduto6" type="text" id="cdproduto6" size="10" maxlength="6" readonly="readonly" <? echo("value='".$cdproduto6."'")?>/></td>
    <td><input name="discriminacao6" type="text" id="discriminacao6" size="80" maxlength="80" <? echo("value='".$discriminacao6."'")?>  disabled="disabled"/></td>
    <td><input name="vlunitario6" type="text" id="vlunitario6" size="10" maxlength="7" readonly="readonly" <? echo("value='".$vlunitario6."'")?>/></td>
    <td><input name="total6" type="text" id="total6" size="10" maxlength="7" readonly="readonly" <? echo("value='".number_format($quant6*$vlunitario6,2,",","")."'")?>/></td>
  </tr>
  <tr>
    <td><input name="quant7" type="text" id="quant7" size="5" maxlength="4" readonly="readonly" <? echo("value='".$quant7."'")?>/></td>
    <td><input name="cdproduto7" type="text" id="cdproduto7" size="10" maxlength="6" readonly="readonly" <? echo("value='".$cdproduto7."'")?>/></td>
    <td><input name="discriminacao7" type="text" id="discriminacao7" size="80" maxlength="80" <? echo("value='".$discriminacao7."'")?>  disabled="disabled"/></td>
    <td><input name="vlunitario7" type="text" id="vlunitario7" size="10" maxlength="7" readonly="readonly" <? echo("value='".$vlunitario7."'")?>/></td>
    <td><input name="total7" type="text" id="total7" size="10" maxlength="7" readonly="readonly" <? echo("value='".number_format($quant7*$vlunitario7,2,",","")."'")?>/></td>
  </tr>
  <tr>
    <td><input name="quant8" type="text" id="quant8" size="5" maxlength="4" readonly="readonly" <? echo("value='".$quant8."'")?>/></td>
    <td><input name="cdproduto8" type="text" id="cdproduto8" size="10" maxlength="6" readonly="readonly" <? echo("value='".$cdproduto8."'")?>/></td>
    <td><input name="discriminacao8" type="text" id="discriminacao8" size="80" maxlength="80" <? echo("value='".$discriminacao8."'")?>  disabled="disabled"/></td>
    <td><input name="vlunitario8" type="text" id="vlunitario8" size="10" maxlength="7" readonly="readonly" <? echo("value='".$vlunitario8."'")?>/></td>
    <td><input name="total8" type="text" id="total8" size="10" maxlength="7" readonly="readonly" <? echo("value='".number_format($quant8*$vlunitario8,2,",","")."'")?>/></td>
  </tr>
  <tr>
    <td><input name="quant9" type="text" id="quant9" size="5" maxlength="4" readonly="readonly" <? echo("value='".$quant9."'")?>/></td>
    <td><input name="cdproduto9" type="text" id="cdproduto9" size="10" maxlength="6" readonly="readonly" <? echo("value='".$cdproduto9."'")?>/></td>
    <td><input name="discriminacao9" type="text" id="discriminacao9" size="80" maxlength="80" <? echo("value='".$discriminacao9."'")?>  disabled="disabled"/></td>
    <td><input name="vlunitario9" type="text" id="vlunitario9" size="10" maxlength="7" readonly="readonly" <? echo("value='".$vlunitario9."'")?>/></td>
    <td><input name="total9" type="text" id="total9" size="10" maxlength="7" readonly="readonly" <? echo("value='".number_format($quant9*$vlunitario9,2,",","")."'")?>/></td>
  </tr>
  <tr>
    <td><input name="quant10" type="text" id="quant10" size="5" maxlength="4" readonly="readonly" <? echo("value='".$quant10."'")?>/></td>
    <td><input name="cdproduto10" type="text" id="cdproduto10" size="10" maxlength="6" readonly="readonly" <? echo("value='".$cdproduto10."'")?>/></td>
    <td><input name="discriminacao10" type="text" id="discriminacao10" size="80" maxlength="80" <? echo("value='".$discriminacao10."'")?>  disabled="disabled"/></td>
    <td><input name="vlunitario10" type="text" id="vlunitario10" size="10" maxlength="7" readonly="readonly" <? echo("value='".$vlunitario10."'")?>/></td>
    <td><input name="total10" type="text" id="total10" size="10" maxlength="7" readonly="readonly" <? echo("value='".number_format($quant10*$vlunitario10,2,",","")."'")?>/></td>
  </tr>
  <?
  $vlnota=number_format(($quant1*$vlunitario1)+($quant2*$vlunitario2)+($quant3*$vlunitario3)+($quant4*$vlunitario4)+($quant5*$vlunitario5)+($quant6*$vlunitario6)+($quant7*$vlunitario7)+($quant8*$vlunitario8)+($quant9*$vlunitario9)+($quant10*$vlunitario10)-$desconto,2,",","");
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">Descontos</td>
    <td><input name="desconto" type="text" id="desconto" size="10" maxlength="7" readonly="readonly" <? echo("value='".$desconto."'")?>/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">Total da nota</td>
    <td><input name="vlnota" type="text" id="vlnota" size="10" maxlength="7" readonly="readonly" <? echo("value='".$vlnota."'")?>/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><a href="javascript:history.back()">Voltar a p�gina anterior</a></td>
    <td><label>
      <input type="submit" name="Incluir" id="Incluir" value="Incluir" />
    </label></td>
    <td><input name="modo" type="hidden" id="modo" value="incluir" />
      <input name="cdloja" type="hidden" id="cdloja" <? echo"value=".$cdloja; ?> /></td>
  </tr>
</table>
<p>&nbsp;</p>
</form>
<p>&nbsp;</p>
</body>
</html>
 