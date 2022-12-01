<?php

function conectarDb():mysqli{
    $db = new mysqli("localhost","root","","sistema-inventario");

    if(!$db){
        echo "Error no se pudo conectar a mysql";
        echo "Error de depuracion".mysqli_connect_errno();
        echo "error de depuracion".mysqli_connect_error();
        exit;
    }
    return $db;
}