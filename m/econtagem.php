<html>
    <head>
        <title>eContagem</title>
        <meta http-equiv= "Content-Type" content= "text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="manutencao.css">

    </head>
    <style>
        .alerta{
            display: none;
        }
    </style>
    <script type="text/javascript" src="js/ajax2020.js"></script>

    <body class="body">

        <?php
            //Prepara conexao ao db
            include("../conectadb.php");

            // Inicializa a sessão
            include("msession.php");
            IF(!$logado or ($nivelusuario<4)){	
                echo "<meta http-equiv='refresh' content='5; url=index.php' target='_SELF'>";
                die("Seu nível de usuário não permite esta operação...");
            } 
	        //echo $nivelusuario;

            //Recebe variaveis * $cdloja vem do conectadb 1=cabos 8=supergames
            $query="SELECT nomeloja 
                    FROM lojas 
                    WHERE cdloja='".$cdloja."'";
            $resultado = mysql_query($query,$conexao);
            $nomeloja=mysql_result($resultado,0,0);

            $dtmovimento=$dthoje_bra; 
        ?> 

          
        <!-- Inclui o menu -->
        <? include("mmenu.php"); ?>    

        <!-- Conteudo principal -->
        <div id="corpo" class="corpo">

            <div id="containerAlerta" class="container alerta mt-2">
                <div class="row">
                    <div class="col-12">
                        <div id="alerta" class="alert alert-success" role="alert">
                            Mensagem aqui...
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 style="margin-top: 30px;">  
                    Contagem de Produtos em estoque
                </h3>
            </div>   

            <div id="divNomeProduto">
                <form action="eajustes.php" method="get">
                    <table width="500" border="0" align="center">
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Data da contagem</td>
                            <td><input type="text" name="dtmovimento" id="dtmovimento" value="<? echo $dtmovimento; ?>"/></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Codigo do produto</td>
                            <td>Quantidade</td>
                        </tr>
                            <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                            <tr>
                            <td><input name="cdproduto1" type="text" id="cdproduto1" maxlength="5" /></td>
                            <td><input name="quantidade1" type="text" id="quantidade1" maxlength="5" /></td>
                        </tr>
                        <tr>
                            <td><input name="cdproduto2" type="text" id="cdproduto2" maxlength="5" /></td>
                            <td><input name="quantidade2" type="text" id="quantidade2" maxlength="5" /></td>
                        </tr>
                        <tr>
                            <td><input name="cdproduto3" type="text" id="cdproduto3" maxlength="5" /></td>
                            <td><input name="quantidade3" type="text" id="quantidade3" maxlength="5" /></td>
                        </tr>
                        <tr>
                            <td><input name="cdproduto4" type="text" id="cdproduto4" maxlength="5" /></td>
                            <td><input name="quantidade4" type="text" id="quantidade4" maxlength="5" /></td>
                        </tr>
                        <tr>
                            <td><input name="cdproduto5" type="text" id="cdproduto5" maxlength="5" /></td>
                            <td><input name="quantidade5" type="text" id="quantidade5" maxlength="5" /></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><input name="modo" type="hidden" id="modo" value="contagem_loja" /></td>
                            <td>
                                <label>
                                    <input type="submit" name="btnEnviar" id="btnEnviar" value="Enviar" />
                                </label>
                            </td>
                        </tr>
                    </table> 
                </form>
            </div>
        
        </div> <!-- Fim da div conteudo_principal -->


        



    </body>
</html>