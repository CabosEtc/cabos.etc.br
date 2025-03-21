<?
    //Prepara conexao ao db
    include("conectaDBMysqli.php");

    $termo=$_REQUEST["q"];
    //echo $termo;

    $queryPesquisaTermo="   SELECT produtos.cdproduto, produtos.nome AS nomeproduto, produtos.url, produtos.descricao, produtos.description, 
                            produtos.keywords, produtos.title, fabricantes.nome AS nomefabricante, produtos.produto as nomeproduto50caracteres, produtos.caracteristicas, produtos.compatibilidade      
                            FROM produtos, fabricantes 
                            WHERE produtos.cdfabricante=fabricantes.cdfabricante  
                            AND  cdproduto='$termo' 
                            OR url='$termo'";

    if (!$resultadoPesquisaTermo = $conexao->query($queryPesquisaTermo)) {
        echo "Desculpe, estamos com problema, favor retornar mais tarde.";
        exit;
    }

    // Pesquisa unica, substitui o mysql_result($resultado,x,x)
    $row=$resultadoPesquisaTermo->fetch_array(MYSQLI_ASSOC); // pode ser NUM ou BOTH
    $cdProduto=$row['cdproduto'];
    $nomeProduto=$row['nomeproduto'];
    $urlProduto=$row['url'];
    if($urlProduto==""){
        $flagHabilitado="disabled";
        $titleBtnComprar="title=\"Produto disponível somente para retirada na loja\"";
    }
    $descricaoSimplificadaProduto=$row['description'];
    $keywordsProduto=$row['keywords'];
    $titleTwitter=$row['title'];
    $titleProduto=$row['title']." | Infoguia.rio.br";
    $descricao=$row['descricao'];
    
    if($descricao<>""){
        $descricaoProduto="<h3>Descrição</h3>".$descricao;
    }
        else{
            $descricaoProduto=$descricaoSimplificadaProduto;
        }
    
    $nomeFabricanteProduto=$row['nomefabricante'];
    if($nomeFabricanteProduto=="Herdado"){
        $nomeFabricanteProduto="N/D";
    }

    $nomeProduto50caracteres=$row['nomeproduto50caracteres'];

    if($nomeProduto50caracteres!=""){
        $nomeProduto=$nomeProduto50caracteres;
    }

    $caracteristicas=$row['caracteristicas'];
    IF($caracteristicas<>""){
        $ArrayCaracteristicas  = explode(';', $caracteristicas);
        $caracteristicasProduto="<p>&nbsp</p><h3>Características técnicas</h3><ul type='square'>";
    
        foreach ($ArrayCaracteristicas as $linha) {
            $caracteristicasProduto=$caracteristicasProduto."<li>".$linha."</li>";
        }
        $caracteristicasProduto=$caracteristicasProduto."</ul>";
    }

    $compatibilidade=$row['compatibilidade'];
    IF ($compatibilidade<>""){
        $ArrayCompatibilidade  = explode(';', $compatibilidade);
        $compatibilidadeProduto="<h3>Compatibilidade</h3></p><ul type='square'>";
    
        foreach ($ArrayCompatibilidade as $linha) {
            $compatibilidadeProduto=$compatibilidadeProduto."<li>".$linha."</li>";
        }
        $compatibilidadeProduto=$compatibilidadeProduto."</ul>";
    }
        
    if(1==1){
        $imagensProduto="https://www.infoguia.rio.br/img/produtos/$cdProduto.jpg";
    }
    // O que é MPN https://ajuda.getcommerce.com.br/article/213-o-que-e-mpn
    $mpn="";

    //Preço

    $queryPreco="SELECT vlvendasite 
                    FROM precos 
                    WHERE cdproduto='$cdProduto' 
                    AND cdloja=$cdloja";
	//echo "$queryPreco<br>";

    //$resultadoPreco = mysql_query($queryPreco,$conexao);
    if (!$resultadoPreco = $conexao->query($queryPreco)) {
        echo "Desculpe, estamos com problema, favor retornar mais tarde.";
        exit;
    }

    $row=$resultadoPreco->fetch_array(MYSQLI_ASSOC); // pode ser NUM ou BOTH
    //$vlVendaSite=mysql_result($resultadoPreco,0,0);
    $vlVendaSite=$row['vlvendasite']; 
    //echo "teste| $vlVendaSite <br>";
    if($vlVendaSite==0){
        $vlVendaSite="Não disponivel";
        $urlProduto="";
    }
    $SEO_vlVendaSite=str_replace(',', '.', $vlVendaSite );
    $vlProduto=str_replace(".",",",$vlVendaSite);
    //$vlProduto="$vlVendaSite";

    // Data de 5 dias a frente
    $SEO_priceValidUntil=date('Y-m-d', strtotime('+5 days'));
        

