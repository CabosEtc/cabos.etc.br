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






echo "<h3>Relatorio de Anuncios do BD</h3>";


//ini_set('allow_url_fopen', 1);

if($cdloja==1) {
$query="SELECT idanunciobd, alterado, publicado, data, valor, marca, nome         
        FROM  bd_mysnapshot 
        WHERE idloja=19 
        ORDER BY id";
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
                    Loja 1
                </td>
                <td>
                    Loja 2
                </td>
                <td>
                    idLinkBD
                </td>
                <td>
                    &nbsp;
                </td>
                <td>
                    Valor
                </td>
                <td>
                    Marca
                </td>                
                <td>
                    Nome
                </td>
            </tr>";

//Incluida em 03Ago19 para permitir ocultar todas as lojas com um unico clique


$naoEncontrado=0;
while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
     
    $idAnuncioBDLoja1=$row[0];
    $alterado=$row[1];
    $publicado=$row[2]; 
	$dataAnuncio=$row[3];
    $valor=$row[4];
    $marcaProduto=$row[5];
    $nomeProduto=$row[6];


    // Pesquisa na Primeira Loja
    $queryBDIdAnuncios="SELECT idlinkbd         
                        FROM  bd_id_anuncios 
                        WHERE idloja=19  AND idanunciobd=$idAnuncioBD";   
    $resultadoBDIdAnuncios = mysql_query($queryBDIdAnuncios,$conexao);
    $idLinkBD=mysql_result($resultadoBDIdAnuncios,0,0);


    if(!$idLinkBD){
        $idLinkBD="Não encontrado";
        //++$naoEncontrado;
        $queryPesquisaIdAnuncio="   SELECT id          
                                    FROM  links_boadica  
                                    WHERE produto='$nomeProduto' 
                                    AND marca='$marcaProduto'";   
        $resultadoPesquisaIdAnuncio = mysql_query($queryPesquisaIdAnuncio,$conexao);
        $numeroLinks=mysql_num_rows($resultadoPesquisaIdAnuncio);
        if($numeroLinks>1){
            $idLinkBD="$numeroLinks anuncios";
        }
        else{
            $idLinkBD=mysql_result($resultadoPesquisaIdAnuncio,0,0);
        }
    }
    else{
        $nomeProduto="";
    }


    // Pesquisa na Segunda Loja

    $queryBDIdAnunciosLoja2="SELECT idanunciobd         
                        FROM  bd_mysnapshot  
                        WHERE idloja=451  AND marca='$marcaProduto' 
                        AND nome='$nomeProduto'";   
    $resultadoBDIdAnunciosLoja2 = mysql_query($queryBDIdAnunciosLoja2,$conexao);
    $idAnuncioBDLoja2=mysql_result($resultadoBDIdAnunciosLoja2,0,0);


    /*
    if(!$idLinkBD){
        $idLinkBD="Não encontrado";
        ++$naoEncontrado;
        $queryPesquisaIdAnuncio="   SELECT id          
                                    FROM  links_boadica  
                                    WHERE produto='$nomeProduto'";   
        $resultadoPesquisaIdAnuncio = mysql_query($queryPesquisaIdAnuncio,$conexao);
        $numeroLinks=mysql_num_rows($resultadoPesquisaIdAnuncio);
        if($numeroLinks>1){
            $idLinkBD="$numeroLinks anuncios";
        }
        else{
            $idLinkBD=mysql_result($resultadoPesquisaIdAnuncio,0,0);
            $idLinkBD="<font color='#0000FF'>$idLinkBD</font>";
        }
    }
    else{
        $nomeProduto="";
    }
    */
    
    if($idAnuncioBDLoja1!="" AND $idAnuncioBDLoja2!=""){
        $idLinkBDColor="<font color='#000000'>$idLinkBD</font>";
    }
    else{
        $idLinkBDColor="<font color='#0000FF'>$idLinkBD</font>";
    }

    // Checagem dos dados

    $queryConfereLoja1="SELECT idanunciobd         
                        FROM  bd_id_anuncios   
                        WHERE idloja=19  AND idlinkbd=$idLinkBD";   
    $resultadoConfereLoja1 = mysql_query($queryConfereLoja1,$conexao);
    $idParaConferirAnuncioBDLoja1=mysql_result($resultadoConfereLoja1,0,0);
    //echo "q: $queryConfereLoja1 id: $idParaConferirAnuncioBDLoja1<br>";

    $queryConfereLoja2="SELECT idanunciobd         
                        FROM  bd_id_anuncios   
                        WHERE idloja=451  AND idlinkbd=$idLinkBD";   
    $resultadoConfereLoja2 = mysql_query($queryConfereLoja2,$conexao);
    $idParaConferirAnuncioBDLoja2=mysql_result($resultadoConfereLoja2,0,0);
    //echo "q: $queryConfereLoja2 id: $idParaConferirAnuncioBDLoja2<br>";

    if(($idParaConferirAnuncioBDLoja1==$idAnuncioBDLoja1) AND ($idParaConferirAnuncioBDLoja2==$idAnuncioBDLoja2)){
        $imgStatus="<img src='/imagens/check.gif' />";
    }
    else{
        $imgStatus="";
        ++$naoEncontrado;
    }


        if($imgStatus=="" && $idAnuncioBDLoja2!=""){
        echo "<tr>                
                    <td align='right'>
                        $dataAnuncio
                    </td>
                    <td>
                        $idAnuncioBDLoja1
                    </td>
                    <td>
                        $idAnuncioBDLoja2
                    </td>
                    <td>
                        <a href='/m/BDPrecosRotinas.php?modo=cadastrar_id_anuncio_bd&idlinkbd=$idLinkBD&idloja1=19&idloja2=451&idanunciobdloja1=$idAnuncioBDLoja1&idanunciobdloja2=$idAnuncioBDLoja2' target='_blank'>$idLinkBDColor</a>
                    </td>

                    <td>
                        $imgStatus
                    </td>
                    
                    
                    <td>
                        $valor
                    </td>
                    <td>
                        $marcaProduto
                    </td>                
                    <td>
                        $nomeProduto
                    </td>
                </tr>";
        }
	} // Fim da linha de exibicao do produto


echo "</table>";

echo "total não encontraldo: $naoEncontrado<br>";

?>



</body>
</html>
