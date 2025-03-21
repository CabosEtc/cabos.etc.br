<?
// Este arquivo é usado pela rotina cUrl.php (localhost), corrigir erro linkbd sendo usado no lugar de idproduto!!!!!!!!!!!
// Log de alterações
// 20Ago22
// Foi adicionado o modo=scraperPaginaBD (lê o conteudo cada vez que uma página do diretorio produtos do BD é lida)
// Foi usado nos testes de programação o endereço: https://www.boadica.com.br/produtos/p152652

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
//Prepara conexao ao db
include("../conectadb.php");

$msg = file_get_contents('php://input');

// Rotinas de arquivo. A variável $fp armazena a conexão com o arquivo e o tipo de ação.
$arquivo="BDRotinasCurl.txt";
$fp=fopen($arquivo, "w+"); //w+ apaga o conteudo anterior, para somar usar a+

/*
//Escreve no arquivo aberto.
fwrite($fp, $msg);

//Fecha o arquivo.
fclose($fp);
*/

$arrJson=(json_decode($msg, true)); // true retorna array, sem parametro retorna objeto

$modo=$arrJson["modo"];
$linkBD=$arrJson["linkBD"]; // Aqui chega o id do linkBD
$arrDados=$arrJson["bd"]; // Aqui chegam os nomes da lojas e os valores

fwrite($fp, "Resultados do link: $linkBD\n\n");

