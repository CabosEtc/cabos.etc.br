<?

$q=$_REQUEST["q"];

//Prepara conexao ao db
$raiz_site=$_SERVER['DOCUMENT_ROOT'];
include("$raiz_site/conectadb.php");

$query="select links_boadica.link, links_boadica.cdproduto, produtos.nome from links_boadica, produtos 
where links_boadica.cdproduto=produtos.cdproduto AND links_boadica.link like '%$q%' ORDER BY cdproduto limit 5";
$resultado=mysql_query($query, $conexao);
$quantidade=mysql_num_rows($resultado);
$ret="";

if($quantidade>0) {
	while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		$link=$row[0];
		$cdproduto=$row[1];
		$nome=$row[2];
		$ret=$ret."<div onclick=\"alert('ola');\">$cdproduto - $nome - $link</div>"; 
	}	
}
else {
$ret="Não localizado";
}	
//$hora=date("H:i:s",strtotime("now"));

echo $ret;
?>