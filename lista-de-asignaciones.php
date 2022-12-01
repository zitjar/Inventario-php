<?php 
require "includes/funciones.php";
$auth = autenticado();

if(!$auth){
    header("Location:login.php");
}

include 'includes/header.php';
include "includes/config/database.php";

$db = conectarDb();

$sql = "SELECT id, id_usuario, id_activo, u_nombre, a_descripcion, a_nombre, fecha FROM asignacion INNER JOIN usuarios  on asignacion.id_usuario = usuarios.u_id INNER JOIN activos on asignacion.id_activo = activos.a_id;";

$result = mysqli_query($db, $sql);

$resultado = $_GET['resultado'] ?? null;
?>

<main class="container magin-top-10">
    <div class="d-flex justify-content-between pt-5">
        <div>
            <h2>Lista de Asignaciones</h2>
        </div>
        <div><a href="asignacion.php" class="btn btn-primary">Asignar equipo</a></div>
    </div>
    <?php if(intval($resultado) === 1){
        echo '<div class="alerta success">Se registro con éxito</div>';
    } elseif(intval($resultado) ===2){
        echo '<div class="alerta error">!Upps algo salió mal intenta de nuevo</div>';
    } elseif(intval($resultado) ===3){
        echo '<div class="alerta success">registro actualizado con éxito</div>';
    } elseif(intval($resultado) ===4){
        echo '<div class="alerta success">registro Eliminado con éxito</div>';
    }

    ?>
    <div class="my-5">
        <table class="table table-striped" id="table-activos" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Equipo</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">fecha</th>
                    <th class="text-center">Borrar</th>
                </tr>
            </thead>
            <tbody>

                <?php
                    while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td class="text-center"><?php echo $row["u_nombre"]  ?></td>
                    <td class="text-center"><?php echo $row["a_nombre"]  ?></td>
                    <td class="text-center"><?php echo $row["a_descripcion"]  ?></td>
                    <td class="text-center"><?php echo $row["fecha"]  ?></td>
                    <td class="text-center"><a data-href="eliminar-asignacion.php?id=<?php echo $row['id'] ?>&equipo=<?php echo $row['id_activo'] ?>&usuario=<?php echo $row['id_usuario'] ?>"
                            class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </a></td>
                </tr>
                <?php  
                    }
                ?>
            </tbody>
        </table>
    </div>
</main>



<!-- Modal -->
<div class="modal fade" id="eliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">¿Deseas eliminar esta asignación?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Eliminar Asignación
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a class="btn btn-danger btn-ok">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<!--Modal-->
<?php
include 'includes/footer.php';
?>
<script>
$(document).ready(function() {
    $('#table-activos').DataTable({
        search: {
            return: true,
        },
        language: {
            lengthMenu: 'Mostrar _MENU_ registros por página',
            zeroRecords: 'No se encontró nada - lo siento',
            info: 'Mostrando la página _PAGE_ de _PAGES_',
            infoEmpty: 'No hay registros disponibles',
            infoFiltered: '(filtrado de _MAX_ registros totales)',
            loadingRecords: "Cargando...",
            search: "Buscar",
            zeroRecords: "No se encontraron registros",
            processing: "Procesando",
            paginate: {
                next: "Siguiente",
                previous: "Anterior",
                first: "Primera",
                last: "Última"
            }
        },
        scrollY: '100vh',
        scrollCollapse: true,
        pagingType: 'full_numbers'
    });
});
$('#eliminar').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data(
        'href'));

    $('.debug-url').html('Delete URL: <Strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
});
</script>