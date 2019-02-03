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

$boton = $_GET['boton'];
$campos = $_SESSION['campos'];
$campos = unserialize($campos);
$nombreTabla = $_GET['tabla'];
if ($boton == "añadir") {

    $btn = "Insertar";
} else {

    $btn = "Guardar";
}

function obtenerFormulario($campos, $boton) {
    foreach ($campos as $i => $campo) {
        if ($boton == "añadir") {
            echo "<label>$i</label>"
            . "<input type='text' name='valorNuevo[]' value=''><br>"
            . "<input type='hidden' name='campos[$i]' value='$campo'><br>"
            . "<input type='hidden' name='valorAnt[]' value=''><br>";
        } else {
            echo "<label>$i</label>"
            . "<input type='text' name='valorNuevo[]' value='$campo'><br>"
            . "<input type='hidden' name='campos[$i]' value='$campo'><br>"
            . "<input type='hidden' name='valorAnt[]' value='$campo'><br>";
        }
    }
}

if (isset($_POST['accion'])) {
    $nombreTabla = $_POST['nombreTabla'];
    switch ($_POST['accion']) {
        case "Guardar":
            $valorNuevo = $_POST['valorNuevo'];
            $valorAnt = $_POST['valorAnt'];
            $campos = $_POST['campos'];
            $res = generaSentenciaUpdate($nombreTabla, $campos, $valorAnt, $valorNuevo);
            $con->run($res);
            header("Location:gestionTabla.php?nombreTabla=$nombreTabla");
            break;
        case "Insertar":
            $valorNuevo = $_POST['valorNuevo'];
            $campos = $_POST['campos'];
            $res = generaInsert($nombreTabla, $campos, $valorNuevo);
            $con->run($res);
            header("Location:gestionTabla.php?nombreTabla=$nombreTabla");
            break;

        case "Cancelar":
            header("Location:gestionTabla.php?nombreTabla=$nombreTabla");
            break;

        default:
            break;
    }
}

function generaSentenciaUpdate($nombreTabla, $campos, $valorAnt, $valorNuevo) {
    $indice = 0;
    foreach ($campos as $titulo => $campo) {
        $set .= "$titulo = '" . $valorNuevo[$indice] . "', ";
        $where .= "$titulo = '" . $valorAnt[$indice] . "' and ";
        $indice++;
    }
    $set = substr($set, 0, strlen($set) - 2);
    $where = substr($where, 0, strlen($where) - 4);
    $sentencia = "UPDATE $nombreTabla SET $set WHERE $where";
    return $sentencia;
}

function generaInsert($nombreTabla, $campos, $valorNuevo) {
    $columns = "";
    $indice = 0;
    $values = "VALUES(";
    $sentencia = "INSERT INTO $nombreTabla(";
    foreach ($campos as $titulo => $campo) {
        $columns .= "$titulo,";
        $values .= "'$valorNuevo[$indice]',";
        $indice++;
    }
    $columns = substr($columns, 0, strlen($columns) - 1) . ")";
    $values = substr($values, 0, strlen($values) - 1) . ")";
    $sentencia .= "$columns $values";
    return $sentencia;
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <link rel="stylesheet" type="text/css" href="estilos.css" media="screen">
        <title>Tabla</title>
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
        <header><?php echo $error ?? null ?></header>
        <fieldset>
            <legend><h2>Editanto Registro de la tabla <span style="color: red"><?php echo $nombreTabla ?></span></h2></legend>
            <form action="editar.php" method="POST">
                <?php obtenerFormulario($campos, $boton); ?>
                <input type='submit' name='accion' value='<?php echo $btn ?>'>
                <input type='submit' name='accion' value='Cancelar'>
                <input  type='hidden' name='nombreTabla' value='<?php echo $nombreTabla ?>'>
            </form>
        </fieldset>
    </body>
</html>

