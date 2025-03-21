<link href="../cabos.css" rel="stylesheet" type="text/css" />
<?
$periodo=date("m/Y",strtotime("now"));
//Prepara conexao ao db
include("../conectadb.php");

// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
$cdloja = fgets($ponteiro, 4096);
}
fclose ($ponteiro);

$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);

// recupera cor dos menus
$query="SELECT cor_menu FROM parametros WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$cor_menu=mysql_result($resultado,0,0);
?>
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="40" colspan="5" align="center" bgcolor="<? echo $cor_menu; ?>"><h3>Menu do sistema - <? echo $nomeloja; ?></h3></td><td colspan="2" align="right" bgcolor="<? echo $cor_menu; ?>" style="padding-right:30px;"><? if(ISSET($_SESSION["usuario"])){echo ($_SESSION["usuario"]."(".$_SESSION["nivel"].") <a href='../manutencao/login.php?modo=logoff'>[Sair]</a>");}?></td>
  </tr>
  <tr>
    <td width="150" height="10" bgcolor="<? echo $cor_menu; ?>"><a href="../manutencao/index.php" target="_self">Principal</a></td>
    <td width="150" bgcolor="<? echo $cor_menu; ?>"><a href="../manutencao/vendas.php">Incluir nota</a></td>
    <td width="150" bgcolor="<? echo $cor_menu; ?>"><a href="../manutencao/produtos_lista.php" target="_blank">Produtos</a></td>
    <td width="150" bgcolor="<? echo $cor_menu; ?>"><p><a href="../manutencao/links.php">Links importantes</a></p></td>
    <td width="150" bgcolor="<? echo $cor_menu; ?>"><? echo "<a href='../manutencao/menu_iptv.php'>IPTV</a>"; ?></td>
    <td width="150" bgcolor="<? echo $cor_menu; ?>"><? echo "<a href='../manutencao/menu_bd.php'>BD</a>"; ?></td>
    <td width="150" bgcolor="<? echo $cor_menu; ?>"><? if($_SESSION["nivel"]==5){echo ("<a href='../manutencao/cartao_listar_compras.php?periodo=<? echo $periodo; ?>&amp;modo=listar_todas_compras&amp;Ok2=Ok' target='_blank'>Compras deste m&ecirc;s</a>");} ?></td>
    
  </tr>
</table>
