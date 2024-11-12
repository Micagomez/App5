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

require_once '../../models/getSpecialistLicenseSpecialty.php';
require_once '../../models/getPersonById.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $personId = $_GET['id'];
}

$doctors = obtenerDatosEspecialistas();
//var_dump($doctors);
foreach($doctors as $doctor){
    if($doctor['specialist_id'] == $_SESSION['specialist']){
        $doctorName = $doctor['specialist_name'];
        $doctorSpeciality = $doctor['specialities'];
    }
}

$person = obtenerPersonaPorId($personId);
foreach($person as $patient){
    $patientName = $patient['name'];
}
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
                                    <h1 class="mainTitle">Médico | Agregar Historial Clínico</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li>
                                        <span>Médico</span>
                                    </li>
                                    <li class="active">
                                        <span>Historial Clínico</span>
                                    </li>
                                </ol>
                            </div>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="panel panel-white">
                                    <div class="panel-body">
                                        <form id = "appointmentForm" role="form" name="book" method="post" action="../../controllers/insertClinicalHistory.php">
                                            <div class="form-group">
                                                <label for="doctor">Médico</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $doctorName; ?>">
                                                <input name="id_specialist" type="hidden" class="form-control" value="<?php echo $doctorId; ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="DoctorSpecialization">Especialización Médico</label>
                                                <input id = "speciality" name="speciality" type="text" class="form-control" readonly value="<?php echo $doctorSpeciality; ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="consultancyfees">Paciente</label>
                                                <input type="text" readonly class="form-control" value="<?php echo $patientName; ?>">
                                             </div>

                                             <div class="form-group">
                                                <label for="date">Fecha</label>
                                                <span id="date" class="form-control" readonly></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="coment">Comentario de la consulta de hoy</label>
                                                <textarea name="coment" id="coment" class="form-control" rows="5" style="width: 100%;"></textarea>
                                            </div>


                                            <button id = "button" type="submit" name="submit" class="btn btn-o btn-primary">Enviar</button>
                                        </form>
                                        <div id = "messaje"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        
        <?php include('../include/script.php'); ?>
        
        <script>
            // Obtener el campo de fecha
            const dateSpan = document.getElementById('date');

            // Crear una nueva fecha con la fecha actual
            const today = new Date();
            
            // Formatear la fecha en DD-MM-YYYY
            const day = String(today.getDate()).padStart(2, '0');
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Los meses van de 0 a 11
            const year = today.getFullYear();
            
            // Formato DD-MM-YYYY
            const formattedDate = `${day}-${month}-${year}`;
            
            // Establecer la fecha actual en el span
            dateSpan.textContent = formattedDate;
        </script>
        <?php include('../include/footer.php'); ?>
        <?php include('../include/setting.php'); ?>
    </body>
</html>