?>

<html lang="pt-br">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PCPFWSQ');</script>
    <!-- End Google Tag Manager -->

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="icon" href="../img/logo.png">
    <link rel="icon" sizes="192x192" href="../img/logo192x192.png">
    <!--
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="/static/images/ico/apple-touch-icon-76x76-precomposed.png/666282be8229.png">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="/static/images/ico/apple-touch-icon-120x120-precomposed.png/8a5bd3f267b1.png">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="/static/images/ico/apple-touch-icon-152x152-precomposed.png/68193576ffc5.png">
    <link rel="apple-touch-icon-precomposed" sizes="167x167" href="/static/images/ico/apple-touch-icon-167x167-precomposed.png/4985e31c9100.png">
    <link rel="apple-touch-icon-precomposed" sizes="180x180" href="/static/images/ico/apple-touch-icon-180x180-precomposed.png/c06fdb2357bd.png">
    <link rel="icon" sizes="192x192" href="/static/images/ico/favicon-192.png/68d99ba29cc8.png">
    <link rel="mask-icon" href="/static/images/ico/favicon.svg/fc72dd4bfde8.svg" color="#262626">
    <link rel="shortcut icon" type="image/x-icon" href="/static/images/ico/favicon.ico/36b3ee2d91ed.ico">
    -->


    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?  
        echo "<title>$titleProduto</title>\n";
        echo "\t<meta name=\"theme-color\" content=\"#ff6600\">\n";
        echo "\t<meta name=\"robots\" content=\"FOLLOW,INDEX,ALL\"/>\n";
        echo "\t<meta name=\"description\" content=\"$descricaoSimplificadaProduto\" />\n"; 
        echo "\t<meta name= \"keywords\" content=\"$keywordsProduto\" />\n";
        echo "\t<meta name=\"title\" content=\"$titleProduto\" />\n";
    ?>

    <?
        /* Referências: 
        https://neilpatel.com/blog/open-graph-meta-tags/#:~:text=og%3Adescription,won't%20affect%20your%20SEO.

        https://www.devmedia.com.br/html-meta-tags-entendendo-o-uso-de-meta-tags/30328

        https://rockcontent.com/br/blog/canonical-tag/

        https://developer.mozilla.org/pt-BR/docs/Web/HTML/Element/base
        */

        // Script OG (Open Graph)
        $dtExpires=date("D, d M Y",strtotime('+1 days'))." 00:00:00 GMT";
        echo "<meta http-equiv=\"expires\" content=\"$dtExpires\">\n";
        echo "\t<link rel=\"canonical\" href=\"https://www.infoguia.rio.br/$urlProduto\"/>\n";
        echo "\t<base id=\"tag_base\" href=\"https://www.cabos.etc.br/\"/>\n";
        echo "\t<meta name=\"SKYPE_TOOLBAR\" content=\"SKYPE_TOOLBAR_PARSER_COMPATIBLE\"/>\n";
        echo "\t<meta property=\"og:locale\" content=\"pt_BR\">\n";
        echo "\t<meta property=\"og:type\" content=\"website\">\n";
        echo "\t<meta property=\"og:site_name\" content=\"Infoguia Rio\">\n";
        echo "\t<meta property=\"og:title\" content=\"$titleProduto\" />\n";
        echo "\t<meta property=\"og:description\" content=\"$descricaoSimplificadaProduto\" />\n";
        echo "\t<meta property=\"og:phone_number\" content=\"(21) 9999-9999\" />\n";
        echo "\t<meta property=\"og:street-address\" content=\"Avenida Rio Branco, 156\" />\n";
        echo "\t<meta property=\"og:locality\" content=\"Rio de Janeiro\" />\n";
        echo "\t<meta property=\"og:region\" content=\"RJ\" />\n";
        echo "\t<meta property=\"og:email\" content=\"webmaster@infoguia.rio.br\" />\n";
        echo "\t<meta property=\"og:image\" content=\"https://www.infoguia.rio.br/img/produtos/$cdProduto.jpg\" />\n";
        echo "\t <meta property=\"og:image:alt\" content=\"$titleProduto\">\n";
        echo "\t<meta property=\"og:image:type\" content=\"image/jpeg\">\n";
        echo "\t<meta property=\"og:image:width\" content=\"1000\">\n"; // pixels
        echo "\t<meta property=\"og:image:height\" content=\"1000\">\n"; 
        

    ?>
    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/estilo.css">

    <!-- Fonte Oswald -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet"> 

    <style>    
    h1, h2, h3, h5, h6{
        font-family: 'Oswald', sans-serif;
        color: #4B0082;
    }
    h2{
        font-size: 28px;
    }

    </style>

