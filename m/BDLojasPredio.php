<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="manutencao.css">
<title>BDLojas</title>
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


$query="SELECT links_boadica_detalhes_snapshot.id_loja, lojas_boadica.nome, lojas_boadica.flag_predio 
FROM `links_boadica_detalhes_snapshot`, lojas_boadica WHERE links_boadica_detalhes_snapshot.id_loja=lojas_boadica.id_loja 
AND lojas_boadica.flag_predio=1 and `data` LIKE '%$dthoje_eua%' group by id_loja ORDER BY lojas_boadica.nome";
//echo $query;

$resultado = mysql_query($query,$conexao);
$quantidade=mysql_num_rows($resultado);
echo "Quantidade de lojas: $quantidade<br>";





echo "<table>";


while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
  $idloja=$row[0]; 
	$nomeloja=$row[1];
	echo "<tr><td><a href='BDPrecosLojaX.php?idloja=$idloja'>$idloja</a></td><td><a href='BDPrecosLojaX.php?idloja=$idloja'>$nomeloja</a></td></tr>";
	} // Fim da linha de exibicao do produto

echo "</table>";

?>



</body>
</html>
