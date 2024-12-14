<?php
/*session_start();
if (isset( $_SESSION)) {
    if (( $_SESSION['rol']) == "" or  $_SESSION['rol'] != '2') {
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
}*/

require_once '../models/updateSpecialist.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $mnsjNotNuLL = "No se acepta vacio en este campo, ingrese un dato ";
    $doctorId = $_POST['id_doctor'];
    if(!empty($_POST['name'])){
        $doctorNombre = $_POST['name'];
    } else{
        echo $mnsjNotNuLL;
        exit();
    }
    if(!empty($_POST['surname'])){
        $doctorApellido = $_POST['surname'];
    } else{
        echo $mnsjNotNuLL;
        exit();
    }
    $doctorOnlineConsultation = $_POST['onlineConsultation'];
    if(!empty($_POST['street'])){
        $doctorCalle = $_POST['street'];
    } else{
        echo $mnsjNotNuLL;
        exit();
    }
    if(!empty($_POST['number'])){
        $doctorNumero = $_POST['number'];
    } else{
        echo $mnsjNotNuLL;
        exit();
    }
    $doctorDepartamento = $_POST['apartment'];
    if($doctorDepartamento == "null"){
        $doctorDepartamento = "";
    }
    $doctorPiso = $_POST['floor'];
    if($doctorPiso == "null"){
        echo "prueba";
    }

    //echo $doctorId, $doctorNombre, $doctorApellido, $doctorOnlineConsultation, $doctorCalle, $doctorNumero, $doctorDepartamento, $doctorPiso;

    // Llamamos a la función con los parámetros en el orden correcto
    UpdateSpecialist($doctorId, $doctorNombre, $doctorApellido, $doctorOnlineConsultation, $doctorCalle, $doctorNumero, $doctorDepartamento, $doctorPiso);
} else {
    echo "Método de envio invalido, no se han recibido los datos";
}
?>
