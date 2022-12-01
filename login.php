<?php

require '/includes/config/database.php';

$db = conectarDb();

$email = '';
$contraseña = '';

$errores = [];

if($_SERVER['REQUEST_METHOD'] === "POST"){
	$email = mysqli_real_escape_string($db, filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL));
	$contraseña = mysqli_real_escape_string($db, $_POST['password']);

	if(!$email){
		$errores[] = 'Correo y/o contraseña no válidos';
	}

	if(!$contraseña){
		$errores[] = 'Correo y/o contraseña no válidos';
	}

	if(empty($errores)){
		$query = "SELECT u_id, u_correo, u_contrasenia, u_activo, u_rol FROM usuarios WHERE u_correo = '$email'";
		$result = mysqli_query($db, $query);

		if($result -> num_rows){
			$usuario = mysqli_fetch_assoc($result);

			$passwordDecrypt = password_verify($contraseña, $usuario['u_contrasenia']);

			if($usuario['u_activo'] === "S"){
				if($passwordDecrypt){
					session_start();
					$_SESSION['id'] = $usuario['u_id'];
					$_SESSION['rol'] = $usuario['u_rol'];
					$_SESSION['login'] = true;
					header("Location:/index.php");
				}else{
					$errores[] = "Correo y/o contraseña no válidos";
				}
			}else{
				$errores[] = "El usuario aún no esta activo";
			}
		}else{
			$errores[] = "El usuario no existe";
		}

	}
}

?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>
<head>
	<title>Iniciar Sesión</title>
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/app.css">
</head>
<body>
<div class="container">
<?php
		foreach($errores as $error):?>
		<div class="error text-center text-white fs-3">
			<?php echo $error; ?>
		</div>
		<?php endforeach; ?>
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Inicia Sesión</h3>
			</div>
			<div class="card-body">
				<form action="login.php" method="POST">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span for="correo" class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" id="correo" name="correo" placeholder="Correo">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text" for ="password"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" id="password" name="password" class="form-control" placeholder="Contraseña">
					</div>
					<div class="form-group">
						<input type="submit" value="Iniciar" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					No tienes cuenta?<a href="crear-cuenta.php" class="text-white"> Crea una</a>
				</div>
				<div class="d-flex justify-content-center">
					<a href="olvide-mi-contraseña.php" class="text-white">Olvidaste tu contraseña?</a>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>