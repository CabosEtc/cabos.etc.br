<html>
    <head>
        <title>Relatórios</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" >
        <link rel="stylesheet" type="text/css" href="manutencao.css">
    </head>

    <body>
        <?
            //Prepara conexao ao db
            include("../conectadb.php");

            // Inicializa a sessão
            include("msession.php");
            IF(!$logado or ($nivelusuario<4)){	
                echo "<meta http-equiv='refresh' content='5; url=index.php' target='_SELF'>";
                die("Seu nível de usuário não permite esta operação...");
            } 
            //echo $nivelusuario;

            $queryCentroDeCustos="	SELECT cdloja_centro_custo  
							FROM lojas  	
							WHERE cdloja='".$cdloja."'";
            $resultadoCentroDeCustos = mysql_query($queryCentroDeCustos,$conexao);
            $centroDeCustos=mysql_result($resultadoCentroDeCustos,0,0);

            $queryCentroDePrecos="	SELECT cdloja_centro_precos  
                                    FROM lojas  	
                                    WHERE cdloja='".$cdloja."'";
            $resultadoCentroDePrecos = mysql_query($queryCentroDePrecos,$conexao);
            $centroDePrecos=mysql_result($resultadoCentroDePrecos,0,0);

            //Recebe variaveis
             
            $letrainicial=$_REQUEST["letrainicial"];
            if($letrainicial<>""){
                $condicaoProdutoInicial=" produtos.nome>='$letrainicial'";
            }
            else{
                $condicaoProdutoInicial=" true "; 
            }

            $query="SELECT lojas_grupo   
                    FROM lojas 
                    WHERE cdloja='$cdloja'";
            $resultado = mysql_query($query,$conexao);
            $lojasGrupo=mysql_result($resultado,0,0);
            echo "<div>Código da loja: $cdloja</div>";

            $arrayLojasGrupo=explode(',', $lojasGrupo);
            // Retira o código da loja da lista de destino (para não transferir para ela mesma)
            $arrayLojasGrupo=array_diff($arrayLojasGrupo, array($cdloja));
            
            // Funções da página ---------------->
		 
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
                        WHERE notas.cdloja='$cdLojaParaContarEstoque' 
                        AND notas.idnota=notas_detalhes.idnota 
                        AND notas_detalhes.cdproduto='$cdproduto'";
                $resultado = mysql_query($query,$conexao);
                $quantidadeVendida=mysql_result($resultado,0,0);
                if($quantidadeVendida==""){
                    $quantidadeVendida=0;
                }

    
                // Saidas diversas 
                $query="SELECT sum(quantidade) as quantidade_saida 
                        FROM estoque 
                        WHERE cdloja='$cdLojaParaContarEstoque' AND historico<50 AND cdproduto='$cdproduto'";
                $resultado = mysql_query($query,$conexao);
                $quantidadeSaida=mysql_result($resultado,0,0);
    
                $estoqueAtual=$quantidadeEntrada-$quantidadeSaida-$quantidadeVendida; // Indice 0
    

                // Metodo padrão para retornar mais de um valor em uma função
                $dadosEstoque=array($estoqueAtual,$quantidadeVendida);
                //Estoque atual =$dadosEstoque[0]
                //Quantidade vendida =$dadosEstoque[1]
                return $dadosEstoque;
            }
        
 
            echo "<h3>Listagem de estoque</h3><br>";
            
            echo "  <table>
                        <tr>
                            <td align='center'>Codigo</td>
                            <td align='center'>Marca</td>
                            <td>Nome</td>
                            <td align='center'>Modelo</td>
                            <td align='center'>Custo</td>
                            <td  align='center' title='Estoque da loja'>Estoque</td>
                            <td  align='center'title='Estoque Ideal'>Ideal</td>
                            <td  align='center' title='Estoque Total (de todas as lojas)'>Total</td>
                            <td align='center'>Compras</td>
                            <td align='center'>Total Estoque</td>
                            <td align='center'>Total a chegar</td>
                            <td align='center'>Vendidos</td>
                        </tr>";
            /* Record set anterior, estava errado, o foco devem ser os produtos ativos na loja principal
            $queryEstoque=" SELECT estoque.cdproduto, fabricantes.nome, produtos.nome, produtos.modelo, precos.vlcompra, precos.ativo   
                            FROM estoque, produtos, fabricantes, precos  
                            WHERE estoque.cdproduto=produtos.cdproduto 
                            AND produtos.cdfabricante=fabricantes.cdfabricante 
                            AND precos.cdproduto=produtos.cdproduto 
                            AND estoque.cdloja IN($lojasGrupo)   
                            AND precos.ativo=1 
                            GROUP BY estoque.cdproduto 
                            ORDER BY produtos.nome";
            */

            $queryEstoque=" SELECT produtos.cdproduto, fabricantes.nome, produtos.nome, produtos.modelo, precos.vlcompra    
            FROM produtos, fabricantes, precos  
            WHERE produtos.cdfabricante=fabricantes.cdfabricante 
            AND precos.cdproduto=produtos.cdproduto 
            AND precos.cdloja=$centroDePrecos     
            AND precos.ativo=1 
            AND $condicaoProdutoInicial 
            ORDER BY produtos.nome";
            $resultadoEstoque = mysql_query($queryEstoque,$conexao);
            //echo "$queryEstoque<br>";

            $somaTotalTodosOsProdutosEmEstoque=0;
            $somaTotalTodosOsProdutosEmEstoqueLojaLogada=0;
            while ($row = mysql_fetch_array($resultadoEstoque, MYSQL_NUM)) {
                $cdProduto=$row[0];
                $marcaProduto=$row[1];
                $nomeProduto=$row[2];
                $modeloProduto=$row[3];
                $custoProduto=$row[4];
                //$codigotAtivo=$row[5];

                $queryEstoqueIdeal="SELECT produtos_complemento.estoque_ideal    
                                    FROM  produtos_complemento  
                                    WHERE produtos_complemento.cdproduto='$cdProduto'  
                                    AND cdloja='$centroDeCustos'";
                //echo "$queryEstoqueIdeal<br>";
                $resultadoEstoqueIdeal = mysql_query($queryEstoqueIdeal,$conexao);
                $estoqueIdeal=mysql_result($resultadoEstoqueIdeal,0,0);
                if($estoqueIdeal==0 OR $estoqueIdeal==''){
                    $estoqueIdeal="<a href='pinc.php?cdproduto=$cdProduto&modo=editar' target='_blank'><img src='../imagens/edit.png' title='Editar o produto' width='16' height='16' /></a>";
                }
                

                $dadosEstoque=contaEstoque($cdProduto, $cdLoja, $conexao);
                $quantEstoqueProduto=$dadosEstoque[0];
                $quantVendida=$dadosEstoque[1];

                if($quantEstoqueProduto<$estoqueIdeal AND $estoqueIdeal>0 AND $estoqueIdeal<>''){
                    $backGroundColor="style=\"background-color:$corMarcaTexto\""; // vem da tabela parametros
                }
                else{
                    $backGroundColor="";
                }

                //Rotina para contar o estoque de todas as lojas do grupo
					
					//Apaga o conteudo do title anterior
					$titleQuantidadeEstoqueProdutoOutrasLojas="";
                    $titlequantProdutosVendidosEmTodasAsLojas="";

                    $quantEstoqueTotalProdutoEmTodasAsLojas=$quantEstoqueProduto;
                    $quantProdutosVendidosEmTodasAsLojas=$quantVendida;

					foreach ($arrayLojasGrupo as $cdLojaContandoEstoque) {
						$queryApelidoLoja="	SELECT apelido 
											FROM lojas 
											WHERE cdloja=$cdLojaContandoEstoque";
                        //echo "$queryApelidoLoja<br>";
						$resultadoApelidoLoja = mysql_query($queryApelidoLoja,$conexao);
						$apelidoLoja=mysql_result($resultadoApelidoLoja,0,0);
						//echo "<option value='$item' selected>
						//		$apelidoLoja
						//	</option>";
						$dadosEstoque=contaEstoque($cdProduto, $cdLojaContandoEstoque, $conexao);

						$quantEstoqueProdutoOutraLoja=$dadosEstoque[0];
                        $quantVendidaOutraLoja=$dadosEstoque[1];

						$quantEstoqueTotalProdutoEmTodasAsLojas=$quantEstoqueTotalProdutoEmTodasAsLojas+$quantEstoqueProdutoOutraLoja;
						$titleQuantidadeEstoqueProdutoOutrasLojas=$titleQuantidadeEstoqueProdutoOutrasLojas."$apelidoLoja | $quantEstoqueProdutoOutraLoja\n";
					
                        $quantProdutosVendidosEmTodasAsLojas=$quantProdutosVendidosEmTodasAsLojas+$quantVendidaOutraLoja;
                        $titlequantProdutosVendidosEmTodasAsLojas=$titlequantProdutosVendidosEmTodasAsLojas."$apelidoLoja | $quantVendidaOutraLoja\n";
                    }
                
                /*                
                                $queryValorMinimo="SELECT estoque.vlindividual 
                                FROM estoque
                                WHERE estoque.cdproduto='$cdproduto'   
                                AND estoque.cdloja=$cdloja ORDER BY vlindividual ASC LIMIT 1 ";
                                $resultadoValorMinimo = mysql_query($queryValorMinimo,$conexao);
                                //echo "$query2<br>";
                                $vlIndividualMinimo=mysql_result($resultadoValorMinimo,0,0);
                */

                if($quantEstoqueTotalProdutoEmTodasAsLojas>0){
                    $valorTotalProdutoEmEstoque=$quantEstoqueTotalProdutoEmTodasAsLojas*$custoProduto;
                    $valorTotalProdutoEmEstoqueFormatado=number_format($valorTotalProdutoEmEstoque, 2, '.', '');
                    $valorTotalProdutoEmEstoqueLojaLogada=$quantEstoqueProduto*$custoProduto;
                    $valorTotalProdutoEmEstoqueLojaLogadaFormatado=number_format($valorTotalProdutoEmEstoqueLojaLogada, 2, '.', '');
                }
                else{
                    $valorTotalProdutoEmEstoque=0;
                    $valorTotalProdutoEmEstoqueFormatado="0.00";
                    //Lidar com os números negativos!
                    //$valorTotalProdutoEmEstoqueLojaLogada=0;
                    //$valorTotalProdutoEmEstoqueLojaLogadaFormatado="0.00";
                }
                
                if($quantEstoqueProduto>0){
                    $valorTotalProdutoEmEstoqueLojaLogada=$quantEstoqueProduto*$custoProduto;
                    $valorTotalProdutoEmEstoqueLojaLogadaFormatado=number_format($valorTotalProdutoEmEstoqueLojaLogada, 2, '.', '');
                }
                else{
                    $valorTotalProdutoEmEstoqueLojaLogada=0;
                    $valorTotalProdutoEmEstoqueLojaLogadaFormatado="0.00";
                }

                $somaTotalTodosOsProdutosEmEstoque=$somaTotalTodosOsProdutosEmEstoque+$valorTotalProdutoEmEstoque;
                $somaTotalTodosOsProdutosEmEstoqueLojaLogada=$somaTotalTodosOsProdutosEmEstoqueLojaLogada+$valorTotalProdutoEmEstoqueLojaLogada;


                
                echo "  <tr>
                            <td align='center'>$cdProduto</td>
                            <td>$marcaProduto</td>
                            <td>$nomeProduto</td>
                            <td>$modeloProduto</td>
                            <td align='right'>$custoProduto</td>
                            <td  $backGroundColor align='right'>$quantEstoqueProduto</td>
                            <td align='right'>$estoqueIdeal</td>
                            <td align='right' title='$titleQuantidadeEstoqueProdutoOutrasLojas'>$quantEstoqueTotalProdutoEmTodasAsLojas</td>
                            <td align='right'>&nbsp;</td>
                            <td align='right'>$valorTotalProdutoEmEstoqueLojaLogadaFormatado ($valorTotalProdutoEmEstoqueFormatado)</td>
                            <td align='right'>&nbsp;</td>
                            <td align='right' title='$titlequantProdutosVendidosEmTodasAsLojas'>$quantVendida($quantProdutosVendidosEmTodasAsLojas)</td>
                        </tr>";

                  

            } // fim while
            
            echo "</table>";
            $somaTotalTodosOsProdutosEmEstoqueFormatado=number_format($somaTotalTodosOsProdutosEmEstoque, 2, '.', '');
            $somaTotalTodosOsProdutosEmEstoqueLojaLogadaFormatado=number_format($somaTotalTodosOsProdutosEmEstoqueLojaLogada, 2, '.', '');
            echo "Soma total (loja/todas as lojas+estoque): $somaTotalTodosOsProdutosEmEstoqueLojaLogadaFormatado ($somaTotalTodosOsProdutosEmEstoqueFormatado)<br>";



        ?>

    </body>
</html>
