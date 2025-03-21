<?php

/*
// Conexão com o banco de dados
$host = "localhost"; // Ajuste conforme necessário
$user = "root";
$password = "";
$database = "nps_db"; // Nome do banco de dados

$conn = new mysqli($host, $user, $password, $database);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

*/
    //Prepara conexao ao db
    include("../conectadb.php");

    // Recebe o nível de satisfação via POST
    $nivel_satisfacao = intval($_POST['nivel_satisfacao']);

// Insere no banco de dados

$query="INSERT INTO nps (id,nivel_satisfacao, cdloja, data) VALUES ('', $nivel_satisfacao, '1','$timestampSaoPaulo')";
$resultado = mysql_query($query,$conexao) OR DIE(mysql_error());
/*
$sql = "INSERT INTO nps (id,nivel_satisfacao, cdloja) VALUES ('', $nivel_satisfacao, '1')";
if ($conexao->query($sql) === TRUE) {
    echo "Avaliação salva com sucesso";
} else {
    echo "Erro: " . $sql . "<br>" . $conexao->error;
}

$conexao->close();
*/
?>