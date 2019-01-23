
<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});

session_start();

if (isset($_POST['submit'])) {
    switch ($_POST['submit']) {
        case "Conectar":
            $bd = new BD("172.17.0.2");
            $user = $_POST['usuario'];
            $pass = $_POST['pass'];
            $host = $_POST['host'];
            $_SESSION['user'] = $bd;
            $conectado = true;
            break;
        case "Gestionar":
            break;

        default:
            break;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Ejemplo de estilos CSS en un archivo externo</title>
        <link rel="stylesheet" type="text/css" href="estilos.css" media="screen">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <fieldset id="sup" style="width:70%">
            <legend>Datos de conexión</legend>
            <form action="." method="POST">
                <label for="host">Host</label>
                <input type="text" name="host" value="localhost" id="">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" value="root" id="">
                <label for="pass">Password</label>
                <input type="text" name="pass" value="root" id="">
                <input type="submit" value="Conectar" name="submit">
            </form>

        </fieldset>
        <?php if ($conectado === true): ?>

            <fieldset style = "width:70%; margin-top:8%">
                <legend>Gestion de las Bases de Datos del host <span class = "resaltar"><span style="color:red"><?php echo $host
            ?></span></span></legend>
                <form action="tablas.php" method="post">
                    SHOW DATABASES WHERE User="xxxxx";<br/>
                    <input type="submit"value="gestionar" name="submit">
                </form>
            </fieldset>
        <?php endif; ?>



    </body></html>
