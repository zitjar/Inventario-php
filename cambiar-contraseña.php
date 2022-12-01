<?php 

require '/includes/config/database.php';

$db = conectarDb();

$id = $_POST['id'];
$contraseña = $_POST['id'];
$confirma = $_POST['confirma'];

if($password === $confirmar){
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
}else{
    header("Location:/mi-perfil.php?resultado=1");
}

$sql = "UPDATE usuarios SET u_contrasenia='$passwordHash' WHERE u_id = '$id'";
$resultado = mysqli_query($db, $sql);

if(!$resultado){
    header("Location:/mi-perfil.php?resultado=1");
}else{
    header("Location:/mi-perfil.php?resultado=2");
}