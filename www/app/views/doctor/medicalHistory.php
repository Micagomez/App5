<?php
session_start();
require_once '../../models/getContacts.php';
require_once '../../models/getAddress.php';
require_once '../../models/getPersons.php';
require_once '../../models/getNeighborhood.php';

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

$contactos = obtenerContactos();
$personas= obtenerPersonas();
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
                            <div class="row">
                                <div class="col-sm-8">
                                    <h1 class="mainTitle">Médico | Vista Historial Clínico</h1>
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
                            <div class="row">
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
                                            foreach ($personas as $row) {
                                                if($row['status'] == 0){
                                                    continue; // evitamos mostrar los pacientes borrados
                                                }
                                            ?>
                                            
                                                <tr class="center">
                                                    <td class="hidden-xs"><?php echo $row['name']; ?></td>
                                                    <td class="hidden-xs"><?php echo $row['surname']; ?></td>
                                                    <td class="hidden-xs"><?php
                                                    foreach($contactos as $contact){
                                                        if($contact['id_person'] == $row['id']){
                                                            echo $contact['contact'];
                                                        }
                                                    }
                                                    ?></td>
                                                    <td class="hidden-xs"><?php echo $row['dni']; ?></td>
                                                    <td class="hidden-xs"><?php echo date('d/m/Y', strtotime($row['birth_date'])); ?></td>
                                                    <td class="hidden-xs">
                                                        <a href="addClinicalHistory.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Agregar Historial</a>
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
