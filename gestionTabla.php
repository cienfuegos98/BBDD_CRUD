<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});
$datoKey;
$campoKey;
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
    foreach ($campos as $i => $campo) {
        $tabla .= "<th> $campos[$i]</th>";
    }
    $tabla .= "<th> Acciones</th>";
    $tabla .= "</tr>";
    foreach ($filas as $datos) {
        $tabla .= "<form action = 'gestionTabla.php' method = POST>"
                . "<input type = hidden value = '$valor' name = 'key'>"
                . "<tr>";
        foreach ($campos as $i => $fila) {
            $datoKey = $datos[0];

            $tabla .= "<td>$datos[$i]</td>";
        }
        $tabla .= "<td><input type = 'submit' value = 'Editar' name = 'submit'><input type = 'submit' value = 'Delete' name = 'submit'></td></tr></form>";
    }
    $tabla .= "</table>";
    return $tabla;
}

$submit = $_POST['submit'];
if (isset($submit)) {
    switch ($submit) {
        case "Editar":
            header("Location: editar.php?valor=$valor");
            break;
        case "Delete":
            var_dump($datoKey);
            $c = "DELETE FROM $nombreTabla WHERE ";
            $con->run($c);
            break;
        case "Add":
            header("Location: editar.php?valor=$valor");
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
                <input type="submit" value="Add" name="submit">
                <input type="submit" value="Close" name="submit">
            </form>
        </fieldset>
    </body>
</html>