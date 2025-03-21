<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="manutencao.css">
        <title>Notas excluidas</title>
    </head>

    <style>
        .cor{
            background-color : #EEE8AA;
        }

        .margem20 {
            float:left;
            width: 20px;
        }

        .margem100 {
            float:left;
            width: 100px;
        }

        .margem200 {
            float:left;
            width: 200px;
        }
        .primeiraLinha{
            clear: both;
        }
    </style>

    <body>
        <?
        //Prepara conexao ao db
            include("../conectadb.php");

            // Inicializa a sessão
            include("msession.php");
            IF(!$logado){	
            echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
            } 
            //echo $nivelusuario;
            
            //Variaveis
            //$cdsubcategoria=$_REQUEST["cdsubcategoria"];

            //Inclui o menu
            include("mmenu.php");   

            echo "<br>";
            echo "<h3>Relatório de notas excluidas</h3>";
            //ini_set('allow_url_fopen', 1);

            $queryNotasExcluidas="SELECT log.inf1, log.inf2, log.inf3, log.inf4, log.inf5, log.data, log.idlog, 
                    formas_cancelamento_nota.formacancelamento      
                    FROM  log, formas_cancelamento_nota 
                    WHERE log.inf6=formas_cancelamento_nota.idformacancelamento  
                    AND log.loja=$cdloja  AND log.codigo=2 
                    ORDER BY log.data desc, log.inf2 asc 
                    ";
            $resultadoNotasExcluidas = mysql_query($queryNotasExcluidas,$conexao);
            //echo "queryNotasExcluidas: $queryNotasExcluidas<BR>";


            /*
            $queryDetalhes="SELECT inf1, inf2, inf3, inf4, inf5, data, idlog     
                    FROM  log
                    WHERE loja=$cdloja  AND codigo=3  
                    ORDER BY data desc, inf2 asc";
            $resultadoDetalhes = mysql_query($queryDetalhes,$conexao);

            echo "queryDetalhes: $queryDetalhes<BR>";
            */

            $contador_item=0;
            $contador_item_produtos_atualizaveis=0;



            echo "  <div>
                        <div class='margem100 primeiraLinha'>
                            Data exclusão
                        </div>
                        <div class='margem100'>
                            Data da nota
                        </div>
                        <div class='margem100'>
                            Nr nota
                        </div>
                        <div class='margem100'>
                            Usuario
                        </div>
                        <div class='margem200'>
                            Forma pagto
                        </div>
                        <div class='margem200'>
                            Motivo cancelamento
                        </div>
                        <div class='margem200'>
                            Observações
                        </div>
                        <div class='margem20'>
                            &nbsp
                        </div>
                    </div>";

            //Incluida em 03Ago19 para permitir ocultar todas as lojas com um unico clique



            while ($row = mysql_fetch_array($resultadoNotasExcluidas, MYSQL_NUM)) {
                $nrNota=$row[0]; 
                $usuario=$row[1];
                if ($usuario==""){
                    $usuario="&nbsp;";
                }
                $dtNota=$row[2];
                $formaPagamento=$row[3]; 
                $observacoes=$row[4];
                if($observacoes==""){
                    $observacoes="&nbsp;";

                }
                $dataInclusao=substr($row[5],8,2)."/".substr($row[5],5,2)."/".substr($row[5],0,4);
                $idLog=$row[6];
                $motivoCancelamento=$row[7];

                echo "<div class='primeiraLinha'>      
                            <div class='margem100 cor'>
                                $dataInclusao
                            </div>
                            <div class='margem100 cor'>
                                <a href='http://www.cabos.etc.br/m/nlist.php?data=$dtNota'>$dtNota</a>
                            </div>
                            <div class='margem100 cor'>
                                $nrNota
                            </div>

                            <div class='margem100 cor'>
                                $usuario
                            </div>
            
                            <div class='margem200 cor'>
                                $formaPagamento
                            </div>

                            <div class='margem200 cor'>
                                $motivoCancelamento
                            </div>
                            
                            <div class='margem200 cor'>
                                $observacoes
                            </div>

                            <div class='margem20 cor'>
                                <img src='../imagens/trash.png' width='16' heigtht='16' /></a>
                            </div>
                        </div>";


                $queryDetalhes="SELECT inf1, inf2, inf3, inf4, inf5, data, idlog     
                FROM  log
                WHERE loja=$cdloja  AND codigo=3 AND inf1='$nrNota' 
                ORDER BY inf2 asc";
                $resultadoDetalhes = mysql_query($queryDetalhes,$conexao);
                //echo "queryDetalhes: $queryDetalhes<BR>";

                echo "      
                        <div class='margem100 primeiraLinha'>
                            Código
                        </div>
                        <div  class='margem100'>
                            Quantidade
                        </div>

                        <div  class='margem100'>
                            Valor
                        </div>";

                while ($rowDetalhes = mysql_fetch_array($resultadoDetalhes, MYSQL_NUM)) {
                    $cdProduto=$rowDetalhes[1]; 
                    $quantidadeProduto=$rowDetalhes[2];
                    $valorProduto=$rowDetalhes[3];
                    echo "      
                                <div class='margem100 primeiraLinha'>
                                    $cdProduto
                                </div>
                                <div  class='margem100'>
                                    $quantidadeProduto
                                </div>

                                <div  class='margem100'>
                                    $valorProduto
                                </div>";
                }
            

                echo "<div class='primeiraLinha'>&nbsp</div>";

            } 

                
                // retirado por segurança
                // <a href='prot.php?modo=apagarLogProdutoNaoCadastrado&idlog=$idLog' target='_blank'>
                
                
                // Fim da linha de exibicao do produto

            /*
                            <td>
                                <a href='https://boadica.com.br/produtos/$idAnuncio' target='_blank'><img src='../imagens/coruja.png' width='16' height='16' /></a>
                            </td>
                            <td>
                                $nomeProduto
                            </td>

            */

            //echo "</table>";

        ?>
    </body>
</html>
