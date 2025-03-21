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
        .idcompra{
            clear: left;
            float: left;
            width: 50px;
            display: flex;
            align-items: center;
	        justify-content: right;
        }
        .enderecocompra{
            float: left;
            width: 50px;
            display: flex;
            align-items: center;
	        justify-content: right;
        }
        .cdstatus{
            float: left;
            width: 50px;
            display: flex;
            align-items: center;
	        justify-content: right;
        }
        .quantidadeproduto{
            float: left;
            width: 50px;
            display: flex;
            align-items: center;
	        justify-content: right;
        }
        .pedido{
            float: left;
            width: 160px;
            display: flex;
            align-items: center;
	        justify-content: right;
        }
        .cdrastreamento{
            float: left;
            width: 160px;
            display: flex;
            align-items: center;
	        justify-content: right;
        }
        .data{
            float: left;
            width: 100px;
            display: flex;
            align-items: center;
	        justify-content: right;
        }

        .observacao{
            float: left;
            width: 250px;
            padding-left: 10px;
            display: flex;
            align-items: left;
	        justify-content: left;
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

        .info-status{
            position: fixed;
            width: 140px;
            top: 200;
            left: 0px;
            margin-left: 200px;
            background-color: DeepSkyBlue ;
            z-index: 1050;
            display: none;
            }


    </style>

<body>
    <script type="text/javascript" src="js/ajax2020.js"></script>
	
	<?	
        //Prepara conexao ao db
		include("../conectadb.php");

        // Inclui o menu 
		include("mmenu.php"); 

        $cdProduto=$_REQUEST["cdproduto"];

        $queryNomeProduto="  SELECT produtos.nome, fabricantes.nome        
        FROM produtos, fabricantes    
        WHERE produtos.cdfabricante=fabricantes.cdfabricante 
        AND cdproduto='$cdProduto'";
        $resultadoNomeProduto = mysql_query($queryNomeProduto,$conexao);
        $nomeProduto=mysql_result($resultadoNomeProduto,0,0);
        $marcaProduto=mysql_result($resultadoNomeProduto,0,1);

        echo "  <div id='infoStatus' class='info-status'>
                    <div>
                        <img src='../imagens/china.png' onclick='mudaStatusEncomenda(0);' />
                    </div>
                    <div>
                        <img src='../imagens/aviao.png' onclick='mudaStatusEncomenda(1);' />
                    </div>
                    <div>
                        <img src='../imagens/brasil.png' onclick='mudaStatusEncomenda(2);' />
                    </div>
                    <div>
                        <img src='../imagens/lion.png' onclick='mudaStatusEncomenda(3);' />
                    </div>
                    <div>
                        <img src='../imagens/caminhao.png' onclick='mudaStatusEncomenda(4);' />
                    </div>
                    <div>
                        <img src='../imagens/check.gif' onclick='mudaStatusEncomenda(5);' width='32' height='32' />
                    </div>
                    <input type='hidden' id='idEncomenda' value='0'>
                </div>";

        echo "<h1 style='margin-bottom: 20px;'>$cdProduto - $nomeProduto ($marcaProduto)</h1>";

        $queryCompraDetalhes="  SELECT idcompra, quantidade       
                        FROM compras_detalhes  
                        WHERE cdproduto='$cdProduto' 
                        ORDER BY idcompra DESC";
        $resultadoCompraDetalhes = mysql_query($queryCompraDetalhes,$conexao);


        
        
        echo "      <div class='idcompra'>Id</div>
                    <div class='cdstatus'>Status</div>
                    <div class='enderecocompra'>End</div>
                    <div class='quantidadeproduto'>Quant</div>
                    <div class='pedido'>Pedido</div>
                    <div class='cdrastreamento'>Cd Rastreamento</div>
                    <div class='data'>Dt Pedido</div>
                    <div class='data'>Dt Chegada</div>
                    <div class='observacao'>Observações</div>";
        
        while ($row = mysql_fetch_array($resultadoCompraDetalhes, MYSQL_NUM)) {
            $idCompra=$row[0];
            $quantidadeProduto=$row[1];
            $queryCompra="  SELECT pedido, cdrastreamento, dtcompra, observacao, cdstatus, dtchegada, endereco   
                            FROM compras 
                            WHERE idcompra=$idCompra";
            //echo "$queryCompra<br>";
            $resultadoCompra = mysql_query($queryCompra,$conexao);
            $PedidoCompra=mysql_result($resultadoCompra,0,0);
            $cdRastreamento=mysql_result($resultadoCompra,0,1); 
            if ($cdRastreamento==""){
                $cdRastreamento="&nbsp";
            }
            $dtCompra=mysql_result($resultadoCompra,0,2);
            $observacao=mysql_result($resultadoCompra,0,3);
            if(($observacao<>"") AND ($nivelusuario>=4)){
                $observacao=$observacao;
            }
            else{
                $observacao="&nbsp";
            }
            $cdStatus=mysql_result($resultadoCompra,0,4);
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

            $dtChegada=mysql_result($resultadoCompra,0,5);
            if($dtChegada=="0000-00-00"){
                $dtChegada="&nbsp";
            }
            $enderecoCompra=mysql_result($resultadoCompra,0,6);


            echo "      <div class='idcompra'>
                            $idCompra 
                        </div>
                        <div class='cdstatus'>
                            <img id='imgStatus$idCompra' src='$imgStatus' onclick='mostraPopUpStatusEncomenda($idCompra);' width='24' height='24'/>
                        </div>
                        <div class='enderecocompra'>
                            $enderecoCompra
                        </div>
                        <div class='quantidadeproduto'>
                            $quantidadeProduto
                        </div>
                        <div class='pedido'>
                            $PedidoCompra 
                        </div>
                        <div class='cdrastreamento'>
                            <span onclick='getElementById(\"div$idCompra\").style.display=\"block\"'>
                                <a href='https://t.17track.net/pt#nums=$cdRastreamento' target='_blank'>$cdRastreamento</a>
                            </span>
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
            /*
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
            */

        } // fim while
       
	?>

    <script>
        function mostraPopUpStatusEncomenda(id){
            document.getElementById("infoStatus").style.display="block";
            document.getElementById("idEncomenda").value=id;
            
            //alert("Passei aqui! "+id);
        }

        function mudaStatusEncomenda(novoStatus){
            let id=document.getElementById("idEncomenda").value;
            let imgStatus="imgStatus"+id;
            //document.getElementById("infoStatus").style.display="block";
            //alert(imgStatus);
            document.getElementById(imgStatus).src='../imagens/lion.png';
            switch (novoStatus){
                case 0:
                    document.getElementById(imgStatus).src='../imagens/china.png';
                break;
                case 1:
                    document.getElementById(imgStatus).src='../imagens/aviao.png';
                break;
                case 2:
                    document.getElementById(imgStatus).src='../imagens/brasil.png';
                break;
                case 3:
                    document.getElementById(imgStatus).src='../imagens/lion.png';
                break;
                case 4:
                    document.getElementById(imgStatus).src='../imagens/caminhao.png';
                break;
                case 5:
                    document.getElementById(imgStatus).src='../imagens/check.gif';
                break;
            }
            document.getElementById("infoStatus").style.display="none";


            let pagina=`BDRotinasAjax.php?modo=ajustaStatusEncomenda&idcompra=${id}&cdstatus=${novoStatus}`;

            //alert(pagina);
            //console.log(pagina);

            var async = true;
            xmlhttp.open("GET", pagina, async); // foi adicionado um false aqui, parece que funcionou!
            xmlhttp.onreadystatechange=function(){
                if(xmlhttp.readyState==4 && xmlhttp.status==200){
                    console.log(xmlhttp.responseText);
                    alert(xmlhttp.responseText);                    
                }
            }
            xmlhttp.send(null);


        }
    </script>

</body>
</html>
