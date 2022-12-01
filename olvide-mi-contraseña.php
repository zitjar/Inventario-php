<?php

include "includes/config/database.php";
require "includes/funciones.php"; 
zonaHoraria();

$db = conectarDb();

$correo = '';
$password = '';
$confirmar = '';
$errores = [];

if($_SERVER["REQUEST_METHOD"]==="POST"){
	$correo = mysqli_real_escape_string($db,$_POST['correo']);
	$password = mysqli_real_escape_string($db,$_POST['password']);
	$confirmar = mysqli_real_escape_string($db,$_POST['confirmar']);

	if($password === $confirmar){
		$passwordHash = password_hash($password, PASSWORD_BCRYPT);
	}else{
		$errores[] = "Las contraseñas no coinciden";
	}

	if(!$correo){
		$errores[] = "Debe ingresar un correo";
	}

	if(empty($errores)){
		$sql = "UPDATE usuarios SET u_contrasenia='$passwordHash' WHERE u_correo = '$correo'";
        echo $sql;
		$result = mysqli_query($db, $sql);

		if(!$result){
			header("Location:olvide-mi-contraseña.php?resultado=2");
		}else{
			header("Location:olvide-mi-contraseña.php?resultado=1");
		}
	}
}

$resultado = $_GET['resultado'] ?? null;
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>

<head>
    <title>Cambiar contraseña</title>

    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/app.css">
</head>

<body>
    <div class="container">
	<?php 
	if(intval($resultado) === 1){
       echo '<div class="alerta success">Se registro con éxito</div>';
    } elseif(intval($resultado) ===2){
        echo '<div class="alerta error fs-1">!Upps algo salió mal intenta de nuevo</div>';
    }

    ?>
        <div class="d-flex justify-content-center h-100">
		<?php
		foreach($errores as $error):?>
		<div class="error">
			<?php echo $error; ?>
		</div>
		<?php endforeach; ?>
		
            <div class="card">
                <div class="card-header">
                    <h3>Cambiar contraseña</h3>
                  
                </div>
                <div class="card-body">
                    <form action="olvide-mi-contraseña.php" method="POST">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" for="correo"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo">

                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" for="password"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Contraseña">
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" for="confirmar"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" id="confirmar" name="confirmar" class="form-control"
                                placeholder="Confirmar Contraseña">
                        </div>

                        <div class="form-group">
						<a href="login.php" class="text-white">Iniciar Sesión</a>
                            <input type="submit" value="Cambiar" class="btn float-right login_btn">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>