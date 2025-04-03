<?
    //Prepara conexao ao db
    //include("conectaDBMysqli.php");
    $raiz_site=$_SERVER['DOCUMENT_ROOT'];
?>
    

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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Cabos e Etc Informática Ltda">
    <meta name="keywords" content="cabos e etc,cabos & etc,cabos e etc informatica ltda,cabos & etc informatica ltda,edificio avenidade central,infocentro,rio de janeiro">

<?  
    echo "<title>Cabos & Etc Informática</title>\n";
    echo "\t<meta name=\"theme-color\" content=\"#ff6600\">\n";

?>

    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../css/estilo.css">



    <!-- Fonte Oswald -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet"> 

    <style>
    h1, h2, h3{
        font-family: 'Oswald', sans-serif;
        color: #4B0082;
    }
    </style>

</head>
<body>
    <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PZHZ5PB"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
    <!-- End Google Tag Manager (noscript) -->
   
    <!-- Topo -->
    <?
        include("$raiz_site/topo.php");
    ?>



    
<!-- Termo pesquisado --> 
    <div class="container">
        <div class="container mx-auto">
           <?
            echo $nome;
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

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <h1>Cabos & Etc Informática</h1>
            <h2>Av Rio Branco, 156 Loja 329 Stand M</h2>
            <div class='my-2'><img src="../img/mapas/1.jpg" alt="mapa de localização"/></div>
        </div>
        <div class="col-lg-6 col-sm-12 p-1">
            <h2 class=''>Informações</h2>
            <h3 mt-2>Telefone</h3>
            <p>(21) 3420-3366</p>
            <h3>Whatsapp</h3>
            <p>(21) 99362-3164</p>
            <h3>Site</h3>
            <p><a href="https://www.cabosetc.com.br">www.cabosetc.com.br</a></p>
            <h3>Email</h3>
            <p><a href="mailto:cabosetcinfo@gmail.com?subject=Cabos%20&amp;Etc%20-%20Informações">Enviar email</a></p>
        </div>
    </div>
</div>
<div mt-3>
    &nbsp;
</div>
    <!-- Rodapé -->
    <?
        include("../rodape.php");
    ?>

    <!-- JS JQuery/Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="../js/produto.js"></script>
</body>
</html>
