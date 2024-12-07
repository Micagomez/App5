<?php
session_start();

require_once '../../models/getSpecialistLicenseSpecialty.php';
require_once '../../models/getPersonById.php';
require_once '../../models/getTypeConsultation.php';

if (isset($_SESSION)) {
    if ($_SESSION['rol'] == "" or $_SESSION['rol'] != '3') {        
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


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $personId = $_GET['id'];
}

$consultas = obtenerTipodeConsulta();

$doctors = obtenerDatosEspecialistas();
foreach($doctors as $doctor){
    if($doctor['specialist_id'] == $_SESSION['specialist']){
        $doctorName = $doctor['specialist_name'];
        $doctorSpeciality = $doctor['specialities'];
        $doctorId = $doctor['specialist_id'];
    }
}
function calcularEdad($fechaNacimiento) {
    $fechaNacimiento = new DateTime($fechaNacimiento);
    $fechaActual = new DateTime();
    $diferencia = $fechaActual->diff($fechaNacimiento);
    return $diferencia->y;
}

$person = obtenerPersonaPorId($personId);
foreach($person as $patient){
    $patientName = $patient['name'];
    $birthDate = $patient['birth_date']; 
    $patientAge = calcularEdad($birthDate);
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
                                    <h1 class="mainTitle">Médico | Agregar Historial Clínico Detallado</h1>
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
                            <div class="col-lg-12 col-md-12">
                                <div class="panel panel-white">
                                    <div class="panel-body">
                                        <form id="clinicalHistoryForm" role="form" name="clinicalHistory" method="post" action="../../controllers/insertClinicalHistoryController.php">
                                            <!-- Patient Information Section -->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="doctor">Médico</label>
                                                        <input type="text" class="form-control" readonly value="<?php echo $doctorName; ?>">
                                                        <input name="id_specialist" type="hidden" value="<?php echo $doctorId; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="speciality">Especialización Médico</label>
                                                        <input id="speciality" name="speciality" type="text" class="form-control" readonly value="<?php echo $doctorSpeciality; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="date">Fecha de Consulta</label>
                                                        <input type="text" id="date" name="consultation_date" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Patient Basic Information -->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="patient">Paciente</label>
                                                        <input type="text" readonly class="form-control" value="<?php echo $patientName; ?>">
                                                        <input type="hidden" name="patient_id" value="<?php echo $personId; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="patient_age">Edad</label>
                                                        <input type="text" readonly class="form-control" value="<?php echo $patientAge; ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="consultation_type">Tipo de Consulta</label>
                                                        <select name="consultas[]" class="form-control select2-multi"  placeholder="Tipo de consulta" required>
                                                        <?php
                                                            if (!empty($consultas)) {
                                                                foreach ($consultas as $consulta) {
                                                                    echo '<option value="' . $consulta['id'] . '">' . $consulta['type'] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="">No hay tipos de consulta disponibles</option>';
                                                            }
                                                            ?>
                                                        </select>


                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Clinical Assessment Section -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="reason_consultation">Motivo de Consulta</label>
                                                        <textarea name="reason_consultation" class="form-control" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="current_symptoms">Síntomas Actuales</label>
                                                        <textarea name="current_symptoms" class="form-control" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Physical Examination Section -->
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="blood_pressure">Presión Arterial (mmHg)</label>
                                                        <input type="text" name="blood_pressure" class="form-control" placeholder="ej. 120/80">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="heart_rate">Frecuencia Cardíaca (bpm)</label>
                                                        <input type="number" name="heart_rate" class="form-control" min="40" max="200">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="temperature">Temperatura (°C)</label>
                                                        <input type="number" name="temperature" class="form-control" step="0.1" min="35" max="42">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="weight">Peso (kg)</label>
                                                        <input type="number" name="weight" class="form-control" step="0.1" min="0">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Diagnosis and Treatment Section -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="diagnostic">Diagnóstico</label>
                                                        <textarea name="diagnostic" class="form-control" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="treatment_plan">Plan de Tratamiento</label>
                                                        <textarea name="treatment_plan" class="form-control" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Medications Section -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="medications">Medicamentos Recetados</label>
                                                        <textarea name="medications" class="form-control" rows="3" placeholder="Nombre del medicamento, dosis, frecuencia"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Additional Notes -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="additional_comments">Notas Adicionales</label>
                                                        <textarea name="additional_comments" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" name="submit" class="btn btn-primary btn-block">Guardar Historial Clínico</button>
                                        </form>
                                        <div id="message"></div>
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
            // Date formatting script
            const dateInput = document.getElementById('date');
            const today = new Date();
            
            const day = String(today.getDate()).padStart(2, '0');
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const year = today.getFullYear();
            
            const formattedDate = `${day}-${month}-${year}`;
            
            dateInput.value = formattedDate;

            // Optional: Form validation
            document.getElementById('clinicalHistoryForm').addEventListener('submit', function(e) {
                const requiredFields = ['reason_consultation', 'current_symptoms', 'diagnostic', 'treatment_plan'];
                let isValid = true;

                requiredFields.forEach(fieldName => {
                    const field = document.querySelector(`[name="${fieldName}"]`);
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Por favor, complete todos los campos requeridos.');
                }
            });
        </script>
        <?php include('../include/footer.php'); ?>
        <?php include('../include/setting.php'); ?>
    </body>
</html>


