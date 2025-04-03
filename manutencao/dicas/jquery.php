<!DOCTYPE html>
<html>
<head>
    <title>JQuery</title>
    <meta charset="UTF8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php require_once "menu.php" ?>

    <div id="css"><h1>JQuery</h1></div>
    <h3>Como formatar campos de CPF, CEP, Telefone e moeda com jQuery (jMask)</h3>
    <a href="https://www.blogson.com.br/como-formatar-campos-de-cpf-cep-telefone-e-moeda-com-jquery-jmask/" target="_blank">Fonte</a>
    <PRE>
    </PRE>

    <div class="form-row">
        <div class="form-group col-md-4">
            <label>CPF</label>
            <input type="text" class="form-control" onkeypress="$(this).mask('000.000.000-00');">
            <!-- Este codigo só funciona em html 5 
            <input type="text" minlength="14" maxlength="14" class="form-control" onkeypress="$(this).mask('000.000.000-00');">
            -->
        </div>
        <div class="form-group col-md-4">
            <label>CNPJ</label>
            <input type="text" class="form-control" onkeypress="$(this).mask('00.000.000/0000-00')">
        </div>
        <div class="form-group col-md-4">
            <label>CEP</label>
            <input type="text" class="form-control" onkeypress="$(this).mask('00.000-000')">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            <label>Altura / Peso</label>
            <input type="text" class="form-control" onkeypress="$(this).mask('90,00')">
        </div>
        <div class="form-group col-md-4">
            <label>Moeda / Dinheiro</label>
            <input type="text" class="form-control" onkeypress="$(this).mask('#.##0,00', {reverse: true});">
        </div>
        <div class="form-group col-md-4">
            <label>Telefone</label>
            <input type="text" class="form-control" onkeypress="$(this).mask('(00) 0000-00009')">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            <label>Data</label>
            <input type="text" class="form-control" onkeypress="$(this).mask('00/00/0000')">
        </div>
        <div class="form-group col-md-4">
            <label>Hora</label>
            <input type="text" class="form-control" onkeypress="$(this).mask('00:00')">
            <!--
            <input type="text" class="form-control" onkeypress="$(this).mask('00h 00m')">
            -->
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!-- É preciso incluir o jquery.mask abaixo -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>