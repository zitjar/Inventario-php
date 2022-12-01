<?php

require 'includes/config/database.php';

$db = conectarDb();

$nombre = '';
$descripcion = '';
$almacen = '';
$tipoArtiulo = '';
$fechaIngreso = '';
$imagen = '';
$categoria = '';

$errores = [];

if($_SERVER['REQUEST_METHOD']==='POST'){

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$almacen = $_POST['almacen'];
$tipoArtiulo = $_POST['tipoArticulo'];
$fechaIngreso = $_POST['fechaIngreso'];
$imagen = $_POST['imagen'];
$categoria = $_POST['categoria'];

if(!$nombre){
    $errores[] = "Debe ingresar el nombre del activo";
}

if(!$descripcion){
    $errores[] = "La descripción es obligatoria";
}

if(!$almacen){
    $errores[] = "La ubicación del activo es obligatoria";
}

if(!$tipoArtiulo){
    $errores[] = "Ingrese que tipo de activo es";
}

if(!$fechaIngreso){
    $errores[] = "Debe ingresar la fecha en la que se adquirio el activo";
}

if(!$imagen){
    $errores[] = "Ingrese el link de la imagen";
}
if(!$categoria){
    $errores[] = "Ingrese una categoria";
}


if(empty($errores)){
    $sql = "UPDATE `activos` SET `a_nombre` = '$nombre', `a_descripcion` = '$descripcion', `a_almacen` = '$almacen', `a_tipo_articulo` = '$tipoArtiulo', `a_fecha_ingreso` = '$fechaIngreso', `a_categoria` = '$categoria', `a_imagen` = '$imagen' WHERE `activos`.`a_id` = "$id";";
    
    $resultado = mysqli_query($db, $sql);
    
    if(!$resultado){
       header('Location:lista-de-activos.php?resultado=2');
    }else{
        header('Location:lista-de-activos.php?resultado=3');
    }
}

}

$id = $_GET['id'];

$query = "SELECT * FROM activos WHERE a_id = '$id'";

$result = mysqli_query($db, $query);

$data = mysqli_fetch_assoc($result);

include 'includes/header.php';

?>
<section class="container pt-5">
<h2>Editar Activo</h2>
    <form class="form-group" method="POST" action="actualizar-activo.php">

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error ?>
        </div>
        <?php endforeach; ?>

        <fieldset>
            <div>
                <div class="mb-3 col-auto">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $data['a_nombre'] ?>">
                </div>
                <div class="mb-3 col-auto">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion"
                        value="" rows="3"><?php echo $data['a_descripcion'] ?></textarea>
                </div>
                <div class="mb-3 col-auto">
                    <label for="almacen" class="form-label">Ubicación</label>
                    <input type="text" class="form-control" id="almacen" value="<?php echo $data['a_almacen'] ?>" name="almacen">
                </div>
                <div class="mb-3 col-auto">
                    <label for="tipoArticulo" class="form-label">Tipo de artículo</label>
                    <input type="text" class="form-control" id="tipoArticulo" value="<?php echo $data['a_tipo_articulo'] ?>"
                        name="tipoArticulo">
                </div>
                <div class="mb-3 col-auto">
                    <label for="categoria" class="form-label">Categoria</label>
                    <input type="text" class="form-control" id="categoria" value="<?php echo $data['a_categoria'] ?>"
                        name="categoria">
                </div>
                <div class="mb-3 col-auto">
                    <label for="fechaIngreso" class="form-label">Fecha de ingreso</label>
                    <input type="date" class="form-control" name="fechaIngreso" id="fechaIngreso"
                        value="<?php echo $data['a_fecha_ingreso'] ?>" name="fechaIngreso">
                </div>
                <div class="mb-3 col-auto">
                    <label for="imagen" class="form-label">link de la imagen</label>
                    <input type="text" class="form-control" value="<?php echo $data['a_imagen'] ?>" name="imagen" id="imagen">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </fieldset>
    </form>

</section>

<?php
include 'includes/footer.php';