if ($modo=="processarDadosPaginaBD"){ // Usada por cUrl.php

    

    $total=count($arrDados);
    //$keyCabosEtc= array_search("Cabos and etc ...", array_column($arrDados, "nomeLoja")); Funciona, retorna a chave

    // Procura pela Cabos
    $findCabosEtc= in_array("Cabos e etc ...", array_column($arrDados, "nomeLoja")); // Verifica se existe
    if ($findCabosEtc){
        fwrite($fp, "Achei a Cabos e Etc\n"); 
        $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_boadica='1' WHERE id ='$linkBD'";
        
    }
    else{
        $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_boadica='0' WHERE id ='$linkBD'";
    }
    $resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);

    // Procura a Cabos 2
    $findCabosEtc2= in_array("Cabos 2 Inform&#225;tica", array_column($arrDados, "nomeLoja")); // Verifica se existe
    if ($findCabosEtc2){
        fwrite($fp, "Achei a Cabos2\n"); 
        $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdcabos2='1' WHERE id ='$linkBD'";
    }
    else{
        $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdcabos2='0' WHERE id ='$linkBD'";
    }
    $resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);

    // Procura pela SuperGame
    $findSuperGame= in_array("Super Game", array_column($arrDados, "nomeLoja")); // Verifica se existe
    if ($findSuperGame){
        fwrite($fp, "Achei a Super Game\n"); 
        $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdsg='1' WHERE id ='$linkBD'";
    }
    else{
        $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdsg='0' WHERE id ='$linkBD'";
    }
    $resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);

    // Procura pela Supernova
    $findSupenova= in_array("Supenova", array_column($arrDados, "nomeLoja")); // Verifica se existe
    if ($findSupenova){
        fwrite($fp, "Achei a Supenova\n"); 
        $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdsg2='1' WHERE id ='$linkBD'";
    }
    else{
        $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdsg2='0' WHERE id ='$linkBD'";
    }
    $resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);

    fwrite($fp, "\n");

    //echo "$key\n";

    // Apaga os dados anteriores das tabelas links_boadica_detalhes_snapshot e links_boadica_pendencias
    $query_apaga_dados_anteriores="DELETE from links_boadica_detalhes_snapshot WHERE id_produto='".$linkBD."'";
    $resultado_apaga_dados_anteriores = mysql_query($query_apaga_dados_anteriores,$conexao);

    $query_apaga_dados_pendencias="DELETE from links_boadica_pendencias WHERE idproduto='".$linkBD."'";
    $resultado_apaga_dados_pendencias = mysql_query($query_apaga_dados_pendencias,$conexao);


    // Pesquisa ultima alteração de preços [Cabos]
    $queryUltimaAlteracao="   SELECT data from links_boadica_detalhes_lojas 
                                WHERE id_loja='19' AND id_produto='$linkBD' 
                                ORDER BY data DESC";
    $resultadoUltimaAlteracao = mysql_query($queryUltimaAlteracao,$conexao);
    IF(mysql_num_rows($resultadoUltimaAlteracao)>0){
        $dataUltimaAlteracao=mysql_result($resultadoUltimaAlteracao,0,0);
    }
    ELSE {
        $dataUltimaAlteracao="2001-01-01";
    }
    $dataUltimaAlteracaoCabos=substr($dataUltimaAlteracao,0,10);
    fwrite($fp, "Data da Ultima alteração da Cabos: $dataUltimaAlteracaoCabos\n"); 

    // Pesquisa ultima alteração de preços [Cabos2]
    $queryUltimaAlteracao="     SELECT data from links_boadica_detalhes_lojas 
                                WHERE id_loja='451' AND id_produto='$linkBD' 
                                ORDER BY data DESC";
    $resultadoUltimaAlteracao = mysql_query($queryUltimaAlteracao,$conexao);
    IF(mysql_num_rows($resultadoUltimaAlteracao)>0){
        $dataUltimaAlteracao=mysql_result($resultadoUltimaAlteracao,0,0);
    }
    ELSE {
        $dataUltimaAlteracao="2001-01-01";
    }
    $dataUltimaAlteracaoCabos2=substr($dataUltimaAlteracao,0,10);
    fwrite($fp, "Data da Ultima alteração da Cabos2: $dataUltimaAlteracaoCabos2\n\n"); 


    foreach ($arrDados as $dado) {
        $nomeLoja=$dado["nomeLoja"]; 
        //$nomeLoja=utf8_decode($nomeLoja); 
        //$nomeLoja=htmlspecialchars(htmlentities($nomeLoja));
        //$nomeLoja=utf8_decode($nomeLoja); 
        //$nomeLoja=htmlspecialchars($nomeLoja,ENT_QUOTES,"utf8");
        //$nomeLoja=mb_convert_encode($nomeLoja,'UTF-8','HTML-ENTITIES');
        $preco=$dado["preco"];

        // Procura se a loja é cadastrada
        $queryIdLoja="  SELECT id_loja, flag_predio 
                        FROM lojas_boadica 
                        WHERE nome LIKE '%".$nomeLoja."%'";
		$resultadoIdLoja = mysql_query($queryIdLoja,$conexao);
			
		if(mysql_num_rows($resultadoIdLoja)>0){ // se a loja é cadastrada
		    $idLoja=mysql_result($resultadoIdLoja,0,0);
			//$flagPredio=mysql_result($resultadoIdLoja,0,1);
			$flagLojaCadastrada=1;
        }
        else{
            $idLoja="";
            $flagLojaCadastrada=0;
        }
        //fwrite($fp, "Query: $queryIdLoja\n");
        fwrite($fp, "\nFlag da loja cadastrada: $flagLojaCadastrada\n");
        fwrite($fp, "ID da loja cadastrada: $idLoja\n");
        fwrite($fp, "$nomeLoja\n$preco\n\n"); // Usado para verificar se os dados estão chegando
        //fwrite($fp, "$dthoje_eua\n");

        $queryPesquisaPrecoAntigo=" SELECT preco, data 
                                    FROM links_boadica_detalhes_lojas 
                                    WHERE id_loja='$idLoja' AND id_produto='$linkBD' 
                                    ORDER BY data DESC";
        //fwrite($fp,"$queryPesquisaPrecoAntigo\n");
        //echo $query_pesquisa_preco_antigo;
        $resultadoPrecoAntigo = mysql_query($queryPesquisaPrecoAntigo,$conexao);
        $quantidadeItens=mysql_num_rows($resultadoPrecoAntigo);
        if($quantidadeItens>0){
            $precoAnterior=mysql_result($resultadoPrecoAntigo,0,0);
            $dataPrecoAnterior=mysql_result($resultadoPrecoAntigo,0,1);
        }
        else{
            $precoAnterior=0;
            $dataPrecoAnterior="2001-01-01";
        }
        fwrite($fp, "Preco anterior: $precoAnterior | Preço atual: $preco | Data preço anterior| $dataPrecoAnterior\n");

       if( $flagLojaCadastrada==1 AND (($quantidadeItens==0) OR ($precoAnterior<>$preco))){	
            // Se não houver preço anterior ou se o preço anterior for difente do atual	
            //echo "preço anterior=".$preco_anterior;
            //echo "flag_loja_cadastrada".$flag_loja_cadastrada;			
            $queryPrecos=" INSERT INTO links_boadica_detalhes_lojas (`id`, `id_loja`, `data`, `id_produto`, `preco`, `origem`) 
                            VALUES (NULL, $idLoja, '$timestampSaoPaulo', $linkBD, $preco, 'BDRotinasCurl');";
            //echo "$query_precos<br>";
            fwrite($fp,"Inserido links_boadica_detalhes_lojas-> Loja: $idLoja Produto: $linkBD Preco: R$ $preco\n");
            //Depuração pelo Insomnia
            //echo "Inserido links_boadica_detalhes_lojas-> Loja: $idLoja Produto: $linkBD Preco: R$ $preco<br>";
            $resultadoPrecos = mysql_query($queryPrecos,$conexao) OR DIE(mysql_error());
            //mysql_query($query_insert) OR DIE(mysql_error());
        }
		
        $queryPrecosSnapshot="  INSERT INTO links_boadica_detalhes_snapshot (`id`, `id_loja`, `data`, `id_produto`, `preco`, `origem`) 
                                VALUES (NULL, $idLoja, '$timestampSaoPaulo', $linkBD, $preco, 'BDRotinasCurl');";
		//echo $query_precos_snapshot;
        $resultadoPrecosSnapshot = mysql_query($queryPrecosSnapshot,$conexao);
        //Depuração pelo Insomnia
        //echo "$idLoja | CURRENT_TIMESTAMP | $linkBD | $preco, 'BDRotinasCurl'<br>";
        //echo "$queryPrecosSnapshot<br>";


    }
}



