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

        <?
            //Prepara conexao ao db
            include("../conectadb.php");

            // Inicializa a sessão
            include("msession.php");
            IF(!$logado){	
                echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
            } 
            //echo $nivelusuario;

            //Recebe variaveis * $cdloja vem do conectadb 1=cabos 8=supergames

            $dtmovimento=$_REQUEST["dtmovimento"];

            $cdproduto1=$_REQUEST["cdproduto1"];
            $cdproduto2=$_REQUEST["cdproduto2"];
            $cdproduto3=$_REQUEST["cdproduto3"];
            $cdproduto4=$_REQUEST["cdproduto4"];
            $cdproduto5=$_REQUEST["cdproduto5"];
            $quantidade1=$_REQUEST["quantidade1"];
            $quantidade2=$_REQUEST["quantidade2"];
            $quantidade3=$_REQUEST["quantidade3"];
            $quantidade4=$_REQUEST["quantidade4"];
            $quantidade5=$_REQUEST["quantidade5"];

            $query="SELECT nomeloja 
                    FROM lojas 
                    WHERE cdloja='".$cdloja."'";
            $resultado = mysql_query($query,$conexao);
            $nomeloja=mysql_result($resultado,0,0);

            $dtmovimento=$dthoje_bra; 
            
            $query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto1."'";
            $resultado = mysql_query($query,$conexao);
            $descricao1=mysql_result($resultado,0,0);
            
            $query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto2."'";
            $resultado = mysql_query($query,$conexao);
            $descricao2=mysql_result($resultado,0,0);
            
            $query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto3."'";
            $resultado = mysql_query($query,$conexao);
            $descricao3=mysql_result($resultado,0,0);
            
            $query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto4."'";
            $resultado = mysql_query($query,$conexao);
            $descricao4=mysql_result($resultado,0,0);
            
            $query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto5."'";
            $resultado = mysql_query($query,$conexao);
            $descricao5=mysql_result($resultado,0,0);
            // Entradas ----------------------------------------------

            $query="SELECT sum(quantidade) as quantidade_entrada 
                    FROM estoque 
                    WHERE cdloja='".$cdloja."' AND historico>=50 AND cdproduto='".$cdproduto1."'";
            $resultado = mysql_query($query,$conexao);
            $quantidade_entrada1=mysql_result($resultado,0,0);
            //echo $query."<br>";
            //echo "$quantidade_entrada1<br>";

            $query="SELECT sum(quantidade) as quantidade_entrada 
                    FROM estoque 
                    WHERE cdloja='".$cdloja."' AND historico>=50 AND cdproduto='".$cdproduto2."'";
            $resultado = mysql_query($query,$conexao);
            $quantidade_entrada2=mysql_result($resultado,0,0);
            //echo $query."<br>";

            $query="SELECT sum(quantidade) as quantidade_entrada 
                    FROM estoque 
                    WHERE cdloja='".$cdloja."' AND historico>=50 AND cdproduto='".$cdproduto3."'";
            $resultado = mysql_query($query,$conexao);
            $quantidade_entrada3=mysql_result($resultado,0,0);
            //echo $query."<br>";

            $query="SELECT sum(quantidade) as quantidade_entrada 
                    FROM estoque 
                    WHERE cdloja='".$cdloja."' AND historico>=50 AND cdproduto='".$cdproduto4."'";
            $resultado = mysql_query($query,$conexao);
            $quantidade_entrada4=mysql_result($resultado,0,0);
            //echo $query."<br>";

            $query="SELECT sum(quantidade) as quantidade_entrada 
                    FROM estoque 
                    WHERE cdloja='".$cdloja."' AND historico>=50 AND cdproduto='".$cdproduto5."'";
            $resultado = mysql_query($query,$conexao);
            $quantidade_entrada5=mysql_result($resultado,0,0);
            //echo $query."<br>";

            // Quantidade vendida -------------------------------------------------------

            $query="SELECT sum(notas_detalhes.quantidade) as quantidade_vendida 
                    FROM notas_detalhes, notas 
                    WHERE notas.cdloja='".$cdloja."' AND notas.idnota=notas_detalhes.idnota AND cdproduto='".$cdproduto1."'";
            $resultado = mysql_query($query,$conexao);
            $quantidade_vendida1=mysql_result($resultado,0,0);
            //echo "$query<br>";
            //echo "$quantidade_vendida1<br>";

            $query="SELECT sum(notas_detalhes.quantidade) as quantidade_vendida 
                    FROM notas_detalhes, notas 
                    WHERE notas.cdloja='".$cdloja."' AND notas.idnota=notas_detalhes.idnota AND cdproduto='".$cdproduto2."'";
            $resultado = mysql_query($query,$conexao);
            $quantidade_vendida2=mysql_result($resultado,0,0);
            //echo $query."<br>";

            $query="SELECT sum(notas_detalhes.quantidade) as quantidade_vendida 
                    FROM notas_detalhes, notas 
                    WHERE notas.cdloja='".$cdloja."' AND notas.idnota=notas_detalhes.idnota AND cdproduto='".$cdproduto3."'";
            $resultado = mysql_query($query,$conexao);
            $quantidade_vendida3=mysql_result($resultado,0,0);
            //echo $query."<br>";

            $query="SELECT sum(notas_detalhes.quantidade) as quantidade_vendida 
                    FROM notas_detalhes, notas 
                    WHERE notas.cdloja='".$cdloja."' AND notas.idnota=notas_detalhes.idnota AND cdproduto='".$cdproduto4."'";
            $resultado = mysql_query($query,$conexao);
            $quantidade_vendida4=mysql_result($resultado,0,0);
            //echo $query."<br>";

            $query="SELECT sum(notas_detalhes.quantidade) as quantidade_vendida 
                    FROM notas_detalhes, notas 
                    WHERE notas.cdloja='".$cdloja."' AND notas.idnota=notas_detalhes.idnota AND cdproduto='".$cdproduto5."'";
            $resultado = mysql_query($query,$conexao);
            $quantidade_vendida5=mysql_result($resultado,0,0);
            //echo $query."<br>";

            //--------------------------------

            $query="SELECT sum(quantidade) as quantidade_saida 
                    FROM estoque 
                    WHERE cdloja='".$cdloja."' AND historico<50 AND cdproduto='".$cdproduto1."'";
            $resultado = mysql_query($query,$conexao);
            $quantidade_saida1=mysql_result($resultado,0,0);
            //echo "$query<br>";
            //echo "$quantidade_saida1<br>";

            $query="SELECT sum(quantidade) as quantidade_saida 
                    FROM estoque 
                    WHERE cdloja='".$cdloja."' AND historico<50 AND cdproduto='".$cdproduto2."'";
            $resultado = mysql_query($query,$conexao);
            $quantidade_saida2=mysql_result($resultado,0,0);
            //echo $query."<br>";

            $query="SELECT sum(quantidade) as quantidade_saida 
                    FROM estoque 
                    WHERE cdloja='".$cdloja."' AND historico<50 AND cdproduto='".$cdproduto3."'";
            $resultado = mysql_query($query,$conexao);
            $quantidade_saida3=mysql_result($resultado,0,0);
            //echo $query."<br>";

            $query="SELECT sum(quantidade) as quantidade_saida 
                    FROM estoque 
                    WHERE cdloja='".$cdloja."' AND historico<50 AND cdproduto='".$cdproduto4."'";
            $resultado = mysql_query($query,$conexao);
            $quantidade_saida4=mysql_result($resultado,0,0);
            //echo $query."<br>";

            $query="SELECT sum(quantidade) as quantidade_saida 
                    FROM estoque 
                    WHERE cdloja='".$cdloja."' AND historico<50 AND cdproduto='".$cdproduto5."'";
            $resultado = mysql_query($query,$conexao);
            $quantidade_saida5=mysql_result($resultado,0,0);
            //echo $query."<br>";

            //---------------------------------------------------------

            $estoqueatual_produto1=$quantidade_entrada1-$quantidade_saida1-$quantidade_vendida1;
            $diferenca1=$quantidade1-$estoqueatual_produto1;

            $estoqueatual_produto2=$quantidade_entrada2-$quantidade_saida2-$quantidade_vendida2;
            $diferenca2=$quantidade2-$estoqueatual_produto2;

            $estoqueatual_produto3=$quantidade_entrada3-$quantidade_saida3-$quantidade_vendida3;
            $diferenca3=$quantidade3-$estoqueatual_produto3;

            $estoqueatual_produto4=$quantidade_entrada4-$quantidade_saida4-$quantidade_vendida4;
            $diferenca4=$quantidade4-$estoqueatual_produto4;

            $estoqueatual_produto5=$quantidade_entrada5-$quantidade_saida5-$quantidade_vendida5;
            $diferenca5=$quantidade5-$estoqueatual_produto5;

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
                    Compara&ccedil;&atilde;o do estoque  no sistema e contagem fisica
                </h3>
            </div>   

            <div id="divNomeProduto">


                <form action="erot.php" method="get">
                    <table width="960" border="0" align="center">
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">Data da contagem</td>
                            <td>&nbsp;</td>
                            <td><? echo "<input name='dtmovimento' type='hidden' value='".$dtmovimento."' />".$dtmovimento; ?></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Codigo</td>
                            <td>Produto</td>
                            <td>Vendas</td>
                            <td>Contagem</td>
                            <td>Sistema</td>
                            <td>Diferen&ccedil;a</td>
                            <td>A&ccedil;&atilde;o requerida</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <?
                            echo "<tr>";
                            echo "<td><input name='cdproduto1' type='hidden' value='".$cdproduto1."' />".$cdproduto1."</td>";
                            echo "<td>".$descricao1."</td>";
                            echo "<td align='right'>".$quantidade_vendida1."</td>";
                            echo "<td align='right'>".$quantidade1."</td>";
                            echo "<td align='right'>".$estoqueatual_produto1."</td>";
                            echo "<td align='right'><input name='diferenca1' type='hidden' value='".$diferenca1."' />".$diferenca1."</td>";
                            if ($diferenca1==0){
                                echo "<td align='right'><select name='acao1' id='acao1'><option value='0'>Nada a fazer...</option></select></td>";
                            }

                            if ($diferenca1>0){
                                echo "<td align='right'><select name='acao1' id='acao1'><option value='1'>Incluir esta quantidade no sistema</option></select></td>";
                            }
                            if ($diferenca1<0){
                                echo "<td align='right'><select name='acao1' id='acao1'><option value='2'>Diminuir esta quantidade no sistema</option></select></td>";
                            }
                                
                            echo "</tr>";
                            //---------------------
                            echo "<tr>";
                            echo "<td><input name='cdproduto2' type='hidden' value='".$cdproduto2."' />".$cdproduto2."</td>";
                            echo "<td>".$descricao2."</td>";
                            echo "<td align='right'>".$quantidade_vendida2."</td>";
                            echo "<td align='right'>".$quantidade2."</td>";
                            echo "<td align='right'>".$estoqueatual_produto2."</td>";
                            echo "<td align='right'><input name='diferenca2' type='hidden' value='".$diferenca2."' />".$diferenca2."</td>";
                            if ($diferenca2==0){
                                echo "<td align='right'><select name='acao2' id='acao2'><option value='0'>Nada a fazer...</option></select></td>";
                            }

                            if ($diferenca2>0){
                                echo "<td align='right'><select name='acao2' id='acao2'><option value='1'>Incluir esta quantidade no sistema</option></select></td>";
                            }

                            if ($diferenca2<0){
                                echo "<td align='right'><select name='acao2' id='acao2'><option value='2'>Diminuir esta quantidade no sistema</option></select></td>";
                            }
                                
                            echo "</tr>";
                            //---------------------
                            echo "<tr>";
                            echo "<td><input name='cdproduto3' type='hidden' value='".$cdproduto3."' />".$cdproduto3."</td>";
                            echo "<td>".$descricao3."</td>";
                            echo "<td align='right'>".$quantidade_vendida3."</td>";
                            echo "<td align='right'>".$quantidade3."</td>";
                            echo "<td align='right'>".$estoqueatual_produto3."</td>";
                            echo "<td align='right'><input name='diferenca3' type='hidden' value='".$diferenca3."' />".$diferenca3."</td>";
                            if ($diferenca3==0){
                                echo "<td align='right'><select name='acao3' id='acao3'><option value='0'>Nada a fazer...</option></select></td>";
                            }

                            if ($diferenca3>0){
                                echo "<td align='right'><select name='acao3' id='acao3'><option value='1'>Incluir esta quantidade no sistema</option></select></td>";
                            }

                            if ($diferenca3<0){
                                echo "<td align='right'><select name='acao3' id='acao3'><option value='2'>Diminuir esta quantidade no sistema</option></select></td>";
                            }
                                
                            echo "</tr>";
                            //---------------------
                            echo "<tr>";
                            echo "<td><input name='cdproduto4' type='hidden' value='".$cdproduto4."' />".$cdproduto4."</td>";
                            echo "<td>".$descricao4."</td>";
                            echo "<td align='right'>".$quantidade_vendida4."</td>";
                            echo "<td align='right'>".$quantidade4."</td>";
                            echo "<td align='right'>".$estoqueatual_produto4."</td>";
                            echo "<td align='right'><input name='diferenca4' type='hidden' value='".$diferenca4."' />".$diferenca4."</td>";
                            if ($diferenca4==0){
                                echo "<td align='right'><select name='acao4' id='acao4'><option value='0'>Nada a fazer...</option></select></td>";
                            }
                            if ($diferenca4>0){
                                echo "<td align='right'><select name='acao4' id='acao4'><option value='1'>Incluir esta quantidade no sistema</option></select></td>";
                            }
                            if ($diferenca4<0){
                                echo "<td align='right'><select name='acao4' id='acao4'><option value='2'>Diminuir esta quantidade no sistema</option></select></td>";
                            }
                                
                            echo "</tr>";
                            //---------------------
                            echo "<tr>";
                            echo "<td><input name='cdproduto5' type='hidden' value='".$cdproduto5."' />".$cdproduto5."</td>";
                            echo "<td>".$descricao5."</td>";
                            echo "<td align='right'>".$quantidade_vendida5."</td>";
                            echo "<td align='right'>".$quantidade5."</td>";
                            echo "<td align='right'>".$estoqueatual_produto5."</td>";
                            echo "<td align='right'><input name='diferenca5' type='hidden' value='".$diferenca5."' />".$diferenca5."</td>";
                            if ($diferenca5==0){
                                echo "<td align='right'><select name='acao5' id='acao5'><option value='0'>Nada a fazer...</option></select></td>";
                            }

                            if ($diferenca5>0){
                                echo "<td align='right'><select name='acao5' id='acao5'><option value='1'>Incluir esta quantidade no sistema</option></select></td>";
                            }
                            if ($diferenca5<0){
                                echo "<td align='right'><select name='acao5' id='acao5'><option value='2'>Diminuir esta quantidade no sistema</option></select></td>";
                            }
                                
                            echo "</tr>";
                            //---------------------
                        ?>
                        <tr>
                            <td><input name="modo" type="hidden" id="modo" value="ajustar_estoque" /></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <label>
                                    <input type="submit" name="btnEnviar" id="btnEnviar" value="Enviar" />
                                </label>
                                </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table> 
                </form>


            </div>
        
        </div> <!-- Fim da div conteudo_principal -->


        



    </body>
</html>