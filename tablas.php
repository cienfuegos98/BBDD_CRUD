<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});

$bd = $_POST['radio'];

session_start();

$host = $_SESSION['conexion'][0];
$user = $_SESSION['conexion'][1];
$pass = $_SESSION['conexion'][2];
$_SESSION['conexion'][3] = $bd;

$con = new BD($host, $user, $pass, $bd);

if ($error == null) {
    $r = $con->consulta("SHOW TABLES");
    while (( $tableNames = $r->fetchColumn(0) ) !== false) {
        $botones .= "<input type='submit' name='botones' value='$tableNames'>";
    }
}
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Ejemplo de estilos CSS en un archivo externo</title>
        <link rel="stylesheet" type="text/css" href="estilos.css" media="screen">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <fieldset id="sup" style="width:25%">
            <legend>Listado bases de datos de <span  style="color:red"><?php echo $bd ?></span></legend>
            <form action="index.php" method="POST">
                <input type="submit" value="Volver" name="volver">
            </form>
        </fieldset>

        <fieldset style="width:70%; margin-top:8%">
            <legend>Gestion de las Bases de Datos <span class="resaltar"></span></legend>
            <form action="gestionTabla.php" method="post">
                <?php echo $botones ?>
            </form>
        </fieldset>
    </body>
</html>