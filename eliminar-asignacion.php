<?php

include '/includes/config/database.php';

$db = conectarDb();

$id = $_GET['id'];
$equipo = $_GET['equipo'];
$usuario = $_GET['usuario'];

$sql = "DELETE FROM asignacion WHERE id = '$id'";
$sql4 = "UPDATE activos SET a_asignado = 'N' WHERE a_id = $equipo";
$sql5 = "UPDATE usuarios SET u_asignado = 'N' WHERE u_id = $usuario";

$result1 = mysqli_query($db, $sql4);
$result2 = mysqli_query($db, $sql5);
$result = mysqli_query($db,$sql);

if(!$result){
    header("Location:/lista-de-asignaciones.php?resultado=2");
}else{
    header("Location:/lista-de-asignaciones.php?resultado=4");
}