// ****************************************************************************************************************

if ($modo=="ajustarProdutosAtualizadosNestaData"){

        $currentTimeStamp=$dthoje_eua." ".$hora;
        // * $dthoje_eua=(Y-m-d")  // * $hora=('H:i:s')


    $strJson=$msg;

    /* Para depuracao somente*/

    /*
    $arquivo="BDRotinasJson.txt";
    $fp=fopen($arquivo, "w+"); //w+ apaga o conteudo anterior, para somar usar a+
    fwrite($fp, $msg);
    fclose($fp);
    */
    


    $arrJson=(json_decode($strJson, true)); // true retorna array, sem parametro retorna objeto
    $arrDados=$arrJson["dados"]; // retorna array contendo todos os subitens do elemento pessoas

    $total=count($arrDados);
    //echo "Total de itens sincronizados: $total"; // Esta linha vai informar em um alert quantos itens foram enviados
    echo '<span class="badge badge-success">'.$total.'</span> Itens sincronizados.<br>';

    //var_dump($arrDados);
    //echo $arrDados[1]["id"]."  ".$arrPessoas[1]["valor"]; // esta é a estrutura correta!

    $contador=0;

    // Colocar uma Query para apagar os dados da loja x
    $query="DELETE from bd_mysnapshot WHERE idloja=$cdLoja";
    //echo "$query<br>";
    $resultado=mysql_query($query, $conexao);
    foreach ($arrDados as $dado) {
        $contador++;
        
        //$texto="********************************************************$contador\n"; //Para não gerar repetições abaixo

        // abaixo: i=id v=valor h=habilitado a=Publicado (se o anuncio está no ar)
        $idAnuncioBD=$dado["i"];
        $valorProduto=$dado["v"];
        $flagAlterado=$dado["h"]; // se já foi alterado hoje 0=nao 1=sim //Aqui é de onde se tira a condição de atualizar abaixo ou não
        $flagPublicado=$dado["a"]; // se o anuncio está Publicado (no Ar)
        $marcaProduto=$dado["m"]; // nome do Produto
        $nomeProduto=$dado["n"]; // nome do Produto

        // A tabela abaixo cria um Snapshot da tabela bd_mysnapshot (não confundir com a tabela links_boadica_detalhes_snapshot)
        $query="INSERT INTO `bd_mysnapshot` (`id`, `idloja`, `idanunciobd`, `valor`, `alterado`, `publicado`, `data`, `marca`, `nome`) 
        VALUES (NULL, '$cdLoja', '$idAnuncioBD', '$valorProduto', '$flagAlterado', '$flagPublicado', CURRENT_TIMESTAMP,'$marcaProduto','$nomeProduto')";
        //echo "$query<br>";
        $resultado=mysql_query($query, $conexao);

        if($flagAlterado==1){ // Se foi alterado hoje
            $queryAjustar="SELECT bd_id_anuncios.idlinkbd, bd_id_anuncios.idloja, links_boadica.cdproduto 
            FROM bd_id_anuncios, links_boadica 
            WHERE bd_id_anuncios.idlinkbd=links_boadica.id AND bd_id_anuncios.idanunciobd='$idAnuncioBD'";
            $resultadoAjustar=mysql_query($queryAjustar, $conexao);
            //echo "$queryAjustar<br>";
            
            if (mysql_num_rows($resultadoAjustar)>0){ // se está cadastrado na tabela bd_id_anuncios
                
                $idLinkBD=mysql_result($resultadoAjustar,0,0); // Nosso numero para o anuncio idAnuncioBD
                $idLoja=mysql_result($resultadoAjustar,0,1);
                $cdProduto=mysql_result($resultadoAjustar,0,2);

                //echo "Nosso id:$idLinkBD idLoja: $idLoja cdProduto: $cdProduto valorProduto: $valorProduto CurrentTimeStamp: $currentTimeStamp<br>";


                // Pesquisa ultima alteração de preços
                $query_ultima_alteracao="SELECT data from links_boadica_detalhes_lojas 
                WHERE id_loja='$idLoja' AND id_produto='$idLinkBD' ORDER BY data DESC";
                $resultado_ultima_alteracao = mysql_query($query_ultima_alteracao,$conexao);
                //echo "$query_ultima_alteracao<br>";
                IF(mysql_num_rows($resultado_ultima_alteracao)>0){
                    $data_ultima_alteracao=substr(mysql_result($resultado_ultima_alteracao,0,0),0,10);
                    //echo "$data_ultima_alteracao<br>";
                    }
                    ELSE {
                    $data_ultima_alteracao="2001-01-01";
                    }
                    //echo "$data_ultima_alteracao<br>";
                IF ($data_ultima_alteracao==$dthoje_eua){  
                    $flagQueimado=1;
                }
                else{
                    $flagQueimado=0;
                }
                //echo "flag: $flagQueimado<br>";
                
                // Guarda no log
                if(!$flagQueimado){ // Se não constar alteração com data de hoje, então ele registra na tabela
                /*
                $query_inserir_log="INSERT INTO log(`idlog`, `data`,  `codigo`, `loja`, `inf1`, `inf2`, `inf3`, `inf4`) 
                VALUES ('null', CURRENT_TIMESTAMP, '888', '$idLoja', '$idLinkBD', '$idAnuncioBD', '$valorProduto', '$flagAlteravel')";
                $resultado_inserir_log = mysql_query($query_inserir_log,$conexao);
                $ultimaInsercao=mysql_insert_id($conexao);	
                //echo "$idAnuncioBD<br>last id: $ultimaInsercao<br>";
                */

                // Atualiza o links_boadica_detalhes_snapshot e inclui no links_boadica_detalhes_lojas
                $queryApagaLinksBoadicaDetalhesLojas="DELETE FROM links_boadica_detalhes_lojas 
                WHERE id_loja = $idLoja AND id_produto=$idLinkBD AND data LIKE '%$dthoje_eua%'";
                //echo "$queryApagaLinksBoadicaDetalhesLojas<br>";
                $resultadoApagaLinksBoadicaDetalhesLojas = mysql_query($queryApagaLinksBoadicaDetalhesLojas,$conexao);

                $query_precos=" INSERT INTO links_boadica_detalhes_lojas (`id`, `id_loja`, `data`, `id_produto`, `preco`) 
                                VALUES (NULL, $idLoja, CURRENT_TIMESTAMP, $idLinkBD, $valorProduto);";
                //echo "queryDetalhesLojas: $query_precos<br>\n";
                //echo "Inserido -> Loja: $idLoja Produto: $idLinkBD Preco: R$ $valorProduto<br>";
                $resultado_precos = mysql_query($query_precos,$conexao) OR DIE(mysql_error());

                // Esta rotina foi alterada, se a loja não estava no snapshot, não havia como fazer update
                //$queryAtualizaLinksBoadicaDetalhesSnapshot="UPDATE links_boadica_detalhes_snapshot SET preco = $valorProduto  
                //WHERE id_loja = $idLoja AND id_produto=$idLinkBD";
                //echo "queryDetalhesSnapshot: $queryAtualizaLinksBoadicaDetalhesSnapshot<br>";
                //$resultadoAtualizaLinksBoadicaDetalhesSnapshot = mysql_query($queryAtualizaLinksBoadicaDetalhesSnapshot,$conexao);

                $queryApagaLinksBoadicaDetalhesSnapshot="   DELETE FROM links_boadica_detalhes_snapshot 
                                                            WHERE id_loja = $idLoja AND id_produto=$idLinkBD";
                $resultadoApagaLinksBoadicaDetalhesSnapshot = mysql_query($queryApagaLinksBoadicaDetalhesSnapshot,$conexao);

                // Usar linha abaixo para depurar pela manhã, visualizar efeitos nas tabelas
                //echo "$queryApagaLinksBoadicaDetalhesSnapshot<br>";

                $queryInsereLinksBoadicaDetalhesSnapshot="  INSERT INTO links_boadica_detalhes_snapshot (`id`, `id_loja`, `data`, `id_produto`, `preco`) 
                                                            VALUES (NULL, $idLoja, CURRENT_TIMESTAMP, $idLinkBD, $valorProduto);";
                //echo "queryDetalhesSnapshot: $queryInsereLinksBoadicaDetalhesSnapshot<br>\n";
                $resultadoInsereLinksBoadicaDetalhesSnapshot = mysql_query($queryInsereLinksBoadicaDetalhesSnapshot,$conexao);
                
                // Usar linha abaixo para depurar pela manhã, visualizar efeitos nas tabelas
                //echo "$queryInsereLinksBoadicaDetalhesSnapshot<br>";
                }
            }
            else {
                // bla bla bla não achei, talvez escrever no log de transações...
            }
        }
   
    }
//echo "$contador";

}


