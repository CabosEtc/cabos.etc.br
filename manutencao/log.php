<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?
$periodo=$_REQUEST["periodo"];
echo ("<title>Log</title>");
?>
</head>
<link href="../lojas.css" rel="stylesheet" type="text/css" />
<body>

<?
//Prepara conexao ao db
include("../conectadb.php");
?>

<?
// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
  $cdloja = fgets($ponteiro, 4096);
}
fclose ($ponteiro);

$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);

$query="SELECT data, codigo, inf1, inf2, inf3, inf4, loja FROM log WHERE loja='".$cdloja."' ORDER BY idlog";
$resultado = mysql_query($query,$conexao);

?>

<?

	echo "<h3>Log Loja: ".$nomeloja."</h3><br>";


	echo "<table>";
	echo "<tr><td width='100'>Data ocorrencia</td><td width='50'>Loja</td><td width='120'>Código</td><td width='100' align='right'>Informacao 1</td><td width='100' align='right'>Informacao 2</td><td width='100' align='right'>Informacao 3</td><td width='100' align='right'>Informacao 4</td></tr>";
	while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		$data=$row[0]; // nome da categoria
		$data=substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4);
		$codigo=$row[1]; // nome da categoria
		$query2="SELECT descricao FROM log_codigos WHERE codigo='".$codigo."'";
		$resultado2 = mysql_query($query2,$conexao);
		$descricao=mysql_result($resultado2,0,0);

		$inf1=$row[2];
		$query3="SELECT inf1 FROM log_codigos WHERE codigo='".$codigo."'";
		$resultado3 = mysql_query($query3,$conexao);
		$inf1_campo=mysql_result($resultado3,0,0);

		$inf2=$row[3];
		$query4="SELECT inf2 FROM log_codigos WHERE codigo='".$codigo."'";
		$resultado4 = mysql_query($query4,$conexao);
		$inf2_campo=mysql_result($resultado4,0,0);

		$inf3=$row[4];
		$query5="SELECT inf3 FROM log_codigos WHERE codigo='".$codigo."'";
		$resultado5 = mysql_query($query5,$conexao);
		$inf3_campo=mysql_result($resultado5,0,0);

		$inf4=$row[5];
		$query6="SELECT inf4 FROM log_codigos WHERE codigo='".$codigo."'";
		$resultado6 = mysql_query($query6,$conexao);
		$inf4_campo=mysql_result($resultado6,0,0);

		$loja=$row[6];

		echo "<tr><td>".$data."</td><td>".$loja."</td><td>".$descricao."</td><td align='right'>".$inf1_campo."</td><td align='right'>".$inf2_campo."</td><td align='right'>".$inf3_campo."</td><td align='right'>".$inf4_campo."</td></tr>";
		echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>".$codigo."</td><td align='right'>".$inf1."</td><td align='right'>".$inf2."</td><td align='right'>".$inf3."</td><td align='right'>".$inf4."</td></tr>";
		echo "<tr><td colspan='7'>&nbsp;</td></tr>";

	}
	
		echo "</table>";
?>
</body>
</html>