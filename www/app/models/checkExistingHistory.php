<?php
require_once 'connection.php';

function existeHistorialClinico($id_patient, $consultation_date) {
    $connection = conectar();
    if ($connection) {
        try {
            $query = "SELECT COUNT(*) as count FROM clinical_history WHERE id_person = :id_patient AND consultation_date = :consultation_date";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':id_patient', $id_patient, PDO::PARAM_INT);
            $stmt->bindParam(':consultation_date', $consultation_date, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (Exception $e) {
            error_log("Error al verificar historial clínico: " . $e->getMessage()); 
            return false; 
        }
    }
    return false;
}
