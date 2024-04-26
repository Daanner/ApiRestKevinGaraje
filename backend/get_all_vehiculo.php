<?php
require_once('includes/Vehiculo.php');

$database = new Database();
$connection = $database->getConnection();


$query = "";
$salida = array();
$query ="SELECT * FROM vehiculo ";

$stmt = $connection->prepare($query);
$stmt->execute();
$resultado = $stmt->fetchAll();
$datos = array();
$filtered_rows = $stmt->rowCount();

foreach($resultado as $fila){

    $sub_array = array();
    $sub_array[] = $fila["id"];
    $sub_array[] = $fila["placa"];
    $sub_array[] = $fila["marca"];
    $sub_array[] = $fila["modelo"];
    $sub_array[] = $fila["estado"];
    $sub_array[] = '<button type="button" name="editar" id="'.$fila["id"].'" class="btn
    btn-warning btn-xs editar">Editar</button>';
    $sub_array[] = '<button type="button" name="borrar" id="'.$fila["id"].'" class="btn
    btn-warning btn-xs borrar">Borrar</button>';
    $datos[]=  $sub_array;

}

$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;

$salida = array(
    "draw"           => $draw, 
    "recordsTotal"   => $filtered_rows,
    "recordsFiltered" => Vehiculo::get_all_vehiculo(), 
    "data"            => $datos
);

echo json_encode($salida);