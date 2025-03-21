<?php
$session_status_inicial=session_status();
IF (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
	$_SESSION['data']="hoje";
	setcookie('teste', 'teste', (time() + (3 * 24 * 3600)));
	$token=session_id();
}

IF (isset($_SESSION["user"])){
	$logado=true;
	$idusuario=$_SESSION["user"]["idusuario"];
	$nomeusuario=$_SESSION["user"]["usuario"];
	$nivelusuario=$_SESSION["user"]["nivel"];
	}
	ELSE{
	$logado=false;
	}
?>