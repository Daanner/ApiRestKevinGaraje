<?php 
require_once('includes/Vehiculo.php');
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    if(isset($data['id']) && isset($data['placa']) && isset($data['marca']) && isset($data['modelo']) && isset($data['estado'])){
       
        Vehiculo::update_vehiculo($data['id'], $data['placa'], $data['marca'], $data['modelo'], $data['estado']);
      
        http_response_code(200);
        echo json_encode(array("message" => "Vehículo actualizado correctamente."));
    } else {
        
        http_response_code(400);
        echo json_encode(array("message" => "Falta información necesaria para actualizar el vehículo."));
    }
} else {

    http_response_code(405);
    echo json_encode(array("message" => "Método no permitido. Se espera una solicitud PUT."));
}
?>