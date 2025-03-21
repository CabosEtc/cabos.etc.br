<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="manutencao.css">
<title>BDPLojaX</title>
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

//Recebe variaveis
$modo=$_REQUEST["modo"];

//Inclui o menu
include("mmenu.php");   

$idloja=$_REQUEST["idloja"];
$arrayLojas = explode(",",$idloja);
$contador=0;
foreach($arrayLojas as $elemento)
{
  $queryNomeLoja="SELECT nome FROM lojas_boadica WHERE id_loja=$elemento";
  //echo "$queryNomeLoja<br>";
  $resultadoNomeLoja=mysql_query($queryNomeLoja,$conexao);
  $nomeLojaAtual=mysql_result($resultadoNomeLoja,0,0);
  //echo "$nomeLojaAtual<br>";
  if($contador==0){
    $nomeLojas=$nomeLojaAtual;
  }
  else
  {
    $nomeLojas=$nomeLojas.",".$nomeLojaAtual;
  }
  $contador=$contador+1;
}

$datapesquisa=$_REQUEST["datapesquisa"];
if($datapesquisa==""){
  $datapesquisa=$dthoje_eua;
}
echo "<br>";
?>
<form action="BDPrecosLojaX.php" method="get">
<input type="text" name="datapesquisa" value="<? echo $datapesquisa; ?>" />
<input type="hidden" name="idloja" value="<? echo $idloja; ?>" />
<select name="modo">
<option value='completo'>Completo</option>
<option value='compacto'>Compacto</option>
</select>
<input type="submit" name="ok" value="Buscar" />
</form>

<?



$query="SELECT nome FROM lojas_boadica  WHERE id_loja= $idloja";
$resultado = mysql_query($query,$conexao);
$nome_lojax=mysql_result($resultado,0,'nome');
echo "$nomeLojas [$datapesquisa]<br>";


$query="SELECT links_boadica_detalhes_snapshot.id_produto, links_boadica.cdproduto, links_boadica.produto,
 links_boadica_detalhes_snapshot.preco, links_boadica_detalhes_snapshot.data, links_boadica.marca, produtos.nome   
 FROM `links_boadica_detalhes_snapshot`, `produtos`, `links_boadica`  
 WHERE links_boadica_detalhes_snapshot.id_produto=links_boadica.id AND produtos.cdproduto=links_boadica.cdproduto 
 AND  links_boadica_detalhes_snapshot.id_loja IN ($idloja) AND links_boadica_detalhes_snapshot.data  
 LIKE '%$datapesquisa%' order by links_boadica.produto";
//echo $query;

$resultado = mysql_query($query,$conexao);




echo "<table>";


while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
  $idproduto=$row[0]; 
  $cdproduto=$row[1];
  $produto=$row[2]; 
	$preco=$row[3];
	$data=$row[4];
  $marca=$row[5];
  $nomeProdutoTabelaProdutos=$row[6];
  echo "<tr>";
  if($modo<>"compacto"){
    echo "<td>$idproduto</td><td><a href='BDPrecos.php?cdproduto=$cdproduto&showall=1'>$cdproduto</a></td>";
  }    
    echo "<td>$marca</td><td title='$nomeProdutoTabelaProdutos'>$produto</td><td>$preco</td>";
  if ($modo<>"compacto"){
    echo "<td>$data</td>";
  }
  echo "</tr>";
	} // Fim da linha de exibicao do produto

echo "</table>";

?>



</body>
</html>
