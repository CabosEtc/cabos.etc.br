<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Precos BD - Atualizações de hoje</title>


</head>


<body onload='timedCount()'>


<div id="txt">Texto</div>

<?
session_start();
//if (!isset($_SESSION["usuario"])){
//			echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
//	}

//Prepara conexao ao db
include("../conectadb.php");

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


echo "<br>";
//echo "<table width='960' align='center'><tr><td>"; // tabela estrutural externa



echo "<h3>Relatório de alterações de precos do Boadica</h3><br>";


$modo=$_REQUEST["modo"];
//if ($_SESSION["nivel"]<3){
//			echo "<meta http-equiv='refresh' content='0; url=../manutencao/mensagem.php?cdmensagem=1'>";
//	}
// permite que pagina externas sejam lidas
ini_set('allow_url_fopen', 1);

// seleciona os produtos no banco de dados links_boadica

// Escreve todas as categorias no inicio da pagina com link


$query="SELECT lojas_boadica.nome, links_boadica.produto, links_boadica_detalhes_lojas.preco, links_boadica_detalhes_lojas.data, links_boadica.link, links_boadica_detalhes_lojas.id_produto, lojas_boadica.flag_predio FROM links_boadica_detalhes_lojas, lojas_boadica, links_boadica
WHERE links_boadica_detalhes_lojas.id_loja=lojas_boadica.id_loja AND links_boadica_detalhes_lojas.id_produto=links_boadica.id AND DATE(
links_boadica_detalhes_lojas.data ) = CURDATE( ) ORDER BY links_boadica_detalhes_lojas.data DESC";
$resultado = mysql_query($query,$conexao);
//echo $query;
echo "<table>";
echo "<tr><td>data</td><td>Loja</td><td>Produto</td><td>Preço</td><td>Preço Cabos</td><td>Flag</td><td>Link</td></tr>";
while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	$loja=$row[0]; 
	$produto=$row[1]; 
	$preco=$row[2];
	$data=$row[3];
	$link=$row[4];
	$id_produto=$row[5];
	$flag_predio=$row[6];
	$query2="SELECT links_boadica_detalhes_lojas.preco
FROM links_boadica_detalhes_lojas
WHERE links_boadica_detalhes_lojas.id_loja=19 AND links_boadica_detalhes_lojas.id_produto=".$id_produto." ORDER BY links_boadica_detalhes_lojas.data DESC";
//echo $query2;
$resultado2 = mysql_query($query2,$conexao);
if(mysql_num_rows($resultado2)>0){
$preco_cabos=mysql_result($resultado2,0,0);
}	else {$preco_cabos=0;}
	IF($flag_predio==0){
		$cor="#FFA500";}
	IF($flag_predio==1){
		$cor="#FF0000";}
	IF($flag_predio==2){
		$cor="#0000FF";}
		echo "<tr><td>".$data."</td><td><DIV><FONT COLOR='".$cor."'>".$loja."</FONT></DIV></td><td>".$produto."</td><td>".$preco."</td><td align='right'>".$preco_cabos."</td><td>&nbsp;</td><td><a href='".$link."'  TARGET='_blank'>Link</a></td></tr>";
	}
echo "</table>";

?>



</body>
</html>
