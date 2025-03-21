<?php include("msession.php");?>
<html>
<head>
    <title>3DCon</title>
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

    
<!-- Inclui o menu -->
<? include("mmenu.php"); ?>    

    
  
    
<div id="pesquisa_corpo" class="pesquisa_corpo">


<?php
	
	ECHO"<div>Produtos com alguma pendência no site:</div>
	
	<div id='l_cdproduto'>Código</div>
	<div id='l_nome'>Nome</div>
	<div id='l_vlvenda'>Pendências</div>";
	//$query="SELECT cdproduto FROM pvenda where 1  GROUP BY cdproduto ORDER by cdproduto";
	$query="SELECT produtos.cdproduto, produtos.nome, produtos.pendencias FROM produtos WHERE produtos.pendencias<>'' ORDER BY produtos.cdproduto ASC";
	//echo $query;
	$resultado = mysql_query($query,$conexao);

	WHILE ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
			$cdproduto=$row[0];
			$nome=$row[1];
			$pendencias=$row[2];
				ECHO " 
				<div id='l_cdproduto'>$cdproduto</div>
				<div id='l_nome'>$nome</div>
				<div id='l_pendencias'>$pendencias</div>
				<div id='l_site'><a href='../produto.php?cd=$cdproduto' target='_blank'><img src='../imagens/www.png' title='Ver produto no site' width='16' height='16' /></a></div>
				<div id='l_edit'><a href='pinc.php?cdproduto=$cdproduto&modo=editar' target='_blank'><img src='../imagens/edit.png' title='Editar o produto' width='16' height='16' /></a></div>";
	}
?>

</div>
<!-- Fim da div conteudo_principal -->

</div> <!--fim da div wrapper -->
</body>
</html>