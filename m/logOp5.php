<html>
    <head>
        <title>BD</title>
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
            $token=$_REQUEST["token"];
            $depuracao=$_REQUEST["depuracao"];

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
                <h1>Relatório de alterações de preços no sistema</h1>
                <?
                    $query="SELECT log.data, log.inf1, log.inf2, log.inf3, log.inf4, produtos.nome 
                    FROM log, produtos  
                    WHERE log.inf1=produtos.cdproduto 
                    AND log.codigo=5 
                    AND loja=$cdloja 
                    ORDER BY log.idlog DESC";
                    //echo $query;
                    $resultado = mysql_query($query,$conexao);

                    echo "<table>";
                    ECHO "<tr><td>Data</td><td>Código</td><td>Nome</td><td>Usuário</td><td>$ antigo</td><td>$ novo</td></tr>";
                    while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
                        $dataLog=$row[0];
                        $cdProduto=$row[1];
                        $usuario=$row[2];
                        $vlAntigo=number_format($row[3], 2, ',', '');
                        $vlNovo=number_format($row[4], 2, ',', '');
                        $nomeProduto=$row[5];

                        ECHO "<tr><td>$dataLog</td><td align='right'>$cdProduto</td><td>$nomeProduto</td><td align='right'>$usuario</td><td align='right'>$vlAntigo</td><td align='right'>$vlNovo</td></tr>";
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