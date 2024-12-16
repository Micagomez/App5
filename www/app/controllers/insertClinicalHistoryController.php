<?php
session_start();

include '../models/insertClinicalHistoryModel.php';
require_once '../models/checkExistingHistory.php'; // Incluir el modelo de verificación

if (isset($_SESSION)) {
    if ($_SESSION['rol'] == "" || $_SESSION['rol'] != '3') {
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos enviados desde el formulario
    $doctorId = $_POST['id_specialist'];
    $speciality = $_POST['speciality_id'];
    $date = $_POST['consultation_date'];
    if ($date) {
        $formattedDate = DateTime::createFromFormat('d-m-Y', $date);
        if ($formattedDate) {
            $date = $formattedDate->format('Y-m-d');
        } else {
            echo 'Formato de fecha inválido';
            exit();
        }
    }
    $idUser = $_POST['id_patient'];
    $consultation_type = $_POST['id_consultation_type']; 
    $reason_consultation = $_POST['reason_consultation'];
    $current_symptoms = $_POST['current_symptoms'];
    $blood_pressure = !empty($_POST['blood_pressure']) ? $_POST['blood_pressure'] : null;
    $heart_rate = !empty($_POST['heart_rate']) ? $_POST['heart_rate'] : null;
    $temperature = !empty($_POST['temperature']) ? $_POST['temperature'] : null;
    $weight = !empty($_POST['weight']) ? $_POST['weight'] : null;
    $diagnostic = $_POST['diagnostic'];
    $treatment_plan = $_POST['treatment_plan'];
    $medications = $_POST['medications'];
    $additional_comments = !empty($_POST['additional_comments']) ? $_POST['additional_comments'] : null;

    // Verificar que los campos obligatorios no estén vacíos
    if (empty($reason_consultation) || empty($current_symptoms) || empty($diagnostic) || empty($treatment_plan) || empty($medications)) {
        echo '<script type="text/javascript">';
        echo 'alert("Por favor, complete todos los campos obligatorios.");';
        echo 'window.location.href="../views/doctor/addClinicalHistory.php?id=' . $idUser . '";';
        echo '</script>';
        exit();
    }

    // Validar formato de presión arterial (si no está vacío)
    if ($blood_pressure && !preg_match('/^\d{2,3}\/\d{2,3}$/', $blood_pressure)) {
        echo '<script type="text/javascript">';
        echo 'alert("Formato de presión arterial inválido. Ejemplo correcto: 120/80");';
        echo 'window.location.href="../views/doctor/addClinicalHistory.php?id=' . $idUser . '";';
        echo '</script>';
        exit();
    }

    // Validar que los valores numéricos como heart_rate, temperature y weight sean válidos
    if ($heart_rate && (!is_numeric($heart_rate) || $heart_rate < 40 || $heart_rate > 200)) {
        echo '<script type="text/javascript">';
        echo 'alert("La frecuencia cardíaca debe ser un valor numérico entre 40 y 200.");';
        echo 'window.location.href="../views/doctor/addClinicalHistory.php?id=' . $idUser . '";';
        echo '</script>';
        exit();
    }

    if ($temperature && (!is_numeric($temperature) || $temperature < 35 || $temperature > 42)) {
        echo '<script type="text/javascript">';
        echo 'alert("La temperatura debe ser un valor numérico entre 35 y 42 °C.");';
        echo 'window.location.href="../views/doctor/addClinicalHistory.php?id=' . $idUser . '";';
        echo '</script>';
        exit();
    }

    if ($weight && !is_numeric($weight)) {
        echo '<script type="text/javascript">';
        echo 'alert("El peso debe ser un valor numérico válido.");';
        echo 'window.location.href="../views/doctor/addClinicalHistory.php?id=' . $idUser . '";';
        echo '</script>';
        exit();
    }
      // Verificar si ya existe un historial clínico para este paciente en la fecha indicada
    if (existeHistorialClinico($idUser, $date)) {
        echo '<script type="text/javascript">';
        echo 'alert("Ya existe un historial clínico para este paciente en la fecha indicada.");';
        echo 'window.location.href="../views/doctor/medicalHistory.php";';
        echo '</script>';
        exit();
    }

    // Procesar los datos (Insertar en la base de datos)
    $result = insertClinicalHistory($doctorId, $speciality, $date, $idUser, $consultation_type, 
    $reason_consultation, $current_symptoms, $blood_pressure, $heart_rate, $temperature, $weight, $diagnostic, 
    $treatment_plan, $medications, $additional_comments);

    if($result){
        echo '<script type="text/javascript">';
        echo 'alert("Historial clínico agregado con éxito.");';
        echo 'window.location.href="../views/doctor/addClinicalHistory.php";';
        echo '</script>';
        exit();
    } else{
        echo '<script type="text/javascript">';
        echo 'alert("Error al agregar el historial clínico. Intente nuevamente.");';
        echo 'window.location.href="../views/doctor/addClinicalHistory.php";';
        echo '</script>';
        exit();
    }

} else {
    echo "Metodo de envio invalido";
}
?>