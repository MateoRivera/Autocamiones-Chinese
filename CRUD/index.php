<?php
session_start();
 
if(!isset($_SESSION['id'])){
    header('Location: ..');
    exit;
} else {
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crud</title>

  <link href="bootstrap-4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <link href="datatables/datatables.min.css" rel="stylesheet">

  <script src="js/jquery-3.4.1.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>
  <script src="datatables/datatables.min.js"></script>    
</head>

<body>

  <h1>AUTOCAMIONES CHINESE</h1>
  <div class="container">

    <div class="row">
      <div class="col-12">
        <table class="table table-striped table-bordered table-hover" id="tablarepuestos">
          <thead>
            <tr>
              <!--<td>Índice</td>-->
              <td>Código</td>
              <td>Nombre</td>
              <td>Name</td>
              <td>Stock</td>
              <td>Precio</td>
              <td>Comprado (USD)</td>
              <td>Peso (Libras)</td>
              <td>Modificar</td>
              <td>Borrar</td>
            </tr>
          </thead>
        </table>
        <button class="btn btn-sm btn-primary" id="BotonAgregar">Agregar artículo</button>
      </div>
    </div>

    <!-- Formulario (Agregar, Modificar) -->

    <div class="modal fade" id="FormularioArticulo" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <input type="hidden" id="Codigo">

<!-------------------------------------------->            
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Código:</label>
                <input type="text" id="id" class="form-control" placeholder="">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Nombre:</label>
                <input type="text" id="spare_part_name_es" class="form-control" placeholder="">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Name:</label>
                <input type="text" id="spare_part_name_en" class="form-control" placeholder="">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Stock:</label>
                <input type="number" id="stock" class="form-control" placeholder="">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Precio:</label>
                <input type="number" id="price_sale" class="form-control" placeholder="">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Comprado (USD):</label>
                <input type="number" step="0.01" id="purchase" class="form-control" placeholder="">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Peso (Libras):</label>
                <input type="number" step="0.01" id="weight" class="form-control" placeholder="">
              </div>
            </div>
<!-------------------------------------------->

            <div class="modal-footer">
              <button type="button" id="ConfirmarAgregar" class="btn btn-success">Agregar</button>
              <button type="button" id="ConfirmarModificar" class="btn btn-success">Modificar</button>
              <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
            </div>

          </div>
        </div>
      </div>

    </div>

    <script>
      document.addEventListener("DOMContentLoaded", function() {
        
        let tabla1 = $("#tablarepuestos").DataTable({
          "ajax": {
            url: "datos.php?accion=listar",
            dataSrc: ""
          },
          "columns": [
          //-------------------------------
            /*{
              "data":"indice"
            },*/
            {
              "data": "id"
            },
            {
              "data": "spare_part_name_es"
            },
            {
              "data": "spare_part_name_en"
            },
            {
              "data": "stock"
            },
            {
              "data": "price_sale"
            },
            {
              "data": "purchase"
            },
            {
              "data": "weight"
            },


            //--------------------------------

            {
              "data": null,
              "orderable": false
            },
            {
              "data": null,
              "orderable": false
            }
          ],
          "columnDefs": [{
            targets: 7,
            "defaultContent": "<button class='btn btn-sm btn-primary botonmodificar' style='background-color:#FFD738'>Modificar</button>",
            data: null
          }, {
            targets: 8,
            "defaultContent": "<button class='btn btn-sm btn-primary botonborrar' style='background-color:#FF4B4B'>Borrar</button>",
            data: null
          }],
          "language": {
            "url": "DataTables/spanish.json",
          },
        });

        //Eventos de botones de la aplicación
        $('#BotonAgregar').click(function() {
          $('#ConfirmarAgregar').show();
          $('#ConfirmarModificar').hide();
          limpiarFormulario();
          $("#FormularioArticulo").modal('show');
        });

        $('#ConfirmarAgregar').click(function() {
          $("#FormularioArticulo").modal('hide');
          let registro = recuperarDatosFormulario();
          console.log(registro);
          agregarRegistro(registro);
        });

        $('#ConfirmarModificar').click(function() {
          $("#FormularioArticulo").modal('hide');
          let registro = recuperarDatosFormulario();
          modificarRegistro(registro);
        });

        $('#tablarepuestos tbody').on('click', 'button.botonmodificar', function() {
          $('#id').attr('readonly', true);
          $('#ConfirmarAgregar').hide();
          $('#ConfirmarModificar').show();
          let registro = tabla1.row($(this).parents('tr')).data();
          recuperarRegistro(registro.id);
        });

        $('#tablarepuestos tbody').on('click', 'button.botonborrar', function() {
          if (confirm("¿Realmente quiere borrar el artículo?")) {
            let registro = tabla1.row($(this).parents('tr')).data();
            borrarRegistro(registro.id);
          }
        });

        // funciones que interactuan con el formulario de entrada de datos
        function limpiarFormulario() {
          /*$('#Codigo').val('');*/
          $('#id').val('');
          $('#spare_part_name_es').val('');
          $('#spare_part_name_en').val('');
          $('#stock').val('');
          $('#price_sale').val('');
          $('#purchase').val('');
          $('#weight').val('');
        }

        function recuperarDatosFormulario() {
          //alert($('#spare_part_name_es').val());
          let registro = {
            //codigo: $('#Codigo').val(),
            /**/
            id: $('#id').val(),
            spare_part_name_es: $('#spare_part_name_es').val(),
            spare_part_name_en: $('#spare_part_name_en').val(),
            stock: $('#stock').val(),
            price_sale: $('#price_sale').val(),
            purchase: $('#purchase').val(),
            weight: $('#weight').val()



            /**/

            //descripcion: $('#Descripcion').val(),
            //precio: $('#Precio').val()
          };
          return registro;
        }


        // funciones para comunicarse con el servidor via ajax
        function agregarRegistro(registro) {
          console.log("This is the new registro",registro,typeof(registro));
          //var variable = {nombre:"victor",edad:22};
          var variable=registro;


          $.ajax({
            type: 'POST',
            url: "datos.php?accion=agregar",
            //data: registro,
            data: variable,
            dataType:"json",
            success: function(msg) {
              tabla1.ajax.reload();
              alert("Satisfactorio");
            },
            error: function() {
              alert("Hay un problema en la función agregarRegistro");
            }
          });
        }

        function borrarRegistro(codigo) {
          var variable={id:codigo};
          $.ajax({

            type: 'POST',
            //

            url: 'datos.php?accion=borrar',
            data: variable,
            dataType: "json",
            //
            /*url: 'datos.php?accion=borrar&codigo='+codigo,
            data: '',*/
            success: function(msg) {
              tabla1.ajax.reload();
            },
            error: function() {
              alert("Hay un problema en la función borrarRegistro");
            }
          });
        }

        function recuperarRegistro(codigo) {
          var variable={id:codigo};
          $.ajax({
            type: 'POST',
            url: 'datos.php?accion=consultar',
            data: variable,
            dataType: "json",
            success: function(datos) {
              $('#id').val(datos[0].id);
              $('#spare_part_name_es').val(datos[0].spare_part_name_es);
              $('#spare_part_name_en').val(datos[0].spare_part_name_en);
              $('#stock').val(datos[0].stock);
              $('#price_sale').val(datos[0].price_sale);
              $('#purchase').val(datos[0].purchase);
              $('#weight').val(datos[0].weight);

              $("#FormularioArticulo").modal('show');
            },
            error: function() {
              alert("Hay un problema en la función recuperarRegistro");
            }
          });
        }

        function modificarRegistro(registro) {
          $.ajax({
            type: 'POST',
            url: 'datos.php?accion=modificar',
            data: registro,
            dataType:"json",
            success: function(msg) {
              tabla1.ajax.reload();
            },
            error: function() {
              alert("Hay un problema en la función modificarRegistro");
            }
          });
        }

      });
    </script>



</body>

</html>

<?php

}
?>