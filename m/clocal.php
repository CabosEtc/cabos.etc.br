<!DOCTYPE html>
<html>
<head>
    <title>Compras</title>
    <meta charset="UTF8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.3/dist/css/bootstrap.min.css">
</head>
<style type="text/css">
    .inputLabel {
        width: 150px;
    }
    .inputValue {
        width: 100px;
    }
</style>
    <body style="margin-top:20px;">
<script type="text/javascript" src="js/ajax2020.js"></script>
<?php
    //Prepara conexao ao db
    include("../conectadb.php");

    $idFornecedorSelecionado=$_REQUEST["idfornecedor"];
    $modo=$_REQUEST["modo"];
    $cdProdutoParaIncluirNaLista=$_REQUEST["cdproduto"];
    if($modo=="incluirprodutonalista"){
        $querydadosProdutoParaIncluirNaLista="SELECT produtos.nome, fabricantes.nome  
                FROM produtos, fabricantes 
                WHERE produtos.cdfabricante=fabricantes.cdfabricante  
                AND produtos.cdproduto='$cdProdutoParaIncluirNaLista'";
        //echo "$resultadoDadosProdutoParaIncluirNaLista<br>";
        $resultadoDadosProdutoParaIncluirNaLista = mysql_query($querydadosProdutoParaIncluirNaLista,$conexao);
        $nomeProdutoParaIncluirNaLista=mysql_result($resultadoDadosProdutoParaIncluirNaLista,0,0);
        $fabricanteProdutoParaIncluirNaLista=mysql_result($resultadoDadosProdutoParaIncluirNaLista,0,1);
    }

    // A avaliação do modo deve ser feita no final do codigo, a rotina de incluir ainda não existe
