<?php
include '/includes/config/database.php';
// session_start();

// $sesion = $_SESSION['usuario'];

// if($sesion == null || $sesion = ""){
//     header("Location:/../index.php");
//     die();
// }

$db = conectarDb();

$id = $_GET['id'];

$sql = "DELETE FROM activos WHERE id='$id' ";

$resultado = mysqli_query($db, $sql);

header("Location:/lista-de-activos.php?resultado=4");