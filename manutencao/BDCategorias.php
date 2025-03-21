<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8">
<title>BDCategorias</title>


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





echo "<br>";






echo "<table><tr><td><h3>Pesquisa rapida por Categorias</h3></td></tr></table>";





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

$query="SELECT `bd_linkcategoria`.`id`,`bd_linkcategoria`.`link`,`bd_linkcategoria`.`descricao`   FROM  `bd_linkcategoria` ORDER BY `bd_linkcategoria`.`id`";

$resultado = mysql_query($query,$conexao);






echo "<table>";
echo "<tr><td>Id</td><td>BD</td><td>Link</td><td>Descricao</td></tr>";

//Incluida em 03Ago19 para permitir ocultar todas as lojas com um unico clique



while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
  $id=$row[0]; 
	$link=$row[1];
  $descricao=$row[2];
  
      echo "<tr><td>$id</td><td><a href='$link' target='_blank'><img src='../imagens/coruja.png' /></a><td><a href='../manutencao/pbdcat.php?cat=$id'><img src='../imagens/refresh.png' /></a></td><td>$descricao</td></tr>";
	} // Fim da linha de exibicao do produto




  
//echo"<tr><td colspan='6'>Clique <a href='http://www.cabos.etc.br/manutencao/precos_bd.php?modo=pendentes' target='_blank'>Aqui</a> para atualizar todos os ($contador_item_produtos_atualizaveis) itens atualizaveis acima</td></tr>";
echo "</table>";

?>



</body>
</html>
