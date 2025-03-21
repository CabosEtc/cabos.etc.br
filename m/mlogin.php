<?php

	//Prepara conexao ao db
	include("../conectadb.php");

	//Inicia a sessão
	include("msession.php");
	
	//Recebe variaveis
	$modo=$_REQUEST["modo"];
	$user=$_REQUEST["user"];
	$password=$_REQUEST["password"];

	IF($modo=='login'){
		$query = "	SELECT idusuario, usuario, nivel, status, cdloja   
					FROM usuarios 
					WHERE usuario='$user' 
					AND senha='$password'";

					/* AND cdloja=$cdloja";  Foi retirado o filtro de loja em 05Jun22, para permitir logar e a loja ser setada a partir do usuario logado. 
					*/
		//echo "$query<br>";
		$resultado = mysql_query($query,$conexao);
		$total=mysql_num_rows($resultado);

		$idusuario=mysql_result($resultado, 0,0); 
		$usuario=mysql_result($resultado, 0,1); 
		$nivel=mysql_result($resultado, 0,2); 
		$statusUsuario=mysql_result($resultado, 0,3);   // 1=usuario ativo 0=usuario desativado
		$cdLoja=mysql_result($resultado, 0,4); // Nova variavel para ser tratada como Global
		$cdloja=mysql_result($resultado, 0,4); // Vai acertar o numero da loja, antes dependia do arquivo loja.txt, agora depende do usuario logago, atentar para msession estar depois de conectadb

		if ($total==1 AND $statusUsuario==1){
			//ECHO "$idusuario / $usuario / $nivel<br>";
			$_SESSION["user"]= array(idusuario=>$idusuario, usuario=>$usuario, nivel=>$nivel, cdloja=>$cdLoja);
			setcookie('idUsuario', $idusuario, (time() + (1 * 10 * 3600))); //10h
			setcookie('nomeUsuario', $usuario, (time() + (1 * 10 * 3600)));
			setcookie('nivelUsuario', $nivel, (time() + (1 * 10 * 3600)));
			setcookie('cdLoja', $cdLoja, (time() + (1 * 10 * 3600)));
			
			//echo $_SESSION["user"]["usuario"];
			echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
		}
		else {
			echo "Usuário desativado, procure o Admin do sistema";
			echo "<meta http-equiv='refresh' content='10 url=index.php' target='_SELF'>";
		}	
	}


	IF($modo=='logoff'){
			// Destroi a sessão
			unset($_SESSION["usuario"]);
			session_destroy();

			// Destroi os cookies
			setcookie('idUsuario');
			setcookie('nomeUsuario');
			setcookie('nivelUsuario');
			setcookie('cdLoja');

			echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
	}
?>