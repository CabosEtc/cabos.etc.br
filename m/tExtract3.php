<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");
    //header('Content-Type: application/json');
    //header('Content-Type: application/javascript');
    header("Content-Type: text/html");

    $id=$_REQUEST["id"];

    function AbreSite($url, $dadosPost="") { // para poder fazer chamada enviando dados como "POST", 
        //$siteUrl = $url;
        //$site_url="https://www.cabos.etc.br";
        //echo $dadosPost;
        $ch = curl_init();
        $timeout = "10L"; // 10 segundos
        curl_setopt ($ch, CURLOPT_URL, $url);

        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        ob_start();
        // curl por linha de comando 
        // curl -I https://www.keycdn.com

        if($dadosPost<>""){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dadosPost); //Passar parametros CUrl por Post
        }
        curl_exec($ch);
        // Informações retornadas 
        // https://www.php.net/manual/pt_BR/function.curl-getinfo.php
        $info = curl_getinfo($ch);
        $codigoRetorno=$info['http_code'];
        curl_close($ch);
        $file_contents = ob_get_contents();
        ob_end_clean();
        //echo "Código de retorno: $codigoRetorno (0-host não encontrado 200-Ok 404-Pagina não encontrada)<br>";
        return $file_contents;
    }

    $pagina="https://www.cabos.etc.br/m/BDRotinasAjax.php?modo=dadosID&idlink=".$id;
    $dadosJsonID = AbreSite($pagina); // busca o Json com os dados a partir do id do anuncio
    //echo $dadosJsonID;
    //var_dump($dadosJSON);
    //$dadosJSON="{\"inicio\": 329, \"linkbd\": \"https://www.boadica.com.br/produtos/p86423\", \"cdproduto\": \"02020\", \"nomeproduto\": \"Placa de som usb 7.1\"}";
    
    $dadosID=json_decode($dadosJsonID);
    $linkBD=$dadosID->linkbd;
    $cdProduto=$dadosID->cdproduto;
    $nomeProduto=$dadosID->nomeproduto;
    $marcaProduto=$dadosID->marcaproduto;
    $localizadorProduto=$dadosID->localizadorproduto;

    //echo "$linkBD<br>";

    //Abre a pagina do BD
    $pagina = Abresite($linkBD); //metodo novo, usar se der chabu acima
    $tamanhoPagina=strlen($pagina);    // a pagina quando nao abre tem tamanho 133 
                                            //(por causa da mensagem "Object moved to here.")
    //echo "$tamanhoPagina";

    //Aqui vai entrar rotina para lidar com tamanho da pagina=133, indica que não que não conseguiu abrir (link não localizado???)

    $inicioPagina=strpos($pagina,"Busca por Fabricante e/ou Modelo");
    $fimPagina=strrpos($pagina,"<div role=\"tabpanel\" class=\"tab-pane\" id=\"caracteristicas\">");
    
    $tamanhoPagina=$fimPagina-$inicioPagina;
    $paginaReduzida=addslashes(substr($pagina,$inicioPagina,$tamanhoPagina)); // põe \antes de ' " \ e null
    //echo "$paginaReduzida<br>";

    // Aqui vão entrar as rotinas "find me" procurando pelas lojas *** Linha 106 do textract2

    // Aqui ficam as pesquisas de ultima alteração de preços *** Linha 180 do textract2

    $dadosPagina = preg_split("/\n/", $paginaReduzida);
  
    // Variáveis utilizadas durante foreach
    $quantidadeLojasPredio=0; 
    $lojasEncontradas=0;
    $precoSugeridoProduto=0;
    // Valores provisorios
    $flagPredio=1;
    $idLoja=0;
    $flagAlteradoHoje=0;
    $posicaoRank=1;

    $dadosLojas="";

    foreach ($dadosPagina as $linhaDados) {
        //echo "$linhaDados<br>";
        // Nó 1 - Nome
        if(strpos($linhaDados,"target=")){ // se a linha contem um nome de loja
        $inicioNome=strpos($linhaDados,"target")+18;
        $fimNome=strrpos($linhaDados,"</a>");
        $tamanhoNome=$fimNome-$inicioNome;
        $nomeLoja=utf8_encode(substr($linhaDados,$inicioNome,$tamanhoNome));
        //echo "$nomeLoja<br>";
        // Aqui pesquisa se a loja é cadastrada *** Linha 262 do textract2
        // Aqui pesquisa a ultima alteração de preços dela *** Linha 290 do textract2
        }

        // Nó 2 - Preço
        if(strpos($linhaDados,"R$") AND !strpos($linhaDados,"<span>R$")){ // se a linha contem um preco
            //echo $field;
            $inicioPreco=strpos($linhaDados,"R$ ");
            $fimPreco=strrpos($linhaDados,"\n");
            //$tamanho_preco=$fim_preco-$inicio_preco;
            $precoNaoFormatado=floatval(str_replace(",",".",substr($linhaDados,$inicioPreco+3,12)));
            //echo $field;
            //$preco=floatval(str_replace(",",".",$field));
            //echo "preço: $preco<br>";
            $preco=number_format((float)$precoNaoFormatado, 2, '.', '');
            //echo "$preco<br>";
            

            // Aqui faz considerações para definir o preço que vai ser sugerido *** Linha 318 do textract2

            // Aqui define as posições de ranking *** Linha 337 do textract2

            // Como aqui já tem o nome da loja e o preço, faz pesquisas para saber se coloca estes dados na tabela links_boadica_detalhes_lojas
            // *** Linha 369 do textract2

            // Guarda as informações na tabela links_boadica_detalhes_snapshot *** Linha 384 do textract2

            if($lojasEncontradas==0){
                $dadosLojas=$dadosLojas."{\"loja\":\"$nomeLoja\",\"flagpredio\":$flagPredio,\"preco\":$preco,\"idloja\":$idLoja,\"flagalteradohoje\":$flagAlteradoHoje,\"rank\":$posicaoRank}";
            }
            else{
                $dadosLojas=$dadosLojas.",{\"loja\":\"$nomeLoja\",\"flagpredio\":$flagPredio,\"preco\":$preco,\"idloja\":$idLoja,\"flagalteradohoje\":$flagAlteradoHoje, \"rank\":$posicaoRank}";
            }
            $lojasEncontradas=$lojasEncontradas+1;
        }

    }
     
    $retorno="{\"servidor\":9,\"statusanuncio\":1,\"statusloja1\":1,\"statusloja2\":1,";
    $retorno=$retorno."\"flagloja1\":0,\"flagloja2\":0,\"produto\":\"$nomeProduto\",\"marca\":\"$marcaProduto\",";
    $retorno=$retorno."\"idproduto\":$id,\"localizador\":\"$localizadorProduto\",\"linkbd\":\"$linkBD\",\"precosugerido\":99.99,";
    $retorno=$retorno."\"bd\":[$dadosLojas]}";
    //Depuração no Insomnia
    //echo $retorno;

    $pagina="https://www.cabos.etc.br/m/BDRotinasExtract3.php"; // Os dados vão seguir por 'Post' em $dadosPost
    $dadosPost=$retorno;//vai levar estes dados para tratamento por BDRotinasExtract3.php
    $dadosTratadosJson = AbreSite($pagina,$dadosPost); //Esta linha vai fazer uma chamada e passar os dados por Post
    echo $dadosTratadosJson;
?>