<html>
<head>
<meta http-equiv= "Content-Type" content= "text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="manutencao.css">
<title>BD Desativados</title>
</head>
<body>
<?

//Prepara conexao ao db
include("../conectadb.php");

//Variáveis
$dtpesquisa=date("Ymd",strtotime("now"));
$margemMinima=$_REQUEST["margemMinima"];
$margemMaxima=$_REQUEST["margemMaxima"];

// id das lojas no links_boadica
if($cdloja==1) {
	$cdloja1_linksboadica=19;
	$cdloja2_linksboadica=451;
	$LjAbreviada1="CB1";
	$LjAbreviada2="CB2";
	$lojaapelido="Cabos";
	$loja2apelido="Cabos2";
}	

if($cdloja==4) {
	$cdloja1_linksboadica=2;
	$cdloja2_linksboadica=239;
	$LjAbreviada1="SG";
	$LjAbreviada2="SN";
	$lojaapelido="SGames";
	$loja2apelido="SNova";
}
?>

<!-- Inclui o menu -->
<? include("mmenu.php"); ?>   



<?
//echo "$hora<br>";
//echo "Cd loja 1-> $cdloja1_linksboadica , Cd loja 2-> $cdloja2_linksboadica<br>";

echo 	"<div style='float:left; padding-left:10px;'><a href='BDDuploDesativados.php'>
		<img src='../imagens/filtro.gif' title='Exibir todos os itens' /></a></div>";

echo 	"<div style='float:left; padding-left:10px;'><a href='BDDuploDesativados.php?margemMinima=10&margemMaxima=20'>
		<img src='../imagens/filtro.gif' title='Exibir itens com margem entre 10/20%' /></a></div>";
	
echo 	"<div style='float:left; padding-left:10px;'><a href='BDDuploDesativados.php?margemMinima=20&margemMaxima=30'>
		<img src='../imagens/filtro.gif' title='Exibir itens com margem entre 20/30%' /></a></div>";
	
echo 	"<div style='float:left; padding-left:10px;'><a href='BDDuploDesativados.php?margemMinima=30&margemMaxima=40'>
		<img src='../imagens/filtro.gif' title='Exibir itens com margem entre 30/40%' /></a></div>";
	
echo 	"<div style='float:left; padding-left:10px;'><a href='BDDuploDesativados.php?margemMinima=40&margemMaxima=50'>
		<img src='../imagens/filtro.gif' title='Exibir itens com margem entre 40/50%' /></a></div>";
		
echo 	"<div style='float:left; padding-left:10px;'><a href='BDDuploDesativados.php?margemMinima=50&margemMaxima=100'>
		<img src='../imagens/filtro.gif' title='Exibir itens com margem entre 50/100%' /></a></div>";
	
echo 	"<div style='float:left; padding-left:10px;'><a href='BDDuploDesativados.php?margemMinima=100'>
		<img src='../imagens/filtro.gif' title='Exibir itens com margem superior a 100%' /></a></div>";
	

//if ($_SESSION["nivel"]<3){
//			echo "<meta http-equiv='refresh' content='0; url=../manutencao/mensagem.php?cdmensagem=1'>";
//	}
// permite que pagina externas sejam lidas
ini_set('allow_url_fopen', 1);

// seleciona os produtos no banco de dados links_boadica

// Escreve todas as categorias no inicio da pagina com link

if($cdloja==1) {
	$clausulaAtivoLojas=" AND links_boadica.flag_ativo_boadica=0 AND links_boadica.flag_ativo_bdcabos2=0 ";
}
if($cdloja==4) {
	$clausulaAtivoLojas=" AND links_boadica.flag_ativo_bdsg=0 AND links_boadica.flag_ativo_bdsg2=0 ";
}

$query="SELECT links_boadica.produto, links_boadica.link, links_boadica.cdproduto, links_boadica.flag_ativo, links_boadica.marca,  
		links_boadica.id, links_boadica.flag_ativo_boadica, links_boadica.flag_ativo_bdcabos2, produtos.prioridade, 
        produtos.nome  
		FROM links_boadica, produtos 
		WHERE links_boadica.cdproduto=produtos.cdproduto  $clausulaAtivoLojas AND flag_ativo=1 
		ORDER BY produtos.prioridade DESC, produtos.nome ASC";

$resultado = mysql_query($query,$conexao);
$quant_itens_desativados=mysql_numrows($resultado);

//echo $query;

$contador_item=0;

