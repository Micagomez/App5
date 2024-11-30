<?php
require_once 'connection.php';

function obtenerTurnosDelEspecialista($date, $id_specialist) {
    $conecction = conectar();

    if ($conecction) {
        $query = "SELECT
            a.id,
            a.date,
            a.id_specialist,
            a.status,
            p.name,
            p.surname,
            p.dni,
            p.birth_date,
            p.id as person_id,
            c.contact
        FROM 
            appointment a
        JOIN 
            user u ON a.id_user = u.id
        JOIN 
            person p ON u.id_person = p.id
        JOIN 
            contact c ON c.id_person = p.id  -- La unión correcta es con person
        WHERE 
            a.date = :date 
            AND a.id_specialist = :id_specialist 
            AND a.status IN (1, 3, 4);
        ";

        $stmt = $conecction->prepare($query);

        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':id_specialist', $id_specialist);

        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        cerrarConexion($conecction);

        return $resultados;
    } else {
        echo "No se pudo establecer la conexión a la base de datos.<br>";
        return null;
    }
}
?>
