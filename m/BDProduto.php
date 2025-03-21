<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="manutencao.css">
        <title>BDLojas</title>
    </head>

    <body>

        <?

            //Prepara conexao ao db
            include("../conectadb.php");

            //Recebe variaveis
            $cdProduto=$_REQUEST["cdproduto"];

            //Inclui o menu
            include("mmenu.php");   

            $query="SELECT produtos.nome  
                    FROM produtos 
                    WHERE produtos.cdproduto='$cdProduto'";
            $resultado = mysql_query($query,$conexao);
            $nomeProdutoTabelaProdutos=mysql_result($resultado,0,0);


            $query="SELECT  links_boadica.cdproduto, links_boadica.link, links_boadica.produto, 
                            links_boadica.marca, links_boadica.flag_ativo, links_boadica.id    
                    FROM `links_boadica`, produtos 
                    WHERE produtos.cdproduto=links_boadica.cdproduto 
                    AND links_boadica.cdproduto='$cdProduto'";
            //echo $query;

            $resultado = mysql_query($query,$conexao);
            $quantidade=mysql_num_rows($resultado);
            echo "  <h1>
                        $cdProduto - $nomeProdutoTabelaProdutos
                    </h1>";
            echo "Lista dos $quantidade produtos ativos na $nomeloja.<br><br>";






            echo "<table>";

            $contador=1;
            $linksAcumulados="";
            $linksAcumuladosSomenteAtivos="";
            while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
                $codigoProduto=$row[0]; 
                $linkProduto=$row[1]; 
                $nomeProduto=$row[2];
                $marcaProduto=$row[3];
                $flagAtivo=$row[4];
                switch ($flagAtivo) {
                    case 0:
                        $imagemAtivo="ballRed.png";	
                        break;
                    case 1:
                        $imagemAtivo="ballGreen.png";
                        break;
                    case 2:
                        $imagemAtivo="ballYellow.png";	
                        break;

                }
                $idLinkBoadica=$row[5];
                echo "  <tr>
                            <td>
                                $contador
                            </td>
                            <td>
                                <a href='$linkProduto' target='_blank'>
                                <img src='../imagens/coruja.png' width='16' height='16' />
                                </a>
                            </td>
                            <td>
                                <img src='../imagens/$imagemAtivo' width='16' height='16' />
                            </td>
                            <td>
                                $marcaProduto
                            </td>
                            <td>
                                $idLinkBoadica
                            </td>
                            <td>
                                $nomeProduto
                            </td>
                        </tr>";
                $contador=$contador+1;
                $linksAcumulados=$linksAcumulados."window.open(\"$linkProduto\");";
                if($flagAtivo==1){
                    $linksAcumuladosSomenteAtivos=$linksAcumuladosSomenteAtivos."window.open(\"$linkProduto\");";
                }
                } // Fim da linha de exibicao do produto

                echo "</table>";
                echo "  <div style='padding-top:30px;'>
                                Click <span onclick='$linksAcumulados' onMouseOver='this.style.cursor=\"pointer\"'>aqui</span> para abrir todos os links.
                        </div";
                
                echo "  <div style='padding-top:30px;'>
                        Click <span onclick='$linksAcumuladosSomenteAtivos' onMouseOver='this.style.cursor=\"pointer\"'>aqui</span> para abrir todos os links em que nós anunciamos.
                </div";

        ?>
    </body>
</html>