echo "<h3>Produtos desativados em ambas lojas no BD, margem entre $margemMinima/$margemMaxima% (* Ativos para acompanhamento) [<b>$quant_itens_desativados</b> itens]</h3><br>";

echo "<table border='0'cellspacing='0' cellpadding='0'>";
echo "<tr border='0'>
		<td style='padding-right: 5px;'>Prior</td>
		<td bgcolor='Gainsboro' style='padding-right: 5px;'>Id</td>
		<td>Código</td>
		<td>Nome no sistema</td>
		<td>Nome no Boadica</td>
		<td>Marca</td>
		<td>&nbsp</td>
		<td>Faixa custo</td>
		<td>Prédio</td>
		<td style='padding-left:10px'>%Lucro</td>
		<td width='60' colspan='2' bgcolor='Gainsboro' border='0'>$lojaapelido</td>
		<td width='60' colspan='2'>$loja2apelido</td>
		<td>Status</td>
		<td>BD</td>
		<td>Grupo</td>
		<td>Id</td></tr>";
$cdProdutoAnterior="00000";
while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	$produto=$row[0]; 
	$link=$row[1];
  	$cdproduto=$row[2];
	$flag_ativo=$row[3]; // este eh o flag de ativo para pesquisa (se vai entrar na pesquisa)
	$marca=$row[4];
	$id=$row[5];
	$flag_ativo_boadica=$row[6];
	IF ($flag_ativo_boadica=="1"){
		$power_cb1="../imagens/bola_verde.gif";
	}
	ELSE{
		$power_cb1="../imagens/bola_vermelha.gif";
	}
	$flag_ativo_bdcabos2=$row[7];
	IF ($flag_ativo_bdcabos2=="1"){
		$power_cb2="../imagens/bola_verde.gif";
	}
	ELSE{
		$power_cb2="../imagens/bola_vermelha.gif";
	}
	$prioridadeProduto=$row[8];
	$nome=$row[9];
    
  
	$query_preco_cb="SELECT links_boadica_detalhes_lojas.preco
					FROM links_boadica_detalhes_lojas
					WHERE links_boadica_detalhes_lojas.id_loja=$cdloja1_linksboadica AND links_boadica_detalhes_lojas.id_produto=".$id." 
					ORDER BY links_boadica_detalhes_lojas.data DESC";
	//echo $query2;
	$resultado_preco_cb = mysql_query($query_preco_cb,$conexao);
	if(mysql_num_rows($resultado_preco_cb)>0){
		$preco_cb=mysql_result($resultado_preco_cb,0,0);
	}	else {
		$preco_cb=0;
	}


	$query_preco_cb2="SELECT links_boadica_detalhes_lojas.preco
						FROM links_boadica_detalhes_lojas
						WHERE links_boadica_detalhes_lojas.id_loja=$cdloja2_linksboadica 
						AND links_boadica_detalhes_lojas.id_produto=".$id." 
						ORDER BY links_boadica_detalhes_lojas.data DESC";
	//echo $query2;
	$resultado_preco_cb2 = mysql_query($query_preco_cb2,$conexao);
	if(mysql_num_rows($resultado_preco_cb2)>0){
		$preco_cb2=mysql_result($resultado_preco_cb2,0,0);
	}	else {
		$preco_cb2=0;
	}



	$queryMenorPrecoPredio="SELECT links_boadica_detalhes_snapshot.preco
							FROM links_boadica_detalhes_snapshot, lojas_boadica 
							WHERE links_boadica_detalhes_snapshot.id_loja=lojas_boadica.id_loja 
							AND links_boadica_detalhes_snapshot.id_produto=$id 
							AND lojas_boadica.flag_predio=1  
							ORDER BY links_boadica_detalhes_snapshot.preco ASC";
	//echo "$queryMenorPrecoPredio<br>";
	$resultadoMenorPrecoPredio = mysql_query($queryMenorPrecoPredio,$conexao);
	if(mysql_num_rows($resultadoMenorPrecoPredio)>0){
		$menorPrecoPredio=mysql_result($resultadoMenorPrecoPredio,0,0);
	}	
	else{
		$menorPrecoPredio='---';
	}


	$queryValorMinimo="SELECT estoque.vlindividual 
						FROM estoque
						WHERE estoque.cdproduto='$cdproduto'   
						AND estoque.cdloja=$cdloja ORDER BY vlindividual ASC LIMIT 1 ";
	$resultadoValorMinimo = mysql_query($queryValorMinimo,$conexao);
	//echo "$query2<br>";
	$vlIndividualMinimo=mysql_result($resultadoValorMinimo,0,0);

	$queryValorMaximo="SELECT estoque.vlindividual 
						FROM estoque
						WHERE estoque.cdproduto='$cdproduto'   
						AND estoque.cdloja=$cdloja ORDER BY vlindividual DESC LIMIT 1 ";
	$resultadoValorMaximo = mysql_query($queryValorMaximo,$conexao);
	//echo "$query2<br>";
	$vlIndividualMaximo=mysql_result($resultadoValorMaximo,0,0);

	if($vlIndividualMinimo<>"" OR $vlIndividualMaximo<>""){
		$faixaCusto=$vlIndividualMinimo. " / ".$vlIndividualMaximo;
	}    
	else{
		$faixaCusto="";
	}


	$percentualLucro=($menorPrecoPredio-$vlIndividualMinimo)/$vlIndividualMinimo*100;
	$percentualLucro=number_format($percentualLucro, 2, '.', ',');
	if($percentualLucro<=0){
		$percentualLucro="---";
	}

	if($percentualLucro<=$margemMaxima OR $margemMaxima==""){
		$clausulaMargemMaxima=true;
	}
	else{
		$clausulaMargemMaxima=false;
	}

	$classeTr="classeTr".$cdproduto;

	if ($cdproduto<>$cdProdutoAnterior){
		echo "
		<tr bgcolor='Gainsboro' height='30' onclick='ocultarExibir(\"$classeTr\");'>
			<td>
                $prioridadeProduto
			</td>
			<td style='padding-right: 5px;'>
				$cdproduto
			</td>
			<td style='padding-right: 5px;'>
				$nome
			</td>
			<td colspan='16'>
				&nbsp;
			</td>
			<td style='padding-right: 5px;'>
				<a href='BDJs.php?cdproduto=$cdproduto' target='_blank'><img src='../imagens/thunder.png' width='16' height='16' /></a>
			</td>
		</tr>";
	}
	
	if($percentualLucro>=$margemMinima AND $clausulaMargemMaxima){
		echo "
		<tr  class='$classeTr' style='display: none; height: 20px;' border='0'>
			<td align='right' style='padding-right: 5px;'>
				$prioridadeProduto
			</td>
			<td bgcolor='Gainsboro'  style='padding-right: 5px;'>
				$id
			</td>
			<td title='$nome'>
				$cdproduto
			</td>
			<td>
				$nome
			</td>
			<td>
				$produto
			</td>
			<td>
				$marca
			</td>
			<td>
				<a href='elisthistorico.php?cdproduto=$cdproduto' TARGET='_blank'><img src='../imagens/lista.png' title='Histórico de custos\ndo produto'></a>
			</td>
			<td>
				$faixaCusto
			</td>
			<td>
				$menorPrecoPredio
			</td>
			<td style='padding-left:10px'>
				$percentualLucro
			</td>
			<td bgcolor='Gainsboro' border='0'>
				<img src='$power_cb1'>
			</td>
			<td bgcolor='Gainsboro' border='0'>
				$preco_cb
			</td>
			<td>
				<img src='$power_cb2'>
			</td>
			<td>
				$preco_cb2
			</td>
			<td>
				<img src='../imagens/smile.png'>
			</td>
			<td>
				<a href='$link' target='_blank'>
					<img src='../imagens/coruja.png'>
				</a>
			</td>
			<td>
				<a href='BDPrecos.php?cdproduto=$cdproduto&showall=1' target='_blank'>
					<img src='../imagens/spy.png'>
				</a>
			</td>
			<td>
				<a href='BDPrecos.php?inicio_id=$id&limite=1' target='_blank'>
					<img src='../imagens/camera.png'>
				</a>
			</td>
		</tr>";
	}
    $cdProdutoAnterior=$cdproduto;

} // Fim da linha de exibicao do produto
	echo "</table>";
?>

<script>
function ocultarExibir(classeTr){
	//alert(classeTr);
	x=document.getElementsByClassName(classeTr); 
	//alert(x.length);
	var i;
	var statusAtual;
	for (i = 0; i < x.length; i++) {
		statusAtual=x[i].style.display;
		//alert(x[i].style.display);
		if (statusAtual=='none'){
			x[i].style.display = 'table-row';
		}
		else if (statusAtual=='table-row'){
			x[i].style.display = 'none';
		}
		//x[i].style.display = 'none';
	}
}
</script>

</body>
</html>
