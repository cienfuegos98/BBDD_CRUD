
<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});
$host = "";
$conectado = false;
$radios = "";
$error = "";

if (isset($_POST['submit'])) {
    $user = $_POST['usuario'];
    $pass = $_POST['pass'];
    $host = $_POST['host'];


    $con = new BD($host, $user, $pass);
    $error = $con->getError();
    if ($error == "") {
        $conectado = true;
        $r = $con->consulta('SHOW DATABASES');
        while (( $dbNames = $r->fetchColumn(0) ) !== false) {
            $radios .= "<input type='radio' name='radio' value='$dbNames'> $dbNames<br>";
        }
    }
    //        $_SESSION['user'] = $bd;
    $con->cerrar();
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
        <header><?php echo $error ?></header>
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
        <?php if ($conectado == true): ?>
            <fieldset style = "width:70%; margin-top:8%">
                <legend>Gestion de las Bases de Datos del host <span class = "resaltar"><span style="color:red"><?php echo $host
            ?></span></span></legend>
                <form action="tablas.php" method="post">
                    <br/>
                    <input type="submit"value="gestionar" name="submit">
                </form>
                <?php echo $radios ?>
            </fieldset>
        <?php endif; ?>
    </body>
</html>
