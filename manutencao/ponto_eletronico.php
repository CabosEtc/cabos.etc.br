<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Vendas</title>
</head>

<body>



  

<table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    
      <?

//Prepara conexao ao db
include("../conectadb.php");

session_start();
$usuario=$_SESSION['usuario'];

// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
  $cdloja = fgets($ponteiro, 4096);
}
fclose ($ponteiro);

$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);

// recebe os dados 

$modo=$_REQUEST["modo"];
$idusuario=$_REQUEST["idusuario"];
$senha=$_REQUEST["senha"];


$hora=date('H:i:s');

if ($modo=="entrada"){

	//Verifica a senha do usuario
	$query="SELECT senha,nomeusuario,email FROM usuarios WHERE idusuario = '".$idusuario."'";
	//echo $query;
	
	$resultado = mysql_query($query,$conexao);
	$senha_sistema = mysql_result($resultado,0,0);
	$nomeusuario = mysql_result($resultado,0,1);
	$emailusuario = mysql_result($resultado,0,2);

	if ($senha_sistema==$senha){
		


	
	// nova rotina, manda email.


	// Rotinas de email: -----------------------------------------------------------------------------------------
		
		$emaildestino="mail.f.grande@gmail.com";

	// Dá titulo ao email
		$emailassunto="Ponto eletronico - Entrada do usuario: ".$nomeusuario." (".$nomeloja.")"; 
		
	
// Inicio da montagem do texto da mensagem

		# HTML Version 


		$msg = "
		<html>
		<body><p>"
		// texto aqui //
		
		."O usuario ".$nomeusuario." marcou sua entrada as  ".$hora."</p>";
		
		
		$msg=$msg."	</body>
		</html>";


$headers = "Content-type: text/html; charset=iso-8859-1\r\n";
$headers = "From: ".$nome_loja." <".$emaildestino.">\r\n"; // deve ser configurado emaildestino aqui para evitar que filtros spam bloqueiem a mensagem, a linha return-path faz com que o reply siga para quem esta enviando a mensagem. 
$headers .= "Reply-To: ".$nome_loja." <".$emaildestino.">\r\n";
// adicionado para enviar copia para Suellen
//$headers .= "Cc: mail.f.grande@gmail.com" . "\r\n"; 
$headers .= "Cc: ".$emailusuario. "\r\n"; 


// confirmar sintaxe deste abaixo
$headers .= "Return-Path: ".$nome_loja." <".$emaildestino.">\r\n"; 

$headers .= "Content-Type: text/HTML\r\n"; 
//mail($email,$msg_assunto,$mensagem,$cabecalho) 

// envia o email para a filial escolhida
// a linha de baixo acrescenta texto a msg confeccionada acima, para que o texto de resposta já fique incluido no email da filial, evitando digitação desnecessaria.

		if (mail($emaildestino, $emailassunto, $msg, $headers))
	{ // se o email pode ser enviado

		//envia uma copia ao funcionario
		//mail($emailusuario, $emailassunto, $msg, $headers);
		}

		else {
			echo "Ocorreu um erro durante o envio do email.";
		}
		
		
// ------------------------------------------------------------------------------------


	
// Rotinas de log: Registra a impressão no LOG do sistema:

	
	$dthoje=date("Y-m-d",strtotime("now"));
	//echo $dthoje;
	$query="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) VALUES ('null', '$dthoje', '$cdloja','100', '$nomeusuario', '$hora', 'null', 'null')";
		//echo $query;
		$resultado = mysql_query($query,$conexao);
		
		echo "Sua entrada foi registrada com sucesso.";

	} // Fim do if (senha está ok)
	
		else {
			echo "Sua senha está errada, tente novamente.";
			}
} // fim do if modo='entrada'


//------------------------------------------------------------


if ($modo=="saida"){

	//Verifica a senha do usuario
	$query="SELECT senha,nomeusuario,email FROM usuarios WHERE idusuario = '".$idusuario."'";
	//echo $query;
	
	$resultado = mysql_query($query,$conexao);
	$senha_sistema = mysql_result($resultado,0,0);
	$nomeusuario = mysql_result($resultado,0,1);
	$emailusuario = mysql_result($resultado,0,2);


	if ($senha_sistema==$senha){
		


	
	// nova rotina, manda email.


	// Rotinas de email: -----------------------------------------------------------------------------------------
		
		$emaildestino="mail.f.grande@gmail.com";

	// Dá titulo ao email
		$emailassunto="Ponto eletronico - Saida do usuario: ".$nomeusuario." (".$nomeloja.")"; 
		
	
// Inicio da montagem do texto da mensagem

		# HTML Version 


		$msg = "
		<html>
		<body><p>"
		// texto aqui //
		
		."O usuario ".$nomeusuario." marcou sua saida as  ".$hora."</p>";
		
		
		$msg=$msg."	</body>
		</html>";


$headers = "Content-type: text/html; charset=iso-8859-1\r\n";
$headers = "From: ".$nome_loja." <".$emaildestino.">\r\n"; // deve ser configurado emaildestino aqui para evitar que filtros spam bloqueiem a mensagem, a linha return-path faz com que o reply siga para quem esta enviando a mensagem. 
$headers .= "Reply-To: ".$nome_loja." <".$emaildestino.">\r\n";
// adicionado para enviar copia para Suellen
//$headers .= "Cc: mail.f.grande@gmail.com" . "\r\n";

$headers .= "Cc: ".$emailusuario. "\r\n"; 

// confirmar sintaxe deste abaixo
$headers .= "Return-Path: ".$nome_loja." <".$emaildestino.">\r\n"; 

$headers .= "Content-Type: text/HTML\r\n"; 
//mail($email,$msg_assunto,$mensagem,$cabecalho) 

// envia o email para a filial escolhida
// a linha de baixo acrescenta texto a msg confeccionada acima, para que o texto de resposta já fique incluido no email da filial, evitando digitação desnecessaria.

		if (mail($emaildestino, $emailassunto, $msg, $headers))
	{ // se o email pode ser enviado

		//envia uma copia ao funcionario
		//mail($emailusuario, $emailassunto, $msg, $headers);
		
		}
		else {
			echo "Ocorreu um erro durante o envio do email.";
		}
		
		
// ------------------------------------------------------------------------------------


	
// Rotinas de log: Registra a impressão no LOG do sistema:

	
	$dthoje=date("Y-m-d",strtotime("now"));
	//echo $dthoje;
	$query="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) VALUES ('null', '$dthoje', '$cdloja','101', '$nomeusuario', '$hora', 'null', 'null')";
		//echo $query;
		$resultado = mysql_query($query,$conexao);
		
		echo "Sua saida foi registrada com sucesso.";

	} // Fim do if (senha está ok)
	
		else {
			echo "Sua senha está errada, tente novamente.";
			}
} // fim do if modo='saida'



	
?>
    
    <p style="padding-top:480px; padding-left:750px">
    <a href="../manutencao/index.php">Voltar</a> ao menu principal
    </p>
    </td>
  </tr>
</table>
  
  
</body>
</html>
