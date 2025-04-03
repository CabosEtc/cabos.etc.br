<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="manutencao.css"/>
        <title>Painel do Usuário</title>
    </head>

    <body>
        <?
            //Prepara conexao ao db
            include("../conectadb.php");
            include("msession.php");
            IF(!$logado){	
                echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
            } 

            // Mostra depuracao
            //include("depuracao.php"); 

                
            //Inclui o menu
            include("mmenu.php"); 
        ?>    

            
        
            
        <div id="pesquisa_corpo" class="pesquisa_corpo">
            <div>
                <a href='userEstaticas.php' target='_self'>Estatísticas de venda</a>
            </div>
        </div>
    </body>
</html>