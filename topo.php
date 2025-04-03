<div class="container-fluid backgroundTopo" id="banner">
    <header class="container">
        <a href="/" class="navbar-brand">
            <img src="/img/site/cabosetc.png" height="90" class="d-inline-block align-top" alt="cabos.etc.br"/>
        </a>

        <!-- Barra de pesquisas --> 
        <!-- Ver https://getbootstrap.com/docs/4.0/components/forms/ -->
        <div class="container-fluid backgroundTopo" id="barraPesquisa">
            <div class="row">
                <!-- offset faz ele ocupar colunas na frente-->
                <div class="col-sm-12 offset-md-6 col-md-6 my-2">
                    <form class="form-row" action="/busca">
                        <div class="input-group">
                            <input class="form-control form-control-sm mr-1" type="text" placeholder="Pesquisar"  name="q" id="q" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark justify-content-center">
            
            
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Menu Colapso">
            <span class="navbar-toggler-icon text-light"></span>
        </button>

        <div id="menu" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto text-light">
                <?
                    //ini_set('display_errors', 1);
                
                    $queryCategoria="   SELECT idcategoria, cdcategoria, categoria 
                                        FROM `categoria` 
                                        WHERE flagativo='1' 
                                        AND cdloja='1' 
                                        ORDER BY ordenacao "; // unica por enquanto
                    //echo "$queryCategoria<br>";
                    //$resultadoCategoria = mysql_query($queryCategoria,$conexao);
                    if (!$resultadoCategoria = $conexao->query($queryCategoria)) {
                        echo "Desculpe, estamos com problema, favor retornar mais tarde.";
                        exit;
                    }
                    
                    
                    //while ($row = mysql_fetch_array($resultadoCategoria, MYSQL_NUM)) {
                    //while ($rowCategoria = $resultadoCategoria->fetch_assoc()) {


                    //while {$rowCategoria=$resultadoCategoria->fetch_array(MYSQLI_ASSOC); // pode ser NUM ou BOTH
                    while ($rowCategoria = $resultadoCategoria->fetch_assoc()) {
                        //$vlVendaSite=mysql_result($resultadoPreco,0,0);

                        $idCategoria=$rowCategoria['idcategoria'];
                        $categoria=$rowCategoria['categoria'];
                        //echo "<div>$categoria</div>";
                        
                        echo"
                            <li class='nav-item dropdown'>
                                <a href='#' class='nav-link dropdown-toggle text-light font-weight-bold' role='button' data-toggle='dropdown' >
                                    $categoria
                                </a>
                                <div class='dropdown-menu'>";
                                    $querySubCategoria="   SELECT idcategoria, caminho, descricao  
                                                            FROM `subcategoria` 
                                                            WHERE flagativo='1' 
                                                            AND idcategoria=$idCategoria 
                                                            AND cdloja='1' "; // unica por enquanto
                                    //$resultadoSubCategoria = mysql_query($querySubCategoria,$conexao);
                                    if (!$resultadoSubCategoria = $conexao->query($querySubCategoria)) {
                                        echo "Desculpe, estamos com problema, favor retornar mais tarde.";
                                        exit;
                                    }
                                    //while ($rowSubcategoria = mysql_fetch_array($resultadoSubCategoria, MYSQL_NUM)) {
                                        //while ($rowSubcategoria = $resultadoSubCategoria->fetch_assoc()) {
                                    //while {$rowSubcategoria=$resultadoSubCategoria->fetch_array(MYSQLI_ASSOC); // pode ser NUM ou BOTH
                                    while ($rowSubCategoria = $resultadoSubCategoria->fetch_assoc()) {
                                        $idCategoria=$rowSubCategoria['idcategoria'];
                                        $caminho=$rowSubCategoria['caminho'];
                                        $descricao=$rowSubCategoria['descricao'];
                                        echo"<a class='dropdown-item' href='/c/$caminho'>$descricao</a>";
                                    }
                        echo"
                                </div>
                            </li>
                            ";
                            
                    
                    }
                            
                ?>
            </ul>
        </div>
            
    </nav> 
</div>

