<?php
    // Define o cabeçalho para JSON
    header("Content-Type: application/json");

    //Prepara conexao ao db
    include("../conectadb.php");

    //$json = file_get_contents("php://input");

    $json='[["nome", "email"],["João", "joao@email.com"],["Maria", "maria@email.com"]]';


// Decodifica o JSON para um array PHP
$dados = json_decode($json, true);

// Verifica se a decodificação foi bem-sucedida
if ($dados === null) {
    http_response_code(400);
    echo json_encode(["erro" => "JSON inválido"]);
    exit;
}

// Obtém os cabeçalhos (primeira linha do JSON)
$headers = $dados[0];

// Inicializa um array para armazenar os dados formatados
$registros = [];

// Percorre os dados a partir da segunda linha
for ($i = 1; $i < count($dados); $i++) {
    $registros[] = array_combine($headers, $dados[$i]);
}

// Exibe os registros formatados
foreach ($registros as $registro) {
    echo "Nome: " . $registro['nome'] . " - Email: " . $registro['email'] . "<br>";
}

// Se quiser retornar como JSON:
header("Content-Type: application/json");
echo json_encode($registros, JSON_PRETTY_PRINT);

/*
    echo "<h3>Incluindo no estoque o produto</h3>";
    echo "Codigo do produto: ".$cdproduto."<br>";

    echo "Fornecedor: ".$fornecedor."<br>";

    echo "Valor: ".$valor."<br>";

    echo "Quantidade: ".$quantidade."<br>";

    echo "Data da chegada: ".$dtentrada."<br>";

    // incluir o produto no banco de dados do estoque
    $query="INSERT INTO estoque(iditem, cdproduto, historico, fornecedor, dtmovimento, quantidade, idcompra, cdloja, vlindividual, link) 
    VALUES ('null', '$cdproduto', '51', '$fornecedor', '$dtentrada_eua', '$quantidade', '0', '$cdloja', $valor, '$link')";
    //echo $query;
    $resultado = mysql_query($query,$conexao);
    echo "<BR><BR><BR><a href='einc.php'>Incluir </a> novo produto no sistema.";
*/
?>