<?php
require_once 'connection.php';
function obtenerDatosEspecialistas() {
    $conecction = conectar();
    if ($conecction) {
        // Preparar la consulta SQL
        $query = "SELECT 
            s.id AS specialist_id,
            s.name AS specialist_name,
            s.surname AS specialist_surname,
            s.online_consultation,
            s.street,
            s.number,
            s.apartment,
            s.floor,
            s.status,
            GROUP_CONCAT(DISTINCT l.license_number) AS license_numbers,
            GROUP_CONCAT(DISTINCT sp.speciality) AS specialities,
            GROUP_CONCAT(DISTINCT sls.id_speciality) AS speciality_ids
        FROM 
            specialist s
        LEFT JOIN 
            specialist_license_specialty sls ON s.id = sls.id_specialist
        LEFT JOIN 
            specialisties sp ON sp.id = sls.id_speciality
        LEFT JOIN 
            license_specialist l ON l.id = sls.id_specialist_license
        WHERE 
            s.status = 1
        GROUP BY 
            s.id, s.name, s.surname, s.online_consultation, s.street, s.number, s.apartment, s.floor;

        ";
        
        // Preparar la sentencia
        $stmt = $conecction->prepare($query);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener los resultados como un array asociativo
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Cerrar la conexión
        cerrarConexion($conecction);
        
        // Retornar los resultados
        return $resultados;
    } else {
        echo "No se pudo establecer la conexión a la base de datos.<br>";
        return null;
    }
}