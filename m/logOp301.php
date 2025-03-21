<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="manutencao.css">
<title>Produtos não cadastrados</title>
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


//Prepara conexao ao db
include("../conectadb.php");

//Variaveis
$cdcategoria=$_REQUEST["cdcategoria"];
if($cdcategoria<>""){
    $clausulaCategoria=" inf2='$cdcategoria' ";
}
else{
    $clausulaCategoria=" 1=1 ";
}

//Inclui o menu
include("mmenu.php");   

echo "<br>";






echo "<h3>Relatorio de produtos não cadastrados para pesquisa no BD</h3>";


//ini_set('allow_url_fopen', 1);

if($cdloja==1) {
$query="SELECT inf1, inf2, inf3, inf4, inf5, data, idlog     
        FROM  log
        WHERE loja=$cdloja  AND codigo=301 
        AND $clausulaCategoria
        ORDER BY inf2 asc, data desc, inf3 asc";
}


$resultado = mysql_query($query,$conexao);



//echo $query."<BR><BR>";

$contador_item=0;
$contador_item_produtos_atualizaveis=0;



echo "  <table>
            <tr>
                <td>
                    Data
                </td>
                <td>
                    Anúncio
                </td>
                <td>
                    Id Categoria
                </td>
                <td>
                    Pag
                </td>
                <td>
                    Origem
                </td>
                <td colspam='2'>
                    &nbsp
                </td>
                <td>
                    Nome
                </td>
            </tr>";

//Incluida em 03Ago19 para permitir ocultar todas as lojas com um unico clique



while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
    $idAnuncio=$row[0]; 
    $idCategoria=$row[1];
    $pagina=$row[2];
    $origem=$row[3]; 
	$nomeProduto=$row[4];
    $dataInclusao=substr($row[5],0,10);
    $idLog=$row[6];

      echo "<tr>                
                <td align='right'>
                    $dataInclusao
                </td>
                <td>
                    <a href='BDCadastroLink.php?id=$idAnuncio' TARGET='_blank'>$idAnuncio</a>
                </td>

                <td align='right'>
                    <a href='http://cabos.etc.br/m/logOp301.php?cdcategoria=$idCategoria'>$idCategoria</a>
                </td>
                <td align='right'>
                    $pagina
                </td>      
                <td>
                    $origem
                </td>
                <td>
                    <a href='https://boadica.com.br/produtos/$idAnuncio' target='_blank'><img src='../imagens/coruja.png' width='16' height='16' /></a>
                </td>
                <td>
                <a href='prot.php?modo=apagarLogProdutoNaoCadastrado&idlog=$idLog' target='_blank'><img src='../imagens/trash.png' width='16' heigtht='16' /></a>
                </td>
                <td>
                    $nomeProduto
                </td>
            </tr>";
	} // Fim da linha de exibicao do produto


echo "</table>";

?>



</body>
</html>
