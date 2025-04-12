<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<title>Teste</title>
</head>
<body>
 
 <style>
 #numero {
  font-size:50px;
  color: orange;
}
</style>
 
 <script type="text/javascript" src="ajax2020.js"></script><b></b>
 
 <script type="text/javascript">
 
 /*
 n = 0;
function contador(){
 document.getElementById("relogio").innerHTML=n;
 n++;
 if (n==30){
	 makerequest("teste_ajax_ret.php","hw");
	 n=0;
 }
}
 

setInterval(contador, 1000);
*/
 
// Funcao para buscar o conteudo da pagina via ajax 
 function makerequest(serverPage, objID){
	 var obj=document.getElementById(objID);
	 var txt=document.getElementById("texto").value;
	 serverPage=serverPage+"?q="+txt;
	 //alert(serverPage);
	 	 
	 
	 xmlhttp.open("GET", serverPage);
	 xmlhttp.onreadystatechange=function(){
		 if(xmlhttp.readyState==4 && xmlhttp.status==200){
			 obj.innerHTML=xmlhttp.responseText+"<BR>"; // se quisesse adicionar o conteudo anterior -> +obj.innerHTML;
		 }
		 
	 }
	 xmlhttp.send(null);
	 //alert(xmlhttp.status);
 }
 </script>
 
 <div id='relogio'></div>
 
<div style='clear: both; float: none'><input type="text" name="texto" id="texto" value="ola" onkeyup="makerequest('teste_ajax_ret.php','hw')" /></div>

<!--
<div style='clear: both; float: none'><button type="button" onclick="makerequest('teste_ajax_ret.php','hw')">Buscar</button></div>
-->

<div id="hw"></div>
    
<div>http://cabos.etc.br/manutencao/precos_bd_cadastro_link.php</div>    
<div onclick="alert('oiieee');">clique</div>
    
</body>
</html>
