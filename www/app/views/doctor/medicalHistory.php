<?php
session_start();
require_once '../../models/getAppointmentByDate.php';

if (isset( $_SESSION)) {
    if (( $_SESSION['rol']) == "" or  $_SESSION['rol'] != '3') {        
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
$date = date('Y-m-d');
$turnos = obtenerTurnosDelEspecialista($date, $_SESSION['specialist']);
//var_dump($turnos);
?>

<!DOCTYPE html>
<html lang="es">
    <?php include ('../include/head.php'); ?> 
    <body>
        <div id="app">        
            <?php include('../include/sidebar_doctor.php'); ?>
            <div class="app-content">
                <?php include('../include/header.php'); ?>
                <div class="main-content">
                    <div class="wrap-content container" id="container">
                        <section id="page-title">
                            <div class="turno">
                                <div class="col-sm-8">
                                    <h1 class="mainTitle">Médico | Lista de Pacientes del Día de Hoy</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li>
                                        <span>Médico</span>
                                    </li>
                                    <li class="active">
                                        <span>Pacientes</span>
                                    </li>
                                </ol>
                            </div>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                            <div class="turno">
                                <div class="col-md-12">
                                    <table class="table table-hover" id="sample-table-1">
                                        <thead>
                                            <tr>
                                                <th class="center">Nombre</th>
                                                <th class="center">Apellido</th>
                                                <th class="center">Contacto</th>
                                                <th class="center">D.N.I</th>
                                                <th class="center">Fecha de Nacimiento</th>
                                                <th class="center">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($turnos as $turno) {
                                            ?>
                                            
                                                <tr class="center">
                                                    <td class="hidden-xs"><?php echo $turno['name']; ?></td>
                                                    <td class="hidden-xs"><?php echo $turno['surname']; ?></td>
                                                    <td class="hidden-xs"><?php echo $turno['contact'] ?></td>
                                                    <td class="hidden-xs"><?php echo $turno['dni']; ?></td>
                                                    <td class="hidden-xs"><?php echo date('d/m/Y', strtotime($turno['birth_date'])); ?></td>
                                                    <td class="hidden-xs">
                                                        <a href="addClinicalHistory.php?id=<?php echo $turno['person_id']; ?>" class="btn btn-primary">Agregar Historial</a>
                                                    </td>
                                                </tr>
                                            <?php
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('../include/footer.php'); ?>
            <?php include('../include/setting.php'); ?>
        </div>


        
        <?php include('../include/script.php'); ?>
        
    </body>
</html>
