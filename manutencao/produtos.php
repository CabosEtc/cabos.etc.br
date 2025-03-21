<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Produtos</title>
<link href="../lojas.css" rel="stylesheet" type="text/css">
</head>



<script language="javascript">
<!--
function aumenta(obj){
    obj.height=obj.height*4;
	obj.width=obj.width*4;
}

function diminui(obj){
	obj.height=obj.height/4;
	obj.width=obj.width/4;
}
//-->

<!-- Script de abrir fechar elementos do menu -->

 function abre_div(nome1,nome2)
 {
    var qual_div1 = document.getElementById(nome1);
    var qual_div2 = document.getElementById(nome2);
    qual_div1.style.display="none";
	qual_div2.style.display="block";
 }
 function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
</script>


<body>

<?
session_start();
if (!isset($_SESSION["usuario"])){
			echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
	}

$nivel_usuario=$_SESSION[nivel];

$modo=$_REQUEST["modo"];
$cdsubcategoria_pesquisado=$_REQUEST["cdsubcategoria"];
$procurar=$_REQUEST["procurar"];

//Prepara conexao ao db
include("../conectadb.php");

include("../manutencao/menu.php");
?>

<table width='960' align='center'>
<tr>
<td>
<? // poe o menu igual ao menu da primeira pagina, mas modificado

// seleciona as categorias cadastradas
$query="SELECT categoria, cdcategoria FROM categoria";
$resultado = mysql_query($query,$conexao);

while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	$categoria=$row[0]; // nome da categoria
	$cdcategoria=$row[1]; // nome da categoria

	echo "<div style='display:block' id='".$categoria."_fechado'>";
	echo "<table>";
	echo "<tr><td height='20'  background='../imagens/menu_seta.gif' class='menu_categorias'>
<a href='javascript: abre_div(\"".$categoria."_fechado\",\"".$categoria."_aberto\")'> ".$categoria."</a></td></tr>";
    echo "</table>";
	echo "</div>";

	echo "<div style='display:none' id='".$categoria."_aberto'>";
	echo "<table>";
	echo "<tr><td height='20' background='../imagens/menu_seta.gif' class='menu_categorias'>
<a href='javascript: abre_div(\"".$categoria."_aberto\",\"".$categoria."_fechado\")'> ".$categoria."</a></td></tr>";


	$query2="SELECT subcategoria, cdsubcategoria FROM subcategoria WHERE cdcategoria='".$cdcategoria."' ORDER BY subcategoria";
	$resultado2 = mysql_query($query2,$conexao);

	while ($row = mysql_fetch_array($resultado2, MYSQL_NUM)) {
		$subcategoria=$row[0]; // nome da categoria
		$cdsubcategoria=$row[1]; // nome da categoria
	
		echo "<tr>";
		echo "<td class='menu_subcategorias'><a href='../manutencao/produtos_lista.php?modo=subcategoria&cdsubcategoria=".$cdsubcategoria."'>".$subcategoria."</a></td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "</div>";
}
?>
</td>
<td valign="middle" align="right">
<form id="form1" name="form1" method="get" action="produtos_lista.php">
      <label>
        <input name="procurar" type="text" id="procurar" size="20" maxlength="30" />
      </label>
      <label>
        <input type="submit" name="Pesquisar" id="Pesquisar" value="Pesquisar" />
      </label>
      <input name="modo" type="hidden" id="modo" value="pesquisa" />
    </form>
</td>
</tr>
</table>

<?
echo "<table width='960' align='center'>
<tr><td>"; // tabela estrutural externa



if ($modo=="subcategoria" and $_SESSION["nivel"]<3){
			echo "<meta http-equiv='refresh' content='0; url=../manutencao/mensagem.php?cdmensagem=1'>";
	}


// seleciona o produto no banco de dados

// Escreve todas as categorias no inicio da pagina com link

// Pesquisa novamente pelas categorias e começa a apresentar os produtos, por categoria

