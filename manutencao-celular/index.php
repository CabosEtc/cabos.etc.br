<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Google Tag Manager -->
    <script>
        (
            function(w,d,s,l,i){
                w[l]=w[l]||[];
                w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});
                var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
                j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            }
        )
        (window,document,'script','dataLayer','GTM-PCPFWSQ');
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
    <meta name="description" content="Pesquise os melhores preços de informática no Rio de Janeiro.">
    <meta name="keywords" content="comparação,preços,pesquisa,barato,cabos,adaptadores,conversores,placas pci,placa pci express,fontes,fontes para notebook,placa de captura,informatica,hardware,software,segurança,infocentro,edificio central,rio de janeiro,av rio branco,processador,memoria,cpu,camera,disco,video,lcd,placa,hd,monitor,scanner,netbook,notebook,modem,windows,roteador,celular,dvd,intel,amd,apple,android,tablet,impressora">
    <meta name="title" content="Cabos.etc.br | Os melhores preços estão aqui" />
    <meta http-equiv="expires" content="<? echo $dtExpires;?>">
    <link rel="canonical" href="https://www.cabos.etc.br"/>
    <base id="tag_base" href="https://www.cabos.etc.br/"/>
    <!-- OG Propriedades -->
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>
    <meta property="og:title" content="cabos.etc.br | Os melhores preços estão aqui" />
    <meta property="og:description" content="Pesquise os melhores preços de informática no Rio de Janeiro." />
    <meta property="og:phone_number" content="(21) 9999-9999" />
    <meta property="og:street-address" content="Avenida Rio Branco, 156" />
    <meta property="og:locality" content="Rio de Janeiro" />
    <meta property="og:region" content="RJ" />
    <meta property="og:email" content="contato@cabos.etc.br" />
    <meta property="og:image" content="https://www.cabos.etc.br/img/site/cabos256x256.png" />

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
        h1{
            /*font-size: 22px;*/
        }
    </style>

    <title>Cabos.etc.br | Os melhores preços estão aqui</title>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCPFWSQ"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?
    $termo=$_REQUEST["q"];
    echo $termo;
    ?>
    <!-- Topo -->
        <?
            include("topo.php");
        ?>



    <!--Teste-->
    <!--
    <div class="container-fluid">
        <div class="row">
            <div class="col-1 bg-primary">
                    1
            </div>
            <div class="col-1 bg-secondary">
                2
            </div>
            <div class="col-1 bg-success">
                <div class="row">
                    <div class="col-6 bg-warning">
                        3a
                    </div>
                    <div class="col-6 bg-danger">
                        3b
                    </div>
                </div>
            </div>
            <div class="col-1 bg-secondary">
                4
            </div>
        </div>
    </div>
-->

    <!-- Carrosel -->
    <div class="container-fluid mx-auto mb-2" style="padding:0">
        <div id="slideshow" class="carousel slide" data-ride="carousel">
            <!--
            <ol class="carousel-indicators">
                <li data-target="#slideshow" data-slide-to="0" class="active"></li>
                <li data-target="#slideshow" data-slide-to="1"></li>
                <li data-target="#slideshow" data-slide-to="2"></li>
                <li data-target="#slideshow" data-slide-to="3"></li>
            </ol>
            -->

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href="#">
                        <img src="img/banner/1.jpg" class="d-block img-fluid w-100" alt="Primeira imagem" />
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="../artigos.php">
                        <img src="img/banner/2.jpg"  class="d-block img-fluid w-100" alt="Segunda imagem" />
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="#">
                        <img src="img/banner/3.jpg"  class="d-block img-fluid w-100" alt="Terceira imagem" />
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="../artigos.php">
                        <img src="img/banner/4.jpg"  class="d-block img-fluid w-100" alt="Quarta imagem" />
                    </a>
                </div>
            </div>

            <a href="#slideshow" class="carousel-control-prev" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a href="#slideshow" class="carousel-control-next" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Próximo</span>
            </a>
        </div>
    </div>

    <!-- Ofertas do dia -->
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
