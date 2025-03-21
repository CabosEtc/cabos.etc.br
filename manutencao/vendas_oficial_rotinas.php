<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Vendas</title>
</head>

<body>



  

<table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    
      <?

//Prepara conexao ao db
include("../conectadb.php");

session_start();
$usuario=$_SESSION['usuario'];

// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
  $cdloja = fgets($ponteiro, 4096);
}
fclose ($ponteiro);

$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);

// recebe os dados 

$modo=$_REQUEST["modo"];

$nrnota=$_REQUEST["nrnota"];
$nrnota_inteiro=(int)$nrnota;
//$cdloja=$_REQUEST["cdloja"];
$cdloja= (int)$cdloja;
//echo $cdloja;

$vlnota=$_REQUEST["vlnota"];
$vlnota_ponto=str_replace(",",".",$vlnota);
$nrnota=$_REQUEST["nrnota"];
$nrnota_inteiro= (int)$nrnota;
$dtnota=$_REQUEST["dtnota"];
$dtnota_eua=substr($dtnota,6,4)."-".substr($dtnota,3,2)."-".substr($dtnota,0,2);
$desconto=$_REQUEST["desconto"];
if ($desconto==""){
	$desconto=0;
	}
$desconto_ponto=str_replace(",",".",$desconto);
$garantia=$_REQUEST["garantia"];
$idformapagamento=$_REQUEST["idformapagamento"];
$formapagamento=$_REQUEST["formapagamento"];
$idusuario=$_REQUEST["idusuario"];

$quant1=$_REQUEST["quant1"];
$quant2=$_REQUEST["quant2"];
$quant3=$_REQUEST["quant3"];
$quant4=$_REQUEST["quant4"];
$quant5=$_REQUEST["quant5"];
$quant6=$_REQUEST["quant6"];
$quant7=$_REQUEST["quant7"];
$quant8=$_REQUEST["quant8"];
$quant9=$_REQUEST["quant9"];
$quant10=$_REQUEST["quant10"];
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
$vlunitario1=$_REQUEST["vlunitario1"];
$vlunitario2=$_REQUEST["vlunitario2"];
$vlunitario3=$_REQUEST["vlunitario3"];
$vlunitario4=$_REQUEST["vlunitario4"];
$vlunitario5=$_REQUEST["vlunitario5"];
$vlunitario6=$_REQUEST["vlunitario6"];
$vlunitario7=$_REQUEST["vlunitario7"];
$vlunitario8=$_REQUEST["vlunitario8"];
$vlunitario9=$_REQUEST["vlunitario9"];
$vlunitario10=$_REQUEST["vlunitario10"];

/*
echo $dtnota_eua."<br>";
echo $nrnota_inteiro."<br>";
echo $vlnota_ponto."<br>";
echo $desconto_ponto."<br>";
echo $garantia."<br>";
echo $idformapagamento."<br>";

echo $quant1."<br>";
echo $cdproduto1."<br>";
echo $vlunitario1."<br>";
*/

if ($modo=="incluir"){
	
	// Insere a nota no banco de dados
	$query="INSERT INTO notas_oficial (idnota, cdloja, nrnota, dtnota) VALUES (null, $cdloja, $nrnota_inteiro, '$dtnota_eua')";
	$resultado = mysql_query($query,$conexao);
	$idnota= mysql_insert_id(); 
	//echo $idnota;
	//echo $query;
	
	// Insere os produtos no banco de dados
	$query="INSERT INTO notas_oficial_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto) VALUES (null, $idnota, $quant1, '$cdproduto1', $vlunitario1)";
	$resultado = mysql_query($query,$conexao);
	//echo $query;
	
	if ($quant2<>""){
	$query="INSERT INTO notas_oficial_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto) VALUES (null, $idnota, $quant2, '$cdproduto2', $vlunitario2)";
	$resultado = mysql_query($query,$conexao);
	}

	if ($quant3<>""){
	$query="INSERT INTO notas_oficial_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto) VALUES (null, $idnota, $quant3, '$cdproduto3', $vlunitario3)";
	$resultado = mysql_query($query,$conexao);
	}

	if ($quant4<>""){
	$query="INSERT INTO notas_oficial_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto) VALUES (null, $idnota, $quant4, '$cdproduto4', $vlunitario4)";
	$resultado = mysql_query($query,$conexao);
	}

	if ($quant5<>""){
	$query="INSERT INTO notas_oficial_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto) VALUES (null, $idnota, $quant5, '$cdproduto5', $vlunitario5)";
	$resultado = mysql_query($query,$conexao);
	}

	if ($quant6<>""){
	$query="INSERT INTO notas_oficial_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto) VALUES (null, $idnota, $quant6, '$cdproduto6', $vlunitario6)";
	$resultado = mysql_query($query,$conexao);
	}

	if ($quant7<>""){
	$query="INSERT INTO notas_oficial_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto) VALUES (null, $idnota, $quant7, '$cdproduto7', $vlunitario7)";
	$resultado = mysql_query($query,$conexao);
	}

	if ($quant8<>""){
	$query="INSERT INTO notas_oficial_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto) VALUES (null, $idnota, $quant8, '$cdproduto8', $vlunitario8)";
	$resultado = mysql_query($query,$conexao);
	}

	if ($quant9<>""){
	$query="INSERT INTO notas_oficial_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto) VALUES (null, $idnota, $quant9, '$cdproduto9', $vlunitario9)";
	$resultado = mysql_query($query,$conexao);
	}

	if ($quant10<>""){
	$query="INSERT INTO notas_oficial_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto) VALUES (null, $idnota, $quant10, '$cdproduto10', $vlunitario10)";
	$resultado = mysql_query($query,$conexao);
	}

	// Atualiza o proximo numero de nota
	$proximo_nrnota=$nrnota_inteiro+1;
	$query="UPDATE parametros SET nrnota_oficial=".$proximo_nrnota." WHERE cdloja=".$cdloja;
	$resultado = mysql_query($query,$conexao);

	echo "Nota inserida com sucesso<br>";
}

