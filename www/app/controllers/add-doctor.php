<?php
session_start();
require_once '../models/connection.php';
//require_once 'login.php';

if (isset($_SESSION) && isset($_SESSION['rol'])) {
    if ($_SESSION['rol'] != '2') {
        echo '<script type="text/javascript">';
        echo 'window.location.href="../views/login.php";';
        echo '</script>';
        exit();
    }
} else {
    echo '<script type="text/javascript">';
    echo 'window.location.href="../views/login.php";';
    echo '</script>';
    exit();
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $onlineConsultation = $_POST['onlineConsultation'];
    $street = $_POST['street'];
    $number = $_POST['number'];
    $apartment = $_POST['apartment'];
    $floor = $_POST['floor'];
    $id_speciality[] = $_POST['specialities'];
    $id_license_type = $_POST['license_type'];
    $license_number = $_POST['license_number'];
} else {
    echo "<script>alert('Ingresar datos correctos');</script>";
    echo 'window.location.href="../views/admin/add-doctor.php";';
    exit();
}
/*
var_dump($id_speciality);  // Verifica la estructura del array

// Primer nivel del array
foreach($id_speciality as $specialityGroup) {
    // Segundo nivel del array
    foreach($specialityGroup as $speciality) {
        echo($speciality);  // Aquí verás los valores individuales de las especialidades
    }
}*/


// Conectamos a la base de datos
$conexion = conectar();

if ($conexion) {
    try {
        // Iniciamos la transacción
        $conexion->beginTransaction();

        // Preparamos la consulta SQL
        $query = "INSERT INTO specialist (name, surname, online_consultation, street, number, apartment, floor) VALUES (:name, :surname, :online_consultation, :street, :number, :apartment, :floor)";
        $stmt = $conexion->prepare($query);

        // Vincular los parámetros a las variables de PHP
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $stmt->bindParam(':online_consultation', $onlineConsultation, PDO::PARAM_INT);
        $stmt->bindParam(':street', $street, PDO::PARAM_STR);
        $stmt->bindParam(':number', $number, PDO::PARAM_INT);
        $stmt->bindParam(':apartment', $apartment, PDO::PARAM_STR);
        $stmt->bindParam(':floor', $floor, PDO::PARAM_STR);

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            $id_specialist = $conexion->lastInsertId();
        } else {
            // Si algo falla, revertimos la transacción
            $conexion->rollBack();
            echo "Error al insertar datos.";
            exit();
        }

        // Comprobar si ya existe una matrícula
        $checkQuery = "SELECT COUNT(*) FROM license_specialist WHERE license_number = :license_number";
        $checkStmt = $conexion->prepare($checkQuery);
        $checkStmt->bindParam(':license_number', $license_number, PDO::PARAM_STR);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            echo "<script>alert('La matrícula ya existe');</script>";
            echo "<script>window.location.href ='../views/admin/add-doctor.php'</script>";
            exit();
        }

        // Proceder con la inserción si no hay duplicados
        $querySpecialistLicense = "INSERT INTO license_specialist (id_specialist, id_license_type, license_number) VALUES (:id_specialist, :id_license_type, :license_number)";
        $stmtSpecialistLicense = $conexion->prepare($querySpecialistLicense);
        $stmtSpecialistLicense->bindParam(':id_specialist', $id_specialist, PDO::PARAM_INT);
        $stmtSpecialistLicense->bindParam(':id_license_type', $id_license_type, PDO::PARAM_INT);
        $stmtSpecialistLicense->bindParam(':license_number', $license_number, PDO::PARAM_STR);

        if ($stmtSpecialistLicense->execute()) {
            $id_specialistLicense = $conexion->lastInsertId();
        } else {
            // Si algo falla, revertimos la transacción
            $conexion->rollBack();
            echo "Error al insertar datos.";
            exit();
        }

        $querySpecialistSpeciality = "INSERT INTO specialist_license_specialty (id_specialist, id_speciality, id_specialist_license) VALUES (:id_specialist, :id_speciality, :id_specialist_license)";
        $stmtSpecialistSpeciality = $conexion->prepare($querySpecialistSpeciality);
        foreach ($id_speciality as $specialityGroup) {
            foreach($specialityGroup as $speciality){
                $stmtSpecialistSpeciality->bindValue(':id_specialist', $id_specialist, PDO::PARAM_INT);
                $stmtSpecialistSpeciality->bindValue(':id_speciality', $speciality, PDO::PARAM_INT);
                $stmtSpecialistSpeciality->bindValue(':id_specialist_license', $id_specialistLicense, PDO::PARAM_INT);
                if (!$stmtSpecialistSpeciality->execute()) {
                    $conexion->rollBack();
                    echo "Error al insertar especialidades.";
                    exit();
                }
            }
        }

        $queryUser = "INSERT INTO user (id_specialist, id_rol, email, password) VALUES (:id_specialist, :id_rol, :email, :password)";
        $stmtUser = $conexion->prepare($queryUser);
        $stmtUser->bindParam(':id_specialist', $id_specialist, PDO::PARAM_INT);
        $stmtUser->bindValue(':id_rol', 3, PDO::PARAM_INT);
        $stmtUser->bindParam(':email', $email, PDO::PARAM_STR);
        $passwordHashed = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmtUser->bindParam(':password', $passwordHashed, PDO::PARAM_STR);
        if (!$stmtUser->execute()) {
            $conexion->rollBack();
            echo "Error al insertar email y contraseña.";
            exit();
        }

        // Confirmar la transacción
        $conexion->commit();

        // Redirigir al usuario después de un registro exitoso
        // echo 'window.location.href="../views/admin/doctorsList.php";';

        header('Location: ../views/admin/doctorsList.php');
        exit();

    } catch (PDOException $e) {
        // En caso de error, se revierte la transacción y mostramos el error
        $conexion->rollBack();
        echo "Error en la consulta: " . $e->getMessage();
    }

    // Cerramos la conexión
    cerrarConexion($conexion);
} else {
    echo "No se pudo establecer la conexión a la base de datos.";
}
?>