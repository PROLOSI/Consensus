<?php

include 'ConsensusDB.php';

@$conn = mysqli_connect(SERVIDOR, USUARIO_DB, CONTRASENA_DB, BASE_DE_DATOS);


header('Content-Type: text/json');
header('Access-Control-Allow-Origin: *');  //I have also tried the * wildcard and get the same response
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET,POST,DELETE,PUT');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description,Access-Control-Allow-Headers,Origin, X-Requested-With, Accept');


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $array = json_decode(file_get_contents('php://input'), true);

    foreach ($array as $obj) {

        $consulta = "call insertarUsuarios(null,'" . $obj['usuario'] . "','" . $obj['contrasena'] . "','" . $obj['correo'] . "','" . $obj['telefono'] . "','" . $obj['adress'] . "'," . $obj['estado'] . ",@return)";

        $resultado = mysqli_query($conn, $consulta);

        if ($resultado != null && $resultado != false) {

            $array2[] = array("estado" => "Exito");
        } else {
            $array2[] = array("estado" => "Falla", "message" => mysqli_error($conn));
        }
    }

    $json = $array2;
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $consulta = "call consultarUsuarioTodos()";

    $resultado = mysqli_query($conn, $consulta);

    if ($resultado != null) {

        while ($filas = mysqli_fetch_array($resultado)) {

            $array[] = array(
                "id" => $filas['id'],
                "usuario" => $filas['usuario'],
                "correo" => $filas['correo'],
                "telefono" => $filas['telefono'],
                "adress" => $filas['adress'],
                "estado" => $filas['estado']
            );
        }
    } else {

        $array[] = array("estado" => "NO EXISTEN USUARIOS");
    }

    $json = $array;
}

if ($_SERVER['REQUEST_METHOD'] == "PUT") {

    $array = json_decode(file_get_contents('php://input'), true);

    foreach ($array as $obj) {

        $consulta = "call actualizarUsuario(" . $obj['id'] . ",'" . $obj['usuario'] . "','" . $obj['contrasena'] . "'," . $obj['estado'] . ")";

        $resultado = mysqli_query($conn, $consulta);

        $consulta2 = "call consultarUsuario(" . $obj['id'] . ")";

        $resultado2 = mysqli_query($conn, $consulta2);

        $usuario = mysqli_fetch_array($resultado2);


        if ($obj['usuario'] == $usuario['usuario'] && $obj['estado'] == $usuario['estado']) {

            $array2 = array("estado" => "Exito");
        } else {
            $array2 = array("estado" => "Falla", "message" => mysqli_error($conn));
        }
    }

    $json = $array2;
}

if ($_SERVER['REQUEST_METHOD'] == "DELETE") {

     $array = json_decode(file_get_contents('php://input'), true);

    foreach ($array as $obj) {

        $consulta = "call eliminarUsuario('" . $obj['usuario'] ."')";

     
        $resultado = mysqli_query($conn, $consulta);

        if ($resultado!=null) {

            $array2 = array("estado" => "Exito");
        } else {
            $array2 = array("estado" => "Falla", "message" => mysqli_error($conn));
        }
    }

    $json = $array2;
}

@mysqli_close($conn);

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
