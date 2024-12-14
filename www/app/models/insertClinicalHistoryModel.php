<?php
require_once 'connection.php';

function insertClinicalHistory(
    $doctorId, $speciality, $date, $idUser, $consultation_type, 
    $reason_consultation, $current_symptoms, $blood_pressure, $heart_rate, 
    $temperature, $weight, $diagnostic, $treatment_plan, $medications, $additional_comments
) {
    $connection = conectar();
    if ($connection) {
        try {
            $connection->beginTransaction();

            $query = "INSERT INTO clinical_history (
                id_specialist, id_speciality, consultation_date, id_person, id_type_consultation, 
                reason_consultation, current_symptoms, blood_pressure, heart_rate, temperature, 
                weight, diagnostic, treatment_plan, medications, additional_comments
            ) VALUES (
                :id_specialist, :id_speciality, :consultation_date, :id_person, :id_type_consultation, 
                :reason_consultation, :current_symptoms, :blood_pressure, :heart_rate, :temperature, 
                :weight, :diagnostic, :treatment_plan, :medications, :additional_comments
            )";

            $stmt = $connection->prepare($query);

            // Bind de parámetros obligatorios
            $stmt->bindParam(':id_specialist', $doctorId, PDO::PARAM_INT);
            $stmt->bindParam(':id_speciality', $speciality, PDO::PARAM_INT);
            $stmt->bindParam(':consultation_date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':id_person', $idUser, PDO::PARAM_INT);
            $stmt->bindParam(':id_type_consultation', $consultation_type, PDO::PARAM_INT);
            $stmt->bindParam(':reason_consultation', $reason_consultation, PDO::PARAM_STR);
            $stmt->bindParam(':current_symptoms', $current_symptoms, PDO::PARAM_STR);
            $stmt->bindParam(':diagnostic', $diagnostic, PDO::PARAM_STR);
            $stmt->bindParam(':treatment_plan', $treatment_plan, PDO::PARAM_STR);

            // Bind de parámetros opcionales (manejo de NULL)
            $stmt->bindParam(':blood_pressure', $blood_pressure, $blood_pressure !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindParam(':heart_rate', $heart_rate, $heart_rate !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
            $stmt->bindParam(':temperature', $temperature, $temperature !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindParam(':weight', $weight, $weight !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindParam(':medications', $medications, $medications !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindParam(':additional_comments', $additional_comments, $additional_comments !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);

            // Ejecutar la consulta
            $stmt->execute();
            $connection->commit();

            // Redirigir en caso de éxito
            echo '<script type="text/javascript">';
            echo 'alert("Registro insertado correctamente.");';
            echo 'window.location.href="../views/doctor/appointmentsToday.php";';
            echo '</script>';
        } catch (Exception $e) {
            $connection->rollBack();
            echo '<script type="text/javascript">';
            echo 'alert("Error al insertar el registro: ' . $e->getMessage() . '");';
            echo 'window.location.href="../views/doctor/addClinicalHistory.php?id=' . $idUser . '";';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("No se pudo conectar a la base de datos.");';
        echo 'window.location.href="../views/doctor/addClinicalHistory.php?id=' . $idUser . '";';
        echo '</script>';
    }
}
