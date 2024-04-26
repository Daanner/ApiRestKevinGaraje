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
    $(document).on('click', '.editar', function () {
        var id_usuario = $(this).attr("id");
        
        $.ajax({
            type: "GET",
            url: "http://localhost/ApiRestKevinGaraje/backend/get_vehiculo.php?id_usuario=" + id_usuario,
            dataType: "json",
            success: function (data) {
                // Llenar el formulario con los datos obtenidos
                $("#placa").val(data.placa);
                $("#marca").val(data.marca);
                $("#modelo").val(data.modelo);
                $("#estado").val(data.estado);
                
                // Cambiar el título del modal
                $(".modal-title").text("Editar Usuario");
                
                // Cambiar el valor de los campos ocultos para indicar la operación de edición
                $("#id_usuario").val(id_usuario);
                $("#action").val("Editar");
                $("#operacion").val("Editar");

                // Mostrar el modal de edición
                $('#modalUsuario').modal('show');
            },
            error: function (error) {
                console.error("Error en la solicitud AJAX:", error);
                alert("Error al obtener los datos del vehículo: " + error.responseJSON.message);
            }
        });
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