if($modo=="scraperPaginaBD"){
    //echo "Passei aqui";

    $queryPesquisaIdAnuncioFromCodigoAnuncioNoBD="  SELECT id,cdproduto from links_boadica  
                                                    WHERE link like '%$linkBD%'";
    $resultadoPesquisaIdAnuncioFromCodigoAnuncioNoBD = mysql_query($queryPesquisaIdAnuncioFromCodigoAnuncioNoBD,$conexao);
    //echo "queryPesquisaIdAnuncioFromCodigoAnuncioNoBD: $queryPesquisaIdAnuncioFromCodigoAnuncioNoBD<br>";
    $cdProdutoLocalizadoApartirCodigoLinkBD=mysql_result($resultadoPesquisaIdAnuncioFromCodigoAnuncioNoBD,0,1);
    echo "{\"cdproduto\":\"$cdProdutoLocalizadoApartirCodigoLinkBD\"}";
    if(mysql_num_rows($resultadoPesquisaIdAnuncioFromCodigoAnuncioNoBD)>0){
        $linkBD=mysql_result($resultadoPesquisaIdAnuncioFromCodigoAnuncioNoBD,0,0);

        //fwrite($fp, "Resultados do link: $linkBD\n\n");
        // Para uso com o Insomnia
        //echo "O Link BD agora é: $linkBD<br>";
        //print_r ($arrDados);

        $total=count($arrDados);
        //$keyCabosEtc= array_search("Cabos and etc ...", array_column($arrDados, "nomeLoja")); Funciona, retorna a chave

        // Procura pela Cabos 329
        $findCabosEtc= in_array("Cabos e etc ...", array_column($arrDados, "nomeLoja")); // Verifica se existe
        if ($findCabosEtc){
            fwrite($fp, "Achei a Cabos e Etc\n"); 
            $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_boadica='1' WHERE id ='$linkBD'";
            
        }
        else{
            $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_boadica='0' WHERE id ='$linkBD'";
        }
        $resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);

        // Procura a Cabos 212 
        // ** Alterado em 17Jul24 para a loja 318
        //$findCabosEtc2= in_array("Cabos 2 Inform&#225;tica", array_column($arrDados, "nomeLoja")); // Verifica se existe
        $findCabosEtc2= in_array("Cabos e Etc 2", array_column($arrDados, "nomeLoja")); // Verifica se existe a loja 318
        if ($findCabosEtc2){
            fwrite($fp, "Achei a Cabos 318\n"); 
            $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdcabos2='1' WHERE id ='$linkBD'";
        }
        else{
            $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdcabos2='0' WHERE id ='$linkBD'";
        }
        $resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);

        /*

        // Procura pela SuperGame
        $findSuperGame= in_array("Super Game", array_column($arrDados, "nomeLoja")); // Verifica se existe
        if ($findSuperGame){
            fwrite($fp, "Achei a Super Game\n"); 
            $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdsg='1' WHERE id ='$linkBD'";
        }
        else{
            $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdsg='0' WHERE id ='$linkBD'";
        }
        $resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);

        // Procura pela Supernova
        $findSupenova= in_array("Supenova", array_column($arrDados, "nomeLoja")); // Verifica se existe
        if ($findSupenova){
            fwrite($fp, "Achei a Supenova\n"); 
            $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdsg2='1' WHERE id ='$linkBD'";
        }
        else{
            $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdsg2='0' WHERE id ='$linkBD'";
        }
        $resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);

        
        //fwrite($fp, "\n");

        //echo "$key\n";

        */

        
        // Apaga os dados anteriores das tabelas links_boadica_detalhes_snapshot e links_boadica_pendencias
        $query_apaga_dados_anteriores="DELETE from links_boadica_detalhes_snapshot WHERE id_produto='".$linkBD."'";
        $resultado_apaga_dados_anteriores = mysql_query($query_apaga_dados_anteriores,$conexao);

        fwrite($fp, "Query_apaga_dados_anteriores -> ". $query_apaga_dados_anteriores . " \n"); 

        $query_apaga_dados_pendencias="DELETE from links_boadica_pendencias WHERE idproduto='".$linkBD."'";
        $resultado_apaga_dados_pendencias = mysql_query($query_apaga_dados_pendencias,$conexao);


        // Pesquisa ultima alteração de preços [Cabos]
        $queryUltimaAlteracao="     SELECT data from links_boadica_detalhes_lojas 
                                    WHERE id_loja='19' AND id_produto='$linkBD' 
                                    ORDER BY data DESC";
        $resultadoUltimaAlteracao = mysql_query($queryUltimaAlteracao,$conexao);
        IF(mysql_num_rows($resultadoUltimaAlteracao)>0){
            $dataUltimaAlteracao=mysql_result($resultadoUltimaAlteracao,0,0);
        }
        ELSE {
            $dataUltimaAlteracao="2001-01-01";
        }
        $dataUltimaAlteracaoCabos=substr($dataUltimaAlteracao,0,10);
        fwrite($fp, "Data da Ultima alteração da Cabos: $dataUltimaAlteracaoCabos\n"); 

        // Pesquisa ultima alteração de preços [Cabos2]
        /*$queryUltimaAlteracao="     SELECT data from links_boadica_detalhes_lojas 
                                    WHERE id_loja='451' AND id_produto='$linkBD' 
                                    ORDER BY data DESC";
        */
        // Pesquisa ultima alteração de preços [Cabos318]
        $queryUltimaAlteracao="     SELECT data from links_boadica_detalhes_lojas 
                                    WHERE id_loja='784' AND id_produto='$linkBD' 
                                    ORDER BY data DESC";
        $resultadoUltimaAlteracao = mysql_query($queryUltimaAlteracao,$conexao);
        IF(mysql_num_rows($resultadoUltimaAlteracao)>0){
            $dataUltimaAlteracao=mysql_result($resultadoUltimaAlteracao,0,0);
        }
        ELSE {
            $dataUltimaAlteracao="2001-01-01";
        }
        $dataUltimaAlteracaoCabos2=substr($dataUltimaAlteracao,0,10);
        fwrite($fp, "Data da Ultima alteração da Cabos318: $dataUltimaAlteracaoCabos2\n\n"); 

        
        foreach ($arrDados as $dado) {
            $nomeLoja=$dado["nomeLoja"]; 
            //$nomeLoja=utf8_decode($nomeLoja); 
            //$nomeLoja=htmlspecialchars(htmlentities($nomeLoja));
            //$nomeLoja=utf8_decode($nomeLoja); 
            //$nomeLoja=htmlspecialchars($nomeLoja,ENT_QUOTES,"utf8");
            //$nomeLoja=mb_convert_encode($nomeLoja,'UTF-8','HTML-ENTITIES');
            $preco=$dado["preco"];

            // Procura se a loja é cadastrada
            $queryIdLoja="  SELECT id_loja, flag_predio 
                            FROM lojas_boadica 
                            WHERE nome LIKE '%".$nomeLoja."%'";
            $resultadoIdLoja = mysql_query($queryIdLoja,$conexao);
                
            if(mysql_num_rows($resultadoIdLoja)>0){ // se a loja é cadastrada
                $idLoja=mysql_result($resultadoIdLoja,0,0);
                //$flagPredio=mysql_result($resultadoIdLoja,0,1);
                $flagLojaCadastrada=1;
            }
            else{
                $idLoja="";
                $flagLojaCadastrada=0;
                $queryInserirLog="INSERT INTO log(`idlog`, `data`,  `codigo`, `loja`, `inf1`, `inf2`, `inf3`) 
                VALUES ('null', '$timestampSaoPaulo', '300', '1', '$linkBD', '$nomeLoja', 'Scraper')";
                $resultadoInserirLog = mysql_query($queryInserirLog,$conexao);	
            }
            //fwrite($fp, "Query: $queryIdLoja\n");
            fwrite($fp, "\nFlag se a loja já está cadastrada no sistema: $flagLojaCadastrada\n");
            fwrite($fp, "ID da loja cadastrada: $idLoja\n");
            fwrite($fp, "$nomeLoja\n$preco\n\n"); // Usado para verificar se os dados estão chegando
            //fwrite($fp, "$dthoje_eua\n");

            $queryPesquisaPrecoAntigo=" SELECT preco, data 
                                        FROM links_boadica_detalhes_lojas 
                                        WHERE id_loja='$idLoja' AND id_produto='$linkBD' 
                                        ORDER BY data DESC";
            //fwrite($fp,"$queryPesquisaPrecoAntigo\n");
            //echo $query_pesquisa_preco_antigo;
            $resultadoPrecoAntigo = mysql_query($queryPesquisaPrecoAntigo,$conexao);
            $quantidadeItens=mysql_num_rows($resultadoPrecoAntigo);
            if($quantidadeItens>0){
                $precoAnterior=mysql_result($resultadoPrecoAntigo,0,0);
                $dataPrecoAnterior=mysql_result($resultadoPrecoAntigo,0,1);
            }
            else{
                $precoAnterior=0;
                $dataPrecoAnterior="2001-01-01";
            }
            fwrite($fp, "Preco anterior: $precoAnterior | Preço atual: $preco | Data preço anterior| $dataPrecoAnterior\n");

            if( $flagLojaCadastrada==1 AND (($quantidadeItens==0) OR ($precoAnterior<>$preco))){	
                    // Se não houver preço anterior ou se o preço anterior for difente do atual	
                    //echo "preço anterior=".$preco_anterior;
                    //echo "flag_loja_cadastrada".$flag_loja_cadastrada;			
                    $queryPrecos=" INSERT INTO links_boadica_detalhes_lojas (`id`, `id_loja`, `data`, `id_produto`, `preco`, `origem`) 
                                    VALUES (NULL, $idLoja, '$timestampSaoPaulo', $linkBD, $preco, 'BDRotinasCurl');";
                    //echo "$query_precos<br>";
                    fwrite($fp,"Inserido links_boadica_detalhes_lojas-> Loja: $idLoja Produto: $linkBD Preco: R$ $preco\n");
                    //Depuração pelo Insomnia
                    //echo "Inserido links_boadica_detalhes_lojas-> Loja: $idLoja Produto: $linkBD Preco: R$ $preco<br>";
                    $resultadoPrecos = mysql_query($queryPrecos,$conexao) OR DIE(mysql_error());
                    //mysql_query($query_insert) OR DIE(mysql_error());
            }
                
            $queryPrecosSnapshot="  INSERT INTO links_boadica_detalhes_snapshot (`id`, `id_loja`, `data`, `id_produto`, `preco`, `origem`) 
                                    VALUES (NULL, $idLoja, '$timestampSaoPaulo', $linkBD, $preco, 'BDRotinasCurl');";
            //echo "Query_precos_snapshot: $queryPrecosSnapshot<br>";
            $resultadoPrecosSnapshot = mysql_query($queryPrecosSnapshot,$conexao);
            //Depuração pelo Insomnia
            //echo "$idLoja | CURRENT_TIMESTAMP | $linkBD | $preco, 'BDRotinasCurl'<br>";
            //echo "$queryPrecosSnapshot<br>";
        }

        
    }
    else{
        //echo "Não localizei, abortando...<br>";
    }
}

