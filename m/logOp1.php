<html>
    <head>
        <title>Relatório de Impressão de notas</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="manutencao.css">
    </head>
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

            //Recebe variaveis
            //$token=$_REQUEST["token"];
            //$depuracao=$_REQUEST["depuracao"];

            // Mostra depuracao
            //include("depuracao.php"); 
        ?> 

        <script src="javascript.js"></script>


        <div id="wrapper" class="wrapper">

                
            <!-- Inclui o menu -->
            <? 
                include("mmenu.php"); 
            ?>    

            <!-- Conteudo principal -->
            <div id="corpo" class="corpo">
                <h1>Relatório de notas impressas</h1>
                <?
                    $query="SELECT log.data, log.inf1, log.inf2, log.inf3  
                    FROM log
                    WHERE log.codigo=1 
                    AND loja=$cdloja 
                    ORDER BY log.data DESC, log.inf1 DESC";
                    //echo $query;
                    $resultado = mysql_query($query,$conexao);

                    echo "<table>";
                    ECHO "  <tr>
                                <td>Data</td>
                                <td>Nr nota</td>
                                <td>Usuário</td>
                                <td>Data da Nota</td>
                            </tr>";
                    while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
                        $dataLogFormatoEUA=$row[0];
                        $SomenteDataLog=substr($dataLogFormatoEUA,8,2)."/".substr($dataLogFormatoEUA,5,2)."/".substr($dataLogFormatoEUA,0,4);
                        $horaLog=substr($dataLogFormatoEUA,11,8);
                        $dataLog=$SomenteDataLog." ".$horaLog; 
                        $nrNota=$row[1];
                        $usuario=$row[2];
                        $dataOriginal=$row[3];
                        if($SomenteDataLog<>$dataOriginal){
                            $corEstiloTR="style='color:red'";
                        }
                        else{
                            $corEstiloTR="";
                        }

                        ECHO "  <tr $corEstiloTR>
                                    <td>$dataLog</td>
                                    <td align='right'>$nrNota</td>
                                    <td align='right'>$usuario</td>
                                    <td align='right'>$corFonte $dataOriginal</td>
                                </tr>";
                    }
                    echo "</table>";
                ?>
                <!-- 

                Versão 2
                SELECT links_boadica_detalhes_lojas.data, lojas_boadica.nome, links_boadica_detalhes_lojas.id_produto, links_boadica.cdproduto, produtos.nome 
                FROM `links_boadica_detalhes_lojas`,`lojas_boadica`, links_boadica, produtos 
                WHERE lojas_boadica.id_loja=links_boadica_detalhes_lojas.id_loja AND links_boadica.id=links_boadica_detalhes_lojas.id_produto 
                AND links_boadica.cdproduto=produtos.cdproduto AND `data` LIKE '%23:59:00%' 
                ORDER BY links_boadica_detalhes_lojas.data DESC

                versao 3

                SELECT links_boadica_detalhes_lojas.data, produtos.cdsubcategoria, lojas_boadica.nome, links_boadica_detalhes_lojas.id_produto, links_boadica.cdproduto, produtos.nome 
                FROM `links_boadica_detalhes_lojas`,`lojas_boadica`, links_boadica, produtos 
                WHERE lojas_boadica.id_loja=links_boadica_detalhes_lojas.id_loja 
                AND links_boadica.id=links_boadica_detalhes_lojas.id_produto 
                AND links_boadica.cdproduto=produtos.cdproduto 
                AND `data` LIKE '%2020-11-29 23:59:00%' 
                ORDER BY links_boadica_detalhes_lojas.data DESC

                versao 4

                SELECT links_boadica_detalhes_lojas.data, produtos.cdsubcategoria, lojas_boadica.nome, links_boadica_detalhes_lojas.id_produto, links_boadica.cdproduto, produtos.nome FROM `links_boadica_detalhes_lojas`,`lojas_boadica`, links_boadica, produtos WHERE lojas_boadica.id_loja=links_boadica_detalhes_lojas.id_loja AND links_boadica.id=links_boadica_detalhes_lojas.id_produto AND links_boadica.cdproduto=produtos.cdproduto AND `data` LIKE '%2020-11-29 23:59:00%' ORDER BY produtos.cdsubcategoria, produtos.cdproduto DESC

                -->
            </div> <!--fim do conteudo principal -->


        </div> <!--fim da div wrapper_site -->
    </body>
</html>