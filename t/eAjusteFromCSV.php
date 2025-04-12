<html>
    <body>
        <?php
            $cdLoja=$_REQUEST("cdloja");
            if $cdLoja==""{
                exit()
            }
            die("Rotina interrompida, verifique os dados da loja, data, etc...");
            $cdLoja='11'; // 11 - Estoque Supergames
            $dtExclusaoVendas='2023-04-28';
            $dtAtualizacao='2023-04-28';
            echo "loja: $cdLoja<br>";
            echo "Excluindo as vendas feitas a partir de $dtExclusaoVendas<br>";
            echo "Data da atualizacao: $dtAtualizacao<br>";
        ?>
        <h2>
            Importa codigo e quantidade do arquivo dados.csv. 
        </h2>
        <?php
            //Prepara conexao ao db
            include("../conectadb.php");

            $raiz_site=$_SERVER['DOCUMENT_ROOT'];
            $ponteiro = fopen ($raiz_site."/t/dados.csv", "r");

            if ($ponteiro) {
                echo"<table>";
                echo "  <tr>
                            <td align='center'>Código</td>
                            <td align='center'>Fabricante</td>
                            <td align='left'>Produto</td>
                            <td  align='center' title='Quantidade contada durante inventário'>Inventário</td>
                            <td  align='center' title='Quantidade atual no sistema'>Sistema</td>
                            <td  align='center' title='Vendas efetuadas depois da data da contagem'>Vendas</td>
                            <td  align='center' title='Quantidade ajustada'>Ajuste</td>
                            <td  align='center' title='Instrução a ser comandada no estoque'>Instrução</td>
                            <td  align='center' title='Quantidade final em estoque, depois de todos os ajustes'>Final</td>

                        </tr>";
                while (($linha = fgets($ponteiro, 4096)) !== false){
                    //$linha = fgets($ponteiro, 4096);
                    
                    $ArrayDados = explode(',', $linha);
                    $cdProduto=$ArrayDados[0];
                    $queryProduto=" SELECT produtos.nome,fabricantes.nome 
                                        FROM produtos,fabricantes 
                                        WHERE produtos.cdproduto='$cdProduto' 
                                        AND fabricantes.cdfabricante=produtos.cdfabricante";
                    $resultadoProduto = mysql_query($queryProduto,$conexao);
                    $nomeProduto=mysql_result($resultadoProduto,0,0);
                    $nomeFabricante=mysql_result($resultadoProduto,0,1);
                    //$nomeProduto=$ArrayDados[1];
                    $quantidadeProduto=$ArrayDados[1];

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




                    $quantidadeAjustar=$quantidadeProduto-$quantidadeEstoqueProduto-$quantidadeVendasAposContagem;
                    $quantidadeAjustarAbsoluto=abs($quantidadeAjustar);

                    if($quantidadeAjustar>0){
                        $instrucaoAjuste="Aumentar";
                        $queryAjustaQuantidade="INSERT INTO `estoque` (`iditem`, `cdloja`, `cdproduto`, `dtmovimento`, `historico`, `fornecedor`, `quantidade`, `vlindividual`, `idcompra`, `idnota`, `link`, `dados`, `observacao`) 
                                            VALUES (NULL, '$cdLoja', '$cdProduto', '$dtAtualizacao', '55', '0', $quantidadeAjustarAbsoluto, 0, '', '', '', '', 'Aumentado pela rotina eAjusteFromCSV em $dtAtualizacao');";
                        $resultadoAjustaQuantidade=mysql_query($queryAjustaQuantidade,$conexao);
                        //echo "$queryAjustaQuantidade<br>";
                    }
                    elseif($quantidadeAjustar==0){
                        $instrucaoAjuste="Nada a fazer";
                    }
                    else{
                        $instrucaoAjuste="Diminuir";
                        $queryAjustaQuantidade="INSERT INTO `estoque` (`iditem`, `cdloja`, `cdproduto`, `dtmovimento`, `historico`, `fornecedor`, `quantidade`, `vlindividual`, `idcompra`, `idnota`, `link`, `dados`, `observacao`) 
                                            VALUES (NULL, '$cdLoja', '$cdProduto', '$dtAtualizacao', '5', '0', $quantidadeAjustarAbsoluto, 0, '', '', '', '', 'Diminuido pela rotina eAjusteFromCSV em $dtAtualizacao');";
                        $resultadoAjustaQuantidade=mysql_query($queryAjustaQuantidade,$conexao);
                        //echo "$queryAjustaQuantidade<br>";
                    }
                    $quantidadeAjustarAbsoluto=abs($quantidadeAjustar);


                    //Trata de cadastrar preço, caso não exista preço na tabela.
                    $queryProcuraPrecoAnterior="SELECT * FROM precos WHERE cdproduto='$cdProduto' AND cdloja='$cdLoja'";
                    $resultadoProcuraPrecoAnterior = mysql_query($queryProcuraPrecoAnterior,$conexao);
                    $quantidadeItens=mysql_num_rows($resultadoProcuraPrecoAnterior);
                    IF($quantidadeItens==0){
                        //echo "Não achei preço anterior do Produto $cdProduto, cadastrando...<br>";
                        /*
                        $query="INSERT INTO precos(idpreco, cdproduto, cdloja, cdsubcategoria, vlcompra, dtatualizacao,cdmoeda,vlvenda,quant_estoque_min, garantia, ativo, siteflag)
                                VALUES (NULL, '$cdProduto', $cdLoja, 1, '999.99', '$dtAtualizacao', 'BRL', '999.99', 0, 90, 1, 0)";
                        */
                    }


                    echo "  <tr>
                                <td align='center'>$cdProduto</td>
                                <td align='left'>$nomeFabricante</td>
                                <td align='left'>$nomeProduto</td>
                                <td align='right'>$quantidadeProduto</td>
                                <td align='right'>$quantidadeEstoqueProduto</td>
                                <td align='right'>$quantidadeVendasAposContagem</td>
                                <td align='right'>$quantidadeAjustarAbsoluto</td>
                                <td align='right'>$instrucaoAjuste</td>
                                <td align='right'>$quantidadeFinalAposAjustes</td>
                            </tr>";
                }
                echo"</table>";
            }
            else{
                echo "erro na abertura<br>";
            }
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