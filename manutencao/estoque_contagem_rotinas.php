<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Vendas</title>
</head>

<body>

<?
//Prepara conexao ao db
include("../conectadb.php");
?>

<?
// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
  $linha = fgets($ponteiro, 4096);
  $cdloja=$linha;

}
fclose ($ponteiro);

$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);

?>

  

<table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    
<?
// recebe os dados 
$modo=$_REQUEST["modo"];
$dtmovimento=$_REQUEST["dtmovimento"];
$dtmovimento_eua=substr($dtmovimento,6,4)."/".substr($dtmovimento,3,2)."/".substr($dtmovimento,0,2);

$diferenca1=$_REQUEST["diferenca1"]; 
$diferenca1=abs($diferenca1);// torna ele positivo
$diferenca2=$_REQUEST["diferenca2"]; 
$diferenca2=abs($diferenca2);// torna ele positivo
$diferenca3=$_REQUEST["diferenca3"]; 
$diferenca3=abs($diferenca3);// torna ele positivo
$diferenca4=$_REQUEST["diferenca4"]; 
$diferenca4=abs($diferenca4);// torna ele positivo
$diferenca5=$_REQUEST["diferenca5"]; 
$diferenca5=abs($diferenca5);// torna ele positivo
$acao1=$_REQUEST["acao1"];
$acao2=$_REQUEST["acao2"];
$acao3=$_REQUEST["acao3"];
$acao4=$_REQUEST["acao4"];
$acao5=$_REQUEST["acao5"];
$cdproduto1=$_REQUEST["cdproduto1"];
$cdproduto2=$_REQUEST["cdproduto2"];
$cdproduto3=$_REQUEST["cdproduto3"];
$cdproduto4=$_REQUEST["cdproduto4"];
$cdproduto5=$_REQUEST["cdproduto5"];

if ($acao1==1) // estoque atual menor que a contagem // codigo 55=Acrescentado durante contagem de material
{ $historico=55; }

if ($acao1==2) // estoque maior que a contagem // codigo 5=Diminuido durante contagem de material
{ $historico=5; }

if ($acao1>0){ // se for zero não faz nada, está batido.
	$query="INSERT INTO estoque(iditem, cdloja, cdproduto, dtmovimento, historico, quantidade, idcompra) VALUES (null, $cdloja, '$cdproduto1', '$dtmovimento_eua', $historico, $diferenca1, 0)";
	$resultado = mysql_query($query,$conexao);
	echo $query." este é o numero 1<br>";
}
//--------------
if ($acao2==1) // estoque atual menor que a contagem // codigo 55=Acrescentado durante contagem de material
{ $historico=55; }

if ($acao2==2) // estoque maior que a contagem // codigo 5=Diminuido durante contagem de material
{ $historico=5; }

if ($acao2>0){ // se for zero não faz nada, está batido.
	$query="INSERT INTO estoque(iditem, cdloja, cdproduto, dtmovimento, historico, quantidade, idcompra) VALUES (null, $cdloja, '$cdproduto2', '$dtmovimento_eua', $historico, $diferenca2, 0)";
	$resultado = mysql_query($query,$conexao);
	echo $query;
}
//--------------
if ($acao3==1) // estoque atual menor que a contagem // codigo 55=Acrescentado durante contagem de material
{ $historico=55; }

if ($acao3==2) // estoque maior que a contagem // codigo 5=Diminuido durante contagem de material
{ $historico=5; }

if ($acao3>0){ // se for zero não faz nada, está batido.
	$query="INSERT INTO estoque(iditem, cdloja, cdproduto, dtmovimento, historico, quantidade, idcompra) VALUES (null, $cdloja, '$cdproduto3', '$dtmovimento_eua', $historico, $diferenca3, 0)";
	$resultado = mysql_query($query,$conexao);
	echo $query;
}
//--------------
if ($acao4==1) // estoque atual menor que a contagem // codigo 55=Acrescentado durante contagem de material
{ $historico=55; }

if ($acao4==2) // estoque maior que a contagem // codigo 5=Diminuido durante contagem de material
{ $historico=5; }

if ($acao4>0){ // se for zero não faz nada, está batido.
	$query="INSERT INTO estoque(iditem, cdloja, cdproduto, dtmovimento, historico, quantidade, idcompra) VALUES (null, $cdloja, '$cdproduto4', '$dtmovimento_eua', $historico, $diferenca4, 0)";
	$resultado = mysql_query($query,$conexao);
	echo $query;
}
//--------------
if ($acao5==1) // estoque atual menor que a contagem // codigo 55=Acrescentado durante contagem de material
{ $historico=55; }

if ($acao5==2) // estoque maior que a contagem // codigo 5=Diminuido durante contagem de material
{ $historico=5; }

if ($acao5>0){ // se for zero não faz nada, está batido.
	$query="INSERT INTO estoque(iditem, cdloja, cdproduto, dtmovimento, historico, quantidade, idcompra) VALUES (null, $cdloja, '$cdproduto5', '$dtmovimento_eua', $historico, $diferenca5, 0)";
	$resultado = mysql_query($query,$conexao);
	echo $query;
}
//--------------

?>
    
    <p style="padding-top:480px; padding-left:750px">
    <a href="../manutencao/estoque_contagem.php">Inserir</a> contagem de novos produtos
    </p>
	<? // echo ("<a href='../manutencao/nota.php?nrnota=".$nrnota_inteiro."'>Imprimir</a> nota"); ?>
    </td>
  </tr>
</table>
  
  
</body>
</html>