<!-- Script original, completo
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Product",
      "name": "Executive Anvil",
      "image": [
        "https://example.com/photos/1x1/photo.jpg",
        "https://example.com/photos/4x3/photo.jpg",
        "https://example.com/photos/16x9/photo.jpg"
       ],
      "description": "Sleeker than ACME's Classic Anvil, the Executive Anvil is perfect for the business traveler looking for something to drop from a height.",
      "sku": "0446310786",
      "mpn": "925872",
      "brand": {
        "@type": "Brand",
        "name": "ACME"
      },
      "review": {
        "@type": "Review",
        "reviewRating": {
          "@type": "Rating",
          "ratingValue": "4",
          "bestRating": "5"
        },
        "author": {
          "@type": "Person",
          "name": "Fred Benson"
        }
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.4",
        "reviewCount": "89"
      },
      "offers": {
        "@type": "Offer",
        "url": "https://example.com/anvil",
        "priceCurrency": "USD",
        "price": "119.99",
        "priceValidUntil": "2020-11-20",
        "itemCondition": "https://schema.org/UsedCondition",
        "availability": "https://schema.org/InStock"
      }
    }
</script>
-->

<!-- Script Ritch Edit -->
<? echo "
        <script type=\"application/ld+json\">
            {
                \"@context\": \"https://schema.org/\",
                \"@type\": \"Product\",
                \"name\": \"$nomeProduto\",
                \"image\": [
                    \"$imagensProduto\"
                ],
                \"description\": \"$descricaoSimplificadaProduto\",
                \"sku\": \"$cdProduto\",
                \"mpn\": \"$mpn\",
                \"brand\": {
                    \"@type\": \"Brand\",
                    \"name\": \"$nomeFabricanteProduto\"
                },
                \"offers\": {
                    \"@type\": \"Offer\",
                    \"url\": \"http://www.infoguia.rio.br/$urlProduto\",
                    \"priceCurrency\": \"BRL\",
                    \"price\": \"$SEO_vlVendaSite\",
                    \"priceValidUntil\": \"$SEO_priceValidUntil\",
                    \"itemCondition\": \"https://schema.org/NewCondition\",
                    \"availability\": \"https://schema.org/InStock\"
                }
            }
    </script>
";
?>

<!-- Script do Bing -->
<?
    echo "<div itemscope=\"\" itemtype=\"http://Contoso.com/Product\">\n";
    echo "\t<meta itemprop=\"name\" content=\"$nomeProduto\" />\n";
    echo "\t<meta itemprop=\"sku\" content=\"$cdProduto\" />\n";
    echo "\t<meta itemprop=\"description\" content=\"$descricaoSimplificadaProduto\" />\n";
    echo "\t<meta itemprop=\"gtin14\" content=\"\"/>\n";
    echo "\t<meta itemprop=\"image\" content=\"$imagensProduto\" />\n";
    echo "\t<meta itemprop=\"brand\" content=\"$nomeFabricanteProduto\" />\n";
    echo "\t<div itemprop=\"offers\" itemscope=\"\" itemtype=\"http://Contoso.com/Offer\">\n";
    echo "\t\t<meta itemprop=\"priceCurrency\" content=\"BRL\" />\n";
    echo "\t\t<meta itemprop=\"price\" content=\"$SEO_vlVendaSite\" />\n";
    echo "\t\t<meta itemprop=\"availability\" content=\"http://Contoso.com/InStock\" />\n";
    echo "\t</div>\n";
    echo "</div >\n";
?>

<!-- Script do Twitter -->
<?
    echo "\t<meta name=\"twitter:title\" content=\"$titleTwitter\"\n>"; 
    //echo "\t<meta name=\"twitter:site\" content=\"@infoguia\" />\n"";
    echo "\t<meta name=\"twitter:description\" content=\"$descricaoSimplificadaProduto\"\n>"; 
    echo "\t<meta name=\"twitter:card\" content=\"summary_large_image\"\n>"; 
    echo "\t<meta name=\"twitter:image\" content=\"$imagensProduto\"\n>"; 
?>

