<html>
    <body>
        <?php
            //Prepara conexao ao db
            include("../conectadb.php");
            
            $cdLoja=$_REQUEST["cdloja"];
            $dadosCSV=$_REQUEST["csv"];
            $dtExclusao=$_REQUEST["dtexclusao"];
            $arrayDados = explode("\n",$dadosCSV); // Separa as linha que contem os dados

            echo "<h3>Comparação do estoque no sistema e contagem fisica</h3>";
            echo "Loja: $cdLoja";

            $id=1;
            echo "  <table>
                        <tr>
                            <td>
                                Código
                            </td>
                            <td>
                                Produto
                            </td>
                            <td>
                                Sistema
                            </td>
                            <td>
                                Contagem
                            </td>
                            <td>
                                Excluidos
                            </td>
                            <td>
                                Diferença
                            </td>
                            <td>
                                Mensagem
                            </td>
                        </tr>";

            foreach($arrayDados as $linhasDados){
                $dados=explode(",",$linhasDados); // Separa os dados separados por vírgula
                $cdProduto=$dados[0];
                $quantidadeProduto=$dados[1];
                $id++;

                $queryNomeProduto=" SELECT nome 
                                    FROM produtos 
                                    WHERE cdproduto='$cdProduto'";
                $resultadoNomeProduto = mysql_query($queryNomeProduto,$conexao);
                $nomeProduto=mysql_result($resultadoNomeProduto,0,0);
                if(!mysql_num_rows($resultadoNomeProduto)){
                    $mensagemErro="<font color='#FF0000'>Código do produto não localizado</font>"; 
                }

                // Vendas Excluidas
                $queryNotasExcluidas="  SELECT sum(notas_detalhes.quantidade) as quantidade_vendida 
                                        FROM notas_detalhes, notas 
                                        WHERE notas.cdloja='$cdLoja' 
                                        AND notas.idnota=notas_detalhes.idnota 
                                        AND cdproduto='$cdProduto' 
                                        AND notas.dtnota>='$dtExclusao'";
                //echo "$queryNotasExcluidas<br>";
                $resultadoNotasExcluidas = mysql_query($queryNotasExcluidas,$conexao);
                $quantidadeExcluida=mysql_result($resultadoNotasExcluidas,0,0);
                if($quantidadeExcluida==""){
                    $quantidadeExcluida=0;
                }

                $dadosEstoque=contaEstoque($cdProduto, $cdLoja, $conexao);
				$quantidadeEstoqueProduto=$dadosEstoque[0];
                $diferençaQuantidadeProduto=$quantidadeProduto-$quantidadeEstoqueProduto-$quantidadeExcluida; //O que foi vendido entra somando

                echo "  <tr>
                            <td>
                                $cdProduto
                            </td>
                            <td>
                                $nomeProduto
                            </td>
                            <td>
                                $quantidadeEstoqueProduto
                            </td>
                            <td>
                                $quantidadeProduto
                            </td>
                            <td>
                                $quantidadeExcluida
                            </td>
                            <td>
                                $diferençaQuantidadeProduto
                            </td>
                            <td>
                                $mensagemErro
                            </td>

                        </tr>";

                $mensagemErro="";

                //Faz a inclusão no Banco de dados
                if ($diferençaQuantidadeProduto>0){
                    $historico="55";
                    $observacao="Aumentado pela rotina eContagemFromCSV em $dthoje_eua";
                }
                if ($diferençaQuantidadeProduto<0){
                    $historico="5";
                    $diferençaQuantidadeProduto=abs($diferençaQuantidadeProduto); // Para o quantidade não entrar negativa no banco de dados
                    $observacao="Diminuido pela rotina eContagemFromCSV em $dthoje_eua";
                }
                if ($diferençaQuantidadeProduto<>0){ // Isto evita gravar registros com valor zero
                    $queryInsereAjuste="INSERT INTO estoque(iditem, cdloja, cdproduto, dtmovimento, historico, quantidade, idcompra, observacao) 
                                        VALUES (null, $cdLoja, '$cdProduto', '$dthoje_eua', $historico, $diferençaQuantidadeProduto, 0, '$observacao')";
                    $resultado = mysql_query($queryInsereAjuste,$conexao);
                    //echo "$cdloja | $cdproduto1 | $historico | $diferenca1<br>";
                    //echo "$queryInsereAjuste<br>";
                }
            }
            echo "</table>";

            //echo nl2br($dados);
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
