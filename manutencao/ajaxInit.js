function ajaxInit() {
    var xmlhttp;
    
    try {
 xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch(e) {
 try {
     xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
 } catch(exception) {
     try {
   xmlhttp = new XMLHttpRequest();
     } catch(exception) {
   alert("Esse browser não tem recursos para uso do Ajax");
   xmlhttp = null;
     }
 }
    }
    
    return xmlhttp;
}