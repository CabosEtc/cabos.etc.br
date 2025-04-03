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
        //ini_set('display_errors', 1);
        //Prepara conexao ao db
	    //include("../conectadb.php");
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
    <meta name="title" content="Drivers | cabos.etc.br" />
    <meta http-equiv="expires" content="<? echo $dtExpires;?>">
    <link rel="canonical" href="https://www.infoguia.rio.br/artigos.php"/>
    <base id="tag_base" href="http://www.cabos.etc.br/"/>
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

    <title>Drivers | cabos.etc.br</title>

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
    //echo $termo;
    ?>
    <!-- Topo -->
        <?
            //include("../topo.php");
        ?>



    <!-- Carrosel -->
    <div class="container mx-auto my-2">
        <div class='mt-5'>
            <h1>Drivers:</h1>
            <p class="text-muted">
                Publicações (listadas por ordem do código SKU) 
            </p>
        </div>


        <div class="container">


            <div class="row">
                <div class="col-6 col-lg-4 p-2">
                    <figure class="figure">
                        <a href="">
                            <img class="img-fluid" src='../img/produtos/01002.jpg' alt='Easycap.'/>
                        </a>
                        <figcaption class="figure-caption text-right">
                            19/06/21
                        </figcaption>
                    </figure>
                </div>
                <div class="col-6 col-lg-8 mt-0 mb-auto p-2">
                    <h2>Easycap.</h2>
                    <div>
                        <p class="text-muted">
                            SKU: 01002
                        </p>

                        <p class="text-muted">
                            Id de Hardware: AV TO USB2.0 USB\VID_534D&PID_0021&REV_0121&MI_02 - USB\VID_534D&PID_0021&MI_02
                        </p>
                        <p class="text-muted">
                            Clique <a href='https://www.cabos.etc.br/drivers/01002_19Jun21.zip'>aqui</a> para download do driver/programa.
                        </p>
                        <p class="text-primary">
                            Compatibilidade:
                        </p>
                        <ul>
                            <li class="text-muted">
                                Windows XP/Vista/Win7/Win8 e Win10, não é compativel com Mac OS.
                            </li>
                        </ul>
                        <p class="text-primary">
                            Dicas de instalação:
                        </p>
                        <ul>
                            <li class="text-muted">
                                Não plugue o dispositivo na porta USB antes de instalar o programa acima.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-6 col-lg-4 p-2">
                    <figure class="figure">
                        <a href="">
                            <img class="img-fluid" src='../img/produtos/01159.jpg' alt='Cabo Usb 3.0 VGA.'/>
                        </a>
                        <figcaption class="figure-caption text-right">
                            17/07/21
                        </figcaption>
                    </figure>
                </div>

                <div class="col-6 col-lg-8 mt-0 mb-auto p-2">
                    <h2>Cabo usb 3.0 VGA.</h2>
                    <div>
                        <p class="text-muted">
                            SKU: 01159A
                        </p>
                        <p class="text-muted">
                            Id de Hardware: MS USB Display - USB\VID_534D&PID_6021&REV_0110&MI_03 USB\VID_534D&PID_6021&MI_03

                        </p>
                        <p class="text-muted">
                            Clique <a href='https://www.cabos.etc.br/drivers/downloads/01159A_03Abr25.zip'>aqui</a> para download do driver.
                        </p>
                        <p class="text-primary">
                            Conteúdo do disco:
                        </p>
                        <ul>
                            <li class="text-muted">
                                MSDisplay_MultiDev_v1.0.1.60.exe  - Driver para Windows 7, 8, 8.1, 10 e 11
                            </li>
                        </ul>
                    </div>
                    <!--
                    <div>
                        <p class="text-muted">
                            SKU: 01159B
                        </p>
                        <p class="text-muted">
                            Id de Hardware: MS USB 2.0 Display USB\VID_534D&PID_6021&REV_01&MI_03 - USB\VID_534D&PID_6021&MI_03
                        </p>
                        <p class="text-muted">
                            Clique <a href='https://www.cabos.etc.br/drivers/01159_17Jan23.zip'>aqui</a> para download do driver.
                        </p>
                        <p class="text-primary">
                            Conteúdo do disco:
                        </p>
                        <ul>
                            <li class="text-muted">
                                FL2000-2.1.36287.0 - Driver para Windows 7, 8, 8.1, 10 e 11
                            </li>
                        </ul>
                    </div>
                    -->


                    <div>
                        <p class="text-primary">
                            Dicas de instalação:
                        </p>
                        <ul>
                            <li class="text-muted">
                                Plugue o dispositivo na porta usb 3.0 (se você só tiver portas usb 2.0, ele vai funcionar, mas somente com resolução 800x600)
                             </li>
                            <li class="text-muted">
                                Rode o disco de instalação e escolha o driver correto, cfe lista acima. Se você instalar o driver errado, será necessário desinstala-lo e reiniciar o computador.
                            </li>
                            <li class="text-muted">
                                Reinicie o computador, será criado um ícone próximo ao relógio, na barra de tarefas. Neste aplicativo você poderá ver se a placa está plugada ou não. Para escolherá entre duplicar ou estender o conteúdo da tela, tecle a tecla Windows+P.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-6 col-lg-4 p-2">
                    <figure class="figure">
                        <a href="">
                            <img class="img-fluid" src='../img/produtos/01160.jpg' alt='Cabo Usb 3.0 Hdmi.'/>
                        </a>
                        <figcaption class="figure-caption text-right">
                            07/12/22
                        </figcaption>
                    </figure>
                </div>
                <div class="col-6 col-lg-8 mt-0 mb-auto p-2">
                    <h2>Cabo usb 3.0 Hdmi.</h2>
                    <div>
                        <p class="text-muted">
                            SKU: 01160
                        </p>
                        <p class="text-muted">
                            Clique <a href='https://www.cabos.etc.br/drivers/01160_07Dez22.zip'>aqui</a> para download do driver mais atual (incluindo o Windows 11).
                        </p>
                        <p class="text-primary">
                            Conteúdo do disco:
                        </p>
                        <ul>
                            <li class="text-muted">
                                MSDisplay_Windows_V2.0.1.7.3.exe - Driver para Windows 7, 8, 8.1, 10 e 11
                            </p>
                            <li class="text-muted">
                                MSDisplay_v1.0.0.0_XP.exe - Driver para Windows XP
                            </p>
                            <li class="text-muted">
                                MSDisplay_MacOS_V2.0.0.1_20220606.dmg - Driver para Mac OS
                            </p>
                            <li class="text-muted">
                                MSDisplay_Android_V2.0.1.3.apk - Driver para Android
                            </li>
                        </ul>

                        <p class="text-muted">
                            Clique <a href='https://www.cabos.etc.br/drivers/01160_12Jun21.zip'>aqui</a> para download do driver mais antigo (Windows até o 10).
                        </p>
                        <p class="text-primary">
                            Dicas de instalação:
                        </p>
                        <ul>
                            <li class="text-muted">
                                Plugue o dispositivo na porta usb 3.0 (se você só tiver portas usb 2.0, ele vai funcionará bem em resoluções menores).
                             </li>
                            <li class="text-muted">
                                Faça o download e descompacte os arquivos, escolha o driver correto, conforme lista acima. Se você instalar o driver errado, será necessário desinstala-lo usando o mesmo programa de instalação e reiniciando o computador em seguida.
                            </li>
                            <li class="text-muted">
                                Reinicie o computador, será criado um ícone próximo ao relógio, na barra de tarefas. Neste aplicativo você escolherá entre duplicar ou estender o conteúdo da tela.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>




            <div class="row">
                <div class="col-6 col-lg-4 p-2">
                    <figure class="figure">
                        <a href="">
                            <img class="img-fluid" src='../img/produtos/03003.jpg' alt='Cabo Usb serial.'/>
                        </a>
                        <figcaption class="figure-caption text-right">
                            19/05/21
                        </figcaption>
                    </figure>
                </div>
                <div class="col-6 col-lg-8 mt-0 mb-auto p-2">
                    <h2>Cabo usb serial 9 pinos.</h2>
                    <div>
                        <p class="text-muted">
                            SKU: 03003
                        </p>
                        <p class="text-muted">
                            Clique <a href='https://www.cabos.etc.br/drivers/03003_19Mai21.zip'>aqui</a> para download do driver.
                        </p>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-6 col-lg-4 p-2">
                    <figure class="figure">
                        <a href="">
                            <img class="img-fluid" src='../img/produtos/10057.jpg' alt='Adaptador de rede usb.'/>
                        </a>
                        <figcaption class="figure-caption text-right">
                            15/05/21
                        </figcaption>
                    </figure>
                </div>
                <div class="col-6 col-lg-8 mt-0 mb-auto p-2">
                    <h2>Adaptador de rede usb.</h2>
                    <div>
                        <p class="text-muted">
                            SKU: 10057
                        </p>
                        <p class="text-muted">
                            Clique <a href='https://www.cabos.etc.br/drivers/10057_15Mai21.zip'>aqui</a> para download do driver.
                        </p>
                    </div>
                </div>
            </div>
            

            <div class="row">
                <div class="col-6 col-lg-4 p-2">
                    <figure class="figure">
                        <a href="">
                            <img class="img-fluid" src='../img/produtos/10077.jpg' alt='Adaptador de rede wifi 150Mbps usb.'/>
                        </a>
                        <figcaption class="figure-caption text-right">
                            24/06/21
                        </figcaption>
                    </figure>
                </div>
                <div class="col-6 col-lg-8 mt-0 mb-auto p-2">
                    <h2>Adaptador de rede wifi 150Mbps usb - Realtek 8188EU.</h2>
                    <div>
                        <p class="text-muted">
                            SKU: 10077
                        </p>
                        <p class="text-muted">
                            Clique <a href='https://www.cabos.etc.br/drivers/10077_24Jun21.zip'>aqui</a> para download do driver.
                        </p>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-6 col-lg-4 p-2">
                    <figure class="figure">
                        <a href="">
                            <img class="img-fluid" src='../img/produtos/40010.jpg' alt='Adaptador de rede wifi Dual band 600Mbps usb.'/>
                        </a>
                        <figcaption class="figure-caption text-right">
                            09/07/21
                        </figcaption>
                    </figure>
                </div>
                <div class="col-6 col-lg-8 mt-0 mb-auto p-2">
                    <h2>Adaptador de rede wifi Dual band 600Mbps usb - Realtek 8811CU.</h2>
                    <div>
                        <p class="text-muted">
                            SKU: 40010
                        </p>
                        <p class="text-muted">
                            Clique <a href='https://www.cabos.etc.br/drivers/40010_09Jul21.zip'>aqui</a> para download do driver.
                        </p>
                        <p class="text-muted">
                            Descompacte o arquivo e execute o programa Setup.exe.
                        </p>
                    </div>
                </div>
            </div>




            <div class="row">
                <div class="col-6 col-lg-4 p-2">
                    <figure class="figure">
                        <a href="">
                            <img class="img-fluid" src='../img/produtos/40058.jpg' alt='Adaptador de rede wifi 150Mbps usb - Mediatek MT7601U.'/>
                        </a>
                        <figcaption class="figure-caption text-right">
                            28/07/21
                        </figcaption>
                    </figure>
                </div>
                <div class="col-6 col-lg-8 mt-0 mb-auto p-2">
                    <h2>Adaptador de rede wifi 150Mbps usb - Mediatek MT7601U.</h2>
                    <div>
                        <p class="text-muted">
                            SKU: 40058
                        </p>
                        <p class="text-muted">
                            Clique <a href='https://www.cabos.etc.br/drivers/40058_28Jul21.zip'>aqui</a> para download do driver.
                        </p>
                        <p class="text-muted">
                            Descompacte o arquivo e execute o arquivo .exe, plugue o dispositivo e reinicie o computador.
                        </p>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-6 col-lg-4 p-2">
                    <figure class="figure">
                        <a href="">
                            <img class="img-fluid" src='../img/produtos/40060.jpg' alt='Adaptador de rede wifi 150Mbps usb com antena- Mediatek MT7601U.'/>
                        </a>
                        <figcaption class="figure-caption text-right">
                            24/08/21
                        </figcaption>
                    </figure>
                </div>
                <div class="col-6 col-lg-8 mt-0 mb-auto p-2">
                    <h2>Adaptador de rede wifi 150Mbps usb  com antena - Mediatek MT7601U.</h2>
                    <div>
                        <p class="text-muted">
                            SKU: 40060
                        </p>
                        <p class="text-muted">
                            Clique <a href='https://www.cabos.etc.br/drivers/40060_24Ago21.zip'>aqui</a> para download do driver.
                        </p>
                        <p class="text-muted">
                            Descompacte o arquivo e execute o arquivo .exe da pasta Windows, plugue o dispositivo e reinicie o computador.
                        </p>
                    </div>
                </div>
            </div>





            <div class="row">
                <div class="col-6 col-lg-4 p-2">
                    <figure class="figure">
                        <a href="">
                            <img class="img-fluid" src='../img/produtos/50134.jpg' alt='Cabo Console Ativo Usb x RJ45 Macho.'/>
                        </a>
                        <figcaption class="figure-caption text-right">
                            27/07/21
                        </figcaption>
                    </figure>
                </div>
                <div class="col-6 col-lg-8 mt-0 mb-auto p-2">
                    <h2>Cabo Console Ativo Usb x RJ45 Macho.</h2>
                    <div>
                        <p class="text-muted">
                            SKU: 50134
                        </p>
                        <p class="text-muted">
                            Clique <a href='https://www.cabos.etc.br/drivers/50134_27Jul21.zip'>aqui</a> para download do driver.
                        </p>
                        <p class="text-muted">
                            Descompacte o arquivo e siga as instruções do arquivo leia-me.txt
                        </p>
                    </div>
                </div>
            </div>




        </div>
    </div>
    <!-- Ofertas do dia -->
    <div  class="mt-5">
        &nbsp;
    </div>
    <?
        include("../ofertas.php");
    ?>    

    <!-- Rodapé -->
    <?
        include("../rodape.php");
    ?>

    <!-- JS JQuery/Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