</head>
<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCPFWSQ"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?
    
    /*
        $resultadoPesquisaTermo=mysql_query($queryPesquisaTermo, $conexao);
        $cdProduto=mysql_result($resultadoPesquisaTermo,0,0);
        $nomeProduto=mysql_result($resultadoPesquisaTermo,0,1);
        $urlProduto=mysql_result($resultadoPesquisaTermo,0,2);
    */   
    //echo $queryPesquisaTermo;

    
    ?>
    <!-- Topo -->
        <!-- Topo -->
        <?
            include("topo.php");
        ?>
       
    <!-- Termo pesquisado --> 
        <div class="container">
            <div class="container mx-auto">
            <?
                echo "$nome";
            ?>
            </div>
        </div>

    <!-- Quantidade, opções de exibição e filtros --> 
    <div class="container">
            <!--
            <div class="container-fluid mx-auto">
                <div class="row d-inline">
                    <div class="col-sm-4 col-md-7"></div>
                    <div class="col-sm-4 col-md-3 d-inline">
                        <span class="badge badge-primary d-inline">28</span><span class="ml-2">Localizados</span>
                    </div>
                    <div class="col-sm-2 col-md-1 d-inline">
                    
                        <i class="fa fa-th d-line"></i>
                    
                    </div>
                    <div class="col-sm-2 col-md-1 d-inline">
                        
                        <i class="fa fa-filter"></i>
                        
                    </div>

                </div>   
            </div>
            -->
        </div>

    <!-- Exibição do produto --> 

    <div class="container-fluid">
        <?
            $raiz_site=$_SERVER['DOCUMENT_ROOT'];
            
            $img1=$raiz_site."/img/produtos/".$cdProduto.".jpg";
            $img2=$raiz_site."/img/produtos/".$cdProduto."b.jpg";
            $img3=$raiz_site."/img/produtos/".$cdProduto."c.jpg";
            $img4=$raiz_site."/img/produtos/".$cdProduto."d.jpg";

            $imgA="$cdProduto.jpg";
            $imgB="$cdProduto"."b.jpg";
            $imgC="$cdProduto"."c.jpg";
            $imgD="$cdProduto"."d.jpg";
            

            IF (file_exists($img1)){
                $thumbs1="<img class=\"img-fluid\"  onmouseover=\"trocaImagem('$imgA')\" src=\"../img/produtos/$imgA\" alt=\"$nomeProduto\"/>";
            } 
            IF (file_exists($img2)){
                $thumbs2="<img class=\"img-fluid\"  onmouseover=\"trocaImagem('$imgB')\" src=\"../img/produtos/$imgB\" alt=\"$nomeProduto\"/>";
            } 
            IF (file_exists($img3)){
                $thumbs3="<img class=\"img-fluid\"  onmouseover=\"trocaImagem('$imgC')\" src=\"../img/produtos/$imgC\" alt=\"$nomeProduto\"/>";
            } 
            IF (file_exists($img4)){
                $thumbs4="<img class=\"img-fluid\"  onmouseover=\"trocaImagem('$imgD')\" src=\"../img/produtos/$imgD\" alt=\"$nomeProduto\"/>";
            } 
            echo"  
                        <div class='container mx-auto'>
                            <div class='row my-1'>
                                <div class='col-sm-12 col-md-6 #bg-primary'>
                                    <div>
                                        <a href='/$urlProduto'><img id='imagemProduto' src='img/produtos/$cdProduto.jpg' class='img-fluid' alt=\"$nomeProduto\"/></a>
                                    </div>                                
                                    <div class='row'>
                                        <div class='col-3 bd-highlight'>
                                            $thumbs1
                                        </div>
                                        <div class='col-3 bd-highlight'>
                                            $thumbs2
                                        </div>
                                        <div class='col-3 bd-highlight'>
                                            $thumbs3
                                        </div>
                                        <div class='col-3 bd-highlight'>
                                            $thumbs4
                                        </div>
                                </div>

                                </div>
                                <div class='col-sm-12 col-md-6 #bg-warning ProdutoNomeProduto'>
                                    <h1>$nomeProduto</h1>
                                    <p>Marca: Cabos Etc</p>
                                    <p class='text-muted small'>sku: ce$cdProduto</p>
                                    
                                    <div class='row'>
                                        <div class='col-sm-3 col-6 mt-2'>
                                            <a href='/lojas/cabos-e-etc' target='_blank'>
                                                <img src='img/lojas/cabosetc.jpg' class='img-fluid' alt='Cabos & Etc...'  title='Informações sobre o vendedor'/>
                                            </a>
                                        </div> 
                                        <div class='col-sm-3 col-6 d-flex flex-row my-2'>
                                            
                                                <span class=\"text-muted align-self-center\">R</span><span class=\"text-muted small align-self-center pr-1\">$ </span>
                                           
                                           
                                                <h2 class=''>$vlProduto</h2>
                                            
                                        </div>
                                        <div class='col-sm-3 col-6 mt-2'>
                                            <!-- Desabilitado temporariamente
                                            <a href='https://www.cabosetc.com.br/$urlProduto'>
                                                <button type='button' class='btn btn-primary' $flagHabilitado $titleBtnComprar>
                                                    Comprar
                                                </button>
                                            </a>
                                            -->
                                        </div>
                                        <div class='col-sm-3 col-6 mt-2'>
                                            <a href='https://api.whatsapp.com/send?phone=+5521993623164&text=Olá%20Cabos,%20tudo%20bem?%20Gostaria%20de%20informações%20sobre%20seu%20produto%20$nomeProduto,%20código%20$cdProduto,%20anunciado%20por%20R$%20$vlProduto.'>
                                                <button type='button' class='btn btn-success' title='Faça uma pergunta ao vendedor'>
                                                    Whatsapp
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <div class='mt-3'>
                                        <h5>Compartilhe:</h5>
                                    </div>
                                    <div class='col-sm-3 col-6 d-flex flew-row mt-2'> 
                                        <span class=\"\"> <a target=\"_blank\" href=\"https://api.whatsapp.com/send?text=$titleTwitter\n https://www.infoguia.rio.br/$urlProduto\"><img src=\"../img/site/whtsp.jpg\" width=\"32\" height=\"32\"/> </a></span> 
                                        <span class=\"\"> <a target=\"_blank\" href=\"https://www.facebook.com/sharer/sharer.php?t=$titleTwitter&u=https://www.infoguia.rio.br/$urlProduto\"><img src=\"../img/site/fcbk.jpg\" width=\"32\" height=\"32\" /> </a></span> 
                                        <span class=\"\"> <a target=\"_blank\" href=\"https://twitter.com/intent/tweet?text= $titleTwitter&url=https://www.infoguia.rio.br/$urlProduto\"><img src=\"../img/site/twtr.jpg\" width=\"32\" height=\"32\" /> </a></span> 
                                    </div>
                                    

                                </div>
                            </div>   
                        </div>
                        
                        <div class='container mx-auto'>
                            $descricaoProduto
                        </div>    
                        <div class='container mx-auto'>
                            $caracteristicasProduto
                        </div>    
                        <div class='container mx-auto'>
                            $compatibilidadeProduto
                        </div>";    

        ?>
    </div>

