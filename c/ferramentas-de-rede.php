<?    
    //Prepara conexao ao db
    $raiz_site=$_SERVER['DOCUMENT_ROOT'];
    include("$raiz_site/conectaDBMysqli.php");

    $arquivoExecutavel=substr(basename($_SERVER['PHP_SELF']),0,strlen($arquivoExecutavel)-4);
    //echo "Nome do executavel: $arquivoExecutavel<br>";

    if($arquivoExecutavel<>"busca"){
        $queryCdSubCategoria="  SELECT cdsubcategoria, descricao, caminho, keywords, description       
                                FROM subcategoria  
                                WHERE caminho='$arquivoExecutavel' 
                                AND cdloja=$cdloja";
        //echo "$queryCdSubCategoria<br>";
        if (!$resultadoCdSubCategoria = $conexao->query($queryCdSubCategoria)) {
            echo "Desculpe, estamos com problema, favor retornar mais tarde.";
            exit;
        }


        $row=$resultadoCdSubCategoria->fetch_array(MYSQLI_ASSOC); // pode ser NUM ou BOTH
        //$vlVendaSite=mysql_result($resultadoPreco,0,0);
        $cdSubCategoriaProcurada=$row['cdsubcategoria']; 
        // Muda o titulo e a tag canonical da pagina
        $descricaoSubCategoriaProcurada=$row['descricao']; 
        $caminhoSubCategoriaProcurada=$row['caminho']; 

        $titlePagina="$descricaoSubCategoriaProcurada | Infoguia.rio.br";
        $descriptionSubCategoriaProcurada=$row['description'];
        $keywordsSubCategoriaProcurada=$row['keywords'];
        $cannonicalLink="https://www.infoguia.rio.br/c/$arquivoExecutavel";
        

        /*
        echo    "<script type=\"text/javascript\">
                document.title = \"$descricaoSubCategoriaProcurada | Infoguia\";

                const canonical = document.querySelector('link[rel=\"canonical\"]');
                if (canonical !== null) {
                canonical.href = 'https://www.infoguia.rio.br/c/$caminhoSubCategoriaProcurada';
                }

            </script>";
        */
        
    }
    else{
        $titlePagina="Busca | Infoguia.rio.br";
        $descriptionSubCategoriaProcurada="Pesquise os melhores preços de informática no Rio de Janeiro.";
        $keywordsSubCategoriaProcurada="busca de preços,pesquisa de preços,infocentro,edificio avenida central,infocentro";
        $cannonicalLink="https://www.infoguia.rio.br/busca.php";
       
    }


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-PZHZ5PB');
    </script>
    <!-- End Google Tag Manager -->
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="icon" href="../img/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="/css/estilo.css">


    <!-- Fonte Oswald -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet"> 

    <style>
    h1, h2, h3{
        font-family: 'Oswald', sans-serif;
        color: #4B0082;
    }
    h2{
            font-size: 28px;
        }
    </style>
    
     
    <?
        echo "<meta name=\"theme-color\" content=\"#ff6600\">\n";
        echo "\t<meta name=\"robots\" content=\"FOLLOW,INDEX,ALL\"/>\n";
        
        echo "\t<meta name=\"description\" content=\"$descriptionSubCategoriaProcurada\" />\n"; 
        echo "\t<meta name=\"keywords\" content=\"$keywordsSubCategoriaProcurada\">\n";
        echo "\t<title>$titlePagina</title>\n";
        $dtExpires=date("D, d M Y",strtotime('+1 days'))." 00:00:00 GMT";
        echo "\t<meta http-equiv=\"expires\" content=\"$dtExpires\">\n";
        if($arquivoExecutavel<>"busca"){
            echo "\t<link rel=\"canonical\" href=\"$cannonicalLink\"/>\n";
        }
        echo "\t<base id=\"tag_base\" href=\"https://www.cabos.etc.br/\"/>\n";

        /* OG Propriedades */
        echo "\t<meta name=\"SKYPE_TOOLBAR\" content=\"SKYPE_TOOLBAR_PARSER_COMPATIBLE\">\n";
        echo "\t<meta property=\"og:title\" content=\"$titlePagina\" >\n";
        echo "\t<meta property=\"og:description\" content=\"$descriptionSubCategoriaProcurada\" >\n";
        echo "\t<meta property=\"og:phone_number\" content=\"(21) 9999-9999\" >\n";
        echo "\t<meta property=\"og:street-address\" content=\"Avenida Rio Branco, 156\" >\n";
        echo "\t<meta property=\"og:locality\" content=\"Rio de Janeiro\" >\n";
        echo "\t<meta property=\"og:region\" content=\"RJ\" >\n";
        echo "\t<meta property=\"og:email\" content=\"webmaster@infoguia.rio.br\" >\n";
        echo "\t<meta property=\"og:image\" content=\"https://www.infoguia.rio.br/img/site/infoguia256x256.png\" >\n";
        
    ?>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PZHZ5PB"
        height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?


    $termo=$_REQUEST["q"];
    if($termo==""){
        $termo="cat6";
    }
    //echo "termo de pesquisa: $termo<br>";

    

    if ($termo<>"" and $arquivoExecutavel=="busca"){
        $ArrayChave  = explode(' ', $termo);
        $chave1=$ArrayChave[0];
        $chave2=$ArrayChave[1];
        //Pesquisar como excluir de, para, etc nas pesquisas, talvez no !IN(de,para)
        if ($chave2<>""){
            $condicaoChave2=" OR fabricantes.nome LIKE '%$chave2%' ";
        }
        
        $chave3=$ArrayChave[2];
        if ($chave3<>""){
            $condicaoChave3=" OR fabricantes.nome LIKE '%$chave3%' ";
        }

        $queryPesquisaTermo="SELECT produtos.cdproduto, produtos.nome, produtos.url, precos.vlvendasite, produtos.description     
            FROM produtos, precos, fabricantes  
            WHERE produtos.cdproduto=precos.cdproduto 
            AND produtos.cdfabricante=fabricantes.cdfabricante 
            AND precos.cdloja='$cdloja'  
            AND precos.vlvendasite!=0 
            AND (
                (produtos.nome LIKE '%$chave1%' AND  produtos.nome LIKE '%$chave2%' AND  produtos.nome LIKE '%$chave3%')  
                OR produtos.cdproduto='%$chave1%'    
                OR produtos.keywords LIKE '%$chave1%' 
                OR produtos.modelo LIKE '%$chave1%'  
                OR fabricantes.nome LIKE '%$chave1%' 
                OR produtos.descricao LIKE '%$chave1%' 
                $condicaoChave2 
                $condicaoChave3
            ) 
            ORDER BY nome";

        $descricaoSubCategoriaProcurada="Busca: ".$termo;
    }

    if($arquivoExecutavel<>"busca"){
        /*
        $caminhoCompletoPastaAtual=dirname(__FILE__);
       
        $inicio=strpos($caminhoCompletoPastaAtual,"public_html");
        $pastaAtual=substr($caminhoCompletoPastaAtual,$inicio+12,50);
        $arquivoExecutavel=basename($_SERVER['PHP_SELF']);
        */
        /*
        if($pastaAtual=="video/cabos"){
            $cdSubCategoriaProcurada=7;
        }
        */


       

        $queryPesquisaTermo="SELECT produtos.cdproduto, produtos.nome, produtos.url, precos.vlvendasite, produtos.description     
        FROM produtos, precos, fabricantes  
        WHERE produtos.cdproduto=precos.cdproduto 
        AND produtos.cdfabricante=fabricantes.cdfabricante 
        AND precos.cdloja='$cdloja'  
        AND precos.vlvendasite!=0 
        AND produtos.cdsubcategoria=$cdSubCategoriaProcurada 
        ORDER BY nome";
    }

    if (!$resultadoPesquisaTermo = $conexao->query($queryPesquisaTermo)) {
        echo "Desculpe, estamos com problema, favor retornar mais tarde.";
        exit;
    }

    $quantidadePesquisaTermo=$resultadoPesquisaTermo->num_rows;
    
    //echo "Termo de pesquisa: $queryPesquisaTermo<br>";
    ?>
        <!-- Topo -->
        <?
            include("$raiz_site/topo.php");
        ?>
          
        <!-- Termo pesquisado --> 
        <div class="container-fluid">
            <div class="container mx-auto">
            <?
                echo $nome;
            ?>
            </div>
        </div>

        <!-- Quantidade, opções de exibição e filtros --> 
        <div class="container">
            <div class="container mx-auto">
                <div class="row d-inline">
                    <div class="col-sm-12 col-md-12 d-inline">
                        <div>                       
                            <? echo "<h1>$descricaoSubCategoriaProcurada</h1>\n"; ?>
                        </div>
                        <div>
                            <span class="badge badge-primary d-inline">
                                <? echo $quantidadePesquisaTermo; ?>
                            </span>
                            <span class="ml-2">
                                Localizados
                            </span>
                        </div>
                    </div>
                    <!-- Implementar
                    <div class="col-sm-2 col-md-1 d-inline">
                        <i class="fa fa-th d-line"></i>
                    </div>
                    <div class="col-sm-2 col-md-1 d-inline">
                        <i class="fa fa-filter"></i>
                    </div>
                    -->

                </div>   
            </div>
        </div>

    <!-- Exibição das linhas --> 

    <div class="container">
        <?
            /*
            breakpoints
            xs=0
            sm=576px
            md=768px
            lg=992px
            xl=1200px
            xxl=1400px
            */
            //while ($row = mysql_fetch_array($resultadoPesquisaTermo, MYSQL_NUM)) {

            while ($row = $resultadoPesquisaTermo->fetch_assoc()) {
                $cdProduto=$row['cdproduto'];
                $nomeProduto=$row['nome'];
                $urlProduto=$row['url'];
                
                if($urlProduto==""){
                    $urlProduto=$cdProduto;
                }
                
                $valorProduto=$row['vlvendasite'];
                $valorProduto=str_replace(".",",",$valorProduto);
                $descricaoSimplificadaProduto=$row['description'];
                echo"  
                            <div class='container buscaExibicaoProdutos mx-auto'>
                                <div class='row'>
                                    <div class='col-6 col-sm-6 col-md-4 col-lg-3  #bg-primary'>
                                        <a href='/$cdProduto'><img src='/img/produtos/$cdProduto.jpg' class='img-fluid' alt='$nomeProduto'/></a>
                                    </div>
                                    <div class='col-6 col-sm-6 col-md-8 col-lg-9 #bg-warning'>
                                        <div class='buscaDivNomeProduto'>
                                            <h2>$nomeProduto</h2>
                                        </div>
                                        <div class='buscaDivCdProduto'>
                                            <span class=\"text-muted small\">
                                                sku: $cdProduto
                                            </span>
                                        </div>
                                        
                                        <div class='buscaDivDescricaoProduto'>
                                            $descricaoSimplificadaProduto
                                        </div>
                                        <div class='col-sm-3 col-6 d-flex flex-row my-2'>
                                            
                                                <span class=\"text-muted align-self-center\">R</span><span class=\"text-muted align-self-center small pr-1\">$ </span>
                                            
                                            
                                                <h3>$valorProduto</h3>
                                            
                                        </div>
                                        <div class='buscaDivBotaoCompraProduto float-none'>
                                            <a class='btn-sm btn-primary' href='/$urlProduto' role='button'>+Detalhes</a>
                                            
                                        </div>
                                    </div>
                                </div>   

                                

                            </div>";    
            }
        ?>

    </div>


     <!-- Rodapé -->
        <?
            include("$raiz_site/rodape.php");
        ?>

        <!-- JS JQuery/Bootstrap-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
