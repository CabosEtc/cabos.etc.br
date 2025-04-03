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

session_start();
$usuario=$_SESSION['usuario'];

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

<?
session_start();
//if (!isset($_SESSION["usuario"])){
//			echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
//	}
include("../manutencao/menu.php");
?>

<?
$modo=$_REQUEST["modo"];
$produto=$_REQUEST["produto"];
$vlcompra=$_REQUEST["vlcompra"];
$vlvenda=$_REQUEST["vlvenda"];
$vlvendasite=$_REQUEST["vlvendasite"];
$cdmoeda=$_REQUEST["cdmoeda"];
$ativo=$_REQUEST["ativo"];
$siteflag=$_REQUEST["siteflag"];
$garantia=$_REQUEST["garantia"];

//echo "total de elementos:".count($produto);

if ($modo=="Incluir produtos"){
	echo "<meta http-equiv='refresh' content='0; url=../manutencao/precos_cadprodutos.php'>";
	}

if ($modo=="Atualizar precos"){
	

	// echo "loja=".$cdloja."<br>";
	$contador=0;
	foreach ($produto as $rotulo => $cdproduto):
	// echo "$cdproduto";
		//$ponteirodoarray=key($produto);
		$vlcompraproduto=$vlcompra[$contador];
		$vlvendaproduto=$vlvenda[$contador];
		$cdativo=$ativo[$contador];
		$cdsiteflag=$siteflag[$contador];
		$prazogarantia=$garantia[$contador];
		$codigomoeda=$cdmoeda[$contador];
		$valorvendasite=$vlvendasite[$contador];
		// echo $cdativo;
		if ($cdativo=="on"){
			$cdativo=1;
		}
				else {
					$cdativo=0;
					}
		if ($cdsiteflag=="on"){
			$cdsiteflag=1;
		}
				else {
					$cdsiteflag=0;
					}

		// echo $vlvendaproduto."<br>";
		// echo "ponteiro do array = ".$ponteirodoarray."<br>";
		
		// aqui entra um comparacao do preço que está no sistema com o preco que veio da tela de atualização, se for diferente, cadastra no log do sistema.
		$querypreco="SELECT vlcompra, vlvenda, cdmoeda, vlvendasite FROM precos WHERE cdproduto='".$cdproduto."' AND cdloja='".$cdloja."'";
		$resultadopreco = mysql_query($querypreco,$conexao);
		$vlcompraproduto_sistema=mysql_result($resultadopreco,0,0);
		$vlvendaproduto_sistema=mysql_result($resultadopreco,0,1);
		$cdmoeda_sistema=mysql_result($resultadopreco,0,2);
		$vlvendasite_sistema=mysql_result($resultadopreco,0,3);
		if ($vlcompraproduto_sistema<>$vlcompraproduto){
			echo "o valor de compra do produto ".$cdproduto." foi alterado de R$".$vlcompraproduto_sistema." para R$".$vlcompraproduto."<br>";
			// Rotinas de log: Registra a impressão no LOG do sistema:
			$dthoje=date("Y-m-d",strtotime("now"));
			$query_vlcompra="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) VALUES ('null', '$dthoje', '$cdloja', '4', '$cdproduto', '$usuario','$vlcompraproduto_sistema', '$vlcompraproduto')"; // codigo 4 = alteracao de valor de compra
				$resultado_vlcompra = mysql_query($query_vlcompra,$conexao);
			}

		if ($vlvendaproduto_sistema<>$vlvendaproduto){
			echo "o valor de venda do produto ".$cdproduto." foi alterado de R$".$vlvendaproduto_sistema." para R$".$vlvendaproduto."<br>";
			// Rotinas de log: Registra a impressão no LOG do sistema:
			$dthoje=date("Y-m-d",strtotime("now"));
			$query_vlvenda="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) VALUES ('null', '$dthoje', '$cdloja', '5', '$cdproduto', '$usuario','$vlvendaproduto_sistema', '$vlvendaproduto')"; // codigo 5 = alteracao de valor de venda
				$resultado_vlvenda = mysql_query($query_vlvenda,$conexao);
			}

		if ($cdmoeda_sistema<>$codigomoeda){
			echo "A moeda do produto ".$cdproduto." foi alterado de ".$cdmoeda_sistema." para ".$codigomoeda."<br>";
			// Rotinas de log: Registra a impressão no LOG do sistema:
			$dthoje=date("Y-m-d",strtotime("now"));
			$query_vlvenda="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) VALUES ('null', '$dthoje', '$cdloja', '6', '$cdproduto', '$usuario','$cdmoeda_sistema', '$codigomoeda')"; // codigo 5 = alteracao de valor de venda
				$resultado_vlvenda = mysql_query($query_vlvenda,$conexao);
			}
		
		if ($vlvendasite_sistema<>$valorvendasite){
			echo "O valor de venda no site do produto ".$cdproduto." foi alterado de ".$vlvendasite_sistema." para ".$valorvendasite."<br>";
			// Rotinas de log: Registra a impressão no LOG do sistema:
			$dthoje=date("Y-m-d",strtotime("now"));
			$query_vlvenda="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) VALUES ('null', '$dthoje', '$cdloja', '7', '$cdproduto', '$usuario','$vlvendasite_sistema', '$valorvendasite')"; // codigo 5 = alteracao de valor de venda
				$resultado_vlvenda = mysql_query($query_vlvenda,$conexao);
			}
		
			$query="UPDATE precos SET vlcompra='".$vlcompraproduto."',vlvenda='".$vlvendaproduto."', ativo='".$cdativo."', garantia='".$prazogarantia."', siteflag='".$cdsiteflag."', cdmoeda='".$codigomoeda."', vlvendasite='".$valorvendasite."' WHERE cdproduto='".$cdproduto."' AND cdloja='".$cdloja."'";
			$resultado = mysql_query($query,$conexao);
			// echo $query."<br>";
		
		$contador=$contador+1;
	endforeach;
	
echo "<script>";
echo "window.alert(\"Valores atualizados!\" ); ";
echo "</script>";

} // fim do if
?>

