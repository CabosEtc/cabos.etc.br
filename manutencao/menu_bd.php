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
<td><h3>BD</h3></td>
  </tr>
  <tr>
    <td height="20" style="padding-left:20px">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" style="padding-left:20px">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" style="padding-left:20px"><a href="../manutencao/Snapshot.php">Listar instantaneo das pendencias (Snapshot)</a></td>
  </tr>
  <tr>
    <td height="20" style="padding-left:20px">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" style="padding-left:20px"><a href="../manutencao/precos_bd_desativados.php">Listar produtos desativados no BD em ambas as lojas</a></td>
  </tr>
  <tr>
    <td height="20" style="padding-left:20px">&nbsp;</td>
  </tr>
    <tr>
    <td height="20" style="padding-left:20px"><a href="../manutencao/Duploativo.php">Listar produtos ativos no BD em ambas as lojas (Duploativo)</a></td>
  </tr>
  <tr>
    <td height="20" style="padding-left:20px">&nbsp;</td>
  </tr><tr>
    <td height="20" style="padding-left:20px"><a href="../manutencao/precos_bd_cadastro_link.php">Cadastrar novo produto na pesquisa</a></td>
  </tr>
  <tr>
    <td height="20" style="padding-left:20px">&nbsp;</td>
  </tr>
</table>
</body>
</html>
