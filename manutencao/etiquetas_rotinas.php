<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Etiquetas</title>
</head>

<body>
<p>
<?
$modo=$_REQUEST["modo"];
$cd1=$_REQUEST["cd1"];
$cd2=$_REQUEST["cd2"];
$cd3=$_REQUEST["cd3"];
$cd4=$_REQUEST["cd4"];

if ($modo!=="todas_as_etiquetas"){
	include("../manutencao/menu.php");
}

//Prepara conexao ao db
include("../conectadb.php");

// Lê o arquivo original e carrega na variavel

$arquivo_original=fopen("../manutencao/etiqueta_padrao.doc","rt");
while (!feof($arquivo_original)){
	$conteudo.=fgets($arquivo_original,1024);
}



if ($modo==80){
	$query="SELECT nome FROM produtos WHERE cdproduto='".$cd1."'";
	$resultado = mysql_query($query,$conexao);
	$nome=mysql_result($resultado,0,0);
	$nome=sprintf("%-40s",$nome);
	
	$conteudo=str_replace("00000",$cd1,$conteudo);
	$conteudo=str_replace("11111",$cd1,$conteudo);
	$conteudo=str_replace("22222",$cd1,$conteudo);
	$conteudo=str_replace("33333",$cd1,$conteudo);
	$conteudo=str_replace("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",$nome,$conteudo);
	$conteudo=str_replace("bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb",$nome,$conteudo);
	$conteudo=str_replace("cccccccccccccccccccccccccccccccccccccccc",$nome,$conteudo);
	$conteudo=str_replace("dddddddddddddddddddddddddddddddddddddddd",$nome,$conteudo);
	$nome_arquivo_novo=$cd1.".doc";
}


if ($modo==4040){
	$query="SELECT nome FROM produtos WHERE cdproduto='".$cd1."'";
	$resultado = mysql_query($query,$conexao);
	$nome=mysql_result($resultado,0,0);
	$nome=sprintf("%-40s",$nome);
	
	$query="SELECT nome FROM produtos WHERE cdproduto='".$cd2."'";
	$resultado = mysql_query($query,$conexao);
	$nome2=mysql_result($resultado,0,0);
	$nome2=sprintf("%-40s",$nome2);

	$conteudo=str_replace("00000",$cd1,$conteudo);
	$conteudo=str_replace("11111",$cd1,$conteudo);
	$conteudo=str_replace("22222",$cd2,$conteudo);
	$conteudo=str_replace("33333",$cd2,$conteudo);
	$conteudo=str_replace("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",$nome,$conteudo);
	$conteudo=str_replace("bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb",$nome,$conteudo);
	$conteudo=str_replace("cccccccccccccccccccccccccccccccccccccccc",$nome2,$conteudo);
	$conteudo=str_replace("dddddddddddddddddddddddddddddddddddddddd",$nome2,$conteudo);
	$nome_arquivo_novo="etiquetas.doc";
}


if ($modo==20202020){
	$query="SELECT nome FROM produtos WHERE cdproduto='".$cd1."'";
	$resultado = mysql_query($query,$conexao);
	$nome=mysql_result($resultado,0,0);
	$nome=sprintf("%-40s",$nome);
	
	$query="SELECT nome FROM produtos WHERE cdproduto='".$cd2."'";
	$resultado = mysql_query($query,$conexao);
	$nome2=mysql_result($resultado,0,0);
	$nome2=sprintf("%-40s",$nome2);

	$query="SELECT nome FROM produtos WHERE cdproduto='".$cd3."'";
	$resultado = mysql_query($query,$conexao);
	$nome3=mysql_result($resultado,0,0);
	$nome3=sprintf("%-40s",$nome3);

	$query="SELECT nome FROM produtos WHERE cdproduto='".$cd4."'";
	$resultado = mysql_query($query,$conexao);
	$nome4=mysql_result($resultado,0,0);
	$nome4=sprintf("%-40s",$nome4);

	$conteudo=str_replace("00000",$cd1,$conteudo);
	$conteudo=str_replace("11111",$cd2,$conteudo);
	$conteudo=str_replace("22222",$cd3,$conteudo);
	$conteudo=str_replace("33333",$cd4,$conteudo);
	$conteudo=str_replace("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",$nome,$conteudo);
	$conteudo=str_replace("bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb",$nome2,$conteudo);
	$conteudo=str_replace("cccccccccccccccccccccccccccccccccccccccc",$nome3,$conteudo);
	$conteudo=str_replace("dddddddddddddddddddddddddddddddddddddddd",$nome4,$conteudo);
	$nome_arquivo_novo="etiquetas.doc";
}


