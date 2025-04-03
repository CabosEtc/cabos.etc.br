<?php
    $file = '../busca.php';

    //Mostra erros
    ini_set('display_errors', 1);
    //Prepara conexao ao db
    include("../conectaDBMysqli.php");

    $querySubcategoria="   SELECT subcategoria.cdsubcategoria, subcategoria.descricao, 
    subcategoria.caminho 
    FROM subcategoria 
    WHERE subcategoria.flagativo=1 
    ORDER BY cdsubcategoria"; 


if (!$resultadoSubcategoria = $conexao->query($querySubcategoria)) {
    echo "Desculpe, estamos com problema, favor retornar mais tarde.";
    exit;
}

/*
Pesquisa unica, substitui o mysql_result($resultado,x,x)
$row=$resultadoSubcategoria->fetch_array(MYSQLI_ASSOC); // pode ser NUM ou BOTH
$cdSubcategoria=$row['cdsubcategoria'];
*/

while ($rowSubcategoria = $resultadoSubcategoria->fetch_assoc()) {
    $cdSubcategoria=$rowSubcategoria['cdsubcategoria'];
    $descricao=$rowSubcategoria['descricao'];
    $caminho=$rowSubcategoria['caminho'];
    
    //echo "<div>subcategoria $cdSubcategoria | descrição $descricao | caminho $caminho</div>";
    //echo "<h3>Rede</h3>";
    $newFile = "$caminho.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else{
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

}

/*



    // Rede
    echo "<h3>Rede</h3>";
    $newFile = "cabos-de-rede.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else{
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "placas-adaptadores-rede-sem-fio.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else{
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "ferramentas-de-rede.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else{
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "placas-adaptadores-usb-de-rede.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else{
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "conectores-de-rede.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }


    // PC & Mac
    echo "<h3>PC & Mac</h3>";
    $newFile = "cabos-notebook-desktop.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "acessorios-notebook-desktop.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "fontes-para-notebook.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "placas-pci.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "placas-pci-express.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }


    // Vídeo
    echo "<h3>Vídeo</h3>";
    $newFile = "cabos-de-video.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "adaptadores-e-conversores-de-video.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "placas-de-captura.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "acessorios-de-video.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "conectores-de-video.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    // Áudio
    echo "<h3>Áudio</h3>";
    $newFile = "cabos-de-audio.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "adaptadores-de-audio.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    // Celular
    echo "<h3>Celular</h3>";
    $newFile = "cabos-celular-tablet.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "acessorios-para-celulares-tablets.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    // Home Office
    echo "<h3>Home Office</h3>";
    $newFile = "suporte-para-tv.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "controle-remoto.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    // Outros
    echo "<h3>Outros</h3>";
    $newFile = "fontes-de-alimentacao.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "ferramentas.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "pilhas-e-baterias.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "pilhas-recarregaveis.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "carregadores-de-pilhas-e-baterias.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

    $newFile = "outros.php";
    if (!copy($file, $newFile)) {
        echo "$newFile <img src='cross32x32.png' /><br>";
    }
    else {
        echo "$newFile <img src='/img/icones/tick32x32.png' /><br>";
    }

*/
?>
