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

$campos = $_POST['campos'];
var_dump($campos);
//foreach ($campos as $campo) {
//    $form = "<label> $campo</label>";
//}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <style>
            textarea{
                width: 350px;
                height: 150px;
            }
            fieldset{
                width: 35%;
            }
        </style>
    </head>
    <body>
        <fieldset>
            <legend><h2>xxxx</h2></legend>

        </fieldset>
    </body>
</html>

