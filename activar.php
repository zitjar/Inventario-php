<?php

include '//includes/config/database.php';

$db = conectarDb();

$id = $_POST['id'];

if($_POST['activo'] == "S"){
    $activo = "N";
}else{
    $activo = "S";
}

$sql = "UPDATE `usuarios` SET `u_activo` = '$activo' WHERE `u_id` = '$id'";

$resultado = mysqli_query($db, $sql);

if(!$resultado){
    header("Location://lista-de-usuarios.php?resultado=1");
}else{
    header("Location://lista-de-usuarios.php?resultado=2");
}