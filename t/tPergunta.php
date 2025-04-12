<?php //include("msession.php");?>
<html>
<head>
    <title>tPergunta</title>
	<meta http-equiv= "Content-Type" content= "text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="manutencao.css">
</head>
<body>
<?
//Prepara conexao ao db
//include("../conectadb.php");
?>
<script type="text/javascript" src="js/ajax2020.js"></script>

 <script type="text/javascript">
 
// Funcao para buscar o conteudo da pagina via ajax 
 function makerequest(pagina){

	//alert(pagina); 	 
	 
	 xmlhttp.open("GET", pagina);
	 xmlhttp.onreadystatechange=function(){
		 if(xmlhttp.readyState==4 && xmlhttp.status==200){
			 var objeto=JSON.parse(xmlhttp.responseText);
			 for(var i=0;i<objeto.bd.length;i++){
				    alert(`${objeto.bd[i].loja}  -  R$${objeto.bd[i].preco} `);
				}		
		 }
	 }

	 xmlhttp.send(null);
	 //alert(xmlhttp.status);
	 return "oieeeeee";
 }

 makerequest('tExtract2.php?id=987'); // 987 Extensor VGA Através de RJ45 até 60m
 </script>












<!-- Conteudo principal -->
<div id="corpo" class="corpo">




</div> <!--fim do conteudo principal -->    
</body>
</html>
