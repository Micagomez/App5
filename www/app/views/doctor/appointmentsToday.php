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
                                                <th class="center">Estado</th>
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
                                                        <?php 
                                                            if($turno['status'] == 1){
                                                                echo "Paciente esperando a ser atendido";
                                                            }elseif($turno['status'] == 3){
                                                                echo "Paciente atendido";
                                                            }else{
                                                                echo "Paciente ausente";
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="hidden-xs">
                                                        <button type="button" class="btn-attended btn btn-success" data-id="<?php echo $turno['id']; ?>">Paciente Atendido</button>
                                                        <button type="button" class="btn-absent btn btn-danger" data-id="<?php echo $turno['id']; ?>">Paciente Ausente</button>
                                                    </td>
                                                </tr>
                                            <?php
                                            } ?>
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
        </div>


        
        <?php include('../include/script.php'); ?>
        <script src="../../../assets/js/appointmentCompleted.js"></script>
        <script src="../../../assets/js/appointmentIncompleted.js"></script>
        
    </body>
</html>
