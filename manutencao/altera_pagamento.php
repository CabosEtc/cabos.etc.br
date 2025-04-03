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

$nrnota=$_REQUEST["nrnota"];
$nrnota_inteiro=(int)$nrnota;
//$cdloja=$_REQUEST["cdloja"];
$cdloja= (int)$cdloja;
//echo $cdloja;

$nrnota=$_REQUEST["nrnota"];
$nrnota_inteiro= (int)$nrnota;
$formapagamento=$_REQUEST["formapagamento"];

	//Recupera informações antigas da nota no BD para salvar no LOG
	$query="SELECT dtnota, vlnota, formapagamento FROM notas WHERE nrnota = '".$nrnota."' AND cdloja='".$cdloja."'";
	//echo $query;
	
	$resultado = mysql_query($query,$conexao);
	$dtnota = mysql_result($resultado,0,0);
	$vlnota = mysql_result($resultado,0,1);
	$formapagamento_antiga=mysql_result($resultado,0,2);




	
	// nova rotina, pesquisa se o item esta na lista de produto_autopedido e manda um email para mim informando para pedir automaticamente outro de reposição para a loja.


	// Rotinas de email: -----------------------------------------------------------------------------------------
		
		$emaildestino="mail.f.grande@gmail.com";

	// Dá titulo ao email
		$emailassunto="Forma de pagamento alterada - ".$nomeloja; 
		
	
// Inicio da montagem do texto da mensagem

		# HTML Version 

	//Captura a forma nominal da forma de pagamento nova
	$query="SELECT formapagamento FROM formas_pagamento WHERE idformapagamento = '".$formapagamento."'";
	//echo $query;
	$resultado = mysql_query($query,$conexao);
	$formapagamento_nominal_nova=mysql_result($resultado,0,0);
	
	//Captura a forma nominal da forma de pagamento antiga
	$query="SELECT formapagamento FROM formas_pagamento WHERE idformapagamento = '".$formapagamento_antiga."'";
	//echo $query;
	$resultado = mysql_query($query,$conexao);
	$formapagamento_nominal_antiga=mysql_result($resultado,0,0);

		$msg = "
		<html>
		<body><p>"
		// texto aqui //
		
		."A nota ".$nrnota."</p>"." teve a forma de pagamento alterada de: ".$formapagamento_nominal_antiga." para : ".$formapagamento_nominal_nova."<p>consulte o log <a href='http://www.cabos.etc.br/manutencao/log.php'>aqui</a><p>";
		
		
		$msg=$msg."	</body>
		</html>";


$headers = "Content-type: text/html; charset=iso-8859-1\r\n";
$headers = "From: ".$nome_loja." <".$emaildestino.">\r\n"; // deve ser configurado emaildestino aqui para evitar que filtros spam bloqueiem a mensagem, a linha return-path faz com que o reply siga para quem esta enviando a mensagem. 
$headers .= "Reply-To: ".$nome_loja." <".$emaildestino.">\r\n";
// adicionado para enviar copia para Suellen
$headers .= "Cc: mail.f.grande@gmail.com" . "\r\n"; 

// confirmar sintaxe deste abaixo
$headers .= "Return-Path: ".$nome_loja." <".$emaildestino.">\r\n"; 

$headers .= "Content-Type: text/HTML\r\n"; 
//mail($email,$msg_assunto,$mensagem,$cabecalho) 

// envia o email para a filial escolhida
// a linha de baixo acrescenta texto a msg confeccionada acima, para que o texto de resposta já fique incluido no email da filial, evitando digitação desnecessaria.

		if (mail($emaildestino, $emailassunto, $msg, $headers))
	{ // se o email pode ser enviado
			echo "A alteração da forma de pagamento foi efetuada com sucesso, uma mensagem foi enviada para ".$emaildestino.".<p>";
	//		echo "Você retornará a página inicial em 10 segundos, caso não retorne clique <a href='javascript:history.go(-1)'>aqui</a></p>"; 
		}
		else {
			echo "Ocorreu um erro durante o envio do email.";
		}
// ------------------------------------------------------------------------------------


	
	// Atualiza a forma de pagamento
	$query="UPDATE notas SET formapagamento=".$formapagamento." WHERE nrnota=".$nrnota;
	//echo $query;
	$resultado = mysql_query($query,$conexao);

// Rotinas de log: Registra a impressão no LOG do sistema:

	
	$dthoje=date("Y-m-d",strtotime("now"));
	//echo $dthoje;
	$query="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) VALUES ('null', '$dthoje', '$cdloja','8', '$nrnota', '$usuario', '$dtnota', '$vlnota')";
		//echo $query;
		$resultado = mysql_query($query,$conexao);
	// Detalhes da alteração
		$query="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) VALUES ('null', '$dthoje', '$cdloja','9', '$nrnota', '$formapagamento_nominal_antiga', '$formapagamento_nominal_nova', 'null')";
		//echo $query;
		$resultado = mysql_query($query,$conexao);

	
?>
    
    <p style="padding-top:480px; padding-left:750px">
    <a href="../manutencao/index.php">Voltar</a> ao menu principal (Confira a alteração por favor).
    </p>
    </td>
  </tr>
</table>
  
  
</body>
</html>
