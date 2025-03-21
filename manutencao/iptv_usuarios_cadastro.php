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

?>
<br />
<table width="960" border="0" align="center">
  <tr>
<td><h3>Vendas</h3></td>
  </tr>

<form id='form4' name='form4' method='get' action='../manutencao/iptv_rotinas.php'>
<tr>
<td style='padding-left:20px'>Id do usuario</td>
<td><input name='id' type='text' id='id' size='10' maxlength='6' /></td>
</tr>
<tr>
  <td style='padding-left:20px'>Nome</td>
<td><input name='nome' type='text' id='nome' size='50' maxlength='50' /></td>
</tr>
<tr>
<td style='padding-left:20px'>Telefone (xx)xxxxxxxxx</td>
<td><input name='telefone' type='text' id='telefone' size='15' maxlength='13' /></td>
</tr>
<tr>
<td style='padding-left:20px'>Senha</td>
<td><input name='senha' type='text' id='senha' size='10' maxlength='8' /></td>
</tr>
<tr>
<td style='padding-left:20px'>Adulto (0) - Nao (1) - Sim</td>
<td><input name='adulto' type='text' id='adulto' size='10' maxlength='1' /></td>
</tr>
<input name='modo' type='hidden' id='modo' value='cadastrar_usuario' />
<tr><td>.</td><td><input type='submit' name='Ok3' id='Ok3' value='Ok' /></td></tr>
</form>
</table>
</body>
</html>
