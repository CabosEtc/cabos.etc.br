<html>
    <head>
        <title>eTransferência</title>
        <meta http-equiv= "Content-Type" content= "text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="manutencao.css">
    </head>
    <style>
        .alerta{
            display: block;
        }
    </style>

    <body class="body">

        <?php
            //Prepara conexao ao db
            include("../conectadb.php");

            // Inicializa a sessão
            include("msession.php");
            IF(!$logado){	
                echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
            } 
	        //echo $nivelusuario;

            //Recebe variaveis * $cdloja vem do conectadb 1=cabos 8=supergames
            $cdMensagem=$_REQUEST["cdmensagem"];
            
            if($cdMensagem=="1"){
                $mensagem="Você não tem nível de usuário para esta operação!";
            } 
        ?> 

          
        <!-- Inclui o menu -->
        <? include("mmenu.php"); ?>    

        <!-- Conteudo principal -->
        <div id="corpo" class="corpo">

            <div id="containerAlerta" class="container alerta mt-2">
                <div class="row">
                    <div class="col-12">
                        <div id="alerta" class="alert alert-success" role="alert">
                            <?php
                                echo "$mensagem";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        
        </div> <!-- Fim da div conteudo_principal -->

    </body>
</html>