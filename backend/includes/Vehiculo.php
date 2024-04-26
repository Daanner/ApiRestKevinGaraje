<?php
require_once('Database.php');

class Vehiculo{

    public static function create_vehiculo($placa, $marca, $modelo, $estado){
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('INSERT INTO vehiculo (placa, marca , modelo, estado) VALUES (:placa, :marca, :modelo, :estado)');
        $stmt->bindParam(':placa', $placa);
        $stmt->bindParam(':marca', $marca); 
        $stmt->bindParam(':modelo', $modelo); 
        $stmt->bindParam(':estado', $estado);  
        
        if($stmt->execute()){       
            array(
                ':id'  => $_POST['id_usuario']
            );    
            if(!empty($resultado)){
                echo'Registro Borrado';
            }
            header('HTTP/1.1 201 Vehiculo creado con exito');
        }else{
            header('HTTP/1.1 404 No se ha podido crear vehiculos');
        }
    

    }
    
    public static function delete_vehiculo($id){
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('DELETE FROM vehiculo WHERE id=:id');
        $stmt->bindParam(':id',$id);
        if($stmt->execute()){
            header('HTTP/1.1 201 Vehiculo borrado con exito');
        }else{
            header('HTTP/1.1 404 No se ha podido crear vehiculos');
        }
    
    }


    public static function get_all_vehiculo(){
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT * FROM vehiculo');       
        if($stmt->execute()){
            $result = $stmt->fetchAll();
            header('HTTP/1.1 201 Vehiculo consultado');
            return $stmt->rowCount();
        } else {
            header('HTTP/1.1 404 No se ha podido consultar los vehiculos');
        }
    }

    public static function get_vehiculo($id){
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare("SELECT * FROM `vehiculo` WHERE id=:id");
        $stmt->bindParam(':id', $id);  
        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
            header('HTTP/1.1 201 Vehiculo consultado');
    
        }else{
            header('HTTP/1.1 404 No se ha podido consultar los vehiculos');
        }
    }

    public static function update_vehiculo($id, $placa, $marca, $modelo, $estado) {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('UPDATE vehiculo SET placa=:placa, marca=:marca, modelo=:modelo, estado=:estado WHERE id=:id');
        $stmt->bindParam(':placa', $placa);
        $stmt->bindParam(':marca', $marca); 
        $stmt->bindParam(':modelo', $modelo); 
        $stmt->bindParam(':estado', $estado);  
        $stmt->bindParam(':id', $id);  
        
        if($stmt->execute()){
            header('HTTP/1.1 201 vehiculo actualizado correctamente');
        }else{
            header('HTTP/1.1 404 No se ha podido crear vehiculos');
        }
    
        
     }       
}
?>