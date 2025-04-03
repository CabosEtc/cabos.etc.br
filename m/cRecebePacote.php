<?php 
  	// Inicializa a sessão
	include("msession.php");
	IF(!$logado){	
		echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
	} 
	//echo $nivelusuario;
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="manutencao.css">
        <title></title>
	</head>

    <style>
        .cdstatus{
            float: left;
            clear: left;
            width: 50px;
            display: flex;
            align-items: center;
	        justify-content: right;
        }
        .pedido{
            float: left;
            width: 150px;
        }
        .cdrastreamento{
            
            float: left;
            
            width: 150px;
        }
        .data{
            float: left;
            width: 150px;
        }

        .observacao{
            float: left;
            width: 20px;
        }
        .naoFlutua{
            clear: both;
        }
        .oculta{
            display: none;
        }
        .cdproduto{
            clear: left;
            float: left;
            width: 60px;
        }

        .nomeproduto{
            float: left;
            width: 350px;
        }
        .quantidadeproduto{
            float: left;
            width: 100px;
        }
    </style>

<body>
	
	<?	
        //Prepara conexao ao db
		include("../conectadb.php");

        // Inclui o menu 
		include("mmenu.php"); 

        $searchRastreamento=$_REQUEST["cdrastreamento"];

        $modo=$_REQUEST["modo"];
        $incPedido=$_REQUEST["pedido"];
        $incProduto=$_REQUEST["cdproduto"];
        $incQuantidade=$_REQUEST["quantidade"];

        if($modo<>"Incluir"){
        
            $queryCompra="  SELECT idcompra, cdrastreamento, pedido, dtcompra, observacao, dtchegada, cdstatus        
                            FROM compras  
                            WHERE cdrastreamento LIKE '%$searchRastreamento%' 
                            ORDER BY dtcompra DESC";
            $resultadoCompra = mysql_query($queryCompra,$conexao);

            echo "<h1 style='margin-bottom: 20px;'>Listagem de Compras</h1>";
            
            
            echo "      <div class='cdstatus'>Status</div>
                        <div class='pedido'>Pedido</div>
                        <div class='cdrastreamento'>Cd Rastreamento</div>
                        <div class='data'>Compra</div>
                        <div class='data'>Chegada</div>";
            
            while ($row = mysql_fetch_array($resultadoCompra, MYSQL_NUM)) {
                $idCompra=$row[0];
                $cdRastreamento=$row[1]; 
                if ($cdRastreamento==""){
                    $cdRastreamento="&nbsp";
                }
                $idPedido=$row[2];
                $dtCompra=$row[3];
                $observacao=$row[4];
                $dtChegada=$row[5];
                if($dtChegada=="0000-00-00"){
                    $dtChegada="&nbsp;";
                }
                if($observacao<>""){
                    $observacao="<span title='$observacao'><img src='../imagens/etc.png' width='16' height='16'/></span>";
                }
                $cdStatus=$row[6];
                switch ($cdStatus) {
                    case 0:
                        $imgStatus="../imagens/china.png";
                        break;
                    case 1:
                        $imgStatus="../imagens/aviao.png";
                        break;
                    case 2:
                        $imgStatus="../imagens/brasil.png";
                        break;
                    case 3:
                        $imgStatus="../imagens/lion.png";
                        break;
                    case 4:
                        $imgStatus="../imagens/caminhao.png";
                        break;
                    case 5:
                        $imgStatus="../imagens/check.gif";
                        break;
                }

                echo "      <div class='cdstatus'>
                                <img src='$imgStatus' width='24' height='24'/>
                            </div>
                            <div class='pedido'>
                                <span onclick='getElementById(\"div$idCompra\").style.display=\"block\"'>
                                    $idPedido
                                </span>
                            </div>
                            <div class='cdrastreamento'>
                                <a href='https://t.17track.net/pt#nums=$cdRastreamento' target='_blank'>
                                    $cdRastreamento
                                </a>
                            </div>
                            <div class='data'>
                                $dtCompra
                            </div>
                            <div class='data'>
                                $dtChegada
                            </div>
                            <div class='observacao'>
                                $observacao
                            </div>";

                $queryDetalhesCompra="  SELECT produtos.cdproduto, compras_detalhes.quantidade, produtos.nome      
                                        FROM produtos, compras_detalhes   
                                        WHERE produtos.cdproduto=compras_detalhes.cdproduto 
                                        AND idcompra=$idCompra  
                                        ORDER BY cdproduto ASC";
                $resultadoDetalhesCompra = mysql_query($queryDetalhesCompra,$conexao);


                echo "      <div id='div$idCompra' class='naoFlutua oculta'>";
                echo "<form action='cRecebePacote.php' method='get'>";
                ECHO "<input type='hidden' name='pedido' value='$idPedido'/>";
                        
                $contador=0;
                while ($rowDetalhesCompra = mysql_fetch_array($resultadoDetalhesCompra, MYSQL_NUM)) {
                    $cdProduto=$rowDetalhesCompra[0];
                    $quantidadeProduto=$rowDetalhesCompra[1]; 
                    $nomeProduto=$rowDetalhesCompra[2];
                        echo"   <div class='naoFlutua'>
                                    <div class='cdproduto'>
                                        <input type='text' name='cdproduto[$contador]' value='$cdProduto' size='5' readonly>
                                    </div>
                                    <div class='nomeproduto'>
                                        $nomeProduto
                                    </div>
                                    <div class='quantidadeproduto'>
                                        $quantidadeProduto
                                    </div>
                                    <div class='quantidadeproduto'>
                                        <input type='text' name='quantidade[$contador]' value='$quantidadeProduto'>
                                    </div>
                                </div>";
                    $contador++;
                }
                echo "<div class='naoFlutua'><input type='submit' name='modo' id='modo' value='Incluir' /></div>";
                echo "</form>";
                echo "      </div>";

            } // fim while
        }

        if($modo=="Incluir"){
            $contador=0;
            foreach ($incProduto as $row):
                $cdProduto=$incProduto[$contador]; // nome da categoria
                $quantidade=$incQuantidade[$contador]; // nome da categoria
                //$vlvenda=$row[2]; // nome da categoria
                $contador++;
                echo "$cdProduto | $quantidade<br>";
            endforeach;
        }
	?>

</body>
</html>
