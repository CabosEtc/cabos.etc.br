<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8">
<title>Id</title>


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

$only_actives=$_REQUEST["only_actives"];

IF($only_actives=="0"){
  $clausula_where="WHERE flag_ativo='0'";
}

IF($only_actives=="1"){
  $clausula_where="WHERE flag_ativo='1'";
}

IF($only_actives=="2"){
  $clausula_where="WHERE flag_ativo='2'";
}

IF($only_actives=="X" OR $only_actives==""){
  $clausula_where="";
}



echo "<br>";






echo "<table><tr><td><h3>Relatorio de produtos cadastrados para pesquisa no BD</h3></td><td><A HREF='../manutencao/id.php?only_actives=1'><IMG SRC='../imagens/power_on.gif'/></A></td><td><A HREF='../manutencao/id.php?only_actives=0'><IMG SRC='../imagens/power_off.gif'/></A></td><td><A HREF='../manutencao/id.php?only_actives=2'><IMG SRC='../imagens/info.png'/></A></td><td><A HREF='../manutencao/id.php?only_actives=X'>X</A></td></tr></table>";





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

$query="SELECT links_boadica.id, links_boadica.produto,  links_boadica.marca, links_boadica.cdproduto, links_boadica.localizador, links_boadica.flag_ativo, links_boadica.prioridade, links_boadica.link  FROM  links_boadica $clausula_where ORDER BY links_boadica.prioridade DESC, links_boadica.produto";

$resultado = mysql_query($query,$conexao);



//echo $query."<BR><BR>";

$contador_item=0;
$contador_item_produtos_atualizaveis=0;



echo "<table>";
echo "<tr><td>Id</td><td>Marca</td><td>Produto/Localizador</td><td>Codigo BD</td><td>Codigo</td><td>Ativo</td><td>Prioridade</td><td>BD</td></tr>";

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
    $link_ativo="<A HREF='../manutencao/precos_bd_rotinas.php?modo=altera_flag_ativo&idproduto=$idproduto&flag_ativo=0'><IMG SRC='../imagens/power_on.gif'/></A>";
  }
    ELSEIF($flag_ativo=="0"){
      $link_ativo="<A HREF='../manutencao/precos_bd_rotinas.php?modo=altera_flag_ativo&idproduto=$idproduto&flag_ativo=1'><IMG SRC='../imagens/power_off.gif'/></A>";
    }
    ELSEIF($flag_ativo=="2"){
      $link_ativo="<IMG SRC='../imagens/info.png'/>";
    }
    
  
  
  $prioridade=$row[6];
  $link=$row[7];
  $posicao=strrpos($link, '/p');
  $codigo_produto_boadica=substr($link,$posicao+1,7);
      //IF (($only_actives=="1" AND $flag_ativo=="1") OR ($only_actives==0 AND $flag_ativo=="0") OR ($only_actives=="X")){
      echo "<tr><td>$idproduto</td><td>$marca</td><td>$produto</td><td>$codigo_produto_boadica</td><td><A href='../manutencao/precos_bd.php?cdproduto=$cdproduto&showall=1'  TARGET='_blank'>$cdproduto</A></td><td>$link_ativo</td><td>$prioridade</td><td><A TARGET='_blank' HREF='$link'><IMG SRC='../imagens/coruja.png'/></A></td></tr>";
      //}
	} // Fim da linha de exibicao do produto




  
//echo"<tr><td colspan='6'>Clique <a href='http://www.cabos.etc.br/manutencao/precos_bd.php?modo=pendentes' target='_blank'>Aqui</a> para atualizar todos os ($contador_item_produtos_atualizaveis) itens atualizaveis acima</td></tr>";
echo "</table>";

?>



</body>
</html>
