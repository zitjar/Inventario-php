<?php
require "includes/funciones.php";

$rol = $_SESSION['rol'];

$auth = autenticado();

if(!$auth){
    header("Location:login.php");
}

require 'includes/config/database.php';

$db = conectarDb();

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo']; 
$imagen = $_POST['imagen'];

$sql = "UPDATE usuarios SET u_nombre = '$nombre', u_apellido = '$apellido', u_correo='$correo', u_imagen = '$imagen' WHERE u_id = '$id'";

$resultado = mysqli_query($db, $sql);

if(!$resultado){
    header("Location:/mi-perfil.php?resultado=1");
}else{
    header("Location:/mi-perfil.php?resultado=2");
}