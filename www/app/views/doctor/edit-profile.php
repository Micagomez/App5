<?php
session_start();
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

require_once '../../models/getSpecialistById.php';

$doctorId = $_SESSION['specialist'];
$doctors = obtenerEspecialistaPorId($doctorId);
foreach($doctors as $doctor){
    $doctorNombre = $doctor['name'];
    $doctorApellido = $doctor['surname'];
    $doctorOnlineConsultation = $doctor['online_consultation'];
    $doctorCalle = $doctor['street'];
    $doctorNumero = $doctor['number'];
    $doctorDepartamento = $doctor['apartment'];
    $doctorPiso = $doctor['floor'];
}  
?> 

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Usuario | Editar Perfil</title>
    <?php include('../include/head.php'); ?>
</head>

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
                                <h1 class="mainTitle">Administrador | Modificación del doctor</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Admin</span>
                                </li>
                                <li class="active">
                                    <span>Modificación del doctor</span>
                                </li>
                            </ol>
                        </div>
                    </section>

                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h5 class="panel-title">Información personal de <?php echo $doctorNombre; ?></h5>
                                            </div>
                                            <div class="panel-body">
                                                <form id="editDoctorForm" role="form" name="dcotorspcl" method="POST" action="../../controllers/editDoctor.php">
                                                    <!-- Campo oculto para enviar el ID del doctor -->
                                                    <input type="hidden" name="id_doctor" value="<?php echo $doctorId; ?>">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="name">Nombre</label>
                                                                <input id = "name" type="text" name="name" class="form-control" value="<?php echo $doctorNombre; ?>">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="surname">Apellido</label>
                                                                <input id = "surname" type="text" name="surname" class="form-control" value="<?php echo $doctorApellido; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        Realiza consultas online?
                                                        <select id = "onlineConsultation" name="onlineConsultation" id="onlineConsultation">
                                                            <option value="1">Si</option>
                                                            <option value="2">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="steet">Calle</label>
                                                                <input id = "street" type="text" name="street" class="form-control" value="<?php echo $doctorCalle; ?>">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="number">Número</label>
                                                            <input id = "number" type="text" name="number" class="form-control" value="<?php echo $doctorNumero; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="depto">Departamento</label>
                                                            <input id = "apartment" type="text" name="apartment" class="form-control" value="<?php echo $doctorDepartamento; ?>">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="floor">Piso</label>
                                                            <input id = "floor" type="text" name="floor" class="form-control" value="<?php echo $doctorPiso; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button id = "button" type="submit" class="btn btn-o btn-primary">Modificar</button>
                                                </form>
                                                <div id="message"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="panel panel-white"></div>
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
    <script src="../../../assets/js/updateDoctor.js"></script>
</body>

</html>


