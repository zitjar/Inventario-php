<?php

function conectarDb():mysqli{
    $db = new mysqli("containers-us-west-138.railway.app","root","qfiEeMFQjUUFdRlA2XXk","railway",6302);

    if(!$db){
        echo "Error no se pudo conectar a mysql";
        echo "Error de depuracion".mysqli_connect_errno();
        echo "error de depuracion".mysqli_connect_error();
        exit;
    }
    return $db;
}   