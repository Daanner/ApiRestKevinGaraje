<?php
require_once('includes/Vehiculo.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id_usuario'])) {
    $id = $_GET['id_usuario'];
    $result = Vehiculo::get_vehiculo($id);

    if ($result) {
        echo json_encode($result);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "No se encontró el vehículo con el ID proporcionado"));
    }
}else {
    echo "error nose envio los datos";
}
?>