<?php 
require_once('includes/Vehiculo.php');

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_usuario'])) {
    $id_usuario = $_POST['id_usuario'];
    Vehiculo::delete_vehiculo($id_usuario);
}
?>