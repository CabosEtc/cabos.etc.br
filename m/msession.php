<?php
	$session_status_inicial=session_status();
	IF (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
		$_SESSION['data']="hoje";
		//setcookie('teste', 'teste', (time() + (3 * 24 * 3600)));
		$token=session_id();
	}

	IF (isset($_SESSION["user"])){
		$logado=true;
		$idusuario=$_SESSION["user"]["idusuario"];
		$nomeusuario=$_SESSION["user"]["usuario"];
		$nivelusuario=$_SESSION["user"]["nivel"];
		$cdLoja==$_SESSION["user"]["cdLoja"];
	}

	ELSE {
		$logado=false;
	}

	IF (isset($_COOKIE["idUsuario"]) AND isset($_COOKIE["nomeUsuario"]) AND isset($_COOKIE["nivelUsuario"]) AND isset($_COOKIE["cdLoja"])){
		$logado=true;
		$idusuario=$_COOKIE["idUsuario"];
		$nomeusuario=$_COOKIE["nomeUsuario"];
		$nivelusuario=$_COOKIE["nivelUsuario"];
		$cdLoja=$_COOKIE["cdLoja"];
		$cdloja=$_COOKIE["cdLoja"];
	}

	
	if($cdloja==1) {
		$idlojabd=19;
		$idloja2bd=451;
		$abreviacao2Loja1="Cabos";
		$abreviacao2Loja2="Cabos2";
	}

	if($cdloja==4) {
		$idlojabd=2;
		$idloja2bd=239;
		$abreviacao2Loja1="Supergames";
		$abreviacao2Loja2="Supernova";
	}

	if($cdloja==8) {
		$idlojabd=999;
		//$idloja2bd=239;
		$abreviacao2Loja1="Cabos Matriz";
		//$abreviacao2Loja2="Supernova";
	}
?>