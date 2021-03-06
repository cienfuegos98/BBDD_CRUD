<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});
$host = "";
$conectado = false;
$radios = "";
$error = "";
session_start();
//Si vengo del submit conectar.
if (isset($_POST['conectar'])) {
    $user = $_POST['usuario'];
    $pass = $_POST['pass'];
    $host = $_POST['host'];

    $con = new BD($host, $user, $pass);
    $error = $con->getError();
    if ($error == null) {
        $conectado = true;
        $r = $con->consulta('SHOW DATABASES');
        while (( $dbNames = $r->fetchColumn(0) ) !== false) {
            $radios .= "<input type='radio' name='radio' value='$dbNames'> $dbNames<br>";
        }
    }
    $_SESSION['conexion'] = [$host, $user, $pass];
    $con->cerrar();
}

if (isset($_SESSION['conexion'])) {
//Si ya he establecido previamente conexión, recojo los datos de sesión
//Si no contendrán null y la conexión fallará y me informará de ello
    $conexion = $_SESSION['conexion'];
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="estilos.css" media="screen">
        <meta charset="UTF-8">
        <title>Login</title>

    </head>
    <body>
        <!--muestro el error si no es null-->
        <header><?php echo $error ?? null ?></header>
        <fieldset id="sup" style="width:70%">
            <legend>Datos de conexión</legend>
            <form action="." method="POST">
                <label for="host">Host</label>
                <input type="text" name="host" value="localhost" id="">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" value="root" id="">
                <label for="pass">Password</label>
                <input type="text" name="pass" value="root" id="">
                <input type="submit" value="Conectar" name="conectar">
            </form>

        </fieldset>
        <!--Solo si estoy conectado mostrare este fieldset-->
        <?php if ($conectado == true): ?>
            <fieldset style = "width:70%; margin-top:8%">
                <legend>Gestion de las Bases de Datos del host <span class = "resaltar"><span style="color:red"><?php echo $host
            ?></span></span></legend>
                <form action="tablas.php" method="post">
                    <br/>
                    <input type="submit"value="Gestionar" name="gestionar"><br>
                    <?php
                    //muestro las bases con su input radio
                    echo $radios;
                    ?>
                </form>
            </fieldset>
        <?php endif; ?>
    </body>
</html>