<br />

<form action="precos.php" method="post">
<table width="960" border="1" align="center">
  <tr>
    <td>Fabricante</td>
    <td>Modelo (categoria)</td>
    <td align="right">Valor Compra</td>
    <td>Moeda</td>
    <td align="right">Valor Loja</td>
    <td align="right">Valor Site</td>
    <td>Garantia (dias)</td>
    <td>Ativo Loja</td>
    <td>Ativo Site</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<? 

$query_moedas="SELECT cdmoeda FROM moedas ORDER BY cdmoeda";
$resultado_moedas = mysql_query($query_moedas,$conexao);


$query="SELECT precos.cdproduto, precos.vlcompra, precos.vlvenda, fabricantes.nome, produtos.nome, precos.ativo, precos.garantia, precos.siteflag, precos.cdmoeda, precos.vlvendasite, precos.cdsubcategoria FROM precos, produtos, fabricantes WHERE produtos.cdproduto = precos.cdproduto
AND fabricantes.cdfabricante=produtos.cdfabricante
AND produtos.cdproduto=precos.cdproduto
AND precos.cdloja = '".$cdloja."'
ORDER BY produtos.cdfabricante, precos.cdproduto ASC";
	
	// echo $query;
	$resultado = mysql_query($query,$conexao);
	
	$contador=0;
	while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		$cdproduto=$row[0]; // nome da categoria
		$vlcompra=$row[1]; // nome da categoria
		$vlvenda=$row[2]; // nome da categoria
		$nomefabricante=$row[3]; // nome da categoria
		$nomeproduto=$row[4]; // nome da categoria
		$ativo=$row[5];
		$garantia=$row[6];
		if ($ativo=="1"){
			$ativo="checked='true'";
		}
			else { 
				$ativo="";
			}
		$siteflag=$row[7];
		if ($siteflag=="1"){
			$siteflag="checked='true'";
		}
			else { 
				$siteflag="";
			}
		$cdmoeda=$row[8];
		$vlvendasite=$row[9];
		$cdsubcategoria=$row[10];


		$moeda_inicio="<label for='cdmoeda[".$contador."]'></label><select name='cdmoeda[".$contador."]' id='cdmoeda[".$contador."]'>";
		
			$moeda_meio=""; // inicializa
			mysql_data_seek($resultado_moedas,0); // reseta o ponteiro do mysql_fetch_array.
			
			while ($row_moeda = mysql_fetch_array($resultado_moedas, MYSQL_NUM)) {
				$nome_moeda=$row_moeda[0]; // nome das moedas no BD
				$moeda_meio=$moeda_meio."<option value='".$nome_moeda."'";
				if ($nome_moeda==$cdmoeda){
					$moeda_meio=$moeda_meio." selected='selected'";
					} 
				$moeda_meio=$moeda_meio.">".$nome_moeda."</option>";
			}
		$moeda_fim="</select>";
		$moeda=$moeda_inicio.$moeda_meio.$moeda_fim;
		echo "<tr><td>".$nomefabricante."</td><td><a href='../manutencao/produtos_editar.php?cdproduto=".$cdproduto."'>".$cdproduto."</a>-".$nomeproduto." (".$cdsubcategoria.")<input type='hidden' name='produto[".$contador."]' id='produto[".$contador."]' value='".$cdproduto."'/></td><td align='right'><input type='text' name='vlcompra[".$contador."]' id='vlcompra[".$contador."]' value='".$vlcompra."' /></td><td>".$moeda."</td><td align='right'><input type='text' name='vlvenda[".$contador."]' id='vlvenda[".$contador."]' value='".$vlvenda."' /></td><td align='right'><input type='text' name='vlvendasite[".$contador."]' id='vlvendasite[".$contador."]' value='".$vlvendasite."' /></td><td align='right'><input type='text' name='garantia[".$contador."]' id='garantia[".$contador."]' align='right' value='".$garantia."' /></td><td align='right'><input type='checkbox' name='ativo[".$contador."]' id='ativo[".$contador."]'".$ativo."/></td><td align='right'><input type='checkbox' name='siteflag[".$contador."]' id='siteflag[".$contador."]'".$siteflag."/></td></tr>";
	$contador=$contador+1;
	}
?>

  <tr>
    <td><label>
      <input type="hidden" name="cdloja" id="cdloja" value='<? echo $cdloja; ?>'/>
      <input type="submit" name="modo" id="modo" value="Atualizar precos" />
    </label></td>
    <td><input type="submit" name="modo" id="modo" value="Incluir produtos" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
