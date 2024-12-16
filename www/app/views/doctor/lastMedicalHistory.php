<?php
session_start();

require_once '../../models/getClinicalHistory.php';


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

$historialClinico =obtenerRegistrosHistorialClinico();
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
                                    <h1 class="mainTitle">Médico | Últimos Historiales Agregados</h1>
                                </div>
                            </div>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="dataTabledoctorList" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                        <th class="center">Paciente: </th>
                                        <th class="center">DNI </th>
                                        <th class="center">Fecha</th>
                                        <th class="center">Última consulta</th>
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
                                        if (!empty($historialClinico)) {
                                            foreach ($historialClinico as $row) {
                                            // Verificar si existen los campos antes de mostrarlos
                                                // nombre del especialista a la variable $name;(?) si no(:) está definido, asigna 'Sin nombre'.
                                                $name = isset($row['specialist_name']) ? $row['specialist_name'] : 'Sin nombre';
                                                $surname = isset($row['specialist_surname']) ? $row['specialist_surname'] : 'Sin apellido';
                                                $speciality = isset($row['speciality_name']) ? $row['speciality_name'] : 'Sin especialidad';
                                                $date = isset($row['consultation_date']) 
                                                ? (new DateTime($row['consultation_date']))->format('d/m/Y') 
                                                : 'Sin fecha';
                                                $person_name = isset($row['person_name']) ? $row['person_name'] : 'Sin nombre';
                                                $person_surname = isset($row['person_surname']) ? $row['person_surname'] : 'Sin apellido';
                                                $person_dni = isset($row['person_dni']) ? $row['person_dni'] : 'Sin dni';
                                                $consultation_type = isset($row['consultation_type']) ? $row['consultation_type'] : 'Sin consulta';
                                                $reason = isset($row['reason_consultation']) ? $row['reason_consultation'] : 'Sin motivo de consulta';
                                                $symptom = isset($row['current_symptoms']) ? $row['current_symptoms'] : 'Sin sintomas';
                                                $pressure = isset($row['blood_pressure']) ? $row['blood_pressure'] : 'No se tomo la presión';
                                                $rate = isset($row['heart_rate']) ? $row['heart_rate'] : 'No se tomo la frecuencia cardíaca';
                                                $temperature = isset($row['temperature']) ? $row['temperature'] : 'No se tomo la temperatura';
                                                $weight = isset($row['weight']) ? $row['weight'] : 'No se tomo el peso';
                                                $diagnostic = isset($row['diagnostic']) ? $row['diagnostic'] : 'Sin diagnostico';
                                                $treatment_plan = isset($row['treatment_plan']) ? $row['treatment_plan'] : 'Sin plan de tratamiento';
                                                $medications = isset($row['medications']) ? $row['medications'] : 'Sin medicamentos';
                                                $additional_comments = isset($row['additional_comments']) ? $row['additional_comments'] : 'Sin comentarios adicionales';
                                                $pdf_path = isset($row['pdf_path']) ? $row['pdf_path'] : 'No se genero pdf';
                                                ?>
                                                <tr class="center">
                                                    <td class="hidden-xs"><?php echo $person_name . " " . $person_surname; ?></td>
                                                    <td class="hidden-xs"><?php echo $person_dni; ?></td>
                                                    <td class="hidden-xs"><?php echo $date; ?></td>
                                                    </td>
                                                    <td>
                                                        <button type="button" 
                                                                class="btn btn-success" 
                                                                title="Ver detalles" 
                                                                data-toggle="modal" 
                                                                data-target="#consultationDetailsModal" 
                                                                onclick="showConsultationDetails(
                                                                    '<?php echo addslashes($name); ?>', 
                                                                    '<?php echo addslashes($surname); ?>', 
                                                                    '<?php echo addslashes($speciality); ?>', 
                                                                    '<?php echo addslashes($date); ?>', 
                                                                    '<?php echo addslashes($person_name); ?>', 
                                                                    '<?php echo addslashes($person_surname); ?>', 
                                                                    '<?php echo addslashes($person_dni); ?>', 
                                                                    '<?php echo addslashes($consultation_type); ?>', 
                                                                    '<?php echo addslashes($reason); ?>', 
                                                                    '<?php echo addslashes($symptom); ?>', 
                                                                    '<?php echo addslashes($pressure); ?>', 
                                                                    '<?php echo addslashes($rate); ?>', 
                                                                    '<?php echo addslashes($temperature); ?>', 
                                                                    '<?php echo addslashes($weight); ?>', 
                                                                    '<?php echo addslashes($diagnostic); ?>', 
                                                                    '<?php echo addslashes($treatment_plan); ?>', 
                                                                    '<?php echo addslashes($medications); ?>', 
                                                                    '<?php echo addslashes($additional_comments); ?>', 
                                                                    '<?php echo addslashes($pdf_path); ?>'
                                                                )">
                                                            <i class="ti-eye text-bold" aria-hidden="true"></i>
                                                        </button>

                                                    </td>
                                                </tr>
                                                <?php 
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>No se encontraron historia clínica.</td></tr>";
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
        <div class="modal fade" id="consultationDetailsModal" tabindex="-1" role="dialog" aria-labelledby="consultationDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="consultationDetailsModalLabel">Historia clínica</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                </div>

                <div class="modal-body">
                    
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
    function showConsultationDetails(name, surname, speciality, date, person_name, person_surname, person_dni, consultation_type, reason, symptom, pressure, rate, temperature, weight, diagnostic, treatment_plan, medications, additional_comments, pdf_path) {
        // Actualiza el contenido del modal con los detalles de la consulta
        document.querySelector('#consultationDetailsModal .modal-body').innerHTML = `
            <p class="hidden-xs"><strong>Especialista:</strong> ${name} ${surname}</p>
            <p class="hidden-xs"><strong>Especialidad:</strong> ${speciality}</p>
            <p class="hidden-xs"><strong>Fecha de consulta:</strong> ${date}</p>
            <hr>
            <p class="hidden-xs"><strong>Paciente:</strong> ${person_name} ${person_surname}</p>
            <p class="hidden-xs"><strong>DNI:</strong> ${person_dni}</p>
            <p class="hidden-xs"><strong>Tipo de consulta:</strong> ${consultation_type}</p>
            <p class="hidden-xs"><strong>Motivo de consulta:</strong> ${reason}</p>
            <p class="hidden-xs"><strong>Síntomas actuales:</strong> ${symptom}</p>
            <hr>
            <p class="hidden-xs"><strong>Presión arterial:</strong> ${pressure}</p>
            <p class="hidden-xs"><strong>Frecuencia cardíaca:</strong> ${rate}</p>
            <p class="hidden-xs"><strong>Temperatura:</strong> ${temperature}</p>
            <p class="hidden-xs"><strong>Peso:</strong> ${weight}</p>
            <hr>
            <p class="hidden-xs"><strong>Diagnóstico:</strong> ${diagnostic}</p>
            <p class="hidden-xs"><strong>Plan de tratamiento:</strong> ${treatment_plan}</p>
            <p class="hidden-xs"><strong>Medicamentos:</strong> ${medications}</p>
            <p class="hidden-xs"><strong>Comentarios adicionales:</strong> ${additional_comments}</p>
            <hr>
            ${pdf_path !== 'No se genero pdf' ? `<a href="${pdf_path}" class="btn btn-primary" target="_blank">Ver PDF</a>` : '<p class="hidden-xs"><strong>PDF:</strong> No se generó PDF</p>'}
        `;
    }
</script>

</body>

</html>
