<?php


$auth = autenticado();

if(!$auth){
    header("Location:login.php");
}

include 'includes/config/database.php';
$db = conectarDb();

session_start();

$id = $_SESSION['id'];

$sql = "SELECT * FROM usuarios WHERE u_id = '$id'";

$resultado = mysqli_query($db, $sql);

$data = mysqli_fetch_assoc($resultado);

include 'includes/header.php';
$resultado = $_GET['resultado'] ?? null;
?>

<main class="container py-1">
    <h1 class="text-center">Mi perfil</h1>
    <?php  
    if(intval($resultado) ===2){
        echo '<div class="alerta success">El usuario ha sido actualizado éxitosamente</div>';
    } elseif(intval($resultado) ===1){
        echo '<div class="alerta error">¡upps ha ocurrido un error, intenta de nuevo!</div>';
    }

    ?>
    <section id="datos">
        <div class="d-flex justify-content-center mx-5 centrar" style="width: 400px; height: 400px;">
            <img src="<?php echo $data['u_imagen'] ?>" alt="Foto de perfil" class="img-fluid ">
        </div>
        <h4 class="text-center">nombre: <?php echo $data['u_nombre'] . ' ' . $data['u_apellido']?></h4>
        <p class="text-center">Correo: <?php echo $data['u_correo'] ?></p>
        <p class="text-center">Rol asignado: <?php echo $data['u_rol'] ?></p>
    </section>
    <section class="text-center d-flex justify-content-between" id="acciones">
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contraseña">
                <i class="fa-solid fa-key"></i> Cambiar contraseña
            </button>
        </div>
        <div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editar">
                <i class="fa-solid fa-user-pen"></i> Editar usuario
            </button>
        </div>
    </section>

</main>



<!-- Modal -->
<div class="modal fade" id="contraseña" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar contraseña</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="cambiar-contraseña.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $data['u_id']; ?>">
                    <div class="mb-3">
                        <label for="contraseña" class="form-label">Contraseña</label>
                        <input type="password" class="form-control form-control-lg" id="contraseña" name="contraseña">
                    </div>
                    <div class="mb-3">
                        <label for="confirma" class="form-label">Confirma contraseña</label>
                        <input type="password" class="form-control form-control-lg" id="confirma" name="confirma">
                    </div>
                    <div class="f-flex justify-content-around">
                        <input type="submit" class="btn btn-primary" value="cambiar">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="editar-usuario.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $data['u_id']; ?>">
                    <div class="mb-3">
                        <label class="form-label" for="nombre">Nombre</label>
                        <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $data['u_nombre']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="apellido">Apellido</label>
                        <input type="text" class="form-control form-control-lg" id="apellido" name="apellido" placeholder="Apellido" value="<?php echo $data['u_apellido']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="correo">Correo</label>
                        <input type="text" class="form-control form-control-lg" id="correo" name="correo" placeholder="Correo" value="<?php echo $data['u_correo']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="imagen">imagen</label>
                        <input type="text" class="form-control form-control-lg" id="imagen" name="imagen" placeholder="Imagen" value="<?php echo $data['u_imagen']; ?>">
                    </div>
                    <div class="f-flex justify-content-around">
                        <input type="submit" class="btn btn-primary" value="cambiar">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<?php
include "includes/footer.php";

?>