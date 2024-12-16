<?php
require_once 'connection.php';

function obtenerRegistrosHistorialClinico() {
    $conecction = conectar(); // Asegúrate de que `conectar()` retorna una conexión válida.
    if ($conecction) {
        // Consulta SQL con orden descendente por la fecha de consulta
        $query = "SELECT 
                    ch.id,
                    ch.id_specialist, 
                    s.name AS specialist_name, 
                    s.surname AS specialist_surname, 
                    ch.id_speciality, 
                    sp.speciality AS speciality_name,
                    ch.consultation_date, 
                    ch.id_person, 
                    p.name AS person_name,  
                    p.surname AS person_surname,  
                    p.dni AS person_dni, 
                    ch.id_type_consultation, 
                    tc.type AS consultation_type, 
                    ch.reason_consultation, 
                    ch.current_symptoms, 
                    ch.blood_pressure, 
                    ch.heart_rate, 
                    ch.temperature, 
                    ch.weight, 
                    ch.diagnostic, 
                    ch.treatment_plan, 
                    ch.medications, 
                    ch.additional_comments, 
                    ch.pdf_path
                FROM 
                    clinical_history ch
                LEFT JOIN 
                    specialist s ON ch.id_specialist = s.id
                LEFT JOIN 
                    specialisties sp ON ch.id_speciality = sp.id
                LEFT JOIN 
                    person p ON ch.id_person = p.id
                LEFT JOIN 
                    type_consultation tc ON ch.id_type_consultation = tc.id
                ORDER BY 
                    ch.consultation_date DESC"; // Aquí se ordena por fecha en orden descendente

        // Preparar y ejecutar la consulta
        $stmt = $conecction->prepare($query);
        $stmt->execute();

        // Obtener los resultados
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cerrar la conexión
        cerrarConexion($conecction);

        return $resultados;
    } else {
        echo "No se pudo establecer la conexión a la base de datos.<br>";
        return null;
    }
}
?>
