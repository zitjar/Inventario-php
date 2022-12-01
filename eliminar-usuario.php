<?php

include 'includes/config/database.php';

$db = conectarDb();

$id = $_POST['id'];

$eliminar = $_POST['eliminar'];

$sql = "UPDATE `usuarios` SET `u_eliminar` = '$eliminar' WHERE `u_id` = '$id'";

$resultado = mysqli_query($db, $sql);



if(!$resultado){
    header("Location:lista-de-usuarios.php?resultado=1");
}else{
    header("Location:lista-de-usuarios.php?resultado=3");
}