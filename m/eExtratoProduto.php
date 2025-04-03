<html>
    <body>
        <?php
            //die("Rotina interrompida, verifique os dados da loja, data, etc...");
            //$cdLoja='11';
            $cdProduto=$_REQUEST["cdProduto"];
            $dtCorte=$_REQUEST["dtCorte"];
            if($cdProduto==""){
                $cdProduto="50183";
            }
            if($dtCorte==""){
                $dtCorte="2023-05-01"; // Data em que exibe resumo antes (saldo inicial) e depois detalhamento
            }
                //$dtAtualizacao='2023-04-28';
           
            echo "Data de corte para detalhamento $dtCorte<br>";
            //echo "Data da atualizacao: $dtAtualizacao<br>";
        ?>
        <h2>
            Extrato do produto 
        </h2>
        <?php
            //Prepara conexao ao db
            include("../conectadb.php");
            
            // Inicializa a sessão
            include("msession.php");
            IF(!$logado){	
                echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
            } 

            echo "loja: $cdLoja<br>";


            $queryProduto=" SELECT produtos.nome,fabricantes.nome 
                            FROM produtos,fabricantes 
                            WHERE produtos.cdproduto='$cdProduto' 
                            AND fabricantes.cdfabricante=produtos.cdfabricante";
            $resultadoProduto = mysql_query($queryProduto,$conexao);
            $nomeProduto=mysql_result($resultadoProduto,0,0);
            $nomeFabricante=mysql_result($resultadoProduto,0,1);

            echo "Produto: $cdProduto - $nomeProduto ($nomeFabricante)<br>";

            //Vendas Antes Data Corte
            $queryVendidosAntesDataCorte="  SELECT sum(notas_detalhes.quantidade) as total_vendido 
                                            FROM notas_detalhes, notas  
                                            WHERE notas_detalhes.idnota=notas.idnota 
                                            AND notas.cdloja='$cdLoja'  
                                            AND notas.dtnota<'$dtCorte'  
                                            AND cdproduto LIKE '$cdProduto'";
            $resultadoVendidosAntesDataCorte = mysql_query($queryVendidosAntesDataCorte,$conexao);
            $vendidosAntesDataCortenomeProduto=mysql_result($resultadoVendidosAntesDataCorte,0,0);


            
            //echo "$queryVendidosAntesDataCorte<br>"; 
            echo "Quantidade vendida antes da data de corte: $vendidosAntesDataCortenomeProduto<br>"; 

            // Entradas Anteriores Data Corte
            $queryEntradasAnterioresDataCorte=" SELECT sum(quantidade) as quantidade_entrada 
                                                FROM estoque 
                                                WHERE cdloja='$cdLoja' 
                                                AND historico>=50 
                                                AND dtmovimento<'$dtCorte' 
                                                AND cdproduto='$cdProduto'";
            $resultadoEntradasAnterioresDataCorte = mysql_query($queryEntradasAnterioresDataCorte,$conexao);
            $quantidadeEntradasAnterioresDataCorte=mysql_result($resultadoEntradasAnterioresDataCorte,0,0);
            echo "Entradas Anteriores: $quantidadeEntradasAnterioresDataCorte<br>";

            // Saidas Anteriores Data Corte
            $querySaidasAnterioresDataCorte=" SELECT sum(quantidade) as quantidade_saida 
                                                FROM estoque 
                                                WHERE cdloja='$cdLoja' 
                                                AND historico<50 
                                                AND dtmovimento<'$dtCorte' 
                                                AND cdproduto='$cdProduto'";
            $resultadoSaidasAnterioresDataCorte = mysql_query($querySaidasAnterioresDataCorte,$conexao);
            $quantidadeSaidasAnterioresDataCorte=mysql_result($resultadoSaidasAnterioresDataCorte,0,0);
            echo "Saidas Anteriores: $quantidadeSaidasAnterioresDataCorte<br>";
            $quantidadeTotalAnterior=$quantidadeEntradasAnterioresDataCorte-$quantidadeSaidasAnterioresDataCorte-$vendidosAntesDataCortenomeProduto;
            echo "QuantidadeTotalAnterior: $quantidadeTotalAnterior (Saldo inicial)<br>";

            $arrayLancamentos=array();

            // Movimentos de estoque após data de Corte (inclusive a data)
            $queryMovimentosAposDataCorte=" SELECT estoque.dtmovimento, estoque.historico, estoque.quantidade, estoque.dados, estoque_historicos.descricao_historico 
                                        FROM `estoque`,`estoque_historicos` 
                                        WHERE `cdloja` = '$cdLoja'  
                                        AND estoque.historico=estoque_historicos.historico 
                                        AND `cdproduto` LIKE '$cdProduto'  
                                        AND `dtmovimento` >= '$dtCorte'";
            //echo "Query Movimentos Apos Data Corte: $queryMovimentosAposDataCorte<br>";

            echo "<div>&nbsp;</div>";
            
            $resultadoMovimentosAposDataCorte = mysql_query($queryMovimentosAposDataCorte,$conexao);
            WHILE ($row = mysql_fetch_array($resultadoMovimentosAposDataCorte, MYSQL_NUM)) {
                $dtMovimento=$row[0];
                $codigoHistorico=$row[1];
                $quantidade=$row[2];
                $dados=$row[3];
                $descricaoHistorico=$row[4];
                $historico=$codigoHistorico."-".$descricaoHistorico;
                //echo "Dados: $dtMovimento $historico $quantidade $fornecedor $dados<br>";
                array_push($arrayLancamentos,array($dtMovimento,$historico,$quantidade,$dados));
            }
            //print_r($arrayLancamentos);
            
            // Movimentos de vendas após data de Corte (inclusive a data)
            // trocar por: SELECT sum(notas_detalhes.quantidade) as teste, notas.dtnota, notas_detalhes.quantidade FROM notas_detalhes, notas WHERE notas_detalhes.idnota=notas.idnota AND notas.cdloja='4' AND notas.dtnota>='2023/05/01' AND cdproduto LIKE '50183' group by notas.dtnota ORDER by dtnota DESC;
            /* Query anterior (listava todos os movimentos individualmente)
                        $queryVendidosAposDataCorte="  SELECT notas.dtnota, notas_detalhes.quantidade  
                                            FROM notas_detalhes, notas  
                                            WHERE notas_detalhes.idnota=notas.idnota 
                                            AND notas.cdloja='$cdLoja'  
                                            AND notas.dtnota>='$dtCorte'  
                                            AND cdproduto LIKE '$cdProduto' 
                                            ORDER by dtnota DESC";
            */
            
            $queryVendidosAposDataCorte="  SELECT notas.dtnota, sum(notas_detalhes.quantidade) as quantidade  
                                            FROM notas_detalhes, notas  
                                            WHERE notas_detalhes.idnota=notas.idnota 
                                            AND notas.cdloja='$cdLoja'  
                                            AND notas.dtnota>='$dtCorte'  
                                            AND cdproduto LIKE '$cdProduto' 
                                            GROUP BY notas.dtnota 
                                            ORDER by dtnota DESC";
            //echo "queryVendidosAposDataCorte: $queryVendidosAposDataCorte<br>";
            $resultadoVendidosAposDataCorte = mysql_query($queryVendidosAposDataCorte,$conexao);
            //$vendidosAntesDataCortenomeProduto=mysql_result($resultadoVendidosAntesDataCorte,0,0);            WHILE ($row = mysql_fetch_array($resultadoVendasAposDataCorte, MYSQL_NUM)) {
            //$totalVendidoAposDataCorte=$row[0];

                //echo "Dados: $dtMovimento $historico $quantidade $fornecedor $dados<br>";
                //array_push($arrayLancamentos,array($dtMovimento,$historico,$quantidade,$dados));
                WHILE ($row = mysql_fetch_array($resultadoVendidosAposDataCorte, MYSQL_NUM)) {
                    $dtMovimento=$row[0];
                    $historico="Vendas";
                    $quantidade=$row[1];
                    $dados="";
                    //echo "Dados: $dtMovimento $historico $quantidade $fornecedor $dados<br>";
                    array_push($arrayLancamentos,array($dtMovimento,$historico,$quantidade,$dados));
                }



                echo"<table>";

                    echo "  <tr>
                                <td align='center'>Data</td>
                                <td align='center'>Histórico</td>
                                <td align='left'>Quant</td>
                                <td align='left'>Dados</td>
                            </tr>";
                    echo "  <tr>
                                <td align='center'>$dtCorte</td>
                                <td align='left'>Saldo Anterior</td>
                                <td align='right'>$quantidadeTotalAnterior</td>
                                <td align='left'>&nbsp;</td>
                            </tr>";

                //Ordena os lançamentos por data
                sort($arrayLancamentos);
                foreach ($arrayLancamentos as $row) {
                    $dtMovimento=$row[0];
                    $historico=$row[1];
                    $quantidade=$row[2];
                    $dados=$row[3];

                    echo "  <tr>
                                <td align='center'>$dtMovimento</td>
                                <td align='left'>$historico</td>
                                <td align='right'>$quantidade</td>
                                <td align='right'>$dados</td>
                            </tr>";
                }

                //Aqui entram os dados que faltam para poder chegar no saldo final
                $dadosEstoque=contaEstoque($cdProduto, $cdLoja, $conexao);
					$quantEstoqueProduto=$dadosEstoque[0];


                echo "  <tr>
                <td align='center'>&nbsp;</td>
                <td align='left'>Saldo Final</td>
                <td align='right'>$quantEstoqueProduto</td>
                <td align='left'>&nbsp;</td>
            </tr>";


                /*
                WHILE ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
                    $cdproduto=$row[0]; 
                    $nome=$row[1];
                    $cdsubcategoria=$row[2];
                    $dadosEstoque=contaEstoque($cdProduto, $cdLoja, $conexao);
					$quantidadeEstoqueProduto=$dadosEstoque[0];


                    $queryQuantidadeVendasAposContagem="SELECT SUM(notas_detalhes.quantidade) as quantidade_total 
                                                        FROM notas_detalhes, notas 
                                                        WHERE cdproduto='".$cdProduto."' 
                                                        AND notas.idnota=notas_detalhes.idnota 
                                                        AND notas.dtnota='$dtExclusaoVendas'  
                                                        AND notas.cdloja=$cdLoja";
                    //echo "Query: $queryQuantidadeVendasAposContagem<br>";
                    $resultadoQuantidadeVendasAposContagem = mysql_query($queryQuantidadeVendasAposContagem,$conexao);
                    $quantidadeVendasAposContagem=mysql_result($resultadoQuantidadeVendasAposContagem,0,0);

                    $quantidadeFinalAposAjustes=$quantidadeProduto-$quantidadeVendasAposContagem;







                    echo "  <tr>
                                <td align='center'></td>
                                <td align='left'></td>
                                <td align='left'></td>
                            </tr>";
                }
                */
            
                echo"</table>";

                /*
                $stack = array("orange", "banana");
                array_push($stack, "apple", "raspberry");
                print_r($stack);

                //Multidimensional
                $cars = array (
                    array("Volvo",22,18),
                    array("BMW",15,13),
                    array("Saab",5,2),
                    array("Land Rover",17,15)
                  );
                  echo $cars[0][0].": In stock: ".$cars[0][1].", sold: ".$cars[0][2].".<br>";
                  echo $cars[1][0].": In stock: ".$cars[1][1].", sold: ".$cars[1][2].".<br>";
                  echo $cars[2][0].": In stock: ".$cars[2][1].", sold: ".$cars[2][2].".<br>";
                  echo $cars[3][0].": In stock: ".$cars[3][1].", sold: ".$cars[3][2].".<br>";
                  */

        ?>

        <? 
            function contaEstoque($cdproduto, $cdLojaParaContarEstoque, $conexao){
                // Entradas
                $query="SELECT sum(quantidade) as quantidade_entrada 
                        FROM estoque 
                        WHERE cdloja='".$cdLojaParaContarEstoque."' AND historico>=50 AND cdproduto='$cdproduto'";
                $resultado = mysql_query($query,$conexao);
                $quantidadeEntrada=mysql_result($resultado,0,0);
                //echo "$query<br>";
    
                // Vendas
                $query="SELECT sum(notas_detalhes.quantidade) as quantidade_vendida 
                        FROM notas_detalhes, notas 
                        WHERE notas.cdloja='$cdLojaParaContarEstoque' AND notas.idnota=notas_detalhes.idnota AND cdproduto='$cdproduto'";
                $resultado = mysql_query($query,$conexao);
                $quantidadeVendida=mysql_result($resultado,0,0);
    
                // Saidas diversas 
                $query="SELECT sum(quantidade) as quantidade_saida 
                        FROM estoque 
                        WHERE cdloja='$cdLojaParaContarEstoque' AND historico<50 AND cdproduto='$cdproduto'";
                $resultado = mysql_query($query,$conexao);
                $quantidadeSaida=mysql_result($resultado,0,0);
    
                $estoqueAtual=$quantidadeEntrada-$quantidadeSaida-$quantidadeVendida; // Indice 0
    

                // Metodo padrão para retornar mais de um valor em uma função
                $dadosEstoque=array($estoqueAtual);
                return $dadosEstoque;
            }
        ?>
    </body>
</html>