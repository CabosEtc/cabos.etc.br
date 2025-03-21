<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabos e Etc - Consertos de Celulares</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos customizados */
        .banner {
            background: url('banner-image.jpg') no-repeat center center;
            background-size: cover;
            color: white;
            text-align: center;
            padding: 100px 0;
        }
        .servico {
            padding: 20px;
        }
        .bg-primary {
            background-color: #FF8000 !important; /* Laranja */
        }
        .bg-secondary {
            background-color: #0000FF !important; /* Azul */
        }
        .text-highlight {
            color: #00FF00 !important; /* Verde */
        }
        .bg-light {
            background-color: #f8f9fa !important;
        }
        .btn-highlight {
            background-color: #FF8000 !important; /* Laranja */
            border-color: #FF8000 !important;
            color: white !important;
        }
        .btn-highlight:hover {
            background-color: #e67300 !important; /* Laranja escuro */
            border-color: #e67300 !important;
        }
        .whatsapp-link {
            text-align: center;
            margin-bottom: 20px;
        }
        .whatsapp-link svg {
            width: 50px;
            height: 50px;
            fill: #25D366; /* Cor do ícone do WhatsApp */
        }
    </style>
</head>
<body>

    <!-- Incluir Cabeçalho -->
    <?php include 'header.php'; ?>

    <!-- Banner Principal -->
    <section class="banner">
        <div class="container">
            <h2>Seu celular quebrado? Nós consertamos!</h2>
            <p>Serviços rápidos e de qualidade</p>
            <a href="#servicos" class="btn btn-highlight">Saiba Mais</a>
        </div>
    </section>

    <!-- Seção de Serviços -->
    <section id="servicos" class="py-5">
        <div class="container">
            <h3 class="text-center text-primary">Nossos Serviços</h3>
            <div class="row">
                <!-- Exemplo de serviço -->
                <div class="col-md-4 servico">
                    <h4 class="text-secondary">Troca de Tela</h4>
                    <p>Substituímos a tela do seu celular com rapidez e eficiência.</p>
                    <a href="#contato" class="btn btn-primary">Agendar</a>
                </div>
                <!-- Adicionar mais serviços conforme necessário -->
            </div>
        </div>
    </section>

    <!-- Depoimentos de Clientes -->
    <section class="py-5 bg-light">
        <div class="container">
            <h3 class="text-center text-primary">O que nossos clientes dizem</h3>
            <!-- Adicionar depoimentos aqui -->
        </div>
    </section>

    <!-- Seção Sobre Nós -->
    <section id="sobre" class="py-5">
        <div class="container">
            <h3 class="text-center text-primary">Sobre Nós</h3>
            <p>A Cabos e Etc é uma loja especializada em consertos de celulares...</p>
            <!-- Adicionar mais informações e imagens -->
        </div>
    </section>

    <!-- Seção de Contato -->
    <section id="contato" class="py-5">
        <div class="container">
            <h3 class="text-center text-primary">Fale Conosco</h3>
            
            <!-- Link do WhatsApp -->
            <div class="whatsapp-link">
                <a href="https://wa.me/5521997556677" target="_blank">
                    <svg viewBox="0 0 32 32">
                        <path d="M19.11 18.54c-.29-.14-1.72-.85-1.99-.95-.27-.09-.47-.14-.67.14-.19.29-.76.95-.93 1.15-.17.19-.34.22-.63.08-.29-.14-1.23-.45-2.34-1.43-.86-.76-1.44-1.7-1.61-1.99-.17-.29-.02-.45.13-.59.14-.14.29-.34.43-.51.14-.17.19-.29.29-.48.1-.19.05-.36-.02-.51-.08-.14-.67-1.61-.91-2.2-.24-.57-.48-.49-.67-.5h-.57c-.19 0-.48.07-.73.36-.25.29-.96.94-.96 2.28s.98 2.64 1.12 2.83c.14.19 1.92 2.92 4.65 4.1.65.28 1.15.45 1.54.57.65.21 1.24.18 1.71.11.52-.08 1.72-.7 1.97-1.37.24-.67.24-1.25.17-1.37-.06-.11-.25-.18-.54-.32m-3.11 9.46c-5.52 0-10-4.48-10-10s4.48-10 10-10 10 4.48 10 10-4.48 10-10 10m5.44-15.44c-.73-.3-1.51-.5-2.33-.58-.24-.03-.49-.05-.73-.05-.44 0-.87.06-1.3.14s-.85.21-1.25.37c-.4.16-.78.37-1.13.61-.36.25-.7.55-1 .87-.31.33-.59.68-.83 1.08-.25.4-.45.82-.6 1.27-.14.45-.23.92-.26 1.39-.04.52-.01 1.04.07 1.55.08.52.23 1.03.42 1.52.2.49.46.96.76 1.4.31.45.66.86 1.07 1.22.4.37.83.69 1.3.95.24.14.5.27.76.38.26.11.53.21.8.29.55.17 1.13.26 1.71.28.49.02.98-.02 1.46-.11.5-.09.98-.24 1.45-.43.47-.18.91-.42 1.33-.7.41-.28.8-.61 1.15-.97.34-.36.66-.75.94-1.17.28-.41.52-.85.71-1.31.18-.46.32-.93.41-1.42.09-.49.14-.98.15-1.48.01-.49-.02-.99-.09-1.48-.07-.52-.2-1.02-.37-1.51-.18-.49-.41-.97-.68-1.43-.29-.48-.62-.92-.99-1.34-.36-.4-.76-.76-1.19-1.08-.44-.31-.91-.57-1.41-.78" />
                    </svg>
                    <p>Entre em contato pelo WhatsApp</p>
                </a>
            </div>

            <!-- Formulário de Contato -->
            <form>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" placeholder="Seu nome">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Seu email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="form-control" id="telefone" placeholder="Seu telefone">
                </div>
                <div class="form-group">
                    <label for="mensagem">Mensagem</label>
                    <textarea class="form-control" id="mensagem" rows="4" placeholder="Sua mensagem"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </section>

    <!-- Incluir Rodapé -->
    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
