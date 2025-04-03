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
//$cdsubcategoria=$_REQUEST["cdsubcategoria"];

//Inclui o menu
include("mmenu.php");   

echo "<br>";






echo "<h3>Relatorio de anuncios com preço muito abaixo da concorrência</h3>";


//ini_set('allow_url_fopen', 1);

if($cdloja==1) {
$query="SELECT inf1, inf2, inf3, inf4, inf5, data, idlog     
        FROM  log
        WHERE loja=$cdloja  AND codigo=302 
        ORDER BY data desc, inf2 asc
        LIMIT 0,20";
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
                    Id anuncio
                </td>
                <td>
                    Nosso preço
                </td>
                <td>
                    Concorrência
                </td>
                <td>
                    &nbsp
                </td>
            </tr>";

//Incluida em 03Ago19 para permitir ocultar todas as lojas com um unico clique



while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
    $idLink=$row[0]; 
    $nossoPreco=$row[1];
    $precoConcorrencia=$row[2];
    //$origem=$row[3]; 
	//$nomeProduto=$row[4];
    $dataInclusao=substr($row[5],0,10);
    $idLog=$row[6];

      echo "<tr>                
                <td align='right'>
                    $dataInclusao
                </td>
                <td align='right'>
                    <a href='http://www.cabos.etc.br/m/BDPrecos.php?inicio_id=$idLink&limite=1' target='_blank'>$idLink</a>
                </td>

                <td>
                    $nossoPreco
                </td>
  
                <td>
                    $precoConcorrencia
                </td>
                <td>
                    <a href='prot.php?modo=apagarLogProdutoNaoCadastrado&idlog=$idLog' target='_blank'><img src='../imagens/trash.png' width='16' heigtht='16' /></a>
                </td>
            </tr>";
	} // Fim da linha de exibicao do produto

/*
                <td>
                    <a href='https://boadica.com.br/produtos/$idAnuncio' target='_blank'><img src='../imagens/coruja.png' width='16' height='16' /></a>
                </td>
                <td>
                    $nomeProduto
                </td>

*/

echo "</table>";

?>



</body>
</html>
