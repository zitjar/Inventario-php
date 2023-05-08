<?php
function conectarDb():mysqli{
    $db = new mysqli("","","","",);

    if(!$db){
        echo "Error no se pudo conectar a mysql";
        echo "Error de depuracion".mysqli_connect_errno();
        echo "error de depuracion".mysqli_connect_error();
        exit;
    }
    return $db;
}   
