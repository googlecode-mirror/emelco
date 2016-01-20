## 1.3.1 ##
```
    [!] Modificado un bug que hacia que no se guarde la cookie con el estado del div lateral si no se ve el div de abajo
    [!] Cambié un par de comillas dobles que quedaban
```
## 1.3 ##
```
    [!] Si phpinfo() está desactivado, da un error en w=phpinfo
    [+] Muestra los modulos cargados en w=info
    [!] Solucionado un error muy chico en w=editar, que mostraba todo seguido sin un salto de linea
    [!] Si en w=editar se envia el formulario con enter, se vuelve a mostrar el mismo texto pero no se guarda nada. Antes era como apretar guardar
    [+] Al subir archivos, ahora intenta usar move_uploaded_file(), leerarchivo() y escribirarchivo()
    [+] leerarchivo() ahora llama a cat "$archivo"
    [+] Muestra un div lateral con información importante
    [+] Agregada shell de conexion inversa
    [+] Agregados los links del menu en una linea abajo
    [+] Muestra el tamaño de los archivos en el navegador
    [+] La función shell() usa proc_open() y pcntl_exec()
    [!] Optimizada la función guardar()
    [+] El navegador de archivos permite copiar y mover archivos/directorios
    [!] Las comillas dobles que estaban de mas, ahora son simples
```
## 1.2 ##
```
    [+] Explota un bug con ini_restore para saltearse safe_mode y open_basedir PHP <= 5.1.6 / 4.4.4
    [!] Cambió el orden de los error_reporting para que sea mas facil debuggear
    [!] Intenta modificar memory_limit
    [!] Al listar archivos los va mostrando de a uno, para no llegar al limite de memoria (funciona bien con los 8mb default)
    [!] Las lineas del textarea de w=shell se acomodan a las lineas de la salida del comando
    [!] Arreglado un bug en archivosdeusuarios(), que hacia que devuelva solo una ubicacion
    [+] Agregado "<whereis ruby" y corregido .htacces por .htaccess en w=info
```

## 1.1 ##
```
   [!] No se frena al encontrar funciones no existentes (Compatible con PHP 4.2)
   [+] Te avisa cuando no cambiaste la contraseña
   [!] Sirve para RFI y LFI
```
## 1.0 ##
```
   [!] Arreglado un loop infinito en shellpopen() que se producia cuando no se podia ejecutar el comando por safe_mode
   [!] No se muestran los resultados vacios de la ejecución de comandos en ?w=info
   [!] Mejorada la lectura de archivos con readfile() y file()
   [!] Ya no se muestra la contraseña al ingresarla
   [!] Arreglado bug que saltaba cuando output_buffering era distinto a Off
   [!] Se eliminó un input del editor de archivos, ahora es mas facil de usar
```
## 1.0b1 ##
```
   [!] Arreglados varios bugs
   [+] Agregados comentarios
   [+] chmod, chgrp y chown
   [+] Mejorada la función shell()
   [+] Se puede poner clave
   [+] Mejorada la función leerarchivo()
   [+] Sin tiempo máximo de ejecución
   [+] mas datos en w=info
   [!] Los links en los créditos no tienen referer
   [+] Elimina archivos también con comandos, sin usar unlink y rmdir
   [+] Si no hay permisos para leer o escribir archivos, intenta cambiarlos
```
## 1.0a2 ##
```
   [+] Creditos
   [+] Descarga de archivos
   [!] leerarchivo() comprueba que $ruta no sea un directorio
   [!] Cambios de apariencia en el phpinfo
   [+] Eliminar archivos desde el navegador
   [+] Mas iconos
   [+] Bordes de colores en los textbox e input
   [+] Ahora se pueden crear archivos y directorios desde el navegador
   [+] Ahora se pueden subir archivos
   [+] Ejecutar codigo php
   [!] Los input estan mas parejos 
   [+] Nuevo mailer
   [+] Muestra mas información 
```
## 1.0a1 ##
```
   [+] Primera version
```