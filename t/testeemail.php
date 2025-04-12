<?

 
    // envia email avisando da atualização
    $emailenviar = "mail.f.grande@gmail.com";
    $destino = $emailenviar;
    $assunto = "Contato pelo Site";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: $nome <$email>';
	
	$mensagem="teste";
     
    $enviaremail = mail($destino, $assunto, $mensagem, $headers);
    if($enviaremail){
    $mgm = "E-MAIL ENVIADO COM SUCESSO! <br> O link será enviado para o e-mail fornecido no formulário";
    echo " Arquivo enviado";
    } else {
    echo "ERRO AO ENVIAR E-MAIL!";
    echo "";
    }
?>