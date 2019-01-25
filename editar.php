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
            <form action="editar.php" method="POST">
                <label>Nombre corto</label> <input type="text" value="" name="nombre"><br/><br/>
                <label>Nombre</label> <br/><textarea  name="name"></textarea><br/><br/>
                <label>Descripcion</label> <br/><textarea name="descrip"></textarea><br/><br/>
                <label>PVP</label> <input type="text" value="" name="pvp">
                <br/><br/>
                <input type="submit" value="Modificar" name="submit">
                <input type="submit" value="Cancelar" name="submit">
            </form>
        </fieldset>
    </body>
</html>

