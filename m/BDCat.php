<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="manutencao.css">
<title>BDCat</title>
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


//Inclui o menu
include("mmenu.php");   



echo "<table><tr><td><h3>Lista de Categorias/Subcategorias</h3></td></tr></table>";



// abaixo busca as categorias da loja, nao dá para cada loja usar uma lista diferente de categorias...

$query="SELECT categoria.cdcategoria, categoria.categoria  
 FROM  categoria WHERE cdloja=1 ORDER BY categoria.categoria";
$resultado = mysql_query($query,$conexao);



//echo $query."<BR><BR>";


echo "<table>";
echo "<tr><td>Categoria</td></tr>";


while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
  $cdcategoria=$row[0]; 
	$categoria=$row[1];
      echo "<tr><td><font color='#FF0000'>$categoria</font></td></tr>";
      echo "<table>";
		     $querysubcategoria="SELECT subcategoria.cdsubcategoria, subcategoria.descricao  
 				FROM  subcategoria WHERE cdloja=1 AND cdcategoria=$cdcategoria ORDER BY subcategoria.descricao";
				$resultadosubcategoria = mysql_query($querysubcategoria,$conexao); 
				while ($rowsubcategoria = mysql_fetch_array($resultadosubcategoria, MYSQL_NUM)) {
  					$cdsubcategoria=$rowsubcategoria[0]; 
					$descricao=$rowsubcategoria[1];
					ECHO "<TR><TD><a href='BDSubCat.php?cdsubcategoria=$cdsubcategoria'>$descricao</a></TD></TR>";
				}
				ECHO "</table>";
      //}
	} // Fim da linha de exibicao do produto



echo "</table>";

?>



</body>
</html>
