<?php
require "includes/funciones.php";
$auth = autenticado();

if(!$auth){
    header("Location:login.php");
}

include "includes/config/database.php";

session_start();

$db = conectarDb();

$sql = "SELECT * FROM usuarios";

$result = mysqli_query($db, $sql);

$resultado = $_GET['resultado'] ?? null;
//=========================================================
$rol = $_SESSION['rol'];
if($rol === "Usuario"){
header("Location:/index.php");
}
include "includes/header.php";
?>

<main class="container magin-top-10">
    <div class="d-flex justify-content-between pt-5">
        <div>
            <h2>Lista de usuarios</h2>
        </div>
    </div>
    <?php  
    if(intval($resultado) ===2){
        echo '<div class="alerta success">El usuario ha sido actualizado éxitosamente</div>';
    } elseif(intval($resultado) ===1){
        echo '<div class="alerta error">¡upps ha ocurrido un error, intenta de nuevo!</div>';
    }elseif(intval($resultado) ===3){
        echo '<div class="alerta error">¡Usuario eliminado con éxito!</div>';
    }

    ?>
    <div class="my-5">
        <table class="table table-striped" id="table-usuarios" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">N# Empleado</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Apellido</th>
                    <th class="text-center">Correo</th>
                    <th class="text-center">Imagen</th>
                    <th class="text-center">Activo</th>
                    <th class="text-center">Rol</th>
                    <th class="text-center">Fecha de ingreso</th>
                    <th class="text-center">Eliminar</th>
                </tr>
            </thead>
            <tbody>

                <?php
                    while($row = mysqli_fetch_assoc($result)){
                        if($row['u_eliminar'] !== "1"){
                ?>
                <tr>
                    <td class="text-center"><?php echo $row["u_id"]  ?></td>
                    <td class="text-center"><?php echo $row["u_nombre"]  ?></td>
                    <td class="text-center"><?php echo $row["u_apellido"]  ?></td>
                    <td class="text-center"><?php echo $row["u_correo"]  ?></td>
                    <td class="text-center"><img src="<?php echo $row["u_imagen"]?>" alt="Empleado"
                            class="img-fluid img-thumbnail"></td>
                    <td class="text-center">
                        <form action="activar.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $row['u_id']?>">
                            <input type="hidden" name="activo" value="<?php echo $row['u_activo']; ?>">
                            <button type="submit"
                                class="btn <?php echo $row['u_activo'] == "S"? 'btn-success': 'btn-danger' ?>">
                                <?php echo $row['u_activo'] == "S"? "<i class='fa-solid fa-check'></i>": "<i class='fa-solid fa-xmark'></i>" ?>
                            </button>
                        </form>
                    </td>
                    <td class="text-center">
                        <form action="cambiar-rol.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $row['u_id']?>">
                            <input type="hidden" name="rol" value="<?php echo $row['u_rol']; ?>">
                            <button type="submit"
                                class="btn <?php echo $row['u_rol'] === "Administrador"? 'btn-secondary': 'btn-primary' ?>">
                                <?php echo $row['u_rol'] === "Administrador"? "<i class='fa-solid fa-users'></i>": "<i class='fa-solid fa-user-tie'></i>" ?>
                            </button>
                        </form>
                    </td>
                    <td class="text-center"><?php echo $row["u_fecha_ingreso"]  ?></td>
                    <td class="text-center">
                        <button data-bs-whatever="<?php echo $row['u_id']?>" type="button" class="btn btn-primary"
                            data-bs-toggle="modal" data-bs-target="#eliminar">
                            <i class='fa-solid fa-xmark'></i>
                        </button>

                    </td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="eliminar" tabindex="-1" aria-labelledby="eliminar" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">¿Eliminar usuario?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="eliminar-usuario.php?id=" method="POST">
                                    <input id="id" type="hidden" name="id">
                                    <input type="hidden" name="eliminar" value="1">
                                    <button type="submit" class="btn btn-danger">
                                        Eliminar <i class='fa-solid fa-xmark'></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php  
                          }  }
                ?>
            </tbody>
        </table>
    </div>
</main>




<?php
include 'includes/footer.php';
?>
<script>
$(document).ready(function() {
    $('#table-usuarios').DataTable({
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
<script>
const exampleModal = document.getElementById('eliminar')
exampleModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget
    const recipient = button.getAttribute('data-bs-whatever')
    const modalBodyInput = exampleModal.querySelector('.modal-body input')

    modalBodyInput.value = recipient
})
</script>