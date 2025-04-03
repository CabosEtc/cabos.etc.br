<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manuten&ccedil;&atilde;o</title>
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
			//echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
	}
	*/
	$_SESSION["usuario"]="flavio";
	$_SESSION["nivel"]=4;
include("../manutencao/menu.php");

$dthoje=date("d/m/Y",strtotime("now"));

$produto=$_REQUEST["produto"];
$link=$_REQUEST["link"];
$marca=$_REQUEST["marca"];

?>
<br />
<table width="960" border="0" align="center">
  <tr>
<td><h3>Vendas</h3></td>
  </tr>

<form id='form4' name='form4' method='get' action='../manutencao/precos_bd_rotinas.php'>
<tr>
<td style='padding-left:20px'>Marca</td>
<td><input name='marca' type='text' id='marca' size='96' maxlength='20' value='<? echo $marca;?>'/></td>
</tr>
<tr>
  <td style='padding-left:20px'>Produto</td>
<td><input name='produto' type='text' id='produto' size='96' maxlength='512'  value='<? echo $produto;?>'/></td>
</tr>
<tr>
<td style='padding-left:20px'>Codigo do Produto</td>
<td><input name='cdproduto' type='text' id='cdproduto' size='10' maxlength='5' /></td>
</tr>
<tr>
<td style='padding-left:20px'>Descricao/Localizador</td>
<td><input name='localizador' type='text' id='localizador' size='96' maxlength='50' /></td>
</tr>
<tr>
<td style='padding-left:20px'>Link</td>
<td><input name='link' type='text' id='link' size='96' maxlength='256'  value='<? echo $link;?>'/></td>
</tr>
<input name='modo' type='hidden' id='modo' value='cadastrar_link' />
<tr>
<td style='padding-left:20px'>Status</td>
<td>
<select name="flag_ativo">
    <option value="0">Desativado</option>
    <option selected='selected' value="1">Ativo</option>
    <option value="2">Comparacao</option>
  </select>  
</td>  
</tr>
<tr><td>.</td><td><input type='submit' name='Ok3' id='Ok3' value='Ok' /></td></tr>
</form>
</table>
</body>
</html>
