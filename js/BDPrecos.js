    function ajustarPreco(idLink, idNovoValor, idLoja1, flagAtivoLoja1,idLoja2, flagAtivoLoja2, idAtom){
    let novoValor=document.getElementById(idNovoValor).value;

    //alert(flagAtivoLoja1);
    //alert(flagAtivoLoja2);

    alert(`Id Link: ${idLink} Novo Valor: ${novoValor} Cdloja1: ${idLoja1} Flag: ${flagAtivoLoja1} CdLoja2: ${idLoja2} Flag: ${flagAtivoLoja2} Img: ${idAtom}`);

    //  onclick='ajustarPreco(\"$idProduto\", document.getElementById(\"novoValor$contadorLinhasExibidas\").value, $idloja1, 1, $idLoja2, 0);'

    //	let id="idQuantPedidoMaterial"+cdproduto;


    let imgAtom=document.getElementById(idAtom);
    let pagina=`BDRotinasAjax.php?modo=inserirItemBDRobot&idlink=${idLink}&novovalor=${novoValor}&idloja1=${idLoja1}&flagativoloja1=${flagAtivoLoja1}&idloja2=${idLoja2}&flagativoloja2=${flagAtivoLoja2}`;

    //alert(pagina);
    console.log(pagina);

    //console.log("pagina: "+pagina);
    //idQuantPedidoMaterial.innerHTML="<img src='../imagens/carregando.gif' width='32' height='32' />"; 

    var async = true;
    xmlhttp.open("GET", pagina, async); // foi adicionado um false aqui, parece que funcionou!
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            console.log(xmlhttp.responseText);
            alert(xmlhttp.responseText);
        }
    }


    xmlhttp.send(null);

}



function trocacamera(identificador){
	var objeto=document.getElementById(identificador);
	//alert(identificador);
	objeto.src='../imagens/camera2.png';
}

function marcaiconecopy(identificador){
	var objeto=document.getElementById(identificador);
	//alert(identificador);
	objeto.src='../imagens/copy2.png';
}
