<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8">
<title>Estatisticas</title>


</head>

<style>

/* Demos styles. Remove if desired */

/* demo #1 textarea */

.control-copytextarea{
  cursor: pointer;
}

/* demo #2 input text with control */

#select2{
  line-height: 25px;
  font-size: 105%;
	width: 95%;
	max-width: 500px;
  margin: 0;
}

.control-copyinput{
  cursor: pointer;
  font-weight: bold;
  padding:3px 10px;
  border-radius: 8px;
  background: darkred;
  color: white;
  display: inline-block;
  box-shadow: 0 0 3px gray;
  line-height: 25px;
}

/* demo #3 input text only */

fieldset{
	width: 95%;
	background: lightyellow;
	max-width: 600px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}

#select3{
  font-size: 105%;
  margin: 0;
	width: 90%;
	max-width: 500px;
}

/* demo #4 regular div */

#select4{
	width: 200px;
	padding: 5px;
}

.control-copydiv{
  cursor: pointer;
}

</style>

<body onload='timedCount()'>




<script src="fieldtoclipboard.js">

/***********************************************
* Select (and copy) Form Element Script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Add this script to the very END of your page, right above the </body> tag if possible
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script>


<?
session_start();
//if (!isset($_SESSION["usuario"])){
//			echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
//	}

//Prepara conexao ao db
include("../conectadb.php");

// Ajusta hora do servidor
date_default_timezone_set('America/Sao_Paulo');

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

$dthoje_eua=date("Y-m-d",strtotime("now"));
$dtpesquisa=date("Ymd",strtotime("now"));

$idproduto=$_REQUEST["idproduto"];
$idloja=$_REQUEST["idloja"];



echo "<h3>Relatorio de atualizacao deste produto nos ultimos 7 dias</h3><br>";






//if ($_SESSION["nivel"]<3){
//			echo "<meta http-equiv='refresh' content='0; url=../manutencao/mensagem.php?cdmensagem=1'>";
//	}
// permite que pagina externas sejam lidas
ini_set('allow_url_fopen', 1);

// seleciona os produtos no banco de dados links_boadica

// Escreve todas as categorias no inicio da pagina com link


/*

IF ($modo=="hora"){
$query="SELECT lojas_boadica.nome, links_boadica.produto, links_boadica_detalhes_lojas.preco, links_boadica_detalhes_lojas.data, links_boadica.link, links_boadica_detalhes_lojas.id_produto, lojas_boadica.flag_predio, links_boadica.cdproduto, links_boadica.flag_ativo, links_boadica.marca, links_boadica.id, links_boadica.flag_ativo_boadica FROM links_boadica_detalhes_lojas, lojas_boadica, links_boadica
WHERE links_boadica_detalhes_lojas.id_loja=lojas_boadica.id_loja AND links_boadica_detalhes_lojas.id_produto=links_boadica.id AND DATE(
links_boadica_detalhes_lojas.data ) = $data $clausula_query_only_actives  ORDER BY links_boadica_detalhes_lojas.data DESC";
}
ELSE {
$query="SELECT lojas_boadica.nome, links_boadica.produto, links_boadica_detalhes_lojas.preco, links_boadica_detalhes_lojas.data, links_boadica.link, links_boadica_detalhes_lojas.id_produto, lojas_boadica.flag_predio, links_boadica.cdproduto, links_boadica.flag_ativo, links_boadica.marca, links_boadica.id, links_boadica.flag_ativo_boadica FROM links_boadica_detalhes_lojas, lojas_boadica, links_boadica
WHERE links_boadica_detalhes_lojas.id_loja=lojas_boadica.id_loja AND links_boadica_detalhes_lojas.id_produto=links_boadica.id AND DATE(
links_boadica_detalhes_lojas.data ) = $data $clausula_query_only_actives ORDER BY links_boadica.produto, links_boadica_detalhes_lojas.data DESC";}

*/

$query="SELECT links_boadica_detalhes_lojas.data, links_boadica_detalhes_lojas.preco FROM links_boadica_detalhes_lojas WHERE id_produto=$idproduto AND id_loja=$idloja AND DATA>DATE_SUB(CURRENT_TIMESTAMP(),INTERVAL 168 HOUR)"; // 168h = 7 dias

