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

$cdproduto=$_REQUEST["cdproduto"];
$cdean=$_REQUEST["cdean"];

	//Recupera informações do produto a partir do codigo
	$query="SELECT nome FROM produtos WHERE cdproduto = '".$cdproduto."'";
	//echo $query;
	
	$resultado = mysql_query($query,$conexao);
	$nomeproduto = mysql_result($resultado,0,0);



	
	// nova rotina, pesquisa se o item esta na lista de produto_autopedido e manda um email para mim informando para pedir automaticamente outro de reposição para a loja.


	// Rotinas de email: -----------------------------------------------------------------------------------------
		
		$emaildestino="mail.f.grande@gmail.com";

	// Dá titulo ao email
		$emailassunto="Cadastramento de código EAN - ".$cdproduto; 
		
	
// Inicio da montagem do texto da mensagem

		# HTML Version 


		$msg = "
		<html>
		<body><p>"
		// texto aqui //
		
		."O produto ".$cdproduto." (".$nomeproduto.")</p>"." teve o seguinte codigo EAN cadastrado: ".$cdean."<p>consulte o log <a href='http://www.cabos.etc.br/manutencao/log.php'>aqui</a><p>";
		
		
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
			echo "O código foi cadastrado com sucesso, confira os dados abaixo:<p>";
			echo "Codigo do produto: ".$cdproduto."<p>";
			echo "Nome do produto: ".$nomeproduto."<p>";
			echo "Código EAN: ".$cdean."<p>";
	//		echo "Você retornará a página inicial em 10 segundos, caso não retorne clique <a href='javascript:history.go(-1)'>aqui</a></p>"; 
		}
		else {
			echo "Ocorreu um erro durante o envio do email.";
		}
// ------------------------------------------------------------------------------------


	
	// Atualiza a forma de pagamento
	$query="UPDATE produtos SET ean=".$cdean." WHERE cdproduto=".$cdproduto;
	//echo $query;
	$resultado = mysql_query($query,$conexao);

	
?>
    
    <p style="padding-top:480px; padding-left:750px">
    <a href="../manutencao/index.php">Voltar</a> ao menu principal (Confira os dados acima por favor).
    </p>
    </td>
  </tr>
</table>
  
  
</body>
</html>
