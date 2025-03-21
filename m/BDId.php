<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="manutencao.css">
<title>BDId</title>
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

//Variaveis
$cdsubcategoria=$_REQUEST["cdsubcategoria"];

//Inclui o menu
include("mmenu.php");   

$only_actives=$_REQUEST["only_actives"];

IF($only_actives=="0" and $cdloja==1){
  $clausula_where="WHERE flag_ativo='0'";
}

IF($only_actives=="0" and $cdloja==4){
  $clausula_where="WHERE flag_ativosg='0'";
}

IF($only_actives=="1" and $cdloja==1){
  $clausula_where="WHERE flag_ativo='1'";
}

IF($only_actives=="1" and $cdloja==4){
  $clausula_where="WHERE flag_ativosg='1'";
}

IF($only_actives=="2" and $cdloja==1){
  $clausula_where="WHERE flag_ativo='2'";
}

IF($only_actives=="2" and $cdloja==4){
  $clausula_where="WHERE flag_ativosg='2'";
}
IF($only_actives=="X" OR $only_actives==""){
  $clausula_where="WHERE 1=1";
}

if($cdsubcategoria<>"") {
$clausula_where=$clausula_where." AND produtos.cdsubcategoria='$cdsubcategoria' ";
}

echo "<br>";






echo "<table><tr><td><h3>Relatorio de produtos cadastrados para pesquisa no BD</h3></td>
<td><A HREF='BDId.php?only_actives=1'><IMG SRC='../imagens/power_on.gif'/></A></td>
<td><A HREF='BDId.php?only_actives=0'><IMG SRC='../imagens/power_off.gif'/></A></td>
<td><A HREF='BDId.php?only_actives=2'><IMG SRC='../imagens/info.png'/></A></td>
<td><A HREF='BDId.php?only_actives=X'>X</A></td></tr></table>";





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
if($cdloja==1) {
$query="SELECT links_boadica.id, links_boadica.produto,  links_boadica.marca, links_boadica.cdproduto, links_boadica.localizador,
 links_boadica.flag_ativo, links_boadica.prioridade, links_boadica.link, produtos.cdsubcategoria, produtos.nome   
 FROM  links_boadica, produtos $clausula_where  AND links_boadica.cdproduto=produtos.cdproduto 
 ORDER BY links_boadica.prioridade DESC, links_boadica.produto";
}

if($cdloja==4) {
$query="SELECT links_boadica.id, links_boadica.produto,  links_boadica.marca, links_boadica.cdproduto, links_boadica.localizador,
 links_boadica.flag_ativosg, links_boadica.prioridade, links_boadica.link, produtos.cdsubcategoria, produtos.nome    
 FROM  links_boadica,produtos $clausula_where  AND links_boadica.cdproduto=produtos.cdproduto 
 ORDER BY links_boadica.prioridade DESC, links_boadica.produto";
}

$resultado = mysql_query($query,$conexao);



//echo $query."<BR><BR>";

$contador_item=0;
$contador_item_produtos_atualizaveis=0;



echo "<table>";
echo "<tr><td>Id</td><td>Cat</td><td>Código</td><td>Marca</td><td>Produto/Localizador</td><td>Codigo BD</td><td>Codigo</td><td>Ativo</td><td>Prioridade</td><td>BD</td></tr>";

//Incluida em 03Ago19 para permitir ocultar todas as lojas com um unico clique



while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
  $idproduto=$row[0]; 
	$produto=$row[1];
  $marca=$row[2];
  $cdproduto=$row[3]; 
	$localizador=$row[4];
  IF($localizador<>""){
    $produto=$produto."[$localizador]";
  }
	$flag_ativo=$row[5];
  //echo $flag_ativo."<br>";
  IF($flag_ativo=="1"){
    $link_ativo="<A HREF='BDPrecosRotinas.php?modo=altera_flag_ativo&idloja=$cdloja&idproduto=$idproduto&flag_ativo=0' target='_blank'><IMG SRC='../imagens/power_on.gif'/></A>";
  }
    ELSEIF($flag_ativo=="0"){
      $link_ativo="<A HREF='BDPrecosRotinas.php?modo=altera_flag_ativo&idloja=$cdloja&idproduto=$idproduto&flag_ativo=1' target='_blank'><IMG SRC='../imagens/power_off.gif'/></A>";
    }
    ELSEIF($flag_ativo=="2"){
      $link_ativo="<IMG SRC='../imagens/info.png'/>";
    }
    
  
  
  $prioridade=$row[6];
  $link=$row[7];
   $cdsubcategoria=$row[8];
   $nome=$row[9];
  $posicao=strrpos($link, '/p');
  $codigo_produto_boadica=substr($link,$posicao+1,7);
      //IF (($only_actives=="1" AND $flag_ativo=="1") OR ($only_actives==0 AND $flag_ativo=="0") OR ($only_actives=="X")){
      echo "<tr><td>$idproduto</td><td><a href='BDId.php?cdsubcategoria=$cdsubcategoria' target='_blank'>$cdsubcategoria</a></td>
		<td title='$nome'><a href='pinc.php?cdproduto=".$cdproduto."&modo=editar'>$cdproduto</a></td>      
      <td>$marca</td><td>$produto</td><td>$codigo_produto_boadica</td>
      <td><A href='BDPrecos.php?cdproduto=$cdproduto&showall=1'  TARGET='_blank'>$cdproduto</A></td><td>$link_ativo</td>
      <td>$prioridade</td><td><A TARGET='_blank' HREF='$link'><IMG SRC='../imagens/coruja.png'/></A></td></tr>";
      //}
	} // Fim da linha de exibicao do produto




  
//echo"<tr><td colspan='6'>Clique <a href='http://www.cabos.etc.br/manutencao/precos_bd.php?modo=pendentes' target='_blank'>Aqui</a> para atualizar todos os ($contador_item_produtos_atualizaveis) itens atualizaveis acima</td></tr>";
echo "</table>";

?>



</body>
</html>
