<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manuten&ccedil;&atilde;o</title>
</head>
<link href="../lojas.css" rel="stylesheet" type="text/css" />
<body>

<?
//Prepara conexao ao db
include("../conectadb.php");
?>

<?
// Busca o codigo da Loja
$cdloja=$_REQUEST["cdloja"];
$produto=$_REQUEST["produto"];
$vlvenda=$_REQUEST["vlvenda"];
$modo=$_REQUEST["modo"];
?>

<?
session_start();
if (!isset($_SESSION["usuario"])){
			echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
	}
include("../manutencao/menu.php");?>
<br />

<?

if ($modo=="Atualizar precos"){
	echo "loja=".$cdloja."<br>";
	$contador=0;
	foreach ($produto as $rotulo => $cdproduto):
	echo "$cdproduto";
		$vlvendaproduto=$vlvenda[$contador];
		echo $vlvendaproduto."<br>";
		
			$query="UPDATE precos SET vlvenda='".$vlvendaproduto."' WHERE cdproduto='".$cdproduto."' AND cdloja=".$cdloja;
			$resultado = mysql_query($query,$conexao);
			echo $query;
		
		$contador=$contador+1;
	endforeach;
} // fim do if
?>

</body>
</html>
