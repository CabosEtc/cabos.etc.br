<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="manutencao.css">
<title>BDLojas</title>
</head>

<?

//Prepara conexao ao db
include("../conectadb.php");

//Recebe variaveis
$loja=$_REQUEST["loja"];
if($loja=="cabos"){
  $loja=19;
  $nomeLoja="Cabos & Etc...";
}
elseif ($loja="cabos2"){
  $loja=451;
  $nomeLoja="Cabos 2 Informática...";
}
//Inclui o menu
include("mmenu.php");   


$query="SELECT links_boadica.cdproduto, produtos.nome 
        FROM `links_boadica_detalhes_snapshot`, `links_boadica`, produtos 
        WHERE links_boadica_detalhes_snapshot.id_produto=links_boadica.id 
        AND produtos.cdproduto=links_boadica.cdproduto 
        AND links_boadica_detalhes_snapshot.`id_loja` = $loja 
        AND links_boadica_detalhes_snapshot.`data` LIKE '%$dthoje_eua%' 
        GROUP by links_boadica.cdproduto 
ORDER BY produtos.nome ASC";
//echo $query;

$resultado = mysql_query($query,$conexao);
$quantidade=mysql_num_rows($resultado);
echo "Lista dos $quantidade produtos ativos na $nomeLoja.<br><br>";






echo "<table>";


while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
    $codigoProduto=$row[0]; 
    $nomeProduto=$row[1];
 	echo "<tr>
          <td>
            <a href='BDProduto.php?cdproduto=$codigoProduto' target='_blank'>$codigoProduto</a>
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