if ($modo=="subcategoria")
{
		$sub_query="SELECT nome, cdproduto, vlvenda, vlcompra from produtos WHERE cdsubcategoria='".$cdsubcategoria_pesquisado."' ORDER BY nome";
		echo $sub_query;
		$sub_resultado = mysql_query($sub_query,$conexao);
		echo "<table width='960' align='center'>";
		echo "<tr><td width='60'>Imagem</td><td width='300'>Nome do Produto</td><td width='30'>Código</td><td align='right' width='100'>Venda (R$)</td></tr>";
	
		while ($sub_row = mysql_fetch_array($sub_resultado, MYSQL_NUM)) {
				$nome=$sub_row[0]; // nome do produto
				$cdproduto=$sub_row[1]; // codigo do produto
				$vlvenda_ponto=$sub_row[2]; // valor
				$vlvenda=str_replace(".",",",$vlvenda_ponto);
				$vlcompra_ponto=$sub_row[3]; // valor
				$vlcompra_us=number_format($vlcompra_ponto,2,",","");
				$vlcompra_ponto=$vlcompra_ponto*$cotacao_us; // valor
				$vlcompra=number_format($vlcompra_ponto,2,",","");
				$imagem=$cdproduto.".jpg";
				if ($vlcompra==0){
					$percentual_lucro=0;
					}
					else {
						$percentual_lucro=number_format($vlvenda_ponto/$vlcompra_ponto*100,2,",","");
				}
				
					//if (!file_exists("../imagens/produtos/".$imagem)){
						//$imagem="00000.jpg";
					//}
					
					if ($modo==completo){
						$mostra_vlcompra_us="<td align='right'>".$vlcompra_us."</td>";
						$mostra_vlcompra="<td align='right'>".$vlcompra."</td>";
						$mostra_percentual="<td align='right'>".$percentual_lucro."</td>";
						}
						else {
							$mostra_vlcompra_us="";
							$mostra_vlcompra="";
							$mostra_percentual="";
					}
							
					echo "<tr><td>"."<img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$imagem."' width='50' height='50' onMouseOver='aumenta(this)' onMouseOut='diminui(this)' />"."</td><td>".$nome."</td><td><a href='../manutencao/produtos_editar.php?cdproduto=".$cdproduto."'>".$cdproduto."</a></td>".$mostra_vlcompra_us.$mostra_vlcompra."<td align='right'>".$vlvenda."</td>".$mostra_percentual;
								}
		} // fim do while sub-resultado
	
	echo "</table>";
	echo "<br>";
	
 // fim do if $modo




if ($modo=="pesquisa")
{
		$sub_query="SELECT nome, cdproduto, vlvenda, vlcompra from produtos WHERE nome LIKE '%".$procurar."%' ORDER BY nome";
		//echo $sub_query;
		$sub_resultado = mysql_query($sub_query,$conexao);
		echo "<table width='960' align='center'>";
		echo "<tr><td width='60'>Imagem</td><td width='300'>Nome do Produto</td><td width='30'>Código</td><td align='right' width='100'>Venda (R$)</td></tr>";
	
		while ($sub_row = mysql_fetch_array($sub_resultado, MYSQL_NUM)) {
				$nome=$sub_row[0]; // nome do produto
				$cdproduto=$sub_row[1]; // codigo do produto
				$vlvenda_ponto=$sub_row[2]; // valor
				$vlvenda=str_replace(".",",",$vlvenda_ponto);
				$vlcompra_ponto=$sub_row[3]; // valor
				$vlcompra_us=number_format($vlcompra_ponto,2,",","");
				$vlcompra_ponto=$vlcompra_ponto*$cotacao_us; // valor
				$vlcompra=number_format($vlcompra_ponto,2,",","");
				$imagem=$cdproduto.".jpg";
				if ($vlcompra==0){
					$percentual_lucro=0;
					}
					else {
						$percentual_lucro=number_format($vlvenda_ponto/$vlcompra_ponto*100,2,",","");
				}
				
					
					//if (!file_exists("../imagens/produtos/".$imagem)){
						//$imagem="00000.jpg";
					//}
					
					if ($modo==completo){
						$mostra_vlcompra_us="<td align='right'>".$vlcompra_us."</td>";
						$mostra_vlcompra="<td align='right'>".$vlcompra."</td>";
						$mostra_percentual="<td align='right'>".$percentual_lucro."</td>";
						}
						else {
							$mostra_vlcompra_us="";
							$mostra_vlcompra="";
							$mostra_percentual="";
					}
							
					echo "<tr><td>"."<img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$imagem."' width='50' height='50' onMouseOver='aumenta(this)' onMouseOut='diminui(this)' />"."</td><td>".$nome."</td><td><a href='../manutencao/produtos_editar.php?cdproduto=".$cdproduto."'>".$cdproduto."</a></td>".$mostra_vlcompra_us.$mostra_vlcompra."<td align='right'>".$vlvenda."</td>".$mostra_percentual;
								}
		} // fim do while sub-resultado
	
	echo "</table>";
	echo "<br>";
	
 // fim do if $modo = pesquisar









echo "</td></tr></table>"; // fim da tabela estrutural

?>



</body>
</html>
