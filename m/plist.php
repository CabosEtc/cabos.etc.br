<?php include("msession.php");?>
<html>
<head>
    <title>Ativos no Site</title>
	<meta http-equiv= "Content-Type" content= "text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="manutencao.css">
	<? IF(!$logado){	echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";} ?>
</head>
<body class="body">
<?
//Prepara conexao ao db
include("../conectadb.php");

//Recebe variaveis * $cdloja vem do conectadb 1=cabos 8=supergames
$token=$_REQUEST["token"];
$depuracao=$_REQUEST["depuracao"];
$modo=$_REQUEST["modo"];

// Mostra depuracao
//include("depuracao.php"); 
?> 

<!-- Envoltorio -->
<div id="wrapper" class="wrapper">

<!-- Espacamento superior -->
<div id="topo" class="topo"></div>

<!-- Inclui banner -->
<? //include("banner.php"); ?>
    
<!-- Inclui o menu -->
<? include("mmenu.php"); ?>
    
<div id="pesquisa_corpo" class="pesquisa_corpo">


<?php
IF ($modo=="status1"){ //Ativo
	
	ECHO"<div>Produtos ativos no site:</div>
	
	<div id='l_cdproduto'>Código</div>
	<div id='l_fabricante'>Fabricante</div>	
	<div id='l_nome'>Nome</div>
	<div id='l_vlvenda'>R$</div>";
	$query="SELECT cdproduto FROM pvenda where 1  GROUP BY cdproduto ORDER by cdproduto";
	//$query="SELECT produtos.cdproduto, produtos.nome, pvenda.status, pvenda.vlvenda,fabricantes.nome FROM produtos, pvenda, fabricantes WHERE produtos.cdproduto=pvenda.cdproduto AND fabricantes.cdfabricante=produtos.cdfabricante AND Pvenda.idloja=$cdloja ORDER BY produtos.nome ASC";
	//echo $query;
	$resultado = mysql_query($query,$conexao);

	WHILE ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		$buscaproduto=$row[0]; 
		//echo "$buscaproduto<br>";
		
		$query2="SELECT pvenda.cdproduto, pvenda.status, pvenda.dt, produtos.nome, pvenda.vlvenda, fabricantes.nome FROM pvenda, produtos,fabricantes WHERE pvenda.cdproduto=$buscaproduto AND fabricantes.cdfabricante=produtos.cdfabricante AND pvenda.cdproduto=produtos.cdproduto AND pvenda.idloja=$cdloja ORDER BY pvenda.dt DESC LIMIT 1";
		//echo "$query2<br>";
		$resultado2 = mysql_query($query2,$conexao);
		WHILE ($row = mysql_fetch_array($resultado2, MYSQL_NUM)) {
			$cdproduto=$row[0];
			$status=$row[1];
			$dt=$row[2];
			$nome=$row[3];
			$vlvenda=$row[4];
			$fabricante=$row[5];
			IF($status==1){
				ECHO " 
				<div id='l_cdproduto'>$cdproduto</div>
				<div id='l_fabricante'>$fabricante</div>
				<div id='l_nome'>$nome</div>
				<div id='l_vlvenda'>$vlvenda</div>
				<div id='l_site'><a href='../produto.php?cd=$cdproduto' target='_blank'><img src='../imagens/www.png' title='Ver produto no site' width='16' height='16' /></a></div>
				<div id='l_edit'><a href='pinc.php?cdproduto=$cdproduto&modo=editar' target='_blank'><img src='../imagens/edit.png' title='Editar o produto' width='16' height='16' /></a></div>";
			}
		
		
		}
	}
}

IF ($modo=="status0"){ //Ativo
	
	ECHO"<div>Produtos desativados no site:</div>
	
	<div id='l_cdproduto'>Código</div>
	<div id='l_fabricante'>Fabricante</div>
	<div id='l_nome'>Nome</div>
	<div id='l_vlvenda'>R$</div>";
	$query="SELECT cdproduto FROM pvenda where 1  GROUP BY cdproduto ORDER by cdproduto";
	$resultado = mysql_query($query,$conexao);

	WHILE ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		$buscaproduto=$row[0]; 
		
		$query2="SELECT pvenda.cdproduto, pvenda.status, pvenda.dt, produtos.nome, pvenda.vlvenda, fabricantes.nome FROM pvenda, produtos, fabricantes WHERE pvenda.cdproduto=$buscaproduto AND fabricantes.cdfabricante=produtos.cdfabricante AND pvenda.cdproduto=produtos.cdproduto AND pvenda.idloja=$cdloja ORDER BY pvenda.dt DESC LIMIT 1";
		//echo "$query2<br>";
		$resultado2 = mysql_query($query2,$conexao);
		WHILE ($row = mysql_fetch_array($resultado2, MYSQL_NUM)) {
			$cdproduto=$row[0];
			$status=$row[1];
			$dt=$row[2];
			$nome=$row[3];
			$vlvenda=$row[4];
			$fabricante=$row[5];
			IF($status==0){
				ECHO " 
				<div id='l_cdproduto'>$cdproduto</div>
				<div id='l_fabricante'>$fabricante</div>
				<div id='l_nome'>$nome</div>
				<div id='l_vlvenda'>$vlvenda</div>
				<div id='l_site'><a href='../produto.php?cd=$cdproduto' target='_blank'><img src='../imagens/www.png' title='Ver produto no site' width='16' height='16' /></a></div>
				<div id='l_edit'><a href='pinc.php?cdproduto=$cdproduto&modo=editar' target='_blank'><img src='../imagens/edit.png' title='Editar o produto' width='16' height='16' /></a></div>";
			}
		
		
		}
	}
}

?>

</div>
<!-- Fim da div conteudo_principal -->
   
</div> <!--fim da div wrapper -->
</body>
</html>