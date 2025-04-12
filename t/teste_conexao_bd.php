<?php
$host = "localhost"; // Exemplo: "localhost" ou "127.0.0.1"
$user = "u641118057_flavio";
$password = "Fgl@159753";
$database = "u641118057_cabos_bd";

$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_error) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

echo "Conexão bem-sucedida!<br>";

$result = $mysqli->query("SELECT * FROM produtos LIMIT 5");

if (!$result) {
    die("Erro na consulta: " . $mysqli->error);
}

while ($row = $result->fetch_assoc()) {
    echo "Código: " . $row['cdproduto'] . " | Nome: " . $row['nome'] . "<br>";
}

$mysqli->close();
?>
