<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>

<?
//Prepara conexao ao db
include("../conectadb.php");

// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
  $linha = fgets($ponteiro, 4096);
  $cdloja=$linha;
}

// recebe os dados 

$modo=$_REQUEST["modo"];

$cdproduto1=$_REQUEST["cdproduto1"];
$cdproduto2=$_REQUEST["cdproduto2"];
$cdproduto3=$_REQUEST["cdproduto3"];
$cdproduto4=$_REQUEST["cdproduto4"];
$cdproduto5=$_REQUEST["cdproduto5"];
$cdproduto6=$_REQUEST["cdproduto6"];
$cdproduto7=$_REQUEST["cdproduto7"];
$cdproduto8=$_REQUEST["cdproduto8"];
$cdproduto9=$_REQUEST["cdproduto9"];
$cdproduto10=$_REQUEST["cdproduto10"];

$quantidade1=$_REQUEST["quantidade1"];
$quantidade2=$_REQUEST["quantidade2"];
$quantidade3=$_REQUEST["quantidade3"];
$quantidade4=$_REQUEST["quantidade4"];
$quantidade5=$_REQUEST["quantidade5"];
$quantidade6=$_REQUEST["quantidade6"];
$quantidade7=$_REQUEST["quantidade7"];
$quantidade8=$_REQUEST["quantidade8"];
$quantidade9=$_REQUEST["quantidade9"];
$quantidade10=$_REQUEST["quantidade10"];

$custo_lote1=$_REQUEST["custo_lote1"];
$custo_lote2=$_REQUEST["custo_lote2"];
$custo_lote3=$_REQUEST["custo_lote3"];
$custo_lote4=$_REQUEST["custo_lote4"];
$custo_lote5=$_REQUEST["custo_lote5"];
$custo_lote6=$_REQUEST["custo_lote6"];
$custo_lote7=$_REQUEST["custo_lote7"];
$custo_lote8=$_REQUEST["custo_lote8"];
$custo_lote9=$_REQUEST["custo_lote9"];
$custo_lote10=$_REQUEST["custo_lote10"];

$custo_lote1=str_replace(",",".",$custo_lote1);
$custo_lote2=str_replace(",",".",$custo_lote2);
$custo_lote3=str_replace(",",".",$custo_lote3);
$custo_lote4=str_replace(",",".",$custo_lote4);
$custo_lote5=str_replace(",",".",$custo_lote5);
$custo_lote6=str_replace(",",".",$custo_lote6);
$custo_lote7=str_replace(",",".",$custo_lote7);
$custo_lote8=str_replace(",",".",$custo_lote8);
$custo_lote9=str_replace(",",".",$custo_lote9);
$custo_lote10=str_replace(",",".",$custo_lote10);


$cdstatus=$_REQUEST["cdstatus"];
$dtcompra=$_REQUEST["dtcompra"]; 
$moeda=$_REQUEST["moeda"]; 
$dtcompra=substr($dtcompra,6,4)."-".substr($dtcompra,3,2)."-".substr($dtcompra,0,2);
$dtchegada=$_REQUEST["dtchegada"];
$cdtransportadora=$_REQUEST["cdtransportadora"];
$cdrastreamento=$_REQUEST["cdrastreamento"];
$cotacao_us=$_REQUEST["cotacao_us"];
$cotacao_us=str_replace(",",".",$cotacao_us);
$taxa_lote_rs=$_REQUEST["taxa_lote_rs"];
if ($taxa_lote_rs==""){
	$taxa_lote_rs=0;
	}
$custo_total_individual_rs=0;
$idpaypal=$_REQUEST["idpaypal"];
$cartao=$_REQUEST["cartao"];
$observacao=$_REQUEST["observacao"];

$iditem=$_REQUEST["iditem"];


$query="SELECT cdestoque FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$cdestoque=mysql_result($resultado,0,0);

