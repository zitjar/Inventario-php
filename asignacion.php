<?php 

include 'includes/header.php';
include "includes/config/database.php";

$db = conectarDb();

if($_SERVER['REQUEST_METHOD']==='POST'){
$equipo = $_POST['equipo'];
$usuario = $_POST['usuario'];
$fecha = date("Y-m-d");

$sql3 = "SELECT * FROM asignacion";
$dato = mysqli_query($db, $sql3);


        $sql = "INSERT INTO asignacion (id_usuario, id_activo, fecha) VALUES ('$usuario', '$equipo','$fecha')";
        $sql4 = "UPDATE activos SET a_asignado = 'S' WHERE a_id = $equipo";
        $sql5 = "UPDATE usuarios SET u_asignado = 'S' WHERE u_id = $usuario";
        
        $result1 = mysqli_query($db, $sql4);
        $result2 = mysqli_query($db, $sql5);
        $result3 = mysqli_query($db, $sql);
        
        if(!$result3){
            header('Location:/asignacion.php?resultado=2');
        }else{
            header('Location:/asignacion.php?resultado=1');
        }
        
}

$resultado = $_GET['resultado'] ?? null;
?>

<main class="container py-5">
    <h2>Asignar equipo</h2>
    <?php
    if(intval($resultado) ===2){
        echo '<div class="alerta success">El Equipo ha sido asignado éxitosamente</div>';
    } elseif(intval($resultado) ===1){
        echo '<div class="alerta error">¡upps ha ocurrido un error, intenta de nuevo!</div>';
    }
    ?>
    <form action="asignacion.php" method="POST" class="pt-5">
        <div class="d-flex justify-content-between">
            <div class="mb-3">
                <label for="usuario" class="form-label">Personal</label>
                <?php
                        $sql1 = "SELECT * FROM usuarios";
                        $result1 = mysqli_query($db, $sql1);
                ?>
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="usuario"
                    id="usuario">
                    <?php
                        while($data1 = mysqli_fetch_assoc($result1)){
                            if($data1['u_activo']==="S"){
                                if($data1['u_asignado']==="N"){
                ?>
                    <option value="<?php echo $data1['u_id']?>">
                        <?php echo $data1['u_nombre'] .' '. $data1['u_apellido']?></option>
                    <?php
                                }
                            }
                            }
                ?>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <button type="submit" class="btn btn-lg btn-warning">Asignar</button>
            </div>
            <div class="mb-3">
                <?php
                    $sql2 = "SELECT a_id, a_nombre, a_asignado FROM activos";

                    $result2 = mysqli_query($db, $sql2);
                    ?>
                <label for="equipo" class="form-label">Equipos</label>
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="equipo"
                    name="equipo">
                    <?php  while ($data2 = mysqli_fetch_assoc($result2)){
                    if($data2['a_asignado']=="N"){
                ?>
                    <option value="<?php echo $data2['a_id'] ?>"><?php  echo $data2['a_nombre']?></option>
                    <?php
                   }}
                   ?>
                </select>
            </div>
        </div>
    </form>

</main>

<?php
include 'includes/footer.php';
?>