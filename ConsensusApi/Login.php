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

        $consulta = "call consultarUsuarioUser('" . $obj['usuario'] . "')";

        $resultado = mysqli_query($conn, $consulta);

        if ($resultado != null) {
            while ($filas = mysqli_fetch_array($resultado)) {

                $array2[] = array(
                    "id" => $filas['id'],
                    "usuario" => $filas['usuario'],
                    "correo" => $filas['correo'],
                    "telefono" => $filas['telefono'],
                    "adress" => $filas['adress'],
                    "estado" => $filas['estado']
                );
            }
        }
    }

    $json = $array2;
}

@mysqli_close($conn);

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
