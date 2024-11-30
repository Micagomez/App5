<?php
session_start();
include '../models/connection.php';
require_once '../models/getAvailabilitySchedules.php';
//include 'login.php';

if (isset( $_SESSION)) {
    if (( $_SESSION['rol']) == "" or  $_SESSION['rol'] != '2') {
        // var_dump($_SESSION['rol']);
        // exit;
        // ob_start();
        
            echo '<script type="text/javascript">';
            echo 'window.location.href="../login.php";';
            echo '</script>';
            exit();
    } 
    // else {
    //     $useremail = $_SESSION["email"];
    // }
} else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="../login.php";';
        echo '</script>';
        exit();
}

//$id_dia = "";
//$duracion_del_turno = "";
//$horario_atencion = "";

if (!empty($_POST['dia'])) {
    $id_dia = $_POST['dia'];

    // Mapeo de id a día de la semana
    $dias_semana = [
        1 => "Lunes",
        2 => "Martes",
        3 => "Miércoles",
        4 => "Jueves",
        5 => "Viernes",
        6 => "Sábado",
        7 => "Domingo"
    ];

    $dia_seleccionado = $dias_semana[$id_dia];
    //echo "Has seleccionado el día: $dia_seleccionado con ID: $id_dia";
}

if(empty($id_dia)){
    echo "seleccione un dia para poder cargar los datos correctamente.";
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $duracion_del_turno = $_POST['duracion_turno'];
    $horario_atencion = $_POST['horario_atencion'];
    $id_doctor = $_POST['id_doctor'];
}

//echo $id_doctor, " ", $duracion_del_turno, " ", $duracion_del_turno, " ", $horario_atencion, " ";

$hs_disponibilidad = obtenerHorariosyDias($id_doctor);
foreach ($hs_disponibilidad as $horario) {
    if($horario['dia_servicio_nombre'] === $dia_seleccionado){
        $disponibilidad = $horario['dia_servicio_nombre'];
    }else{
        $disponibilidad = "";
    }
}

if(empty($duracion_del_turno && $horario_atencion)){
    echo "seleccione una opción de cada campo para poder cargar los datos correctamente.";
    exit();
}

$conexion = conectar();
if($conexion){
    if($disponibilidad === $dia_seleccionado){
        echo "ya se han ingresado datos con ese dia, seleccione otro por favor.";
    } else{
        try{
            $conexion->beginTransaction();
            $query = "INSERT INTO availability_schedules (id_specialist, id_service_day, id_appointment_duration, id_service_hours) VALUES (:id_specialist, :id_service_day, :id_appointment_duration, :id_service_hours)";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':id_specialist', $id_doctor, PDO::PARAM_INT);
            $stmt->bindParam(':id_service_day', $id_dia, PDO::PARAM_INT);
            $stmt->bindParam(':id_appointment_duration', $duracion_del_turno, PDO::PARAM_INT);
            $stmt->bindParam(':id_service_hours', $horario_atencion, PDO::PARAM_INT);
            $stmt -> execute();
            // Confirmar (commit) la transacción
            $conexion->commit();
            echo "Datos insertados correctamente";
        }
        catch(Exception $e) {
            $conexion->rollBack();
            echo "Error al insertar datos: " . $e->getMessage();
        }
        cerrarConexion($conexion);
    }
}