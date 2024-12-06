<?php
require_once './connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = conectar();
    $id = $_POST['id']; 
    if ($conexion) {
        try {
            $conexion->beginTransaction();

            if (!empty($id)) {
                $query1 = "UPDATE appointment SET status = 4 WHERE id = :id";

                $stmt1 = $conexion->prepare($query1);

                $stmt1->bindParam(':id', $id, PDO::PARAM_INT);

                $stmt1->execute();

                $conexion->commit();

                echo "Turno no completado.";
            } else {
                echo "ID no válido. Comuniquese con administración.";
            }
        } catch (PDOException $e) {
            $conexion->rollBack();
            echo "Error en la consulta: " . $e->getMessage();
        }

        cerrarConexion($conexion);
    } else {
        echo "No se pudo establecer la conexión a la base de datos.";
    }
}
?>