?>
<div class="container">
    <div class="d-flex flex-row-reverse">
        <div class="p-2 bd-highlight" title="Adicionar produto nesta lista"><img src="https://www.cabos.etc.br/imagens/lista_compras.png" onclick="mostraPesquisaProdutos('incluir_produto_lista_compras');"></div>
        <div class="p-2 bd-highlight" title="Adicionar cotação de preço em uma loja"><img src="https://www.cabos.etc.br/imagens/pricetag.png" onclick="mostraPesquisaProdutos('incluir_cotacao');"></div>
    </div>
    <div id="alerta" class="alert alert-success alert-dismissable" style="text-align:center;display:none;">
        Mensagens    
    </div>

    <h1 class="d-flex justify-content-center">Lista de compras</h1>
    <div class="d-flex justify-content-center mb-2">
        <select name='loja' id='loja' onchange='mudaLoja();'>
            <option value='0'>Todas as lojas</option>
            <?php
                $queryFornecedores="SELECT fornecedor.apelido, fornecedor.id            
                                    FROM fornecedor         
                                    ORDER BY fornecedor.apelido ASC";
                //echo $queryPedidoDeMaterial;

                $resultadoFornecedores = mysql_query($queryFornecedores,$conexao);

                while ($rowFornecedores = mysql_fetch_array($resultadoFornecedores, MYSQL_NUM)) {
                    $apelidoFornecedor=$rowFornecedores[0];
                    $idFornecedor=$rowFornecedores[1];
                    if($idFornecedor==$idFornecedorSelecionado){
                        $flagSelecionado="selected";
                    }
                    else{
                        $flagSelecionado="";
                    }
                    echo "<option $flagSelecionado value='$idFornecedor'>$apelidoFornecedor</option>";
                }
            ?>
        
        </select>
    </div>

    <?php
        if($idFornecedorSelecionado=="" OR $idFornecedorSelecionado=="0"){
            //$flagOnClick="onclick=\"alert('Selecione uma loja');\""; 
            $queryPedidoDeMaterial="SELECT pedmaterial.cdproduto, pedmaterial.quantidade, pedmaterial.idfornecedor, produtos.nome, fabricantes.nome, pedmaterial.prioridade            
                                FROM pedmaterial, produtos, fabricantes         
                                WHERE pedmaterial.quantidade>0 
                                AND pedmaterial.cdproduto=produtos.cdproduto  
                                AND produtos.cdfabricante=fabricantes.cdfabricante   
                                AND pedmaterial.cdloja=1 
                                ORDER BY pedmaterial.prioridade DESC, pedmaterial.cdproduto ASC";
        }
        else{
            //Isto será usado para permitir ou não o clique para acionar a rotina de inclusão do produtos no estoque
            //$flagOnClick="onclick=\"incluirComprasEstoque('$cdProduto');\""; 

            $queryPedidoDeMaterial="SELECT pedmaterial.cdproduto, pedmaterial.quantidade, pedmaterial.idfornecedor, produtos.nome, fabricantes.nome, pedmaterial.prioridade            
                                    FROM pedmaterial, produtos, fabricantes, estoque          
                                    WHERE pedmaterial.quantidade>0 
                                    AND pedmaterial.cdproduto=produtos.cdproduto  
                                    AND produtos.cdfabricante=fabricantes.cdfabricante   
                                    AND pedmaterial.cdloja=1 
                                    AND estoque.fornecedor=$idFornecedorSelecionado 
                                    AND estoque.cdproduto=pedmaterial.cdproduto 
                                    ORDER BY pedmaterial.prioridade DESC, pedmaterial.cdproduto ASC";
        }
        //echo $queryPedidoDeMaterial;

        $resultadoPedidoDeMaterial = mysql_query($queryPedidoDeMaterial,$conexao);

        $cdProdutoAnterior="";
        while ($rowPedidoDeMaterial = mysql_fetch_array($resultadoPedidoDeMaterial, MYSQL_NUM)) {
            $cdProduto=$rowPedidoDeMaterial[0];
            $quantidadeProduto=$rowPedidoDeMaterial[1];
            $idFornecedor=$rowPedidoDeMaterial[2];
            $nomeProduto=$rowPedidoDeMaterial[3];
            $nomeFabricante=$rowPedidoDeMaterial[4];
            $flagPrioridade=$rowPedidoDeMaterial[5];
            if($flagPrioridade==1){
                $corBackground="bg-warning";
            }
            else{
                $corBackground="";
            }

            if($cdProdutoAnterior<>$cdProduto){
                echo "  <div id=\"div$cdProduto\" class=\"row $corBackground\">

                            <div id=\"divNomeProduto\" class=\"col-10\" onclick=\"mostraModalCotacaoPrecos('$cdProduto');\">
                                $nomeProduto [$nomeFabricante] 
                            </div>
                            <div id=\"divQuantidadeProdutos\" class=\"col-2\" onclick=\"mostraModalIncluirComprasEstoque('incluir_compra_estoque','$cdProduto',$quantidadeProduto,'$nomeFabricante','$nomeProduto');\">
                                $quantidadeProduto
                            </div>
                        </div>";
            }
            
            $cdProdutoAnterior=$cdProduto;
        }
    ?>


    <!-- Modal Mostrar cotação de preços da lojas-->
    <div class="modal fade" id="modalCotacaoPrecosLojas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cotação de preços/outras informações</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="divPrecosProduto" class="modal-body">
                    &nbsp;
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Incluir compras no estoque -->
    <div class="modal fade" id="modalIncluirComprasEstoque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="incluirComprasEstoque_titulo">Titulo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="divaajustaristoaqui" class="modal-body">
                    <div>
                        <select name='incluirCompraEstoque_idLoja' id='incluirCompraEstoque_idLoja' onchange=''>
                            <!-- Entrar com php abaixo para encher os selects -->
                            <option value='0'>Todas as lojas</option>
                            <?php
                                $queryFornecedores="SELECT fornecedor.apelido, fornecedor.id            
                                                    FROM fornecedor         
                                                    ORDER BY fornecedor.apelido ASC";
                                //echo $queryPedidoDeMaterial;

                                $resultadoFornecedores = mysql_query($queryFornecedores,$conexao);

                                while ($rowFornecedores = mysql_fetch_array($resultadoFornecedores, MYSQL_NUM)) {
                                    $apelidoFornecedor=$rowFornecedores[0];
                                    $idFornecedor=$rowFornecedores[1];
                                    if($idFornecedor==$idFornecedorSelecionado){
                                        $flagSelecionado="selected";
                                    }
                                    else{
                                        $flagSelecionado="";
                                    }
                                    echo "<option $flagSelecionado value='$idFornecedor'>$apelidoFornecedor</option>";
                                }
                            ?>
                        </select>
                    </div>

















                        <!-- Aqui vão entrar codigo, fabricante e nome montados por código -->
                        <div id='incluirComprasEstoque_produto' class="mb-4">
                            &nbsp;
                        </div>
                        <div class='clearfix mb-2'>
                            <div class='float-left  inputLabel'>
                                Data da entrada                        
                            </div>
                            <div id="inputDataEntrada" class='float-left'>
                                <? echo $dthoje_bra;?>
                            </div>
                        </div>
                        <div class='clearfix mb-2'>
                            <div class='float-left  inputLabel'>
                                Código do Produto
                            </div>
                            <div id='inputCdProduto' class='float-left'>
                                12345
                            </div>                        
                        </div>
                        <div class='clearfix mb-2'>
                            <div class='float-left  inputLabel'>
                                Quantidade
                            </div>
                            <div class='float-left'>
                                <input type='text' size='6' maxlength='6' id='inputQuantidadeProdutos' value='' align='right'>
                            </div>
                        </div>
                        <div class='clearfix mb-2'>
                            <div class='float-left inputLabel'>
                                Valor individual
                            </div>
                            <div class='float-left'>
                                <input type='text' size='6' maxlength='6' id='inputValorIndividual' value='' align='right'>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="incluirComprasEstoque();">Incluir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Incluir cotaçao em uma loja -->
    <div class="modal fade" id="modalIncluirCotacaoLoja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Incluir cotação de produto na Loja X</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="divaajustaristoaqui" class="modal-body">

                        <div>
                            <select name='incluirCotacaoLoja_idLoja' id='incluirCotacaoLoja_idLoja' onchange=''>
                                <!-- Entrar com php abaixo para encher os selects -->
                                <option value='0'>Todas as lojas</option>
                                <?php
                                    $queryFornecedores="SELECT fornecedor.apelido, fornecedor.id            
                                                        FROM fornecedor         
                                                        ORDER BY fornecedor.apelido ASC";
                                    //echo $queryPedidoDeMaterial;

                                    $resultadoFornecedores = mysql_query($queryFornecedores,$conexao);

                                    while ($rowFornecedores = mysql_fetch_array($resultadoFornecedores, MYSQL_NUM)) {
                                        $apelidoFornecedor=$rowFornecedores[0];
                                        $idFornecedor=$rowFornecedores[1];
                                        if($idFornecedor==$idFornecedorSelecionado){
                                            $flagSelecionado="selected";
                                        }
                                        else{
                                            $flagSelecionado="";
                                        }
                                        echo "<option $flagSelecionado value='$idFornecedor'>$apelidoFornecedor</option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <div><img class="img-fluid" src="../imagens/produtos/03003.jpg" /></div>

                        <div id='incluirCotacaoLoja_nomeProduto' class="mb-4">
                            &nbsp;
                        </div>
                        <div class='clearfix'>
                            <div class='float-left  inputLabel'>
                                Data da entrada                        
                            </div>
                            <div id="incluirCotacaoLoja_dataEntrada" class='float-left'>
                                <? echo $dthoje_bra;?>
                            </div>
                        </div>
                        <div class='clearfix'>
                            <div class='float-left  inputLabel'>
                                Código do Produto
                            </div>
                            <div id='incluirCotacaoLoja_cdProduto' class='float-left'>
                                12345
                            </div>                        
                        </div>
                        <div class='clearfix'>
                            <div class='float-left  inputLabel'>
                                Quantidade
                            </div>
                            <div class='float-left'>
                                <input type='text' size='6' maxlength='6' id='incluirCotacaoLoja_quantidadeProdutos' value='0' align='right'>
                            </div>
                        </div>
                        <div class='clearfix'>
                            <div class='float-left inputLabel'>
                                Valor individual
                            </div>
                            <div class='float-left'>
                                <input type='text' size='6' maxlength='6' id='incluirCotacaoLoja_valorIndividual' value='' align='right'>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="incluirCotacaoLoja();">Incluir</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal Pesquisar produtos -->
     <div class="modal fade" id="modalPesquisarProdutos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pesquisar produtos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="divaajustaristoaqui" class="modal-body">

                        <div id='inputNomeProduto' class="mb-4">
                            &nbsp;
                        </div>
                        <div class='clearfix'>
                            <form action="" method="post" target="_blank" id="formPesquisarProduto">
                                <div class='float-left'>
                                    <input name="busca" id="busca" type="text"  placeholder="Nome do produto" size='30' maxlength="40"/>
                                    <input name="pesquisarProdutos_modo" id="pesquisarProdutos_modo" type="hidden"/>
                                </div>
                            </form>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="pesquisaProdutos();">Pesquisar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Mostrar Produtos Pesquisados -->
    <div class="modal fade" id="modalMostrarProdutosPesquisados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Resultado da pesquisa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="divMostraBuscaProdutos" class="modal-body">
                    &nbsp;
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Incluir Produto no Pedido de Material -->
    <div class="modal fade" id="modalIncluirProdutoPedidoMaterial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Incluir produto nesta lista de material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="divIncluirProdutoPedidoMaterial" class="modal-body">
                    &nbsp;
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button> -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="fecharAtualizarAposInclusaoProdutoPedidoMaterial();">Atualizar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function mostraModalCotacaoPrecos(cdProduto){
            //alert(cdProduto)
            pagina="https://www.cabos.etc.br/m/BDRotinasAjax.php?modo=precoComprasBrasil&cdproduto="+cdProduto;
            let idDivPreco=document.getElementById("divPrecosProduto");

            var async = true;
            xmlhttp.open("GET", pagina, async); // foi adicionado um false aqui, parece que funcionou!
            xmlhttp.onreadystatechange=function(){
                
                //console.log(`Status: ${xmlhttp.status} readState: ${xmlhttp.readyState}`);
                if(xmlhttp.readyState==4 && xmlhttp.status==200){
                    
                    //console.log(xmlhttp.responseText);
                    
                    // https://stackoverflow.com/questions/4467044/proper-way-to-catch-exception-from-json-parse
                    
                    try {
                        var objeto=JSON.parse(xmlhttp.responseText);
                        console.log(`retorno: ${xmlhttp.responseText}`);
                    } catch(erro) {
                        console.log(erro); // error in the above string (in this case, yes)!
                        console.log(xmlhttp.responseText);
                        //var trAtual="divLinha"+idDiv;
                        //alert(trAtual);
                        //document.getElementById(trAtual).style.display="none";
                        //divIdx.innerHTML="<img src='../imagens/error.png' width='32' height='32' /> Erro na abertura, clique <a href='BDPrecos.php?inicio_id="+id+"&limite=1' target='_blank'>aqui</a> para ver se alguma loja não está cadastrada.";
                        //setTimeout(function(){makerequest(id,flagConsolidado)}, 8000); // try again in 8 segundos
                    }
                    let cdProdutoParaIncluirNaLista=objeto.cdproduto;
                    let fabricanteProdutoParaIncluirNaLista=objeto.nomefabricante;
                    let nomeProdutoParaIncluirNaLista=objeto.nomeproduto;
                    let conteudo="";
                    conteudo="<div class=\"mb-2\">"+objeto.cdproduto+" - "+objeto.nomeproduto+" ["+objeto.nomefabricante+"]</div>";
                    conteudo=conteudo+"<div class=\"d-flex justify-content-center mb-2\">";
                    conteudo=conteudo+`<img src='../imagens/lista_compras.png' onclick=\"incluirProdutosPedidoMaterial('${cdProdutoParaIncluirNaLista}','${fabricanteProdutoParaIncluirNaLista}','${nomeProdutoParaIncluirNaLista}');\" />`;
                    conteudo=conteudo+"</div>";
                    conteudo=conteudo+"<div class='my-2'><B>Preços de custo nas lojas</B></div>";
                     
                        //alert(objeto.precosugerido);
                        //campoNovoValor.value=objeto.precosugerido.toFixed(2);  // Altera o valor para o que vem sugerido pela rotina BDRotinasAjax.php


                        //conteudo=conteudo+divProduto+separador+divLocalizador+" ["+objeto.marca+" ] [ "+objeto.idproduto+" ]</div>";
                        for(var i=0;i<objeto.precos.length;i++){
                            precoFloat=parseFloat(objeto.precos[i].vlindividual);
                            precoProdutoNaLoja=precoFloat.toFixed(2);
                
                            conteudo=conteudo+"<div>R$ "+precoProdutoNaLoja+" | "+objeto.precos[i].datamovimento+" | <a href=\"https://www.cabos.etc.br/m/clocal.php?idfornecedor="+objeto.precos[i].cdfabricante+"\">"+objeto.precos[i].nomefornecedor+"</a></div>";
                        }		

                        conteudo=conteudo+"<div class='my-2'><B>Preços anunciados no BD</B></div>"

                        // Aqui fica o conteudo do preço dos anuncios do BD

                        for(var i=0;i<objeto.precos_bd.length;i++){
                            precoFloatBD=parseFloat(objeto.precos_bd[i].vlproduto);
                            precoProdutoBD=precoFloatBD.toFixed(2);
                
                            conteudo=conteudo+"<div>"+objeto.precos_bd[i].idanuncio+" | "+"R$ "+precoProdutoBD+" | "+objeto.precos_bd[i].datapesquisa+"</div>";
                        }	

                        conteudo=conteudo+"<div class='my-2'><B>Valores das ultimas vendas nas lojas</B></div>";

                        // Aqui ficam os valores da ultimas vendas nas lojas
                        for(var i=0;i<objeto.precos_ultimas_vendas.length;i++){
                            precoFloatUltimasVendas=parseFloat(objeto.precos_ultimas_vendas[i].vlvenda);
                            precoProdutoUltimasVendas=precoFloatUltimasVendas.toFixed(2);
                
                            conteudo=conteudo+"<div>"+objeto.precos_ultimas_vendas[i].datapesquisa+" | "+"R$ "+precoProdutoUltimasVendas+"</div>";
                        }	

                            idDivPreco.innerHTML=conteudo;
                }
            }


            xmlhttp.send(null);



            //Abre a janela do Modal
            $('#modalCotacaoPrecosLojas').modal('show');
        }

        function mostraModalIncluirComprasEstoque(modo,cdProduto,quantidadeProdutos,fabricanteProduto,nomeProduto){
            let idFornecedor = document.getElementById("loja").value;
            //alert('Estou na linha 486 Modo: '+modo+" idFornecedor: "+idFornecedor);
            if(modo=="incluir_compra_estoque"){
                document.getElementById("incluirComprasEstoque_titulo").innerText="Incluir compras no estoque";
            }
            if(modo=="incluir_cotacao"){
                document.getElementById("incluirComprasEstoque_titulo").innerText="Incluir cotação de preço no sistema";
            }

            /*
            if((idFornecedor==0) && (modo=="incluir_compra_estoque")){
                alerta=document.getElementById("alerta");
                alerta.className="alert alert-success";
                alerta.innerHTML="Selecione uma loja!";
                
                $('#alerta').fadeTo(50, 1)
                window.setTimeout(function() {
                    $('#alerta').fadeTo(500, 0).slideUp(500, function(){
                        //$('#alerta').style.display='none';
                    });
                }, 2000); 
                exit;
            }
            */
            //let quantidadeProdutos = document.getElementById("divQuantidadeProdutos").innerText;
            //let nomeProduto = document.getElementById("divNomeProduto").innerText;
            //let cdProduto = document.getElementById("divCdProduto").innerText;
            document.getElementById("inputQuantidadeProdutos").value=quantidadeProdutos;

            
            let conteudo=`<div><img class="img-fluid" id="incluirCompraEstoque_imagem" src="../imagens/produtos/${cdProduto}.jpg" /></div>`;
            conteudo=conteudo+`<div id="" class="row">`;
            conteudo=conteudo+`<div class="col-2">${cdProduto}</div>`;
            conteudo=conteudo+`<div class="col-2">${fabricanteProduto}</div>`;
            conteudo=conteudo+`<div class="col-8">${nomeProduto}</div>`;
            conteudo=conteudo+`</div>`;
            //alert(conteudo);
            document.getElementById("incluirComprasEstoque_produto").innerHTML=conteudo;
            document.getElementById("inputCdProduto").innerText=cdProduto;
            //alert(idFornecedor+" | "+quantidadeProdutos);
            $('#modalMostrarProdutosPesquisados').modal('hide');
            $('#modalIncluirComprasEstoque').modal('show');
        }

        function incluirComprasEstoque(){
            let inputValorIndividual=document.getElementById('inputValorIndividual').value;
            inputValorIndividual=parseFloat(inputValorIndividual.replace(",","."));

            let idFornecedor = document.getElementById("incluirCompraEstoque_idLoja").value;
            if(idFornecedor==0){
                alert("Escolha uma loja"+idFornecedor);
                alerta=document.getElementById("alerta");
                alerta.className="alert alert-success";
                alerta.innerHTML="Selecione uma loja!";
                
                $('#alerta').fadeTo(50, 1)
                window.setTimeout(function() {
                    $('#alerta').fadeTo(500, 0).slideUp(500, function(){
                        //$('#alerta').style.display='none';
                    });
                }, 2000); 
                exit;
            }
            
            //alert(inputValorIndividual);
            if(isNaN(inputValorIndividual)){
                alert("Não é um número!")
            }
            else {
                //alert('Vou incluir');
                $('#modalIncluirComprasEstoque').modal('hide');

                let pagina="https://www.cabos.etc.br/m/BDRotinasJson.php";
                let cdloja="1";
                let cdProduto=document.getElementById("inputCdProduto").innerText;
                let dtEntrada=document.getElementById("inputDataEntrada").innerText;
                //let idFornecedor=document.getElementById("loja").value;
                let quantidadeProdutos=document.getElementById("inputQuantidadeProdutos").value;
                //let valorIndividual=document.getElementById("inputValorIndividual").value;
                let valorIndividual=inputValorIndividual;
                let elementoDivParaApagar = document.getElementById( 'div'+cdProduto );
                

                //alert(valorIndividual);
                //let linha="";
                let linha=`{\"cdproduto\":"${cdProduto}",\"dtentrada\":\"${dtEntrada}\",\"idfornecedor\":${idFornecedor},\"quantidadeprodutos\":${quantidadeProdutos},\"valorindividual\":${valorIndividual}}`;
                //alert(linha);
                
                msg=`{\"modo\":\"incluirComprasBrasilNoEstoque\",\"cdloja\": ${cdloja},\"dados\":[${linha}]}`;
    

                /*  
                    Para envio da msg, copiar a rotina makeRequestBDRotinasAjaxPostJson do arquivo popup.js das extensoes Chrome das rotinas do BD (corujinha)
                    colocar na ação do botão "enviar"
                */
                
                console.log("Pagina: "+pagina);




                var async = true; // tive que trocar para assincrono...
                xmlhttp.open("POST", pagina, async);
                // Para enviar Json
                xmlhttp.setRequestHeader("Content-Type", "application/json"); // retorna erro 403 se usar text/html
                //console.log("[323]Status: "+xmlhttp.status);


                xmlhttp.send(msg);

                xmlhttp.onreadystatechange=function(){
                    //console.log("[329]status: "+xmlhttp.status);
                    if(xmlhttp.readyState==4 && xmlhttp.status==200){
                        //var objeto=JSON.parse(xmlhttp.responseText);
                        msgRequestBDRotinasAjax=xmlhttp.responseText;

                        // Esta linha mostra o retorno do arquivo Json gerado pelo contentscript.js
                        //alert(msgRequestBDRotinasAjax);
                        alerta=document.getElementById("alerta");
                        alerta.className="alert alert-success";
                        //alerta.innerHTML="Sucesso!";
                        alerta.innerHTML=msgRequestBDRotinasAjax;
                        alerta.style.display="block";
                        window.setTimeout(function() {
                            $('#alerta').fadeTo(500, 0).slideUp(500, function(){
                                $('#alerta').style.display='none';
                            });
                        }, 2000); 
                    }
                    // Apaga a div com conteudo do produto que acabou de ser incluido
                    elementoDivParaApagar.parentNode.removeChild(elementoDivParaApagar);
                }
            }
        }

        function mostraModalIncluirCotacaoLoja(cdProduto, nomeProduto){
            document.getElementById("incluirCotacaoLoja_cdProduto").innerText=cdProduto;
            document.getElementById("incluirCotacaoLoja_nomeProduto").innerHTML=nomeProduto;
            $('#modalMostrarProdutosPesquisados').modal('hide');
            $('#modalIncluirCotacaoLoja').modal('show');
        }

        function incluirCotacaoLoja(){

            let modo=document.getElementById("pesquisarProdutos_modo").value;
          
            //alert('Passei aqui');

            
            let inputValorIndividual=document.getElementById('incluirCotacaoLoja_valorIndividual').value;
            inputValorIndividual=parseFloat(inputValorIndividual.replace(",","."));
            
            //alert(inputValorIndividual);
            if(isNaN(inputValorIndividual)){
                alert("Não é um número!")
            }
            else {
                //alert('Vou incluir');
                $('#modalIncluirCotacaoLoja').modal('hide');

                let pagina="https://www.cabos.etc.br/m/BDRotinasJson.php";
                let cdloja="1";
                let cdProduto=document.getElementById("incluirCotacaoLoja_cdProduto").innerText;
                let dtEntrada=document.getElementById("incluirCotacaoLoja_dataEntrada").innerText;
                let idFornecedor=document.getElementById("incluirCotacaoLoja_idLoja").value;
                let quantidadeProdutos=document.getElementById("incluirCotacaoLoja_quantidadeProdutos").value;
                //let valorIndividual=document.getElementById("inputValorIndividual").value;
                let valorIndividual=inputValorIndividual;
                //let elementoDivParaApagar = document.getElementById( 'div'+cdProduto );
                
               
                //alert(valorIndividual);
                //let linha="";
                let linha=`{\"cdproduto\":"${cdProduto}",\"dtentrada\":\"${dtEntrada}\",\"idfornecedor\":${idFornecedor},\"quantidadeprodutos\":${quantidadeProdutos},\"valorindividual\":${valorIndividual}}`;
                //alert(linha);
                
                if(modo=="incluir_produto_lista_compras"){
                    msg=`{\"modo\":\"incluirComprasBrasilNoEstoque\",\"cdloja\": ${cdloja},\"dados\":[${linha}]}`;
                }
                if(modo=="incluir_cotacao"){
                    msg=`{\"modo\":\"incluirCotacaoPrecoNaLoja\",\"cdloja\": ${cdloja},\"dados\":[${linha}]}`;
                }

                //alert(msg);


                //msg=`{\"modo\":\"incluirComprasBrasilNoEstoque\",\"cdloja\": ${cdloja},\"dados\":[${linha}]}`;
    

                /*  
                    Para envio da msg, copiar a rotina makeRequestBDRotinasAjaxPostJson do arquivo popup.js das extensoes Chrome das rotinas do BD (corujinha)
                    colocar na ação do botão "enviar"
                */
                
                console.log("Pagina: "+pagina);




                var async = true; // tive que trocar para assincrono...
                xmlhttp.open("POST", pagina, async);
                // Para enviar Json
                xmlhttp.setRequestHeader("Content-Type", "application/json"); // retorna erro 403 se usar text/html
                //console.log("[323]Status: "+xmlhttp.status);

                // Isto manda a mensagem efetivamente
                xmlhttp.send(msg);
                //alert(msg);

                xmlhttp.onreadystatechange=function(){
                    //console.log("[329]status: "+xmlhttp.status);
                    if(xmlhttp.readyState==4 && xmlhttp.status==200){
                        //var objeto=JSON.parse(xmlhttp.responseText);
                        msgRequestBDRotinasAjax=xmlhttp.responseText;

                        // Esta linha mostra o retorno do arquivo Json gerado pelo contentscript.js
                        //alert(msgRequestBDRotinasAjax);
                        alerta=document.getElementById("alerta");
                        alerta.className="alert alert-success";
                        alerta.innerHTML="";
                        alerta.innerHTML=msgRequestBDRotinasAjax;
                        alerta.style.display="block";
                        window.setTimeout(function() {
                            $('#alerta').fadeTo(500, 0).slideUp(500, function(){
                                $('#alerta').style.display='none';
                            });
                        }, 2000); 
                    }
                    // Apaga a div com conteudo do produto que acabou de ser incluido
                    //elementoDivParaApagar.parentNode.removeChild(elementoDivParaApagar);
                }
            }

        }

        function mudaLoja(){
            let idFornecedor = document.getElementById("loja").value;
            //alert(idFornecedor);
            //Aqui vai rolar a chamada da pagina com parametro do numero do fornecedor
            let url="https://www.cabos.etc.br/m/clocal.php?idfornecedor="+idFornecedor;
            window.open(url, "_self");
        }

        function mostraPesquisaProdutos(modo){
            //alert(modo);
            document.getElementById("pesquisarProdutos_modo").value=modo;
            $('#modalPesquisarProdutos').modal('show');
        }

        function pesquisaProdutos(){
                //document.getElementById('formPesquisarProduto').submit();modalMostrarProdutosPesquisados
            let modo=document.getElementById("pesquisarProdutos_modo").value;
            //alert(modo);
            let chavePesquisa=document.getElementById("busca").value;
            let pagina="https://www.cabos.etc.br/m/BDRotinasAjax.php?modo=buscaProdutos&busca="+chavePesquisa;
            //alert(pagina);
            var async = true; // tive que trocar para assincrono...
            xmlhttp.open("GET", pagina, async);
            // Para enviar Json
            xmlhttp.setRequestHeader("Content-Type", "text/html"); // retorna erro 403 se usar text/html
            //console.log("[323]Status: "+xmlhttp.status);


            //xmlhttp.send(msg); // Só usado em "Post"
            xmlhttp.onreadystatechange=function(){
                xmlhttp.onreadystatechange=function(){
                    //console.log("[329]status: "+xmlhttp.status);
                    if(xmlhttp.readyState==4 && xmlhttp.status==200){
                        //var objeto=JSON.parse(xmlhttp.responseText);
                        msgRequestBDRotinasAjax=xmlhttp.responseText;
                        //alert(msgRequestBDRotinasAjax);

                        var objeto=JSON.parse(xmlhttp.responseText);
                        let conteudo="";
                        for(var i=0;i<objeto.dados.length;i++){
                            //precoFloat=parseFloat(objeto.precos[i].vlindividual);
                            //precoProdutoNaLoja=precoFloat.toFixed(2);

                            let cdProduto=objeto.dados[i].cdproduto;
                            let fabricanteProduto=objeto.dados[i].fabricanteproduto;
                            let nomeProduto=objeto.dados[i].nomeproduto;

                            if(modo=="incluir_produto_lista_compras"){
                                nomeFuncao=`incluirProdutosPedidoMaterial('${cdProduto}','${fabricanteProduto}','${nomeProduto}');`;
                            }
                            if(modo=="incluir_cotacao"){
                                nomeFuncao=`mostraModalIncluirComprasEstoque('incluir_cotacao','${cdProduto}','0','${fabricanteProduto}','${nomeProduto}');`;
                            }

                            conteudo=conteudo+`<div class=\"row\" id=\"pesquisaProduto_destino${cdProduto}\" onclick=\"${nomeFuncao}\">`;
                            //conteudo=conteudo+`<div class=\"col-2 d-flex flex-row-reverse\">`;
                            //conteudo=conteudo+`<img src=\"https://www.cabos.etc.br/imagens/addverde.png\"  onclick=\"incluirProdutosPedidoMaterial('${cdProduto}','${fabricanteProduto}','${nomeProduto}');\">`;
                            //conteudo=conteudo+`<img src=\"https://www.cabos.etc.br/imagens/cifrao.png\" onclick=\"mostraModalIncluirCotacaoLoja('${cdProduto}','${nomeProduto}');\"></div>`;
                            conteudo=conteudo+"<div class=\"col-2\">"+cdProduto+"</div>";
                            conteudo=conteudo+"<div class=\"col-2\">"+fabricanteProduto+"</div>";
                            conteudo=conteudo+"<div class=\"col-8\">"+nomeProduto+"</div>";
                            conteudo=conteudo+"</div>";
                        }	
                        document.getElementById("divMostraBuscaProdutos").innerHTML=conteudo;

                    }
                }
            }

            xmlhttp.send(null);

            $('#modalPesquisarProdutos').modal('hide');
            $('#modalMostrarProdutosPesquisados').modal('show');
        }

        function incluirProdutosPedidoMaterial(cdProduto,fabricanteProduto,nomeProduto){
            let divIncluirProdutoPedidoMaterial=document.getElementById('divIncluirProdutoPedidoMaterial')

            let conteudo=`<div><img class="img-fluid" src="../imagens/produtos/${cdProduto}.jpg" /></div>`;
            conteudo=conteudo+`<div id="div$cdProduto" class="row">`;
            conteudo=conteudo+`<div class="col-2">${cdProduto}</div>`;
            conteudo=conteudo+`<div class="col-2">${fabricanteProduto}</div>`;
            conteudo=conteudo+`<div class="col-8">${nomeProduto}</div>`;
            conteudo=conteudo+`</div>`;
            conteudo=conteudo+`<div class='d-flex flex-row justify-content-center'>`;
            conteudo=conteudo+`<div class='p-2'><img src='../imagens/add2.png' height='32' width='32' onclick='pedidoMaterial(\"${cdProduto}\", 2);' /></div>`;
            conteudo=conteudo+`<div class='p-2'><img src='../imagens/add5.png' height='32' width='32' onclick='pedidoMaterial(\"${cdProduto}\", 5); '/></div>`;
            conteudo=conteudo+`<div class='p-2'><img src='../imagens/borracha.png' height='32' width='32' onclick='pedidoMaterial(\"${cdProduto}\", 0);' /></div>`;
            conteudo=conteudo+`<div  class='p-2' id='divQuantidadeMaterial' align='right'>0</div>`;
            conteudo=conteudo+`<div class='p-2'><img id="imgFlagPrioridade" src='../imagens/alertpb.png' height='32' width='32' onclick='mudaStatusPrioridade(${cdProduto});' /></div>`;
            conteudo=conteudo+`</div>`;
            divIncluirProdutoPedidoMaterial.innerHTML=conteudo;

            // Atualiza a quantidade de material que já está no pedido e tambem o status de prioridade da compra
            
            let pagina="BDRotinasAjax.php?modo=consultaQuantidadeStatusProdutoPedidoMaterial&cdproduto="+cdProduto;
            var async = true;
			xmlhttp.open("GET", pagina, async); // funcionando com um true
			xmlhttp.onreadystatechange=function(){
					if(xmlhttp.readyState==4 && xmlhttp.status==200){
						//alert(xmlhttp.responseText);
                        var objeto=JSON.parse(xmlhttp.responseText);
                        let quantidadeProduto=objeto.quantidade;
                        let flagPrioridade=objeto.flagprioridade;
                        if (flagPrioridade==0){
                            document.getElementById("imgFlagPrioridade").src="../imagens/alertpb.png";
                            let funcaoPrioridade=`mudaStatusPrioridade('${cdProduto}', 1);`;
                            //alert(funcaoPrioridade);
                            document.getElementById("imgFlagPrioridade").setAttribute('onclick',`${funcaoPrioridade}`);
                        }
                        else{
                            document.getElementById("imgFlagPrioridade").src="../imagens/alert.png";
                            let funcaoPrioridade=`mudaStatusPrioridade('${cdProduto}', 0);`;
                            //alert(funcaoPrioridade);
                            document.getElementById("imgFlagPrioridade").setAttribute('onclick',`${funcaoPrioridade}`);
                        }
						document.getElementById("divQuantidadeMaterial").innerHTML=quantidadeProduto;
					}
			}
			xmlhttp.send(null);


            $('#modalMostrarProdutosPesquisados').modal('hide');
            $('#modalIncluirProdutoPedidoMaterial').modal('show');
        }

        function pedidoMaterial(cdproduto, quantidade){
			let pagina="BDRotinasAjax.php?modo=atualizarPedidoMaterial&cdproduto="+cdproduto+"&quantidade="+quantidade;
            let imgPrioridade=document.getElementById("imgFlagPrioridade").src;
            //alert(`imgPrioridade | ${imgPrioridade}`)
            if(imgPrioridade=="https://www.cabos.etc.br/imagens/alert.png"){
                pagina=pagina+"&flagprioridade=1";
            }
            else{
                pagina=pagina+"&flagprioridade=0"; 
            }
            //alert(pagina);
			let divQuantidadeMaterial=document.getElementById("divQuantidadeMaterial");
		
			var async = true;
			xmlhttp.open("GET", pagina, async); // funcionando com um true
			xmlhttp.onreadystatechange=function(){
					if(xmlhttp.readyState==4 && xmlhttp.status==200){
						console.log(xmlhttp.responseText);
						divQuantidadeMaterial.innerHTML=xmlhttp.responseText;
					}
			}
			xmlhttp.send(null);


		}

        function fecharAtualizarAposInclusaoProdutoPedidoMaterial(){
            // Recarrega a pagina para mostrar a inclusão
            alerta=document.getElementById("alerta");
            alerta.className="alert alert-warning";
            //alerta.innerHTML="Sucesso!";
            alerta.innerHTML="Recarregando a página";
            //alerta.style.display="block";
            $('#alerta').fadeTo(50, 1)
            window.setTimeout(function() {
                $('#alerta').fadeTo(500, 0).slideUp(500, function(){
                    $('#alerta').style.display='none';
                });
                mudaLoja();
            }, 2000); 
            
            $('#modalIncluirProdutoPedidoMaterial').modal('hide');
        }

        function mudaStatusPrioridade(cdProduto){
            let imgPrioridade=document.getElementById("imgFlagPrioridade").src;

            //alert(cdProduto+" | "+status);
            if(imgPrioridade=="https://www.cabos.etc.br/imagens/alert.png"){
                document.getElementById("imgFlagPrioridade").src="../imagens/alertpb.png";
                //let funcaoPrioridade=`mudaStatusPrioridade('${cdProduto}', 1);`;
                //alert(funcaoPrioridade);
                //document.getElementById("imgFlagPrioridade").setAttribute('onclick',`${funcaoPrioridade}`);
            }
            else{
                document.getElementById("imgFlagPrioridade").src="../imagens/alert.png";
                //let funcaoPrioridade=`mudaStatusPrioridade('${cdProduto}', 0);`;
                //alert(funcaoPrioridade);
                //document.getElementById("imgFlagPrioridade").setAttribute('onclick',`${funcaoPrioridade}`);
            }
        }

    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- É preciso incluir o jquery.mask abaixo -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js"></script>

    <!-- Estas são as chamadas da pagina do Bootstrap
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="/docs/4.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/docsearch.js@2/dist/cdn/docsearch.min.js"></script>
    <script src="/docs/4.3/assets/js/docs.min.js"></script>
    -->
    <?php
        // Esta avaliação deve ser feita no final do carregamento, no inicio a rotina javascript não existia ainda
        if($modo=="incluirprodutonalista"){
            echo "  <script>
                    incluirProdutosPedidoMaterial('$cdProdutoParaIncluirNaLista','$fabricanteProdutoParaIncluirNaLista','$nomeProdutoParaIncluirNaLista');
                    </script>";
        }
    ?>
  </body>
</div>
</body>
</html>