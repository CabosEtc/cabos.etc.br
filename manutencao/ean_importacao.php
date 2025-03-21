<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ean Importação do arquivo ean.txt</title>
</head>

<body>
<p>
<?

//Prepara conexao ao db
include("../conectadb.php");

// Lê o arquivo original e carrega na variavel

$arquivo_original=fopen("../manutencao/ean.txt","rt");
while (!feof($arquivo_original)){
	$conteudo=fgets($arquivo_original,1024);
	$cdproduto=substr($conteudo,28,5);
	$ean=substr($conteudo,14,13);
	
	$query="UPDATE produtos SET ean='".$ean."' WHERE cdproduto='".$cdproduto."'";
	echo $query."<p>";
	
	$resultado = mysql_query($query,$conexao);

	echo $cdproduto." : ".$ean."<p>";
}





?>
</body>
</html>