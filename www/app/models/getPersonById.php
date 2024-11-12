<?php
require_once 'connection.php';

function obtenerPersonaPorId($id){
    $conecction = conectar();
    if ($conecction) {
        $query = "SELECT * FROM person WHERE id = :id";
        
        $stmt = $conecction->prepare($query);
        
        $stmt->bindParam(':id', $id);
        
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