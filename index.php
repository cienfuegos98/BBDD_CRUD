<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html><head>
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
                <input type="submit" value="Conectar" name="conectar">
            </form>

        </fieldset>

        <fieldset style="width:70%; margin-top:8%">
            <legend>Gestion de las Bases de Datos del host <span class="resaltar">???BBDD????</span></legend>
            <form action="tablas.php" method="post">
                -------"lista de bases de datos"--------<br/>
                <input type="submit" value="Gestionar">
            </form>
        </fieldset>


    </body></html>
