<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>

<?
// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
  $cdloja = fgets($ponteiro, 4096);
  echo "codigo da loja: ".$cdloja."<br>";
}
fclose ($ponteiro);
?>

<?
//Prepara conexao ao db
include("../conectadb.php");

// recebe os dados 

$modo=$_REQUEST["modo"];
$dtnota=$_REQUEST["dtnota"];
$dtnota=substr($dtnota,6,4)."-".substr($dtnota,3,2)."-".substr($dtnota,0,2);
if ($modo=="alterar_dtnota"){
	
	// seleciona o produto no banco de dados
	$query="UPDATE parametros SET dtnota='".$dtnota."' WHERE cdloja='".$cdloja."'";
	$resultado = mysql_query($query,$conexao);

	echo "Data das notas alteradas para ".$dtnota."<br>";
	echo "<br><br>";
	
}


?>

</body>
</html>
