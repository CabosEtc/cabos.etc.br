<?
header("Content-type: application/xml");
$cdproduto=$_REQUEST["cdproduto"];

//Prepara conexao ao db
	include("../conectadb.php");
?>	
<?
// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
  $cdloja = fgets($ponteiro, 4096);
}
fclose ($ponteiro);

$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);

?>
<?	
	$query="SELECT produtos.nome, precos.vlvenda FROM produtos, precos WHERE produtos.cdproduto=precos.cdproduto AND precos.cdproduto='".$cdproduto."' AND precos.cdloja='".$cdloja."'";
// SELECT produtos.nome, precos.vlvenda FROM produtos, precos WHERE produtos.cdproduto=precos.cdproduto AND precos.cdproduto='01016' AND precos.cdloja='1'
//echo $query;
$resultado = mysql_query($query,$conexao);
	$nome=mysql_result($resultado,0,0);
	$vlvenda=mysql_result($resultado,0,1);
?>
<?	
$xml="<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>\n";
$xml.="<produto>\n";
$xml.="<nome>".trim($nome)."</nome>\n"; 
$xml.="<valor>".trim($vlvenda)."</valor>\n"; 
$xml.="</produto>\n";
echo $xml;
?>