<!--



    <div class="board"><h2 class="color">Deixe seu coment&aacute;rio e sua avaliação</h2><br /><div id="comentario_cliente"><form id="form-comments" class="tray-hide" data-logged-user="true" action="/mvc/store/product/add_comment?loja=935261" method="post"><label>
            Nome: 
            <input disabled name="nome_coment" id="nome_coment" class="text" type="text" size="30" value="" required data-message="Campo nome obrigatório. Digite o seu nome completo por favor." data-input-customer="name" /></label><br /><br /><label> E-mail
            <input disabled name="email_coment" id="email_coment" class="text" type="text" size="40" value="" required data-message="Campo email obrigatório. Digite o seu email por favor." data-input-customer="email" /></label><br /><label><input type="checkbox" class="checkbox" value="1" name="ProductComment[show_email]" id="exibe_email" />
            Mostrar meu e-mail
        </label><br /><br /><label><h3>Mensagem</h3><br /><textarea class="textarea" rows="5" name="ProductComment[comment]" id="mensagem_coment" cols="1" style="width: 99%" required data-message="Campo mensagem obrigatório, digite a mensagem por favor"></textarea></label><h5>- Máximo de <span id='restante'>512</span> caracteres.</h5><br /><h3>Clique para Avaliar</h3><br /><div class="rateBlock"><ul class="stars"><li class="starn" data-id="1" data-message="Ruim"></li><li class="starn" data-id="2" data-message="Regular"></li><li class="starn" data-id="3" data-message="Bom"></li><li class="starn" data-id="4" data-message="Ótimo"></li><li class="starn" data-id="5" data-message="Excelente"></li><li class="nota ajuste-nota">Avaliação: <strong id="rate"></strong></li></ul></div><input type="text" style="display: none;" name="ProductComment[rating]" id="nota_comentario" value="" required data-message="Avaliação do produto obrigatória, dê sua avaliação por favor." /><input type="hidden" name="ProductComment[product_id]" value="339"><input type="hidden" name="ProductComment[customer_id]" value="" data-input-customer="id"><img id="bt-submit-comments" src="https://images2.tcdn.com.br/commerce/assets/store/img//enviar.gif" class="image pointer" alt="Enviar" title="Enviar"/></form>

-->



    <!-- Rodapé -->
    <?
        include("rodape.php");
    ?>

    <!-- JS JQuery/Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="../js/produto.js"></script>
</body>
</html>
