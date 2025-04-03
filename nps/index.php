<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação de Atendimento</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fonte Oswald -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        h1 {
            font-family: 'Oswald', sans-serif;
            color: #FF8000;
        }
        .emoji-layer {
            display: none;
        }
        .emoji-layer.active {
            display: block;
        }
        .emojis img {
            width: 70px;
            cursor: pointer;
            margin: 0 15px;
        }
        .thanks-message {
            font-size: 28px;
            color: #FF8000;
        }
        .container-fluid {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>

    <div class="container-fluid text-center">
        <div class="row justify-content-center">
            <!-- Camada 1: Seleção de Emojis -->
            <div class="col-12 emoji-layer active" id="emojiLayer">
                <h1>Como foi o seu atendimento?</h1>
                <div class="emojis mt-4">
                    <img src="imagens\red.png" alt="Péssimo" data-value="1">
                    <img src="imagens\orange.png" alt="Ruim" data-value="2">
                    <img src="imagens\yellow.png" alt="Neutro" data-value="3">
                    <img src="imagens\light-green.png" alt="Bom" data-value="4">
                    <img src="imagens\green.png" alt="Excelente" data-value="5">
                </div>
            </div>

            <!-- Camada 2: Agradecimento -->
            <div class="col-12 emoji-layer" id="thanksLayer">
                <div class="thanks-message">Obrigado pela sua avaliação!</div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            // Quando o cliente clicar em um emoji
            $(".emojis img").click(function () {
                let satisfaction = $(this).data("value");

                // Fazendo a requisição AJAX
                $.ajax({
                    url: "save.php",
                    method: "POST",
                    data: { nivel_satisfacao: satisfaction },
                    success: function (response) {
                        // Mostra a camada de agradecimento
                        $("#emojiLayer").removeClass("active");
                        $("#thanksLayer").addClass("active");

                        // Retorna para a camada inicial após 3 segundos
                        setTimeout(function () {
                            $("#thanksLayer").removeClass("active");
                            $("#emojiLayer").addClass("active");
                        }, 3000);
                    }
                });
            });
        });
    </script>
</body>
</html>