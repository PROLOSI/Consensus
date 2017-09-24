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


        $consulta = "call crearEventos(null,'" . $obj['nombre'] . "','" . $obj['fecha_inicio'] . "','" . $obj['fecha_final'] . "','" . $obj['tipo_votacion'] . "','" . $obj['tipo_voto'] . "','" . $obj['avance'] . "','" . $obj['cantidad_votos_permitidos'] . "',@return)";

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

    if (isset($_GET['all'])) {

        $consulta = "call consultarEventos()";

        $resultado = mysqli_query($conn, $consulta);

        if ($resultado != null) {

            while ($filas = mysqli_fetch_array($resultado)) {
                $array[] = array(
                    "id" => $filas['id'],
                    "nombre" => $filas['nombre'],
                    "fecha_inicio" => $filas['fecha_inicio'],
                    "fecha_final" => $filas['fecha_final'],
                    "tipo_votacion" => $filas['tipo_votacion'],
                    "tipo_voto" => $filas['tipo_voto'],
                    "avance" => $filas['avance'],
                    "cantidad_votos_permitidos" => $filas['cantidad_votos_permitidos'],
                );
            }
        }
    } else if (isset($_GET['id'])) {

        $consulta = "call consultarEventoPorID('" . $_GET['id'] . "')";

        $resultado = mysqli_query($conn, $consulta);

        if ($resultado != null) {

            while ($filas = mysqli_fetch_array($resultado)) {
                $array[] = array(
                    "id" => $filas['id'],
                    "nombre" => $filas['nombre'],
                    "fecha_inicio" => $filas['fecha_inicio'],
                    "fecha_final" => $filas['fecha_final'],
                    "tipo_votacion" => $filas['tipo_votacion'],
                    "tipo_voto" => $filas['tipo_voto'],
                    "avance" => $filas['avance'],
                    "cantidad_votos_permitidos" => $filas['cantidad_votos_permitidos'],
                );
            }
        }
    } else if (isset($_GET['nombre'])) {

        $consulta = "call consultarEventoPorNombre('" . $_GET['nombre'] . "')";

        $resultado = mysqli_query($conn, $consulta);

        if ($resultado != null) {

            while ($filas = mysqli_fetch_array($resultado)) {
                $array[] = array(
                    "id" => $filas['id'],
                    "nombre" => $filas['nombre'],
                    "fecha_inicio" => $filas['fecha_inicio'],
                    "fecha_final" => $filas['fecha_final'],
                    "tipo_votacion" => $filas['tipo_votacion'],
                    "tipo_voto" => $filas['tipo_voto'],
                    "avance" => $filas['avance'],
                    "cantidad_votos_permitidos" => $filas['cantidad_votos_permitidos'],
                );
            }
        }
    } else {

        $array = array("estado" => "No existe envento");
    }

    $json = $array;
}


@mysqli_close($conn);

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