if ($modo==402020){
	$query="SELECT nome FROM produtos WHERE cdproduto='".$cd1."'";
	$resultado = mysql_query($query,$conexao);
	$nome=mysql_result($resultado,0,0);
	$nome=sprintf("%-40s",$nome);
	
	$query="SELECT nome FROM produtos WHERE cdproduto='".$cd2."'";
	$resultado = mysql_query($query,$conexao);
	$nome2=mysql_result($resultado,0,0);
	$nome2=sprintf("%-40s",$nome2);

	$query="SELECT nome FROM produtos WHERE cdproduto='".$cd3."'";
	$resultado = mysql_query($query,$conexao);
	$nome3=mysql_result($resultado,0,0);
	$nome3=sprintf("%-40s",$nome3);

	$conteudo=str_replace("00000",$cd1,$conteudo);
	$conteudo=str_replace("11111",$cd1,$conteudo);
	$conteudo=str_replace("22222",$cd2,$conteudo);
	$conteudo=str_replace("33333",$cd3,$conteudo);
	$conteudo=str_replace("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",$nome,$conteudo);
	$conteudo=str_replace("bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb",$nome,$conteudo);
	$conteudo=str_replace("cccccccccccccccccccccccccccccccccccccccc",$nome2,$conteudo);
	$conteudo=str_replace("dddddddddddddddddddddddddddddddddddddddd",$nome3,$conteudo);
	$nome_arquivo_novo="etiquetas.doc";
}


//$codigo="09002";
//$nome="Mouse otico sem fio";


// Rotina comum a todas as escolhas

if ($modo!=="todas_as_etiquetas"){
	$arquivo_destino=fopen($nome_arquivo_novo,"w+");
	fwrite($arquivo_destino,$conteudo);
}
echo "<table width='960' border='0' align='center' cellpadding='0' cellspacing='0'>";
echo "<tr>";
echo "<td>";

if ($modo!=="todas_as_etiquetas"){
	echo "<p><h3>Verifique abaixo se os códigos estão corretos e clique em \"baixar etiqueta\"</h3></p>";
	echo "<b>Código - Produto</b><br/>";
	echo $cd1."  - ".$nome."<br/>";
	if ($cd2<>""){
		echo $cd2." - ".$nome2."<br/>";
		}
	if ($cd3<>""){
		echo $cd3."  - ".$nome3."<br/>";
		}
	if ($cd4<>""){
		echo $cd4."  - ".$nome4."<br/>";
		}
	echo "<br/>";
	echo "<a href='../manutencao/".$nome_arquivo_novo."'>baixar etiqueta</a>";
}

if ($modo=="todas_as_etiquetas"){
	//Prepara conexao ao db
include("../conectadb.php");


		$sub_query3="SELECT sum(quantidade) as entrada from estoque WHERE cdproduto='".$cdproduto."' and (cdstatus='1' OR cdstatus='2')"; // entrada via compra anterior ou entrada manual
		//	echo $sub_query;
		$sub_resultado3 = mysql_query($sub_query3,$conexao);
		$entrada=mysql_result($sub_resultado3,0,0);
		
		$sub_query4="SELECT sum(quantidade) as vendidos from notas_detalhes WHERE cdproduto='".$cdproduto."'";
		//	echo $sub_query;
		$sub_resultado4 = mysql_query($sub_query4,$conexao);
		$vendidos=mysql_result($sub_resultado4,0,0);

		$sub_query5="SELECT SUM(compras.quantidade*produtos.vlvenda) as soma_a_chegar from compras, produtos WHERE compras.cdproduto=produtos.cdproduto AND compras.cdproduto='".$cdproduto."' AND compras.cdstatus='0'";
		//	echo $sub_query;
		$sub_resultado5 = mysql_query($sub_query5,$conexao);
		$soma_a_chegar=mysql_result($sub_resultado5,0,0);

		$estoque_atual=$entrada-$vendidos;



	$query="SELECT cdproduto, nome FROM produtos ORDER BY cdproduto";
	$resultado = mysql_query($query,$conexao);
	echo "\"codigo\",\"nome\"<br/>";

while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	$cdproduto=$row[0]; // nome da categoria
	$nome=$row[1]; // nome da categoria

		$sub_query3="SELECT sum(quantidade) as entrada from estoque WHERE cdproduto='".$cdproduto."' and (cdstatus='1' OR cdstatus='2')"; // entrada via compra anterior ou entrada manual
		//	echo $sub_query;
		$sub_resultado3 = mysql_query($sub_query3,$conexao);
		$entrada=mysql_result($sub_resultado3,0,0);
		
		$sub_query4="SELECT sum(quantidade) as vendidos from notas_detalhes WHERE cdproduto='".$cdproduto."'";
		//	echo $sub_query;
		$sub_resultado4 = mysql_query($sub_query4,$conexao);
		$vendidos=mysql_result($sub_resultado4,0,0);

		$sub_query5="SELECT SUM(compras.quantidade*produtos.vlvenda) as soma_a_chegar from compras, produtos WHERE compras.cdproduto=produtos.cdproduto AND compras.cdproduto='".$cdproduto."' AND compras.cdstatus='0'";
		//	echo $sub_query;
		$sub_resultado5 = mysql_query($sub_query5,$conexao);
		$soma_a_chegar=mysql_result($sub_resultado5,0,0);

		$estoque_atual=$entrada-$vendidos;

		if ($estoque_atual>0){ // listar somente se o estoque for maior que zero.
			for ($i = 1; $i <= 20; $i++) {
				echo "\"".$cdproduto."\"".","."\"".$nome."\""."<br/>";
			}
		}
}


	}
// Fim do modo = todas as etiquetas

echo "</td>";
echo "</tr>";
echo "</table>";


?>
</body>
</html>