<!DOCTYPE html>
<html>
<head>
    <title>Bootstrap</title>
    <meta charset="UTF8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
</head>
<body style="margin-top:60px;">
<?php require_once "menu.php" ?>
<div class="container">
    <h1>Bootstrap</h1>

    <h3 id="imagens">Imagens</h3>
    <p>
    <a href="https://www.udemy.com/course/bootstrap-4-completo/learn/lecture/7898758#overview" target="_blank">Visitar</a>
    Como tornar imagens responsivas.
    </p>
    <div class="row">
    <div class="col12"><img class="img-fluid" src="../../imagens/ufo.png" /></div>
    </div>    
    <code>
    <? echo htmlentities('<img class="img-fluid" src="../../imagens/ufo.png" />'); ?>
    </code>
    
    <h3 id="figure">Figure</h3>
    <p>
    <a href="https://www.udemy.com/course/bootstrap-4-completo/learn/lecture/7898822#overview" target="_blank">Visitar</a>
    Imagens que possuem uma descrição no rodapé
    </p>
    <figure class="figure">
    <img src="../../imagens/emconstrucao.png" class="figure-img img-fluid rounded" alt="Uma imagem de espaço reservado quadrada, genérica e com cantos arredondados.">
    <figcaption class="figure-caption text-right">Em construção...</figcaption>
    </figure>
    
    <h3 id="tabelas">Tabelas</h3>
    <p>
    <a href="https://www.udemy.com/course/bootstrap-4-completo/learn/lecture/7898784#overview" target="_blank">Visitar</a>
    </p>
    <div class="container">
        <div class="row">
            <div class="col"> 
                <table class="table table-secondary table-bordered">
                    <thead class="thead-default">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>sobrenome</th>
                            <th>Idade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Flávio</td>
                            <td>Grande da Luz</td>
                            <td>52</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Denise</td>
                            <td>Miccolis</td>
                            <td>37</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Daniel</td>
                            <td>Ramalho da Luz</td>
                            <td>22</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <h3 id="layout">Layout</h3>
    <p>
    <a href="https://www.udemy.com/course/bootstrap-4-completo/learn/lecture/7898480#overview" target="_blank">Visitar</a>
    </p>

    <h3 id="grid">Sistema de Grid</h3>
    <h5>container/row/col</h5>
    <p>
    <a href="https://www.udemy.com/course/bootstrap-4-completo/learn/lecture/7898646#overview" target="_blank">Visitar</a>
    </p>    
    
    <h3 id="navegacao">Barras de navegação</h3>
    <p>
    <a href="https://www.udemy.com/course/bootstrap-4-completo/learn/lecture/8299282#overview" target="_blank">Visitar</a>
    </p>

    <h3 id="alert">Alertas</h3>
    <p>
    <a href="" target="_blank">Visitar</a>
    </p>

    <div class="row">
        <div class="col-6">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Título do meu alert</h4>
                <p>
                Este é um alerta! <a class="alert-link" href="#"> Clique aqui</a> para prosseguir
                </p>
                <p>
                Fugiat ad nulla excepteur Lorem velit cillum consequat exercitation esse non. Ad id dolor laboris voluptate laboris culpa. Nulla aliqua do commodo cillum nostrud.
                </p>
                <p>
                Velit duis sunt excepteur in. Pariatur nulla voluptate et dolor ipsum nostrud laborum excepteur eiusmod in. Ut est nulla occaecat id mollit. Sit ullamco enim nulla culpa voluptate magna ad. Deserunt irure nostrud magna qui adipisicing enim cillum in sit exercitation non excepteur proident ullamco. Dolor laboris et commodo enim proident.
                </p>
            </div>
        </div>
    </div>


    <h3 id="badges">Badges</h3>
    <p>
    <a href="" target="_blank">Visitar</a>
    </p>
    <div class="row">
        <div class="col-12">
        <h1>Exemplo de cabeçalho <span class="badge badge-primary">Novo</span></h1>
        </div>
    </div>
    <div class="row">
        <button class="btn">
        Notificações <span class="badge badge-primary">5</span>
        </button>
    </div>


    <h3 id="breadcrumb">Breadcrumb</h3>
    <p>
    <a href="" target="_blank">Visitar</a>
    </p>
    <div class="row">
        <div class="col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="#">Home</a></li>
                <li class="breadcrumb-item active"><a href="#">Biblioteca</a></li>
                <li class="breadcrumb-item active"><a href="#">Item</a></li>
            </ol>
        </div>
    </div>



    <h3 id="botoes">Botões</h3>
    <p>
    <a href="" target="_blank">Visitar</a> O botão Info está usando a classe outline, o botão warning está desativado.
    </p>
    <p>
    Note que disabled é <mark>estado</mark>, não é classe.
    </p>
    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary">Primário</button>
            <input type="button" class="btn btn-secondary" value="Secondary"> 
            <input type="button" class="btn btn-success" value="Sucess">
            <input type="button" class="btn btn-danger" value="Danger">
            <input type="button" class="btn btn-warning" disabled value="Warning">
            <input type="button" class="btn btn-outline-info" value="Info">
            <input type="button" class="btn btn-light" value="Light">
            <input type="button" class="btn btn-dark" value="Dark">
            <input type="button" class="btn btn-link" value="Link">
            
        </div>
    </div>

    <h3 id="grupobotoes">Grupo de Botões</h3>
    <p>
    <a href="" target="_blank">Visitar</a> Útil para criar um painel de comandos, tipo play/stop/pause/rec.
    </p>

    <h3 id="cards">Cards</h3>
    <p>
    <a href="" target="_blank">Visitar</a> O exemplo abaixo tambem poderia ter itens não ordenados, ver exemplo no video.
    </p>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">Teste</div>
                <img class="card-img-top" src="../../imagens/moreninha.jpg" />
                <div class="card-body">
                <h4 class="card-title">Ilha de Paquetá</h4>
                <h6 class="card-subtitle">Praia da Moreninha</h6>
                <p class="card-text">
                Incididunt excepteur veniam exercitation dolor deserunt consectetur proident anim. Cupidatat culpa in adipisicing dolore excepteur. Aute sit do amet Lorem et. Mollit ea officia incididunt incididunt commodo veniam cillum labore.
                </p>
                <a class="card-link" href="#">Link do cartão</a>
                </div>
                <div class="card-footer">Rodapé</div>           
            </div>           
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-6">
            <div class="card">
                <div class="card-header">Teste</div>
                <div class="card-body">
                <h4 class="card-title">Ilha de Paquetá</h4>
                <h6 class="card-subtitle">Praia da Moreninha</h6>
                <input class="btn btn-warning" value="Visitar">
                <p class="card-text">
                Incididunt excepteur veniam exercitation dolor deserunt consectetur proident anim. Cupidatat culpa in adipisicing dolore excepteur. Aute sit do amet Lorem et. Mollit ea officia incididunt incididunt commodo veniam cillum labore.
                </p>
                <a class="card-link" href="#">Link do cartão</a>
                </div>
                <img class="card-img-bottom" src="../../imagens/moreninha.jpg" />
            </div>           
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-6">
            <div class="card bd-dark text-white">
                <img class="card-img" src="../../imagens/moreninha.jpg" />
                <div class="card-img-overlay">
                    <h4 class="card-title">Ilha de Paquetá</h4>
                    <h6 class="card-subtitle">Praia da Moreninha</h6>
                    <p class="card-text mt-2">
                        Incididunt excepteur veniam exercitation dolor deserunt consectetur proident anim. Cupidatat culpa in adipisicing dolore excepteur. Aute sit do amet Lorem et. Mollit ea officia incididunt incididunt commodo veniam cillum labore.
                    </p>
                    <a class="card-link bg-light" href="#">Link do cartão</a>
                </div>
                
            </div>           
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- É preciso incluir o jquery.mask abaixo -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</div>
</body>
</html>