$resultado = mysql_query($query,$conexao);



//echo $query."<BR><BR>";




echo "<table>";
echo "<tr><td>Data</td><td>Hora</td><td>Valor</td></tr>";

//Incluida em 03Ago19 para permitir ocultar todas as lojas com um unico clique



while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
  $data=$row[0];
  $dtformatada=date("d/m",strtotime("$data"));
	$hrformatada=date("H:i",strtotime("$data"));
	$valor=$row[1];
  
      echo "<tr><td>$dtformatada</td><td>$hrformatada</td><td>$valor</td></tr>";

	} // Fim da linha de exibicao do produto





  
//echo"<tr><td colspan='6'>Clique <a href='http://www.cabos.etc.br/manutencao/precos_bd.php?modo=pendentes' target='_blank'>Aqui</a> para atualizar todos os ($contador_item_produtos_atualizaveis) itens atualizaveis acima</td></tr>";
echo "</table>";

$query="SELECT links_boadica_detalhes_lojas.data FROM links_boadica_detalhes_lojas WHERE id_loja=$idloja AND DATA>DATE_SUB(CURRENT_TIMESTAMP(),INTERVAL 168 HOUR)"; // 168h = 7 dias

$resultado = mysql_query($query,$conexao);

while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
  $data=$row[0]; 
	$hora=substr($data,11,2);
  //echo $hora."<br>";
  
  IF ($hora=="08"){
    $hora08++;
  }
  IF ($hora=="09"){
    $hora09++;
  }
  IF ($hora=="10"){
    $hora10++;
  }
  IF ($hora=="11"){
    $hora11++;
  }
  IF ($hora=="12"){
    $hora12++;
  }
  IF ($hora=="13"){
    $hora13++;
  }
  IF ($hora=="14"){
    $hora14++;
  }
  IF ($hora=="15"){
    $hora15++;
  }
  IF ($hora=="16"){
    $hora16++;
  }
  IF ($hora=="17"){
    $hora17++;
  }
  IF ($hora=="18"){
    $hora18++;
  }
  IF ($hora=="19"){
    $hora19++;
  }
  IF ($hora=="20"){
    $hora20++;
  }
  IF ($hora=="21"){
    $hora21++;
  }
  IF ($hora=="22"){
    $hora22++;
  }
  IF ($hora=="23"){
    $hora23++;
  }
  
  
      //echo "<tr><td></td><td>&nbsp</td></tr>";

	} // Fim da linha de exibicao do produto
$cor="blue";
$caracter="O";

//echo "<BR>";
echo "<h3>Estatisticas de todos os produtos</h3><br>";
//echo "<BR>";

echo "08AM ";
$i = 1;
while ($i <= $hora08) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";

echo "09AM ";
$i = 1;
while ($i <= $hora09) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";

echo "10AM ";
$i = 1;
while ($i <= $hora10) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";

echo "11AM ";
$i = 1;
while ($i <= $hora11) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";

echo "12PM ";
$i = 1;
while ($i <= $hora12) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";

echo "01PM ";
$i = 1;
while ($i <= $hora13) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";

echo "02PM ";
$i = 1;
while ($i <= $hora14) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";

echo "03PM ";
$i = 1;
while ($i <= $hora15) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";

echo "04PM ";
$i = 1;
while ($i <= $hora16) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";

echo "05PM ";
$i = 1;
while ($i <= $hora17) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";

echo "06PM ";
$i = 1;
while ($i <= $hora18) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";

echo "07PM ";
$i = 1;
while ($i <= $hora19) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";

echo "08PM ";
$i = 1;
while ($i <= $hora20) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";

echo "09PM ";
$i = 1;
while ($i <= $hora21) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";

echo "10PM ";
$i = 1;
while ($i <= $hora22) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";

echo "11PM ";
$i = 1;
while ($i <= $hora23) {
    echo "<FONT COLOR='$cor'>$caracter</FONT>";
    $i++;
}
ECHO "<BR>";



?>



</body>
</html>
