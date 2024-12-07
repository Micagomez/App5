<?php
require_once 'connection.php';

function obtenerTipodeConsulta() {
$conecction = conectar();
    if ($conecction) {
        // Preparar la consulta SQL
        $query = "SELECT * FROM `type_consultation`";
        
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