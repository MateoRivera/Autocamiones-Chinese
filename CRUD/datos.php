<?php
header('Content-Type: application/json');

require("conexion.php");

$conexion = retornarConexion();

switch ($_GET['accion']) {
    case 'listar':
        $datos = mysqli_query($conexion, "select * from spare_registered");
        $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode($resultado);
        break;

    case 'agregar':
        $respuesta = mysqli_query($conexion, "insert into spare_registered (id, spare_part_name_es, spare_part_name_en, stock,  price_sale, purchase, weight) values ('$_POST[id]','$_POST[spare_part_name_es])','$_POST[spare_part_name_en]',$_POST[stock]),$_POST[price_sale],$_POST[purchase]),$_POST[weight])");
        echo json_encode($respuesta);
        break;

    case 'borrar':
        $respuesta = mysqli_query($conexion, "delete from spare_registered where id=$_GET[id]");
        echo json_encode($respuesta);
        break;

    case 'consultar':
        $datos = mysqli_query($conexion, "select * from spare_registered where id=$_GET[id]");
        $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode($resultado);
        break;

    case 'modificar':
        $respuesta = mysqli_query($conexion, "update spare_registered set
                                                  id='$_POST[id]',
                                                  spare_part_name_es='$_POST[spare_part_name_es]',
                                                  spare_part_name_en='$_POST[spare_part_name_en]',
                                                  stock=$_POST[stock],
                                                  price_sale=$_POST[price_sale],
                                                  purchase=$_POST[purchase],
                                                  weight=$_POST[weight]
                                               where codigo=$_GET[codigo]");
        echo json_encode($respuesta);
        break;
}
