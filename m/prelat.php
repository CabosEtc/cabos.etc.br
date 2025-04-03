<?php include("msession.php");?>
<html>
<head>
    <title>Relatórios</title>
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
?>
<div style="padding-top: 50px;">&nbsp</div>
<div class="prelat_img"><a href="plist.php?modo=status1"><img src='../imagens/on.png' title='Exibir o relatório' width='16' height='16' /></a></div>
<div class="prelat_descr">Produtos ativos no site</div>

<div class="prelat_img"><a href="plist.php?modo=status0"><img src='../imagens/off.png' title='Exibir o relatório' width='16' height='16' /></a></div>
<div class="prelat_descr">Produtos desativados no site</div>


<div class="prelat_img"><a href="prelatimg.php?modo=uploads"><img src='../imagens/png.png' title='Exibir o relatório' width='16' height='16' /></a></div>
<div class="prelat_descr">Imagens do diretorio upload</div>

<div class="prelat_img"><a href="prelatimg.php?modo=produtos"><img src='../imagens/png.png' title='Exibir o relatório' width='16' height='16' /></a></div>
<div class="prelat_descr">Imagens do diretorio produtos</div>

<div class="prelat_img"><a href="prelatimg.php?modo=joker"><img src='../imagens/joker.png' title='Exibir o relatório' width='16' height='16' /></a></div>
<div class="prelat_descr">Imagens coringa</div>

<div class="prelat_img"><a href="ppend.php"><img src='../imagens/warning.png' title='Exibir o relatório' width='16' height='16' /></a></div>
<div class="prelat_descr">Produtos com pendências no cadastro</div>

<!-- Fim da div conteudo_principal -->
   </div>


</div> <!--fim da div wrapper -->
</body>
</html>