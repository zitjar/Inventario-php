<?php
include 'includes/config/database.php';
// session_start();

// $sesion = $_SESSION['usuario'];

// if($sesion == null || $sesion = ""){
//     header("location:../index.php");
//     die();
// }

$db = conectarDb();

$id = $_GET['id'];

$sql = "DELETE FROM activos WHERE id='$id' ";

$resultado = mysqli_query($db, $sql);

header("location:lista-de-activos.php?resultado=4");