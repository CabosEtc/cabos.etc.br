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

#cadastro{
display: none;
}
</style>
 
 <script type="text/javascript" src="ajax2020.js"></script><b></b>
 
 <script type="text/javascript">
 
 
// Funcao para buscar o conteudo da pagina via ajax 
 function makerequest(serverPage, objID, modo){

 // modo procurar
 if(modo=="procurar"){
	 var obj=document.getElementById(objID);
	 var txt=document.getElementById("texto").value;
	 serverPage=serverPage+"?modo=procurar&q="+txt;
	 //alert(serverPage);
	 	 
	 
	 xmlhttp.open("GET", serverPage);
	 xmlhttp.onreadystatechange=function(){
		 if(xmlhttp.readyState==4 && xmlhttp.status==200){
			 obj.innerHTML=xmlhttp.responseText+"<BR>"; // se quisesse adicionar o conteudo anterior -> +obj.innerHTML;
		 }
		 
	 }
}

// outro modo

if (modo=="capturar") {
	var txt=document.getElementById("texto").value;
	var marca=document.getElementById("marca");
	var produto=document.getElementById("produto");
	var link=document.getElementById("link");
	alert(modo);
	alert(txt);
	serverPage=serverPage+"?modo=capturar&cdprodutobd="+txt;
	alert(serverPage);
	 	 
	 
	 xmlhttp.open("GET", serverPage);
	 xmlhttp.onreadystatechange=function(){
		 if(xmlhttp.readyState==4 && xmlhttp.status==200){
			//alert(xmlhttp.responseText);			 
			var objeto=JSON.parse(xmlhttp.responseText); // se quisesse adicionar o conteudo anterior -> +obj.innerHTML;
			marca.value=objeto.marca;
			produto.value=objeto.modelo;
			link.value="https://www.boadica.com.br/produtos/"+txt;	 
		 }
	}
	
}
//retorno 
	 xmlhttp.send(null);
	 //alert(xmlhttp.status);
 }
 </script>
 

<div style='clear: both; float: none'><input type="text" name="texto" id="texto" value="ola" onkeyup="makerequest('BDCadastroLinkRotinas.php','hw','procurar')" /></div>

<div style='clear: both; float: none'><button type="button" onclick="cadastro.style.display='block'; makerequest('BDCadastroLinkRotinas.php','hw','capturar');">Cadastrar</button></div>
<div id='hw'></div>    
        
<!-- Rotina para cadastramento do link -->

<div id="cadastro">
<table width="960" border="0" align="center">
  <tr>
<td><h3>Cadastro de link do BD</h3></td>
  </tr>

<form id='form4' name='form4' method='get' action='BDCadastroLinkRotinas.php'>
<tr>
<td style='padding-left:20px'>Marca</td>
<td><input name='marca' type='text' id='marca' size='96' maxlength='20' value=''/></td>
</tr>
<tr>
  <td style='padding-left:20px'>Produto</td>
<td><input name='produto' type='text' id='produto' size='96' maxlength='512'  value=''/></td>
</tr>
<tr>
<td style='padding-left:20px'>Codigo do Produto</td>
<td><input name='cdproduto' type='text' id='cdproduto' size='10' maxlength='5' /></td>
</tr>
<tr>
<td style='padding-left:20px'>Descricao/Localizador</td>
<td><input name='localizador' type='text' id='localizador' size='96' maxlength='50' /></td>
</tr>
<tr>
<td style='padding-left:20px'>Link</td>
<td><input name='link' type='text' id='link' size='96' maxlength='256'  value=''/></td>
</tr>
<input name='modo' type='hidden' id='modo' value='cadastrar' />
<tr>
<td style='padding-left:20px'>Status</td>
<td>
<select name="flag_ativo">
    <option value="0">Desativado</option>
    <option selected='selected' value="1">Ativo</option>
    <option value="2">Comparacao</option>
  </select>  
</td>  
</tr>
<tr><td>.</td><td><input type='submit' name='Ok3' id='Ok3' value='Ok' /></td></tr>
</form>
</table>
</div>
    
</body>
</html>
