<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manuten&ccedil;&atilde;o</title>
</head>

<script>

function mouseOver(src, clr) {

  src.style.cursor = 'hand';

  src.bgColor = clr;

}



function mouseOut(src, clr) {

  src.style.cursor = 'default';

  src.bgColor = clr;

}



function mouseClick(id, nome) {

  confirma = confirm("Incluir o produto "+nome+" na sua loja?");

  if (confirma) 

      document.location = 'precos.cad_produtos2.php?cdproduto='+id;

}

</script>

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
  $linha = fgets($ponteiro, 4096);
  $cdloja=$linha;

}
fclose ($ponteiro);

$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);

?>

<?
session_start();
/*if (!isset($_SESSION["usuario"])){
			echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
	}
	*/
		$_SESSION["usuario"]="flavio";
	$_SESSION["nivel"]="4";
include("../manutencao/menu.php");
?>
<br>
<form action="../manutencao/precos_cadprodutos.php" method="get">
<table width="500" border="1" align="center">
  <tr>
    <td>
      Fabricante: 
      
<?      $query="SELECT cdfabricante, nome FROM fabricantes ORDER BY nome ASC";
		$resultado = mysql_query($query,$conexao);
		echo "<select name='fabricante' id='fabricante'>";
		while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
			$cdfabricante=$row[0]; // nome da categoria
			$nomefabricante=$row[1]; // nome da categoria
			echo "<option value='".$cdfabricante."'>".$nomefabricante."</option>";
		}
		echo "</select>";
?>    
	</td>
    <td><input name="modo" type="submit" value="Enviar" id="modo" />
    </td>
  </tr>
</table>
</form>
<?
$modo=$_REQUEST["modo"];
$cdproduto=$_REQUEST["cdproduto"];


?>

<?
$query="SELECT produtos.cdproduto, produtos.nome, fabricantes.nome FROM produtos, fabricantes WHERE produtos.cdproduto='".$cdproduto."'";
	   // echo $query;
		$resultado = mysql_query($query,$conexao);
		while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
			$cdproduto=$row[0]; // nome da categoria
			$nomeproduto=$row[1]; // nome da categoria
			$nomefabricante=$row[2]; // nome da categoria
		}
?>

<form action="../manutencao/precos_cadprodutos2_rotinas.php" method="get">
<table width="960" border="0" align="center" style="padding-top:100px">
  <tr>
    <td>
    <? echo "<img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto.".jpg' width='150' height='150' />"; ?>
    </td>
    <td><? echo $cdproduto." - ".$nomeproduto; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="hidden" name="cdproduto" id="cdproduto" value="<? echo $cdproduto;?>" /></td>
  </tr>
  <tr>
    <td>Valor de compra</td>
    <td><label>
      <input type="text" name="vlcompra" id="vlcompra" />
      (em reais)
    </label></td>
  </tr>
  <tr>
    <td>Valor de venda</td>
    <td><input type="text" name="vlvenda" id="vlvenda" /> 
      (em reais)</td>
  </tr>
  <tr>
    <td>Garantia</td>
    <td><input type="text" name="garantia" id="garantia" value="90" /> 
      (em dias)</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><label>
      <input type="submit" name="modo2" id="modo2" value="Enviar" />
    </label></td>
  </tr>
</table>
</form>
</body>
</html>
