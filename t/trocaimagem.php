<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title></title>
</head>
<body>
<script>
function trocacamera (identificador){
	var objeto=document.getElementById(identificador);
	alert(identificador);
	objeto.src='../imagens/camera2.png';
}
</script>


<?
$idcamera="camera21";
echo "
<IMG SRC='../imagens/error.png'> Erro na abertura da pagina>
       
            <img id='$idcamera' src='../imagens/camera.png'  onclick='trocacamera(\"$idcamera\");' />";
?>
</body>
</html>