if ($modo=="excluir"){
	
	// Pesquisa se a nota existe
	$query="SELECT nrnota FROM notas WHERE notas.nrnota=".$nrnota;
	$resultado = mysql_query($query,$conexao);
	@ini_set("display_errors", 0);
	$nrencontrado=mysql_result($resultado,0,0);
	$nrencontrado=(int)$nrencontrado; // retorna numero sem os zeros
	@ini_set("display_errors", 1);


// Rotinas de log: Registra a impressão no LOG do sistema:

if($nrnota==$nrencontrado){
	$query="SELECT dtnota, vlnota, desconto, garantia, formapagamento FROM notas WHERE nrnota='".$nrnota."' AND cdloja='".$cdloja."'";
	$resultado = mysql_query($query,$conexao);
	$dtnota=mysql_result($resultado,0,0);
	$dtnota=substr($dtnota,8,2)."/".substr($dtnota,5,2)."/".substr($dtnota,0,4);
	//$vlnota=mysql_result($resultado,0,1);
	//$desconto=mysql_result($resultado,0,2);
	//$desconto_formatado=number_format($desconto,2,",","");
	//$garantia=mysql_result($resultado,0,3);
	$idformapagamento=mysql_result($resultado,0,4);
	$querypgto="SELECT formapagamento FROM formas_pagamento WHERE idformapagamento='".$idformapagamento."'";
	$resultadopgto = mysql_query($querypgto,$conexao);
	$formapagamento=mysql_result($resultadopgto,0,0);
	
	$dthoje=date("Y-m-d",strtotime("now"));
	//echo $dthoje;
	$query="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) VALUES ('null', '$dthoje', '$cdloja','2', '$nrnota', '$usuario', '$dtnota', '$formapagamento')";
	// codigo 2 guarda os detalhes principais da nota
		//echo $query;
		$resultado = mysql_query($query,$conexao);
	
	$query="SELECT  notas_detalhes.quantidade, notas_detalhes.cdproduto, notas_detalhes.vlproduto, produtos.nome FROM notas_detalhes, notas, produtos WHERE notas_detalhes.cdproduto=produtos.cdproduto AND notas.nrnota=".$nrnota." AND notas.idnota=notas_detalhes.idnota AND notas.cdloja='".$cdloja."'ORDER BY notas_detalhes.iddetalhe";
		$resultado = mysql_query($query,$conexao);
		while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
			$quantidade=$row[0]; // nome da categoria
			$cdproduto=$row[1]; // nome da categoria
			$vlproduto=$row[2]; // nome da categoria
	
		$query2="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) VALUES ('null', '$dthoje', '$cdloja','3', '$nrnota', '$cdproduto', '$quantidade','$vlproduto')"; // codigo 3 é o detalhamento da nota
		
			// echo $query2;
			$resultado2 = mysql_query($query2,$conexao);
		}
} // fim do if (se a nota foi encontrada)

//--------------------------------------------------------------------------------------------------------------
// Faz a exclusao da nota (esta rotina foi movida, pois se fosse executada acima, não daria para salvar o log.
						   
	if($nrnota<>$nrencontrado){
		echo "Nota não localizada, utilize o número sem zeros na frente (Ex: 4550)";
		}	
		else {
			echo "Nota excluida com sucesso<br>";
			}
	
	// Excluir a nota no banco de dados
	$query="DELETE FROM notas WHERE notas.nrnota=".$nrnota;
	$resultado = mysql_query($query,$conexao);
//	echo $query;

	$query="DELETE FROM notas_detalhes WHERE notas_detalhes.nrnota=".$nrnota;
	$resultado = mysql_query($query,$conexao);
//	echo $query;


} // fim do modo=excluir
?>
    
    <p style="padding-top:480px; padding-left:750px">
    <a href="../manutencao/vendas_oficial.php">Inserir</a> nova nota
    </p>
	<? // echo ("<a href='../manutencao/nota.php?nrnota=".$nrnota_inteiro."'>Imprimir</a> nota"); ?>
    </td>
  </tr>
</table>
  
  
</body>
</html>
