<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">

    <title>CRUD</title>
</head>
<body>
<div class="container fondo">
    <h1 class="text-center">Garaje</h1>
    <div class="row">
        <div class="col-2 offset-10">
            <!-- Button trigger modal -->
            <button class="btn btn-primary" data-bs-target="#modalUsuario" data-bs-toggle="modal" id="botonCrear" type="button">
                <i class="bi bi-plus-circle-fill"></i>
                Crear
            </button>
        </div>
    </div>
    <br><br>

    <div class="table-responsive">
        <table id="datos_usuario" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Id</th>
                <th>Placa</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Estado</th>
                <th>Editar</th>
                <th>Borrar</th>
            </tr>
            </thead>
            <tbody>
            <!-- Tabla -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese los Datos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="formulario" enctype="multipart/form-data">
                    <div class="modal-content">
                        
                        
                        <input type="text" name="id" id="id" class="form-control">
                        <label for="nombre">id del vehiculo</label>
                        <br />
                        
                       
                        <input type="text" name="placa" id="placa" class="form-control">
                        <label for="nombre">Ingrese la placa del vehiculo</label>
                        <br />

                        <label for="apellido">Ingrese la marca del vehiculo</label>
                        <input type="text" name="marca" id="marca" class="form-control">
                        <br />

                        <label for="apellido">Ingrese el modelo del vehiculo</label>
                        <input type="text" name="modelo" id="modelo" class="form-control">
                        <br />

                        <label for="apellido">Ingrese el estado de ingreso del vehiculo</label>
                        <input type="text" name="estado" id="estado" class="form-control">
                        <br />
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="id_usuario" id="id_usuario">
                        <input type="hidden" name="operacion" id="operacion">
                        <input type="submit" name="action" id="action" class="btn btn-success" value="Crear">
                        <button style="display:none" class="btn btn-outline-warning" id="actualizar"> Actualizar</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $("#botonCrear").click(function(){
        $("#formulario")[0].reset();
        $(".modal-title").text("Crear Usuario");
        $("#action").val("Crear");
        $("#operacion").val("Crear");
      
        $("#id, label[for='nombre']").hide();
    });

    // Resto del código...
});
    
    $(document).ready(function(){
        $("#botonCrear").click(function(){
            $("#formulario")[0].reset();
            $(".modal-title").text("Crear Usuario");
            $("#action").val("Crear");
            $("#operacion").val("Crear");
        });

        var dataTable = $('#datos_usuario').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"http://localhost/ApiRestKevinGaraje/backend/get_all_vehiculo.php",
                type:"POST"                       
            },
            "columnDefs":[
                {
                    "targets":[0, 3, 4],
                    "orderable":false,
                },
            ]
        });

        // Crear
        $(document).on('submit', '#formulario', function(event){
            event.preventDefault();
            var placa = $("#placa").val();
            var marca = $("#marca").val();
            var modelo = $("#modelo").val();
            var estado = $("#estado").val();
            
            if (placa != '') {
                $.ajax({
                    url: "http://localhost/ApiRestKevinGaraje/backend/create_vehiculo.php",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        alert(data);
                        $('#formulario')[0].reset();
                        $('#modalUsuario').modal('hide');
                        dataTable.ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        alert("Error al crear el vehículo: " + error);
                    }
                });
            } else {
                alert("Algunos campos son obligatorios");
            }
        });

       // Editar

       $(document).on('click', '.editar', function (){
    var id_usuario = $(this).attr("id");
    $("#actualizar").css("display","block")
    $("#action").css("display","none")
    $.ajax({
        type: "GET",
        url: "http://localhost/ApiRestKevinGaraje/backend/get_vehiculo.php?id_usuario=" + id_usuario,
        dataType: "json",
        success: function (data) {
            console.log(data);

             $("#id").val(data.id);
            $("#placa").val(data.placa);
            $("#marca").val(data.marca);
            $("#modelo").val(data.modelo);
            $("#estado").val(data.estado);
            
            $(".modal-title").text("Editar Usuario");
            
            $("#id_usuario").val(id_usuario);
            $("#action").val("Editar");
            $("#operacion").val("Editar");

            $('#modalUsuario').modal('show');
        },
        error: function (error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
});


$(document).on('submit', '#formulario', function(event){
    event.preventDefault();
    var id = $("#id").val();
    var placa = $("#placa").val();
    var marca = $("#marca").val();
    var modelo = $("#modelo").val();
    var estado = $("#estado").val();
    
    if (placa != '') {
        $.ajax({
            url: "http://localhost/ApiRestKevinGaraje/backend/update_vehiculo.php",
            method: "PUT", 
            data: JSON.stringify({ 
                id: id,
                placa: placa,
                marca: marca,
                modelo: modelo,
                estado: estado
            }),
            contentType: 'application/json', 
            success: function (data) {
                alert(data.message);
                $('#formulario')[0].reset();
                $('#modalUsuario').modal('hide');
                dataTable.ajax.reload();
            },
            error: function(xhr, status, error) {
                alert("Error al actualizar el vehículo: " + error);
            }
        });
    } else {
        alert("Algunos campos son obligatorios");
    }
});

        // Borrar
        $(document).on('click', '.borrar', function(){
            var id_usuario = $(this).attr("id");
            if(confirm("¿Estás seguro de eliminar este registro? Id: " + id_usuario)) {
                $.ajax({
                    url: "http://localhost/ApiRestKevinGaraje/backend/delete_vehiculo.php",
                    method: "POST",
                    data: { id_usuario: id_usuario },
                    success: function(data) {
                        alert(data); 
                        dataTable.ajax.reload(); 
                    },
                    error: function(xhr, status, error) {
                        alert("Error al eliminar el vehículo: " + error);
                    }
                });
            } else {
                return false;
            }
        });
    });
</script>

</body>
</html>
