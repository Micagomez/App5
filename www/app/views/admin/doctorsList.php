<?php
session_start();
include '../../models/connection.php';
include '../../models/getSpecialist.php';
include '../../models/getSpecialistById.php';
include '../../models/getSpecialistLicenseSpecialty.php';

if (isset($_SESSION)) {
    if (($_SESSION['rol']) == "" or $_SESSION['rol'] != '2') {
        echo '<script type="text/javascript">';
        echo 'window.location.href="../login.php";';
        echo '</script>';
        exit();
    }
} else {
    echo '<script type="text/javascript">';
    echo 'window.location.href="../login.php";';
    echo '</script>';
    exit();
}

$doctores = obtenerEspecialistas();
$datosEspecialistas = obtenerDatosEspecialistas();
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../include/head.php'); ?>

<body>
    <div id="app">
        <?php include('../include/sidebar_admin.php'); ?>
        <div class="app-content">
            <?php include('../include/header.php'); ?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">Administración | Vista Doctores</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Admin</span>
                                </li>
                                <li class="active">
                                    <span>Doctores</span>
                                </li>
                            </ol>
                            <div>
                                <a href="../admin/add-doctor.php">
                                    <button type="button">Agregar Doctor</button>
                                </a>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="dataTabledoctorList" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="center">Nombre: </th>
                                            <th class="center">Apellido: </th>
                                            <!-- <th class="center">Calle</th>
                                            <th class="center">Número</th>
                                            <th class="center">Departamento</th>
                                            <th class="center">Piso</th> -->
                                            <th class="center">Matricula: </th>
                                            <th class="center">Realiza consuta online</th>
                                            <th class="center">Estado</th>
                                            <th class="center">Accion</th>
                                            <th class="center">Agregar días y fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <!-- <td class="hidden-xs">
                                        <?php
                                                        if($row['status'] == 1){
                                                            echo 'Activo';
                                                        }
                                                        else{
                                                            echo 'Inactivo';
                                                        }
                                                    ?></td> -->
                                        <?php
                                        if (!empty($datosEspecialistas)) {
                                            foreach ($datosEspecialistas as $row) {
                                                // Verificar si el especialista está activo
                                                if (isset($row['status']) && $row['status'] == 0) {
                                                    continue; // evitamos mostrar los doctores inactivos
                                                }
                                                
                                                // Verificar si existen los campos antes de mostrarlos
                                                // nombre del especialista a la variable $name;(?) si no(:) está definido, asigna 'Sin nombre'.
                                                $name = isset($row['specialist_name']) ? $row['specialist_name'] : 'Sin nombre';
                                                $surname = isset($row['specialist_surname']) ? $row['specialist_surname'] : 'Sin apellido';
                                                $street = isset($row['street']) ? $row['street'] : 'Sin calle';
                                                $number = isset($row['number']) ? $row['number'] : 'Sin número';
                                                $specialities = isset($row['specialities']) ? $row['specialities'] : 'Sin especialidad asignada';
                                                $matricula = isset($row['license_numbers']) ? $row['license_numbers'] : 'Sin matrícula';
                                                $onlineConsultation = isset($row['online_consultation']) ? $row['online_consultation'] : 0;
                                                $status = isset($row['status']) ? $row['status'] : 'Desconocido';
                                                                        ?>
                                                <tr class="center">
                                                    <td class="hidden-xs"><?php echo $name; ?></td>
                                                    <td class="hidden-xs"><?php echo $surname; ?></td>
                                                    <td class="hidden-xs"><?php echo $matricula; ?></td>
                                                    <td class="hidden-xs">
                                                        <?php 
                                                        if ($onlineConsultation == 1) {
                                                            echo 'Realiza consultas online';
                                                        } else {
                                                            echo 'No realiza consultas online';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="hidden-xs">
                                                        <?php 
                                                        echo $status == 1 ? 'Activo' : 'Inactivo'; 
                                                        ?>
                                                    </td>
                                                    <!-- <td class="hidden-xs">
                                                        <button type="button" class="btn-activate" data-id="<?php echo $row['id']; ?>">Activar doctor</button>
                                                        <button type="button" class="btn-delete" data-id="<?php echo $row['id']; ?>">Borrar doctor</button>
                                                        <button type="button" class="btn-modificar" onclick="window.location.href='editDoctor.php?id=<?php echo $row['id']; ?>'">Modificar Doctor</button>
                                                    </td>
                                                    <td>
                                                    <button type="button" class="btn-modificar" onclick="window.location.href='manage-doctors.php?id=<?php echo $row['id']; ?>'">Horarios y Dias de trabajo</button>
                                                    </td> -->
                                                    <td>
                                                        <!-- <button type="button" class="btn btn-success" title="Ver detalles" data-toggle="modal" data-target="#doctorListModal" data-id="<?php echo $row['specialist_id']; ?>" onclick="showDoctorDetails(<?php echo $row['specialist_id']; ?>)">
                                                            <i class="ti-eye text-bold" aria-hidden="true"></i>
                                                        </button> -->
                                                        <button type="button" 
                                                                class="btn btn-success" 
                                                                title="Ver detalles" 
                                                                data-toggle="modal" 
                                                                data-target="#doctorListModal" 
                                                                onclick="showDoctorDetails(
                                                                    '<?php echo addslashes($name); ?>', 
                                                                    '<?php echo addslashes($surname); ?>', 
                                                                    '<?php echo addslashes($street); ?>', 
                                                                    '<?php echo addslashes($number); ?>', 
                                                                    '<?php echo addslashes($matricula); ?>', 
                                                                    <?php echo $onlineConsultation; ?>, 
                                                                    <?php echo $status; ?>,
                                                                    '<?php echo addslashes($specialities); ?>'
                                                                )">
                                                            <i class="ti-eye text-bold" aria-hidden="true"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-activate btn-info" title="Activar Doctor" data-id="<?php echo $row['specialist_id']; ?>">
                                                            <i class="ti-check text-bold" aria-hidden="true"></i></button>
                                                        <button type="button" class="btn btn-delete btn-danger" title="Borrar Doctor" data-id="<?php echo $row['specialist_id']; ?>"> 
                                                            <i class="ti-trash"  aria-hidden="true" ></i></button>
                                                        <button type="button" class="btn btn-modificar btn-primary" title="Modificar Doctor" onclick="window.location.href='editDoctor.php?id=<?php echo $row['specialist_id']; ?>'">
                                                        <i class="ti-pencil-alt"  aria-hidden="true" ></i></button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info" title="Horarios y días de trabajo" onclick="window.location.href='manage-doctors.php?id=<?php echo $row['specialist_id']; ?>'">
                                                            <i class="ti-calendar"  aria-hidden="true" ></i></button>
                                                    </td>
                                                </tr>
                                                <?php 
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>No se encontraron especialistas.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div id="messaje"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('../include/footer.php'); ?>
        <?php include('../include/setting.php'); ?>

        <br>
        <div class="modal fade" id="doctorListModal" tabindex="-1" role="dialog" aria-labelledby="doctorListModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="doctorListModalLabel">Información del Médico</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                </div>

                <div class="modal-body">
                
                        <p class="hidden-xs"><strong>Nombre: </strong><?php echo $name; ?></p>
                        <p class="hidden-xs"><strong>Apellido: </strong><?php echo $surname; ?></p>
                        <p class="hidden-xs"><strong>Calle: </strong><?php echo $street; ?></p>
                        <p class="hidden-xs"><strong>Número: </strong><?php echo $number; ?></p>
                        <p class="hidden-xs"><strong>Matrícula: </strong><?php echo $matricula; ?></p>
                        <p class="hidden-xs"><strong>Consulta Online: </strong>
                            <?php 
                            if ($onlineConsultation == 1) {
                                echo 'Realiza consultas online';
                            } else {
                                echo 'No realiza consultas online';
                            }
                            ?>
                        </p>
                        <p class="hidden-xs"><strong>Estado: </strong>
                            <?php 
                            echo $status == 1 ? 'Activo' : 'Inactivo'; 
                            ?>
                        </p>
                        <td class="hidden-xs">
                            <div class="dropdown">
                                <button class="btn btn-info btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Especialidades<span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <?php
                                    // Convertir las especialidades en un array y mostrar cada una como una opción
                                    $specialitiesArray = explode(',', $specialities);
                                    foreach ($specialitiesArray as $speciality) {
                                        echo "<li><a href='#'>{$speciality}</a></li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </td>
                    <?php
                //     }
                // }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">cerrar</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>





    </div>

    <?php include('../include/script.php'); ?>
    <script src="../../../assets/js/activeDoctor.js"></script>
    <script src="../../../assets/js/deleteDoctor.js"></script>
    <script>
        new DataTable('#dataTabledoctorList');
    </script>


<script>
    function showDoctorDetails(name, surname, street, number, matricula, onlineConsultation, status, specialities) {
    // Actualiza el contenido del modal con los detalles del especialista
    document.querySelector('#doctorListModal .modal-body').innerHTML = `
        <p class="hidden-xs"><strong>Nombre: </strong>${name}</p>
        <p class="hidden-xs"><strong>Apellido: </strong>${surname}</p>
        <p class="hidden-xs"><strong>Calle: </strong>${street}</p>
        <p class="hidden-xs"><strong>Número: </strong>${number}</p>
        <p class="hidden-xs"><strong>Matrícula: </strong>${matricula}</p>
        <p class="hidden-xs"><strong>Consulta Online: </strong>${onlineConsultation == 1 ? 'Realiza consultas online' : 'No realiza consultas online'}</p>
        <p class="hidden-xs"><strong>Estado: </strong>${status == 1 ? 'Activo' : 'Inactivo'}</p>
        <div class="dropdown">
            <button class="btn btn-info btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Especialidades<span class="caret"></span></button>
            <ul class="dropdown-menu">
                ${specialities.split(',').map(speciality => `<li><a href='#'>${speciality}</a></li>`).join('')}
            </ul>
        </div>
    `;
}
</script>
</body>

</html>