if ($modo=="incluir"){
	// seleciona o produto no banco de dados
	$query="INSERT INTO compras(idcompra, cdloja, cdstatus, dtcompra, dtchegada, moeda, cdtransportadora, cdrastreamento, cotacao_us, idpaypal, cartao, observacao) VALUES ('$iditem', '$cdestoque', '$cdstatus', '$dtcompra', '$dtchegada', '$moeda', '$cdtransportadora', '$cdrastreamento', '$cotacao_us', '$idpaypal', '$cartao', '$observacao')";
	$resultado = mysql_query($query,$conexao);
	//echo $query;
	$idcompra= mysql_insert_id(); // ultimo id gerado
	
	if ($cdproduto1<>""){
	$query="INSERT INTO compras_detalhes(iditem, idcompra, cdproduto, quantidade, custo_lote, custo_frete, custo_imposto, cdstatus, dtchegada) VALUES (null, $idcompra, '$cdproduto1', $quantidade1, $custo_lote1,'','','0','0000-00-00')";
	echo $query;
	$resultado = mysql_query($query,$conexao);
	}
	
	if ($cdproduto2<>""){
	$query="INSERT INTO compras_detalhes(iditem, idcompra, cdproduto, quantidade, custo_lote, custo_frete, custo_imposto, cdstatus, dtchegada) VALUES (null, $idcompra, '$cdproduto2', $quantidade2, $custo_lote2,'','','0','0000-00-00')";
	$resultado = mysql_query($query,$conexao);
	}
	
	if ($cdproduto3<>""){
	$query="INSERT INTO compras_detalhes(iditem, idcompra, cdproduto, quantidade, custo_lote, custo_frete, custo_imposto, cdstatus, dtchegada) VALUES (null, $idcompra, '$cdproduto3', $quantidade3, $custo_lote3,'','','0','0000-00-00')";
	$resultado = mysql_query($query,$conexao);
	}
	
	if ($cdproduto4<>""){
	$query="INSERT INTO compras_detalhes(iditem, idcompra, cdproduto, quantidade, custo_lote, custo_frete, custo_imposto, cdstatus, dtchegada) VALUES (null, $idcompra, '$cdproduto4', $quantidade4, $custo_lote4,'','','0','0000-00-00')";
	$resultado = mysql_query($query,$conexao);
	}
	
	if ($cdproduto5<>""){
	$query="INSERT INTO compras_detalhes(iditem, idcompra, cdproduto, quantidade, custo_lote, custo_frete, custo_imposto, cdstatus, dtchegada) VALUES (null, $idcompra, '$cdproduto5', $quantidade5, $custo_lote5,'','','0','0000-00-00')";
	$resultado = mysql_query($query,$conexao);
	}
	
	if ($cdproduto6<>""){
	$query="INSERT INTO compras_detalhes(iditem, idcompra, cdproduto, quantidade, custo_lote, custo_frete, custo_imposto, cdstatus, dtchegada) VALUES (null, $idcompra, '$cdproduto6', $quantidade6, $custo_lote6,'','','0','0000-00-00')";
	$resultado = mysql_query($query,$conexao);
	}
	
	if ($cdproduto7<>""){
	$query="INSERT INTO compras_detalhes(iditem, idcompra, cdproduto, quantidade, custo_lote, custo_frete, custo_imposto, cdstatus, dtchegada) VALUES (null, $idcompra, '$cdproduto7', $quantidade7, $custo_lote7,'','','0','0000-00-00')";
	$resultado = mysql_query($query,$conexao);
	}
	
	if ($cdproduto8<>""){
	$query="INSERT INTO compras_detalhes(iditem, idcompra, cdproduto, quantidade, custo_lote, custo_frete, custo_imposto, cdstatus, dtchegada) VALUES (null, $idcompra, '$cdproduto8', $quantidade8, $custo_lote8,'','','0','0000-00-00')";
	$resultado = mysql_query($query,$conexao);
	}
	
	if ($cdproduto9<>""){
	$query="INSERT INTO compras_detalhes(iditem, idcompra, cdproduto, quantidade, custo_lote, custo_frete, custo_imposto, cdstatus, dtchegada) VALUES (null, $idcompra, '$cdproduto9', $quantidade9, $custo_lote9,'','','0','0000-00-00')";
	$resultado = mysql_query($query,$conexao);
	}
	
	if ($cdproduto10<>""){
	$query="INSERT INTO compras_detalhes(iditem, idcompra, cdproduto, quantidade, custo_lote, custo_frete, custo_imposto, cdstatus, dtchegada) VALUES (null, $idcompra, '$cdproduto10', $quantidade10, $custo_lote10,'','','0','0000-00-00')";
	$resultado = mysql_query($query,$conexao);
	}
	
	echo "Registro inserido com sucesso<br>";
	echo "<table>";
	echo "<tr><td>Produto</td><td>Imagem</td><td>Quantidade</td><td>Custo Lote</td>";
	echo "<tr><td align='right'>".$cdproduto1."</td><td>"."<img src='../imagens/produtos/".$cdproduto1.".jpg' width='30' height='30'>"."</td><td>".$quantidade1."</td><td align='right'>".$custo_lote1."</td></tr>";

	if ($cdproduto2<>""){
		echo "<tr><td align='right'>".$cdproduto2."</td><td>"."<img src='../imagens/produtos/".$cdproduto2.".jpg' width='30' height='30'>"."</td><td>".$quantidade2."</td><td align='right'>".$custo_lote2."</td></tr>";
	}
	
	if ($cdproduto3<>""){
		echo "<tr><td align='right'>".$cdproduto3."</td><td>"."<img src='../imagens/produtos/".$cdproduto3.".jpg' width='30' height='30'>"."</td><td>".$quantidade3."</td><td align='right'>".$custo_lote3."</td></tr>";
	}
	
	if ($cdproduto4<>""){
		echo "<tr><td align='right'>".$cdproduto4."</td><td>"."<img src='../imagens/produtos/".$cdproduto4.".jpg' width='30' height='30'>"."</td><td>".$quantidade4."</td><td align='right'>".$custo_lote4."</td></tr>";
	}
	
	if ($cdproduto5<>""){
		echo "<tr><td align='right'>".$cdproduto5."</td><td>"."<img src='../imagens/produtos/".$cdproduto5.".jpg' width='30' height='30'>"."</td><td>".$quantidade5."</td><td align='right'>".$custo_lote5."</td></tr>";
	}
	
	if ($cdproduto6<>""){
		echo "<tr><td align='right'>".$cdproduto6."</td><td>"."<img src='../imagens/produtos/".$cdproduto6.".jpg' width='30' height='30'>"."</td><td>".$quantidade6."</td><td align='right'>".$custo_lote6."</td></tr>";
	}
	
	if ($cdproduto7<>""){
		echo "<tr><td align='right'>".$cdproduto7."</td><td>"."<img src='../imagens/produtos/".$cdproduto7.".jpg' width='30' height='30'>"."</td><td>".$quantidade7."</td><td align='right'>".$custo_lote7."</td></tr>";
	}
	
	if ($cdproduto8<>""){
		echo "<tr><td align='right'>".$cdproduto8."</td><td>"."<img src='../imagens/produtos/".$cdproduto8.".jpg' width='30' height='30'>"."</td><td>".$quantidade8."</td><td align='right'>".$custo_lote8."</td></tr>";
	}
	
	if ($cdproduto9<>""){
		echo "<tr><td align='right'>".$cdproduto9."</td><td>"."<img src='../imagens/produtos/".$cdproduto9.".jpg' width='30' height='30'>"."</td><td>".$quantidade9."</td><td align='right'>".$custo_lote9."</td></tr>";
	}
	
	if ($cdproduto10<>""){
		echo "<tr><td align='right'>".$cdproduto10."</td><td>"."<img src='../imagens/produtos/".$cdproduto10.".jpg' width='30' height='30'>"."</td><td>".$quantidade10."</td><td align='right'>".$custo_lote10."</td></tr>";
	}
	
	echo "</table>";
	echo "<br><a href='javascript:history.back(1);'>Voltar p/ incluir outro produto</a>";
	echo "<br><br>";
	echo "<a href='../manutencao/compras_editar.php?iditem=".$idinclusao."'>Corrigir erros na entrada dos dados</a>";
	echo "<br><br>";
	
	$sub_query="SELECT COUNT(*) AS total FROM fornecedores WHERE paypal='".$idpaypal."'";
		//  echo $sub_query2;
		$resultado = mysql_query($sub_query,$conexao);
		$total=mysql_result($resultado,0,0);
		if ($total==0){
			Echo "Fornecedor <b>".$idpaypal."</b> não cadastrado, para cadastrar agora clique <a href='fornecedores_incluir.php?paypal=".$idpaypal."'>aqui</a>";
			}
}

if ($modo=="editar"){
	$query="UPDATE compras SET cdproduto='".$cdproduto."', cdstatus='".$cdstatus."', dtcompra='".$dtcompra."' , dtchegada='".$dtchegada."', cdrastreamento='".$cdrastreamento."', quantidade='".$quantidade."', custo_lote='".$custo_lote."', cotacao_us='".$cotacao_us."', taxa_lote_rs=".$taxa_lote_rs.", custo_total_individual_rs='".$custo_total_individual_rs."', idpaypal='".$idpaypal."', cartao='".$cartao."', observacao='".$observacao."' WHERE iditem='".$iditem."'";
$resultado = mysql_query($query,$conexao);
echo "Registro alterado com sucesso";
}
//echo $query;


?>
</body>
</html>
