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
        <title>Relatórios</title>
        <meta http-equiv= "Content-Type" content= "text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="manutencao.css">
    </head>
    <body class="body">
        <?
            //Prepara conexao ao db
            include("../conectadb.php");

            //Recebe variaveis * $cdloja vem do conectadb 1=cabos 8=supergames
            $token=$_REQUEST["token"];
            $depuracao=$_REQUEST["depuracao"];
            $modo=$_REQUEST["modo"];

            // Mostra depuracao
            //include("depuracao.php"); 
        ?> 

        <!-- Envoltorio -->
        <div id="wrapper" class="wrapper">

        <!-- Espacamento superior -->
        <div id="topo" class="topo"></div>

        <!-- Inclui banner -->
        <? //include("banner.php"); ?>
            
        <!-- Inclui o menu -->
        <? include("mmenu.php"); ?>    

        
    
        
        <div id="pesquisa_corpo" class="pesquisa_corpo">


            <div style="padding-top: 50px;">&nbsp</div>

            <div class="prelat_img">
                <a href="cinc.php" target="_blank">
                    <img src='../imagens/shop.png' title='Incluir compra no sistema' width='16' height='16' />
                </a>
            </div>

            <div class="prelat_descr">
                Incluir compra no sistema
            </div>


            <div class="prelat_img">
                <img src='../imagens/packageOk.png' onclick='abrirDivRecebimento();' title='Dar entrada de pacote no sistema' width='16' height='16' />
            </div>

            <div class="prelat_descr">
                Receber pacote de encomenda
            </div>

            <div id="divRecebimento" style="clear: both; display: none; padding-left: 10px;">
                <form action="cRecebePacote.php" method="get" target="_blank">
                    Código de rastreamento: 
                    <input name="cdrastreamento" type="text"  placeholder="Código do pacote" size='20' maxlength="40"/>
                    <input type="image" src="../imagens/gaivota.png"  width='16' height='16' name="enviar" id="enviar" alt="Submit" />
                </form>
            </div>

            <div class="prelat_img">
                <a href="einc.php" target="_blank">
                    <img src='../imagens/addEstoque.png' title='Incluir compra no estoque' width='16' height='16' />
                </a>
            </div>

            <div class="prelat_descr">
                Incluir compra no estoque
            </div>

            <div class="prelat_img">
                <a href="elist.php" target="_blank">
                    <img src='../imagens/list.png' title='Exibir o relatório de entrada no estoque' width='16' height='16' />
                </a>
            </div>

            <div class="prelat_descr">
                Relatório de entrada no estoque
            </div>

            <div class="prelat_img">
                <a href="elist2.php" target="_blank">
                    <img src='../imagens/list2.png' title='Exibir o relatório de contagem de estoque' width='16' height='16' />
                </a>
            </div>

            <div class="prelat_descr">
                Relatório de contagem de estoque
            </div>


            <div class="prelat_img">
                <a href="eChamadaListaReposicao.php" target="_blank">
                    <img src='../img/icones/memory32.png' title='Abre a tela de chamada da lista de reposição de material' width='16' height='16' />
                </a>
            </div>

            <div class="prelat_descr">
                Listagem para reposição de estoque de material
            </div>





            <div class="prelat_img">
                <a href="econtagem.php" target="_blank">
                    <img src='../imagens/ajuste.png' title='Ajustar quantidade de produtos no estoque' width='16' height='16' />
                </a>
            </div>

            <div class="prelat_descr">
                Ajustar quantidade de produtos no estoque
            </div>


            <div class="prelat_img">
                <a href="eChamadaExtratoProduto.php" target="_blank">
                    <img src='../imagens/list3.png' title='Ver extrato de movimentações de produto no estoque' width='16' height='16' />
                </a>
            </div>

            <div class="prelat_descr">
                Visualizar extrato de produto no estoque
            </div>

            <div class="prelat_img">
                <a href="clocal.php" target="_blank">
                    <img src='../imagens/lista_compras.png' title='Lista de compras nas lojas locais' width='16' height='16' />
                </a>
            </div>

            <div class="prelat_descr">
                Lista de compras nas lojas locais
            </div>

            <div class="prelat_img">
                <a href="etransferencia.php" target="_blank">
                    <img src='../imagens/transferencia.png' title='Transferência de estoque entre lojas' width='16' height='16' />
                </a>
            </div>

            <div class="prelat_descr">
                Transferência de estoque entre as lojas
            </div>

        </div> <!-- Fim da div conteudo_principal -->

        <script>
            function abrirDivRecebimento(){
            let divRecebimento=document.getElementById("divRecebimento");
            divRecebimento.style.display="block"; 
            }
        </script>
    
    </body>
</html>