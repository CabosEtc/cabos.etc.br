<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>BBPrecosConsolidado</title>
</head>


<body>




<?

//Prepara conexao ao db
include("../conectadb.php");

$dtpesquisa=date("Ymd",strtotime("now"));
$cdproduto=$_REQUEST["cdproduto"];
$queryNomeProduto="SELECT nome from produtos WHERE cdproduto=$cdproduto";
$resultadoNomeProduto=mysql_query($queryNomeProduto, $conexao);
$nomeProdutoTabelaProdutos=mysql_result($resultadoNomeProduto,0,0);


$query="SELECT id from links_boadica WHERE flag_ativo IN (0,1,2) AND cdproduto IN ($cdproduto) ORDER BY id";
$resultado=mysql_query($query, $conexao);
$id_acumulado="";

while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	if($id_acumulado=="") {
		$id_acumulado=$row[0];
	}
	else {$id_acumulado=$id_acumulado.",".$row[0];
	}
}




//echo "$id_acumulado<br>";






echo "<h3 title='$id_acumulado'>Relatorio consolidado: $cdproduto ($nomeProdutoTabelaProdutos)</h3>";
echo "<div style='margin: 0 0 10px 0'>
      <a href='index.php' ><img src='../imagens/home.png' /></a>
      <a href='elisthistorico.php?cdproduto=$cdproduto' target='_blank'><img src='../imagens/lista.png' /></a>
      <a href='BDPrecos.php?cdproduto=$cdproduto&showall=1' target='_blank'><img src='../imagens/spy.png' /></a>
      </div>";





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

$query="SELECT links_boadica_detalhes_snapshot.id_loja, links_boadica_detalhes_snapshot.id_produto, 
 links_boadica_detalhes_snapshot.preco, lojas_boadica.nome, links_boadica.produto, links_boadica_detalhes_snapshot.data, 
 lojas_boadica.flag_predio, links_boadica.marca  
 FROM `links_boadica_detalhes_snapshot`, lojas_boadica, links_boadica 
 WHERE `id_produto` IN ($id_acumulado) AND LEFT(data,10)='$dthoje_eua' 
 AND links_boadica_detalhes_snapshot.id_loja=lojas_boadica.id_loja AND links_boadica_detalhes_snapshot.id_produto=links_boadica.id 
 ORDER BY preco";

$resultado = mysql_query($query,$conexao);



//echo $query."<BR><BR>";

$contador_item=0;
$contador_item_produtos_atualizaveis=0;



echo "<table>";
echo "<tr><td>Id</td><td>Hora</td><td>Marca</td><td>Produto</td><td>loja</td><td>Valor</td></tr>";

//Incluida em 03Ago19 para permitir ocultar todas as lojas com um unico clique



while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
  $idloja=$row[0]; 
	$idproduto=$row[1];
  $preco=$row[2];
  $loja=utf8_encode($row[3]); 
	$produto=$row[4]; 
	$hora=substr($row[5],11,8);
  $flag_predio=$row[6];
  if ($flag_predio=="0") {
    $cor_fonte="orange";
} elseif ($flag_predio=="1") {
    $cor_fonte="red";
} else {
    $cor_fonte="blue";
}
  $marca=$row[7];	

      echo "<tr><td align='right'><a href='../manutencao/precos_bd.php?inicio_id=$idproduto&limite=1'  TARGET='_blank'>$idproduto</a></td><td>$hora</td><td>$marca</td><td>$produto</td><td><FONT COLOR='$cor_fonte'>$loja</FONT></td><td>$preco</td></tr>";

	} // Fim da linha de exibicao do produto




  
//echo"<tr><td colspan='6'>Clique <a href='http://www.cabos.etc.br/manutencao/precos_bd.php?modo=pendentes' target='_blank'>Aqui</a> para atualizar todos os ($contador_item_produtos_atualizaveis) itens atualizaveis acima</td></tr>";
echo "</table>";

?>



</body>
</html>
