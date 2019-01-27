<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});

session_start();

$nombreTabla = $_POST['botones'];
$host = $_SESSION['conexion'][0];
$user = $_SESSION['conexion'][1];
$pass = $_SESSION['conexion'][2];
$bd = $_SESSION['conexion'][3];
$con = new BD($host, $user, $pass, $bd);

if (!isset($nombreTabla)) {
    $nombreTabla = $_GET['tabla'];
}

function obtenerTabla($con, $nombreTabla) {
    $campos = $con->nombres_campos($nombreTabla);
    $filas = $con->selection("SELECT * FROM $nombreTabla");
    $tabla = "<table><tr>";
    foreach ($campos as $campo) {
        $tabla .= "<th> $campo</th>";
    }
    $tabla .= "<th> Acciones</th>";
    $tabla .= "</tr>";
    foreach ($filas as $datos) {
        $tabla .= "<tr><form action = 'gestionTabla.php' method = POST>";
        foreach ($campos as $i => $fila) {
            $tabla .= "<td>$datos[$i]</td>"
                    . "<input type = hidden value = '$datos[$i]' name = 'campos[$campos[$i]]' >"
                    . "<input type = hidden value = '$nombreTabla' name = 'tabla' >";
        }
        $tabla .= "<td><input type = 'submit' value = 'Editar' name = 'submit'><input type = 'submit' value = 'Delete' name = 'submit'></td></form>"
                . "</tr>";
    }
    $tabla .= "</table>";
    return $tabla;
}

function borrar($tabla, $con) {
    $filas = $con->selection("SELECT * FROM $tabla");
    $sentencia = "DELETE FROM $tabla WHERE ";
    foreach ($filas as $campo => $dato) {
        $columna = substr($campo, 1); // Quitar : = KEY del array asociativo...
        $sentencia .= "$columna=$campo AND ";
    }

    $sql = substr($sentencia, 0, strlen($sentencia) - 4);
    return $con->run($sql, $filas);
}

if (isset($_POST['submit'])) {
    switch ($_POST['submit']) {
        case "Delete":
            $nombreTabla = $_POST['tabla'];
            $result = $con > borrar($nombreTabla, $con); // Controlar que RECARGE LA PAGINA
            header("Location: gestionTabla.php");
            $bd->close(); // Cerrar conexión BBDD...

            break;
        case "Editar":
            header("Location: editar.php");
            break;
        case "Add":
            header("Location: editar.php");
            break;
        case "Close":
            header("Location: tablas.php");
            break;
    }
}
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;
              charset = UTF-8">
        <title>Ejemplo de estilos CSS en un archivo externo</title>
        <link rel="stylesheet" type="text/css" href="estilos.css" media="screen">
        <meta charset="ISO-8859-1">
    </head>
    <body>
        <fieldset style="width:70%">
            <legend>Admnistración de la tabla <span  style="color:red"><?php echo $nombreTabla ?></span></legend>
                <?php echo obtenerTabla($con, $nombreTabla) ?? null ?>
            <form action="gestionTabla.php" method="post">
                <input type="submit" value="Add" name="submit">
                <input type="submit" value="Close" name="submit">
                <input type = hidden value = '<?php $nombreTabla ?>' name = 'tabla' >
            </form>
        </fieldset>
    </body>
</html>