fclose($fp); // fecha o arquivo txt que foi aberto para escrita (util quando não tiver o Imsomnia rodando, ou ele não puder ser usado)

/*




// query interessante, pode ser util
// SELECT links_boadica.id, links_boadica.produto, bd_id_anuncios.idanunciobd FROM `bd_mysnapshot`, `bd_id_anuncios`, `links_boadica` WHERE bd_mysnapshot.idanunciobd=bd_id_anuncios.idanunciobd AND bd_id_anuncios.idlinkbd=links_boadica.ID


//msg enviada pelo Insomnia
// {"modo":"testePost","dados":[{"nome":"Flavio","idade":52},{"nome":"Denise","idade":53}]}

//$msg=ler do arquivo
$arrJson=(json_decode($msg, true)); // true retorna array, sem parametro retorna objeto

$cdLoja=$arrJson["cdloja"];
$arrDados=$arrJson["dados"];

echo "O codigo da loja é: $cdLoja<br>";
//echo $data;

$total=count($arrDados);
echo "itens: $total";

//var_dump($arrJson);

$arquivo="BDRotinasJson.txt";

//Variável $fp armazena a conexão com o arquivo e o tipo de ação.
$fp=fopen($arquivo, "w+"); //w+ apaga o conteudo anterior, para somar usar a+

//Escreve no arquivo aberto.
//fwrite($fp, $msg);

foreach ($arrDados as $key) {
    // $arr[3] será atualizado com cada valor de $arr...
    $idAnuncioBD=$arrDados[$key]["i"];
    $valor=$arrDados[$key]["v"];
    $modificado=$arrDados[$key]["h"];
    $ativo=$arrDados[$key]["a"];
    //fwrite ($fp, "$codbd => $valor\n");
    $query="INSERT INTO `bd_mysnapshot` (`id`, `idloja`, `idanunciobd`, `valor`, `modificado`, `ativo`, `data`) 
    VALUES (NULL, '$cdLoja', '$idAnuncioBD', '$valor', '$modificado', '$ativo', CURRENT_TIMESTAMP)";
    $resultado=mysql_query($query, $conexao);

    //print_r($arr);
}
//Fecha o arquivo.
fclose($fp);

// Fazer um for no array dados e colocar o conteudo no banco de dados snapshot das lojas ou coisa assim



/*
if ($modo=="testePost"){

    // excelente materia sobre json no php

    // https://www.w3schools.com/js/js_json_php.asp

    // Usando o Imsomnia para testes

    $arquivo = "BDRotinasJson.txt";
	
	//Variável $fp armazena a conexão com o arquivo e o tipo de ação.
	$fp = fopen($arquivo, "w+"); //w+ apaga o conteudo anterior, para somar usar a+

	//Escreve no arquivo aberto.
	fwrite($fp, $msg);
	


    $currentTimeStamp=$dthoje_eua." ".$hora;


    $nome=$arrJson["dados"][0]["nome"];    
    echo "Conseguiu entender o modo de operação !!!<br>";
    echo "Gravei o conteudo recebido em BDRotinasJson.txt<br>";
	
	//Fecha o arquivo.
    fclose($fp);
}
*/












?>

