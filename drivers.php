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
    <?
        $dtExpires=date("D, d M Y",strtotime('+1 days'))." 00:00:00 GMT";
        //echo "$dtExpires<br>";
    ?>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="icon" href="../img/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Sobre icones, temas, e outras configurações -->
    <!-- https://developers.google.com/web/fundamentals/design-and-ux/browser-customization?hl=pt -->
    <meta name="theme-color" content="#ff6600">
    <meta name="robots" content="FOLLOW,INDEX,ALL"/>
    <meta name="description" content="Tire suas dúvidas sobre assuntos relacionados a Informática">
    <meta name="keywords" content="diferença entre cabo de rede cat5 e cat6,diagrama de cabos de rede,padrão 568a x 568b">
    <meta name="title" content="Artigos | Infoguia.rio.br" />
    <meta http-equiv="expires" content="<? echo $dtExpires;?>">
    <link rel="canonical" href="https://www.infoguia.rio.br/artigos.php"/>
    <base id="tag_base" href="https://www.infoguia.rio.br/"/>
    <!-- OG Propriedades -->
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>
    <meta property="og:locale" content="pt_BR">
    
    <meta property="og:site_name" content="Infoguia Rio">
    <meta property="og:title" content="Artigos | Infoguia.rio.br" />
    <meta property="og:description" content="Tire suas dúvidas sobre assuntos relacionados a Informática" />
    <meta property="og:phone_number" content="(21) 3420-3366" />
    <meta property="og:street-address" content="Avenida Rio Branco, 156" />
    <meta property="og:locality" content="Rio de Janeiro" />
    <meta property="og:region" content="RJ" />
    <meta property="og:email" content="webmaster@infoguia.rio.br" />
    <meta property="og:image" content="https://www.infoguia.rio.br/artigos/img/artigos.jpg" />
    <meta property="og:image:alt" content="artigos">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="250">
    <meta property="og:image:height" content="250">

    <!-- Em teste OG Article -->
    <!-- Fonte https://tableless.com.br/utilizando-meta-tags-facebook/ -->
    <meta property="og:type" content="article">
    <meta property="article:author" content="Flávio Grande">
    <meta property="article:section" content="Artigos">
    <meta property="article:tag" content="cabo,rede,cat5e,cat6,cat7,cat8,comparação,tipos,blindado,568a,568b">
    <meta property="article:published_time" content="2021-04-10">
    <meta property="article:modified_time" content="2021-04-10" />
    


    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/estilo.css">

    <!-- Fonte Oswald -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet"> 

    <style>
        h1, h2, h3{
            font-family: 'Oswald', sans-serif;
            color: #4B0082;
        }
    </style>

    <title>Artigos | Infoguia.rio.br</title>

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

</head>

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
    echo $termo;
    ?>
    <!-- Topo -->
        <?
            include("topo.php");
        ?>



    <!-- Carrosel -->
    <div class="container mx-auto my-2">
        <div class='mt-5'>
            <h1>Drivers:</h1>
            <p class="text-muted">
                Publicações de 2021 
            </p>

        </div>


        <div class="container">
            <div class="row">
                <div class="col-6 col-lg-4 p-2">
                    <figure class="figure">
                        <a href="../artigos/diferenca-entre-cabos-de-rede-cat5e-cat6-cat7-cat8">
                            <img class="img-fluid" src='/img/produtos/03003.jpg' alt='Cabo Usb serial.'/>
                        </a>
                        <figcaption class="figure-caption text-right">
                            19/05/21
                        </figcaption>
                    </figure>
                </div>
                <div class="col-6 col-lg-8 my-auto p-2">
                    <h2>Cabo usb serial 9 pinos.</h2>
                    <div>
                        <p class="text-muted">
                            Clique <a href='/drivers/03003_19Mai21.zip'>aqui</a> para download do driver.
                        </p>
                    </div>
                </div>
            </div>

            




    </div>
    <!-- Ofertas do dia -->
    <div  class="mt-5">
        &nbsp;
    </div>
    <?
        include("ofertas.php");
    ?>    

    <!-- Rodapé -->
    <?
        include("rodape.php");
    ?>

    <!-- JS JQuery/Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
