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

<? include("../manutencao/menu.php");?>

<?
$dtmovimento=date("d/m/Y",strtotime("now"));
?>

<br />
<table width="960" border="0" align="center">
  <tr>
    <td><h3>Contagem de Produtos em estoque 
       (Loja)<br />
      <br />
    </h3>
    <form action="../manutencao/estoque_contagem_comparacao.php" method="get">
      <table width="500" border="0" align="center">
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Data da contagem</td>
          <td><input type="text" name="dtmovimento" id="dtmovimento" value="<? echo $dtmovimento; ?>"/></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td>Codigo do produto</td>
          <td>Quantidade</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><input name="cdproduto1" type="text" id="cdproduto1" maxlength="5" /></td>
          <td><input name="quantidade1" type="text" id="quantidade1" maxlength="5" /></td>
          </tr>
        <tr>
          <td><input name="cdproduto2" type="text" id="cdproduto2" maxlength="5" /></td>
          <td><input name="quantidade2" type="text" id="quantidade2" maxlength="5" /></td>
        </tr>
        <tr>
          <td><input name="cdproduto3" type="text" id="cdproduto3" maxlength="5" /></td>
          <td><input name="quantidade3" type="text" id="quantidade3" maxlength="5" /></td>
        </tr>
        <tr>
          <td><input name="cdproduto4" type="text" id="cdproduto4" maxlength="5" /></td>
          <td><input name="quantidade4" type="text" id="quantidade4" maxlength="5" /></td>
        </tr>
        <tr>
          <td><input name="cdproduto5" type="text" id="cdproduto5" maxlength="5" /></td>
          <td><input name="quantidade5" type="text" id="quantidade5" maxlength="5" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><input name="modo" type="hidden" id="modo" value="contagem_loja" /></td>
          <td><label>
            <input type="submit" name="btnEnviar" id="btnEnviar" value="Enviar" />
          </label></td>
        </tr>
      </table> 
      </form>

</td>
</tr>
</table>
</body>
</html>
