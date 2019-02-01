<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});

session_start();

$host = $_SESSION['conexion'][0];
$user = $_SESSION['conexion'][1];
$pass = $_SESSION['conexion'][2];
$bd = $_SESSION['conexion'][3];
$nombreTabla = "";
if (isset($_POST['botones'])) {
    $nombreTabla = $_POST['botones'];
} else {
    $nombreTabla = $_GET['nombreTabla'];
}

$con = new BD($host, $user, $pass, $bd);

function obtenerTabla($con, $nombreTabla) {
    $campos = $con->nombres_campos($nombreTabla);
    $filas = $con->selection("SELECT * FROM $nombreTabla");
    $tabla = "<table><tr>";
    foreach ($campos as $campo) {
        $tabla .= "<th> $campo</th>";
    }
    $tabla .= "<th colspan='2'> Acciones</th>";
    $tabla .= "</tr>";
    foreach ($filas as $datos) {
        $tabla .= "<tr><form action = 'gestionTabla.php' method = POST>";
        foreach ($campos as $i => $fila) {
            $tabla .= "<td>$datos[$i]</td>"
                    . "<input type = hidden value = '$datos[$i]' name = 'campos[$campos[$i]]' >"
                    . "<input type = hidden value = '$nombreTabla' name = 'nombreTabla' >";
        }
        $tabla .= "<td><input type = 'submit' value = 'Editar' name = 'submit'></td>"
                . "<td><input type = 'submit' value = 'Delete' name = 'submit'></td></form>"
                . "</tr>";
    }
    $tabla .= "</table>";
    return $tabla;
}

function borrar($nombreTabla, $campos) {
    $sentencia = "DELETE FROM $nombreTabla WHERE ";
    foreach ($campos as $i => $campo) {
        $sentencia .= "$i = '" . $campo . "' and ";
    }
    $sentencia = substr($sentencia, 0, strlen($sentencia) - 4);
    return $sentencia;
}

if (isset($_POST['submit'])) {
    $campos = $_POST['campos'];
    $nombreTabla = $_POST['nombreTabla'];
    switch ($_POST['submit']) {
        case "Delete":
            $c = borrar($nombreTabla, $campos);
            $con->run($c);
            break;
        case "Editar":
            $campos = serialize($campos);
            header("Location:editar.php?campos=$campos&tabla=$nombreTabla");
            break;
        case "Add":
            $boton = "añadir";
            $campos = serialize($campos);
            header("Location:editar.php?campos=$campos&tabla=$nombreTabla&boton=$boton");
            break;
        case "Close":
            header("Location: tablas.php");
            break;
        default:
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

            <form action="gestionTabla.php" method="post">
                <?php echo obtenerTabla($con, $nombreTabla) ?>
                <input type="hidden" name ="botones" value="<?php echo $nombreTabla ?>">
                <input type="hidden" name ="tabla" value="<?php echo $nombreTabla ?>">
                <input type="hidden" name ="bd" value="<?php echo $bd ?>">
                <input type="submit" value="Add" name="submit">
                <input type="submit" value="Close" name="submit">
            </form>
        </fieldset>
    </body>
</html>