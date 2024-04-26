<?php 
require_once('includes/Vehiculo.php');

if(isset($_POST['operacion']) && $_POST['operacion'] == 'Crear' 
    && isset($_POST['placa']) && isset($_POST['marca']) 
    && isset($_POST['modelo']) && isset($_POST['estado'])) {

    Vehiculo::create_vehiculo($_POST['placa'], $_POST['marca'], $_POST['modelo'], $_POST['estado']);
       
    array(
            ':placa'   => $_POST['placa'],
            ':marca'=> $_POST['marca'],
            ':modelo' => $_POST['modelo'],
            ':estado' => $_POST['estado']
            
        );
    

    if(!empty($resultado)){
        echo 'Registro creado';
    }
}
?>