﻿<html>
	<head>
		<title>Manutenção</title>
		<meta http-equiv= "Content-Type" content= "text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="manutencao.css">
	</head>
	<body>
		<?
			//Prepara conexao ao db
			include("../conectadb.php");

			include("msession.php");
			IF(!$logado){	
				//echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
			} 
			//echo $nivelusuario;

			//Recebe variaveis
			$token=$_REQUEST["token"];
			$depuracao=$_REQUEST["depuracao"];

			// Mostra depuracao
			//include("depuracao.php"); 
		?> 


		<script src="banner.js"></script>
		<script src="javascript.js"></script>


		<div id="wrapper" class="wrapper">

		<!-- Inclui o menu -->
		<? include("mmenu.php"); ?>    

		<!-- Conteudo principal -->
		<div id="corpo" class="corpo">


		</div> <!--fim do conteudo principal -->


		</div> <!--fim da div wrapper_site -->
	</body>
</html>