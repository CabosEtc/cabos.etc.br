<?
// Resumo deste arquivo:
// $conexao - nome da conexao aberta no banco de dados, fica disponivel para todas as paginas
// $cdloja - codigo da loja (vinda do arquivo loja.txt)
// $nomeloja - nome da loja
// $caminho_imagens - diretorio que contem imagens no site. 
// $index_description
// $index_keywords
// $raiz_site - diretorio inicial

// Ajusta fuso horario
date_default_timezone_set('America/Sao_Paulo');

// Set algumas variaveis
$dthoje_eua=date("Y-m-d",strtotime("now"));
$dthoje_bra=date("d/m/Y",strtotime("now"));
$dtpesquisa=date("Ymd",strtotime("now"));
$hora=date("H:i:s",strtotime("now"));

// Formato novo, definindo constantes

define("dtHojeEua",date("Y-m-d",strtotime("now")));



// Fazendo a conexão com o servidor MySQL usando Mysqli

// Conexão Uol
//$conexao = new mysqli("bdhost0036.servidorwebfacil.com","cabos_user","fg15975300","cabos_bd");

// Conexão Hostinger
$conexao = new mysqli("localhost","u641118057_flavio","Fgl@159753","u641118057_cabos_bd");

// change character set to utf8
if (!$conexao->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $conexao->error);
    exit();
} else {
    //printf("Current character set: %s\n", $conexao->character_set_name());
}


// Busca o codigo e o nome da loja (fica disponivel em: $cdloja e $nome_loja)
$raiz_site=$_SERVER['DOCUMENT_ROOT'];

$ponteiro = fopen ($raiz_site."/loja.txt", "r");
while (!feof ($ponteiro)) {
  $linha = fgets($ponteiro, 4096);
  $cdloja=$linha;
}
fclose ($ponteiro);

$ponteiro = fopen ($raiz_site."/imagens.txt", "r");
while (!feof ($ponteiro)) {
  $linha = fgets($ponteiro, 4096);
  $caminho_imagens=$linha;
}
fclose ($ponteiro);

$queryLoja = "SELECT nomeloja, index_description, index_keywords 
        FROM lojas 
        WHERE cdloja='$cdloja'";

if (!$resultadoLoja = $conexao->query($queryLoja)) {
    echo "Desculpe, estamos com problema, favor retornar mais tarde.";
    exit;
}

/*
while ($produto = $resultadoLoja->fetch_assoc()) {
     echo $produto['cdproduto'] . ' ' . $produto['nome']."<br>";
}
*/
$row=$resultadoLoja->fetch_array(MYSQLI_ASSOC); // pode ser NUM ou BOTH
$nomeloja=$row['nomeloja']; 
$index_description=$row['index_description'];
$index_keywords=$row['index_keywords'];

//echo "Loja: $nomeloja Descricao: $index_description Keywords: $index_keywords<br>";

?>
