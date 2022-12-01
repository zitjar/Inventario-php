<?php

include 'includes/config/database.php';

$db = conectarDb();

$id = $_POST['id'];

if($_POST['rol'] == "Usuario"){
    $rol = "Administrador";
}else{
    $rol = "Usario";
}

$sql = "UPDATE `usuarios` SET `u_rol` = '$rol' WHERE `u_id` = '$id'";

$resultado = mysqli_query($db, $sql);

if(!$resultado){
    header("Location:lista-de-usuarios.php?resultado=1");
}else{
    header("Location:lista-de-usuarios.php?resultado=2");
}