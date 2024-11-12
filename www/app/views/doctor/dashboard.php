<?php
session_start();
if (isset( $_SESSION)) {
    if (( $_SESSION['rol']) == "" ||  $_SESSION['rol'] != '3') {
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
if(empty($_SESSION)){
    echo '<script type="text/javascript">';
    echo 'window.location.href="../login.php";';
    echo '</script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Médico | Vista general</title>
	<?php include ('../include/head.php');?>
</head>
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
                                <h1 class="mainTitle">Médico | Vista general</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Médico</span></li>
                                <li class="active"><span>Vista general</span></li>
                            </ol>
                        </div>
                    </section>
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Ver Turnos</h2>
                                        <p class="cl-effect-1">
                                            <a href="appointmentsToday.php">
                                                Turnos del dia
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Últimos Historiales Creados</h2>
                                        <p class="cl-effect-1">
                                            <a href="listClinicalHistoy.php">
                                                Lista de historales clínicos
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-terminal fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Historial Clínico</h2>
                                        <p class="links cl-effect-1">
                                            <a href="medicalHistory.php">
                                                Agregar Historial Clínico
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('../include/footer.php'); ?>
                <?php include('../include/setting.php'); ?>
            </div>
        </div>
		<?php include('../include/script.php'); ?>
    </div>
</body>
</html>
