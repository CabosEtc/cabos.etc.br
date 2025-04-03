<?
    /* Historico de alterações
        05Dez21 - CURRENT_TIMESTAMP foi substituido pela variavel $timestampSaoPaulo por causa da troca do servidor para Hostinger
        16Dez21 - Incluidas as lojas 732 e 743 na lista de lojas parceiras
    */
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");
    //Prepara conexao ao db
    include("../conectadb.php");

    // Rotinas retiradas de BDRotinasCUrl.php

    $msg = file_get_contents('php://input');

    $arrJson=(json_decode($msg, true)); // true retorna array, sem parametro retorna objeto

    //$modo=$arrJson["modo"];
    $servidor=$arrJson["servidor"];
    //echo "Servidor: $servidor<br>";
    $linkBD=$arrJson["linkbd"]; // Aqui chega o link do linkBD
    $idLinkBD=$arrJson["idproduto"]; // Aqui chega o id do linkBD
    $nomeProduto=$arrJson["produto"]; // Aqui chega o nome do produto
    $localizador=$arrJson["localizador"]; // Aqui chega o localizador do produto
    $marcaProduto=$arrJson["marca"]; 
    $arrDados=$arrJson["bd"]; // Aqui chegam os nomes da lojas e os valores

    //echo "Quantidade de dados:".count($arrDados)."<br>"; 
    if (count($arrDados)>0) { //apaga a tabela links_boadica_detalhes_snapshot porque tem novas informações para gravar
        $queryApagaDadosAnteriores="DELETE from links_boadica_detalhes_snapshot 
                                    WHERE id_produto='".$idLinkBD."'";
        $resultadoApagaDadosAnteriores = mysql_query($queryApagaDadosAnteriores,$conexao);
        // Apaga os registros anteriores para este produto (guarda somente os daquele momento)
        $queryApagaDadosPendencias="DELETE from links_boadica_pendencias 
                                    WHERE idproduto='".$idLinkBD."'";
        $resultadoApagaDadosPendencias = mysql_query($queryApagaDadosPendencias,$conexao);
    }   

    $findCabosEtc= in_array("Cabos e etc ...", array_column($arrDados, "loja")); // Verifica se existe
    if ($findCabosEtc){
        //fwrite($fp, "Achei a Cabos e Etc\n"); 
        //$query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_boadica='1' WHERE id ='$linkBD'";
        //echo "Achei a Cabos!<br>";
        $statusloja1=1;
        
    }
    else{
        //$query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_boadica='0' WHERE id ='$linkBD'";
        $statusloja1=0;
    }
    //echo "Status Loja1: $statusloja1<br>";

    $findCabosEtc2= in_array("Cabos 2 Inform&#225;tica", array_column($arrDados, "loja")); // Verifica se existe
    if ($findCabosEtc2){
        //fwrite($fp, "Achei a Cabos e Etc\n"); 
        //$query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_boadica='1' WHERE id ='$linkBD'";
        //echo "Achei a Cabos!<br>";
        $statusloja2=1;
        
    }
    else{
        //$query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_boadica='0' WHERE id ='$linkBD'";
        $statusloja2=0;
    }
    //echo "Status Loja2: $statusloja2<br>";


    // Pesquisa ultima alteração de preços [Cabos]
    
    $queryUltimaAlteracao= "SELECT data from links_boadica_detalhes_lojas 
                            WHERE id_loja='19' AND id_produto='$idLinkBD' 
                            ORDER BY data DESC";
    $resultadoUltimaAlteracao = mysql_query($queryUltimaAlteracao,$conexao);
    IF(mysql_num_rows($resultadoUltimaAlteracao)>0){
        $dataUltimaAlteracao=mysql_result($resultadoUltimaAlteracao,0,0);
        $dataUltimaAlteracao=substr($dataUltimaAlteracao,0,10);
    }
    ELSE {
        $dataUltimaAlteracao="2001-01-01";
    }

    //echo "Datas alterações Cabos: $dataUltimaAlteracao | $dthoje_eua<br>";
        
    IF ($dataUltimaAlteracao==$dthoje_eua){  
        $flagAlteracaoCabos=1; // 1 significa que houve alteracao hoje
    }
    ELSE {
        $flagAlteracaoCabos=0;   // 0 significa que nao houve alteracao hoje
    }
    //echo "Flag alteração Cabos: $flagAlteracaoCabos<br>";

        
    // Pesquisa ultima alteração de preços [ Cabos 2 ]
    $queryUltimaAlteracaoCb2=  "SELECT data from links_boadica_detalhes_lojas 
                                WHERE id_loja='451' AND id_produto=$idLinkBD 
                                ORDER BY data DESC";
    
    //echo "Cabos2> $queryUltimaAlteracaoCb2<br>";
    $resultadoUltimaAlteracaoCb2 = mysql_query($queryUltimaAlteracaoCb2,$conexao);
    
    IF(mysql_num_rows($resultadoUltimaAlteracaoCb2)>0){
        $dataUltimaAlteracaoCb2=mysql_result($resultadoUltimaAlteracaoCb2,0,0);
    }
    ELSE {
        $dataUltimaAlteracaoCb2="2001-01-01";
    }

    $dataUltimaAlteracaoCb2=substr($dataUltimaAlteracaoCb2,0,10);
    
    //echo "Cabos2> $dataUltimaAlteracaoCb2/$dthoje_eua<br>";
    //echo "Datas alterações Cabos2: $dataUltimaAlteracaoCb2 | $dthoje_eua<br>";
    
    IF ($dataUltimaAlteracaoCb2==$dthoje_eua){  
            $flagAlteracaoCabos2=1; // 1 significa que houve alteracao hoje
    }
    ELSE {
            $flagAlteracaoCabos2=0; // 0 significa que nao houve alteracao hoje
    }

    //echo "Flag alteração Cabos2: $flagAlteracaoCabos2<br>";





    // Aqui começa o Loop
    

    $contador=0;
    $precoSugeridoProduto=0;
    $quant_lojas_predio=0; // vai ser usado no ranking

    foreach ($arrDados as $dado) {
        $nomeLoja=$dado["loja"]; 
        
        // pesquisa se loja está cadastrada
        $queryId=" SELECT id_loja, flag_predio 
                    FROM lojas_boadica 
                    WHERE nome LIKE '%$nomeLoja%'";
        $resultadoId = mysql_query($queryId,$conexao);
        //echo "$queryId<br>";
        
        if(mysql_num_rows($resultadoId)>0){ // se a loja é cadastrada
            $idLoja=mysql_result($resultadoId,0,0);
            //echo "******************************************************************<br>idLoja: $idLoja<br>";
            $flagPredio=mysql_result($resultadoId,0,1);
            $flagLojaCadastrada=1;
                    
            //echo $flagPredio;
            //echo "field: $field<br>";
            //echo "loja: $nomeLoja<br>";
            /*
            if($lojasEncontradas==0){
            $dadosLojas=$dadosLojas."{\"loja\":\"$nomeLoja\",";
            }
            else{
            $dadosLojas=$dadosLojas.",{\"loja\":\"$nomeLoja\",";
            }
            */        
            // Pesquisa ultima alteração de preços da loja atual
            $queryUltimaAlteracao=" SELECT data 
                                    FROM links_boadica_detalhes_lojas 
                                    WHERE id_loja=$idLoja AND id_produto=$idLinkBD  
                                    ORDER BY data DESC";
            //echo "$queryUltimaAlteracao<br>";
            $resultadoUltimaAlteracao = mysql_query($queryUltimaAlteracao,$conexao);
            
            if(mysql_num_rows($resultadoUltimaAlteracao)>0){
                $dataUltimaAlteracao=mysql_result($resultadoUltimaAlteracao,0,0);
            }
            else {
                
                $dataUltimaAlteracao="2001-01-01";
            }
        
            $dataUltimaAlteracao=substr($dataUltimaAlteracao,0,10);
            //echo "Data ultima alteracao: $dataUltimaAlteracao<br>";
        } 
        else {
                //$dadosLojas=$dadosLojas.",{\"loja\":\"não cadastrada - $nomeLoja\",";
                $idLoja=0;
                $flagLojaCadastrada=0;
                $queryInserirLog="INSERT INTO log(`idlog`, `data`,  `codigo`, `loja`, `inf1`, `inf2`) 
                                    VALUES ('null', '$timestampSaoPaulo', '300', '1', '$idLinkBD', '$nomeLoja')";
                //$resultado_inserir_log = mysql_query($query_inserir_log,$conexao);	
        } 
        //$nomeLoja=utf8_decode($nomeLoja); 
        //$nomeLoja=htmlspecialchars(htmlentities($nomeLoja));
        //$nomeLoja=utf8_decode($nomeLoja); 
        //$nomeLoja=htmlspecialchars($nomeLoja,ENT_QUOTES,"utf8");
        //$nomeLoja=mb_convert_encode($nomeLoja,'UTF-8','HTML-ENTITIES');

        $preco=$dado["preco"];
        //$precoSugeridoProduto=0;
              //if($lojasEncontradas==0){ // menor preço * Busca pelo primeiro preço encontrado e avalia qual valor usar para o preço sugerido
        if($precoSugeridoProduto==0){ // mudei o criterio, agora avalia se o preço sugerido ainda não foi atribuido
            //$precoProdutoMaisUmCentavo=number_format($preco+0.01, 2, '.', '');
            $precoProdutoMenosUmCentavo=number_format($preco-0.01, 2, '.', '');
            if(($idLoja== "2") or ($idLoja== "239") or ($idLoja=="581") or ($idLoja=="19") or ($idLoja=="451") or ($idLoja=="732") or ($idLoja=="743")){ // lojas parceiras
                $precoSugeridoProduto=$preco;
            }
            else{
                if($flagPredio<>"0"){
                    $precoSugeridoProduto=$precoProdutoMenosUmCentavo;
                }
            }
        }

        //Aqui entra a rotina de ranking

        IF ($flagLojaCadastrada==1 AND ($dataUltimaAlteracao<>$dthoje_eua)){
            //echo "vou cadastradar a loja".$nome_loja."codigo ".$id_loja." com o valor ".$preco;
            // Insere no banco de dados, somente se a loja for cadastrada e o preço for diferente da pesquisa anterior	
            $queryPesquisaPrecoAntigo= "SELECT preco, data 
                                        FROM links_boadica_detalhes_lojas 
                                        WHERE id_loja='$idLoja' AND id_produto='$idLinkBD' 
                                        ORDER BY data DESC";
            //echo "queryPreçoAntigo: $queryPesquisaPrecoAntigo<br>";
            $resultadoPesquisaPrecoAntigo = mysql_query($queryPesquisaPrecoAntigo,$conexao);
            $quantidadeItens=mysql_num_rows($resultadoPesquisaPrecoAntigo);
            //echo "quantidade de itens: $quantidadeItens<br>";
            if($quantidadeItens>0){
              $precoAnterior=mysql_result($resultadoPesquisaPrecoAntigo,0,0);
              //echo "Preco Anterior da loja $idLoja: $precoAnterior<br>";
              //$data_preco_anterior=mysql_result($resultadoPesquisaPrecoAntigo,0,1);
              
              //IF ($precoAnterior<>$preco){
              //	echo "  Preco anterior: ".$precoAnterior. " [".$data_preco_anterior."]<br>";
              //}
              //	else {echo "<br>";}
            }
          
            IF (($quantidadeItens==0) OR ($precoAnterior<>$preco)){		
              //echo "preço anterior: $precoAnterior<br>";
              //echo "flag_loja_cadastrada: $flagLojaCadastrada<br>";			
              $queryPrecos=   "INSERT INTO links_boadica_detalhes_lojas (`id`, `id_loja`, `data`, `id_produto`, `preco`, `origem`) 
                                VALUES (NULL, $idLoja, '$timestampSaoPaulo', $idLinkBD, $preco, 'tExtrac3');";
              //echo "$query_precos<br>";
              $resultadoPrecos = mysql_query($queryPrecos,$conexao) OR DIE(mysql_error());
              //echo "Inserido -> Loja: $idLoja Produto: $idLinkBD Preco: R$ $preco<br>";
              //mysql_query($query_insert) OR DIE(mysql_error());
            }
        }

        $queryPrecosSnapshot=  "INSERT INTO links_boadica_detalhes_snapshot (`id`, `id_loja`, `data`, `id_produto`, `preco`, `origem`) 
                                VALUES (NULL, $idLoja, '$timestampSaoPaulo', $idLinkBD, $preco, 'tExtract3');";
        //echo "Query Snapshot [linha 195]: $queryPrecosSnapshot<br>";
        $resultadoPrecosSnapshot = mysql_query($queryPrecosSnapshot,$conexao);

        if($dataUltimaAlteracao==$dthoje_eua){
            $flagAlteradoHoje=1;
        }
        else{
        $flagAlteradoHoje=0;
        }



        //echo "$nomeLoja | $preco<br>";
        if($contador==0){
            $dadosLojas="{\"loja\":\"$nomeLoja\",\"flagpredio\":$flagPredio,\"preco\":$preco,\"idloja\":$idLoja,\"flagalteradohoje\":$flagAlteradoHoje, \"rank\":1}";
        }
        else{
            $dadosLojas=$dadosLojas.",{\"loja\":\"$nomeLoja\",\"flagpredio\":$flagPredio,\"preco\":$preco,\"idloja\":$idLoja,\"flagalteradohoje\":$flagAlteradoHoje, \"rank\":1}";
        }
        //echo "$contador<br>";
        $contador++;
    }
    //echo "$dadosLojas<br>";

    $retorno="{\"servidor\":$servidor,\"statusanuncio\":1,\"statusloja1\":$statusloja1,\"statusloja2\":$statusloja2,\"flagloja1\":0,";
    $retorno=$retorno."\"flagloja2\":0,\"produto\":\"$nomeProduto\",\"marca\":\"$marcaProduto\",\"idproduto\":$idLinkBD,";
    $retorno=$retorno."\"localizador\":\"$localizador\",\"linkbd\":\"$linkBD\",";
    $retorno=$retorno."\"precosugerido\":$precoSugeridoProduto,\"bd\":[$dadosLojas]}";
    echo $retorno;
    /* Exemplo de como esta rotina tem que devolver o resultado
    {"servidor":4,
    "statusanuncio":1,
    "statusloja1":1, 
    "statusloja2":0,
    "flagloja1":0,
    "flagloja2":0,
    "produto":"Cabo Y VGA 1 Macho x 2 VGA Femea 30 cm",
    "marca":"N/D",
    "idproduto":625,
    "localizador":"2 VGA Femea 30 cm, Cabo niquelado, preto, 30 cm.",
    "linkbd":"https://www.boadica.com.br/produtos/p100076",
    "precosugerido":16.93,
    "bd":[{"loja":"Happygames","flagpredio":1,"preco":16.94,"idloja":85,"flagalteradohoje":0, "rank":1},{"loja":"Super Game","flagpredio":1,"preco":16.95,"idloja":2,"flagalteradohoje":0, "rank":2},{"loja":"Cabos e etc ...","flagpredio":2,"preco":16.95,"idloja":19,"flagalteradohoje":0, "rank":2},{"loja":"Supernova","flagpredio":1,"preco":16.97,"idloja":239,"flagalteradohoje":0, "rank":3},{"loja":"MGT - Magnos Tecnologia","flagpredio":1,"preco":16.99,"idloja":410,"flagalteradohoje":0, "rank":4},{"loja":"Alamo Cartuchos","flagpredio":0,"preco":25.00,"idloja":579,"flagalteradohoje":0, "rank":0}]}
    */

    /*
    $retorno="{\"servidor\":9,\"statusanuncio\":1,\"statusloja1\":1,\"statusloja2\":1,";
    $retorno=$retorno."\"flagloja1\":0,\"flagloja2\":0,\"produto\":\"$nomeProduto\",\"marca\":\"$marcaProduto\",";
    $retorno=$retorno."\"idproduto\":999,\"localizador\":\"$localizadorProduto\",\"linkbd\":\"$linkBD\",\"precosugerido\":99.99,";
    $retorno=$retorno."\"bd\":[$dadosLojas]}";
    echo $retorno;
    */
?>
