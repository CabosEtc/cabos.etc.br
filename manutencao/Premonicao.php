<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8">
<title>BDPremonicao</title>


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


$idloja=$_REQUEST["idloja"];
$data=$_REQUEST["data"];
IF($data==""){
  $data=$dthoje_eua;
}


echo "<br>";






echo "<table><tr><td><h3>Materiais ainda nao alterados em $data</h3></td></tr></table>";





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

$query="SELECT links_boadica_detalhes_snapshot.id_produto, links_boadica.produto, links_boadica.cdproduto FROM `links_boadica_detalhes_snapshot`,links_boadica WHERE links_boadica_detalhes_snapshot.id_loja='$idloja' AND LEFT(links_boadica_detalhes_snapshot.data,10)='$data' AND links_boadica.id=links_boadica_detalhes_snapshot.id_produto ORDER BY links_boadica_detalhes_snapshot.id_produto";

$resultado = mysql_query($query,$conexao);
$quantidade=mysql_numrows($resultado);

echo "Itens ativos: $quantidade<br>";




echo "<table>";
echo "<tr><td>Id</td><td>Produto</td><td>Codigo</td></tr>";

//Incluida em 03Ago19 para permitir ocultar todas as lojas com um unico clique



while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
  $idproduto=$row[0];
  $produto=$row[1];
  $cdproduto=$row[2];
  
    $queryLookUp="SELECT links_boadica_detalhes_lojas.id_produto  FROM links_boadica_detalhes_lojas WHERE links_boadica_detalhes_lojas.id_produto='$idproduto' AND links_boadica_detalhes_lojas.id_loja='$idloja' AND LEFT(links_boadica_detalhes_lojas.data,10)='$data'";
    //ECHO "$queryLookUp<br>";
    $resultadoLookUp = mysql_query($queryLookUp,$conexao);
    $ocorrencias=mysql_num_rows($resultadoLookUp);
    //ECHO "$ocorrencias<br>";
    IF ($ocorrencias==1){
      echo "<tr><td>$idproduto</td><td>$produto</td><td>$cdproduto</td></tr>";
    }
  
      
	} // Fim da linha de exibicao do produto




  
//echo"<tr><td colspan='6'>Clique <a href='http://www.cabos.etc.br/manutencao/precos_bd.php?modo=pendentes' target='_blank'>Aqui</a> para atualizar todos os ($contador_item_produtos_atualizaveis) itens atualizaveis acima</td></tr>";
echo "</table>";

?>



</body>
</html>
