<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});


session_start();

$host = $_SESSION['conexion'][0];
$user = $_SESSION['conexion'][1];
$pass = $_SESSION['conexion'][2];
$bd = $_SESSION['conexion'][3];

$con = new BD($host, $user, $pass, $bd);

$datos = $_POST['campos'];

$nombreTabla = $_POST['tabla'];
$contenidosViejos = [];

function obtenerTitulos($datos, $contenidosNuevos) {
    foreach ($datos as $i => $campo) {
        echo "<label>$i</label>"
        . "<input type='text' name='contenidosNuevos[]' value='$campo'><br>"
        . "<input type='hidden' name='contenidosViejos[]' value='$campo'>"
        . "<input type = 'hidden' name = 'titulos[]' value = '$i'>";
    }
}

$contenidosNuevos = $_POST['contenidosNuevos'];
$x = 1;
$c = "UPDATE $nombreTabla SET ";
foreach ($datos as $i => $campo) {
    if ($x >= count($datos)) {
        $c .= "$i = :$i";
    } else {
        $c .= "$i = :$i, ";
    }
    $x++;
    $contenidosNuevos[] = $i;
    //$c->bindParam(":$i", $contenidos);
}
$c .= " WHERE $i = $contenidosViejos[0]";



$error = $con->getError();

echo $c;
if (isset($_POST['submit'])) {
    switch ($_POST['submit']) {
        case "Guardar":

            break;
        case "Cancelar":
            header("Location:gestionTabla.php");
            break;

        default:
            break;
    }
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <link rel="stylesheet" type="text/css" href="estilos.css" media="screen">

        <style>
            textarea{
                width: 350px;
                height: 150px;
            }
            fieldset{
                width: 35%;
            }
            input{
                margin-bottom: 10px;
                margin-left: 5px;
            }
        </style>
    </head>
    <body>
        <fieldset>
            <legend><h2>Editanto Registro de la tabla <span style="color: red"><?php echo $nombreTabla ?></span></h2></legend>
            <form action="gestionTabla.php" method="POST">
                <?php obtenerTitulos($datos, $contenidosNuevos); ?>
                <input type='submit' name='submit' value='Guardar'>
                <input type='submit' name='submit' value='Cancelar'>
                <input  type='hidden' name='tabla' value='<?php echo $nombreTabla ?>'>
            </form>
        </fieldset>
    </body>
</html>

