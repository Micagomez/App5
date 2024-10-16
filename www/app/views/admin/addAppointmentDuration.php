<?php
session_start();
if (isset( $_SESSION)) {
    if (( $_SESSION['rol']) == "" or  $_SESSION['rol'] != '2') {
        // var_dump($_SESSION['rol']);
        // exit;
        // ob_start();
        
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title> Admin | Duración del turno</title>
	<?php include ('../include/head.php');?> 
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
                                <h1 class="mainTitle">Administrador | Agregar duración de atención</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Admin</span>
                                </li>
                                <li class="active">
                                    <span>Agregar duración de atención</span>
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
                                                <h5 class="panel-title">Duración de atención</h5>
                                            </div>
                                            <div class="panel-body">
                                                <form id="appointmentForm" role="form" name="dcotorspcl" method="POST" action="../../controllers/addAppoinmentDuration.php">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Ingrese la duración del turno en minutos</label>
                                                        <input type="number" id="durationInput" name="duracion" class="form-control" required>
                                                    </div>
                                                    <button id="submitButton" type="button" class="btn btn-o btn-primary">Agregar</button>
                                                </form>
                                                <div id="messaje"></div>
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
    <script src="../../../assets/js/addAppointmentDuration.js"></script>
</body>
</html>
