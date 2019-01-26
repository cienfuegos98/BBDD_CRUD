<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});
$nombreTabla = $_POST['botones'];
session_start();
$host = $_SESSION['conexion'][0];
$user = $_SESSION['conexion'][1];
$pass = $_SESSION['conexion'][2];
$bd = $_SESSION['conexion'][3];
$con = new BD($host, $user, $pass, $bd);

function obtenerTabla($con, $nombreTabla) {
    $filas = $con->selection("SELECT * FROM $nombreTabla");
    $campos = $con->nombres_campos($nombreTabla);
    $tabla = "<table><tr>";
    foreach ($campos as $campo) {
        $tabla .= "<th> $campo</th>";
    }
    $tabla .= "<th> Acciones</th>";
    $tabla .= "</tr>";
    foreach ($filas as $datos) {
        $tabla .= "<tr><form action = 'editar.php' method = POST>";
        foreach ($campos as $i => $fila) {
            $tabla .= "<td>$datos[$i]</td>"
                    . "<input type = hidden value = '$datos[$i]' name = 'campos[$campos[$i]]' >";
            var_dump($campos[$i]);
        }
        $tabla .= "<td><input type = 'submit' value = 'Editar' name = 'submit'><input type = 'submit' value = 'Delete' name = 'submit'></td></form>"
                . "</tr>";
    }
    $tabla .= "</table>";
    return $tabla;
}

$submit = $_POST['submit'];
if (isset($submit)) {
    switch ($submit) {
        case "Delete":
//            $c = "DELETE FROM $nombreTabla WHERE ";
//            $con->run($c);
            break;
        case "Modificar":
            header("Location: editar.php");
            break;
        case "Editar":
            header("Location: editar.php");
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
                <?php echo obtenerTabla($con, $nombreTabla) ?>
            <form action="gestionTabla.php" method="post">
                <input type="submit" value="Modificar" name="submit">
                <input type="submit" value="Close" name="submit">
            </form>
        </fieldset>
    </body>
</html>