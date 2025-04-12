function ajaxMulti(idLink){
    //alert(idLink);
    var xmlhttp = {};
    xmlhttp[idLink]= false;
    
    try{ 
        xmlhttp[idLink] = new ActiveXObject("Msxm12.XMLHTTP");
        //alert("Voce esta usando Internet Explorer");
    } catch (e){
        try{
            xmlhttp[idLink]=new ActiveXObject("Microsoft.XMLHTTP");
            //alert("Voce esta usando Internet Explorer");
        } catch (E){
            xmlhttp[idLink] = false;
        }
    }
    
    if(!xmlhttp[idLink] && typeof XMLHttpRequest != 'undefined'){
        xmlhttp[idLink] = new XMLHttpRequest();
        //alert ("Voce esta usando outro navegador");
    }
}