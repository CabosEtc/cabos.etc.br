<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

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

?>

<?
$data=$_REQUEST["data"];
$data_eua=substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);

echo "<title>Notas - ".$data."</title>";

?>


</head>

<body>

<?
//Prepara conexao ao db
//include("../conectadb.php");

$query="SELECT nrnota, vlnota, formapagamento, idvendedor, hrnota  FROM notas WHERE dtnota='".$data_eua."' AND cdloja='".$cdloja."' ORDER BY nrnota";
$resultado = mysql_query($query,$conexao);

	echo "<h3>Listagem de notas do dia ".$data." (".$nomeloja.")</h3><br>";
	
	echo "<table>";
	echo "<tr><td width='120'>Numero da nota</td><td width='120' align='right'>Valor da Nota</td><td width='150' align='right'>Forma de pagamento</td><td>Vendedor</td><td>Hora</td></tr>";
	
	$valor_total_notas=0;
	$valor_total_notas_dinheiro=0;
	$valor_total_notas_outros=0;
	$vendedores_array=array();
	while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		$nrnota=$row[0]; // nome da categoria
		$nrnota_formatado=substr(1000000+$nrnota,1,6);
		$vlnota=$row[1]; // nome da categoria
		$vlnota_formatado=number_format($vlnota,2,",","");
		$idformapagamento=$row[2]; // nome da categoria
		$idvendedor=$row[3]; // vendedor
		$hrnota=$row[4]; // vendedor
		
		// cria uma matriz com todos os idvendedores.
			$vendedores_array[] = $idvendedor; // isto � igual a array_push (adiciona).
		
		if ($idformapagamento==1){
			$valor_total_notas_dinheiro=$valor_total_notas_dinheiro+$vlnota;
			}
		if ($idformapagamento>1){
			$valor_total_notas_outros=$valor_total_notas_outros+$vlnota;
			}
		
		$query2="SELECT formapagamento FROM formas_pagamento WHERE idformapagamento=".$idformapagamento;
		$resultado2 = mysql_query($query2,$conexao);
		$formapagamento=mysql_result($resultado2,0,0);

		$query3="SELECT nomeusuario FROM usuarios WHERE idusuario=".$idvendedor;
		$resultado3 = mysql_query($query3,$conexao);
		$nomevendedor=mysql_result($resultado3,0,0);

		
		$valor_total_notas=$valor_total_notas+$vlnota;
		echo "<tr><td width='50'><a href='../manutencao/notas_imprimir.php?nrnota=".$nrnota."'>".$nrnota_formatado."</a></td><td width='50' align='right'>".$vlnota_formatado."</td><td align='right'>".$formapagamento."</td><td align='left' style='padding-left:10px;'>".$nomevendedor."</td><td align='left' style='padding-left:10px;'>".$hrnota."</td></tr>";
	} // fim while
	
		$query3="SELECT sum(vldevolucao) AS valor_devolucoes FROM devolucao WHERE dtdevolucao='".$data_eua."'";
		$resultado3 = mysql_query($query3,$conexao);
		$valor_devolucoes=mysql_result($resultado3,0,0);

	
		echo "<tr><td colspan='2' align='right'>Total das notas: </td><td align='right'>".number_format($valor_total_notas,2,",","")."</td></tr>";
		echo "<tr><td colspan='2' align='right'>Total das notas (em dinheiro): </td><td align='right'>".number_format($valor_total_notas_dinheiro,2,",","")."</td></tr>";
		echo "<tr><td colspan='2' align='right'>Total das notas (outros): </td><td align='right'>".number_format($valor_total_notas_outros,2,",","")."</td></tr>";
		echo "<tr><td colspan='2' align='right'>Total das devolu��es do dia: </td><td align='right'>".number_format($valor_devolucoes,2,",","")."</td></tr>";
		// retira os valores duplicados
  		$unique_array = array_unique($vendedores_array);
		foreach ($unique_array as $pesquisa_vendedor)
			{
			$query4="SELECT nomeusuario FROM usuarios WHERE idusuario=".$pesquisa_vendedor;
			$resultado4 = mysql_query($query4,$conexao);
			$nomevendedor=mysql_result($resultado4,0,0);
	
			$query5="SELECT sum(vlnota) as total_venda FROM `notas` WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."'";
			$resultado5 = mysql_query($query5,$conexao);
			$total_vendedor=mysql_result($resultado5,0,0);
	
			$query6="SELECT sum(vlnota) as total_venda FROM `notas` WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' AND formapagamento='1'";
			$resultado6 = mysql_query($query6,$conexao);
			$total_vendedor_dinheiro=mysql_result($resultado6,0,0);
	
			$query7="SELECT sum(vlnota) as total_venda FROM `notas` WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' AND formapagamento<>'1'";
			$resultado7 = mysql_query($query7,$conexao);
			$total_vendedor_outros=mysql_result($resultado7,0,0);
			echo "<tr><td colspan='3'>&nbsp;</td></tr>";
			echo "<tr><td colspan='2' align='right'>Total do vendedor ".$nomevendedor.":</td><td align='right'>".$total_vendedor."</td></tr>";
			echo "<tr><td colspan='2' align='right'>Total em $ vendedor ".$nomevendedor.":</td><td align='right'>".$total_vendedor_dinheiro."</td></tr>";
			echo "<tr><td colspan='2' align='right'>Total outros do vendedor ".$nomevendedor.":</td><td align='right'>".$total_vendedor_outros."</td></tr>";
			
			}
		echo "</table>";



?>

</body>
</html>
