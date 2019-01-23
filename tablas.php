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
            <legend>Listado bases de datos</legend>
            <form action="index.php" method="POST">
                <input type="submit" value="Volver" name="volver">
            </form>
        </fieldset>

        <fieldset style="width:70%; margin-top:8%">
            <legend>Gestion de las Bases de Datos <span class="resaltar"></span></legend>
            <form action="gestionTabla.php" method="post">
                <input type="submit" value="boton" name="boton">SHOW TABLES IN (database)
            </form>
        </fieldset>
    </body>
</html>