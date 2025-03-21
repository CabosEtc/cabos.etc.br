<?php include("msession.php");?>
<html>
<head>
<link href="" rel="stylesheet" type="text/css" />
<?
//Prepara conexao ao db
include("../conectadb.php");

$modo=$_REQUEST['modo'];
$usuario=$_REQUEST['usuario'];
$senha=$_REQUEST['senha'];

echo "$usuario / $senha / $modo / $loja / $cdloja<br>";

if ($modo=="logoff"){
unset($_SESSION['usuario']);
unset($_SESSION['senha']);
//echo "<meta http-equiv='refresh' content='0; url=index.php'>";
}

if ($modo=="logon"){
	
	//Filtra pela cidade origem fornecida
	$query = "select usuario, senha, nivel, email FROM usuarios WHERE usuario='".$usuario."' AND senha='".$senha."' AND cdloja='".$cdloja."'";
	echo "$query<br>";	
	$resultado = mysql_query($query,$conexao);
	$total=mysql_num_rows($resultado);
	if ($total==1){
	$_SESSION['usuario']=$usuario;
	$_SESSION['senha']=$senha;
	$_SESSION['nivel']=mysql_result($resultado,0,2);
	$email_usuario=mysql_result($resultado,0,3);
	//echo $email_usuario;
	
	// Inclui a informação de login no arquivo log // codigo 500=login
	$dthoje=date("Y-m-d",strtotime("now"));
	$hora_atual=strftime("%H:%M",strtotime("now"));
	$query_login="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) VALUES ('null', '$dthoje', '$cdloja', '500', '$hora_atual', '$usuario','null', 'null')"; 
	//echo $query_login;
	$resultado_login = mysql_query($query_login,$conexao);
	
	// Rotinas de email: ---------------------------------------------------------------------------------------------------------------------------------

//  Manda o email para o vendedor, confirmando seu login no sistema
	
	echo "Vou para o Index!!!";
	//echo "<meta http-equiv='refresh' content='1; url=../manutencao/index.php'>";
	}
	else {
		
	echo "Vou para o Login!!!";
		//echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
		}
}
?>

<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Manuten&ccedil;&atilde;o</title>
</head>
<link href="" rel="stylesheet" type="text/css" />
<body>
<? include("../manutencao/menu.php");?>
<br />
<table width="960" border="0" align="center">
  <tr>
    <td><h3>&nbsp;</h3></td>
  </tr>
  <tr>
    <td height="300">
    <form id="form1" name="form1" method="post" action="../manutencao/login.php">
    <table width="300" border="0" align="center">
      <tr>
        <td colspan="2"><? if(!isset($_SESSION["usuario"])) {echo"<Senha incorreta, tente novamente por favor.";} ?></td>
        </tr>
      <tr>
        <td width="150">Login:
          
          </td>
        <td><label>
          <input type="text" name="usuario" id="usuario" />
        </label></td>
      </tr>
      <tr>
        <td>Senha:</td>
        <td><label>
          <input type="password" name="senha" id="senha" />
        </label></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><input name="modo" type="hidden" id="modo" value="logon" /></td>
        <td><label>
          <input type="submit" name="Enviar" id="Enviar" value="Enviar" />
        </label></td>
      </tr>
    </table>
    </form></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;	</p>
</body>

</html>
