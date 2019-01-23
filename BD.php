<?php

class BD {

//Inicializamos las variables
    private $con; //conexion
    private $error;
    private $host;
    private $user;
    private $pass;
    private $bd;

    function getError() {
        return $this->error;
    }
    
//Creamos el constructor con los atributos de la base de datos
    public function __construct($host = "localhost", $user = "root", $pass = "root", $bd = null) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->bd = $bd;
        $this->con = $this->conexion();
    }

    private function conexion() {
        try {
            $con = new PDO("mysql:host=$this->host;dbname=$this->bd", $this->user, $this->pass);
            return $con;
        } catch (Exception $e) {
            $this->error =  $e->getMessage();
        }
    }

    public function cerrar() {//cerramos la conexion con la bbdd
        $this->con = null;
    }

    public function consulta($c) {
        return $this->con->query($c);
    }

}

////creamos una funcion que devuelve la conexion de la base de datos
//    private function conexion(): mysqli {
//        $con = new mysqli($this->host, $this->user, $this->pass, $this->bd);
//        if ($con->connect_errno) {
//            $this->info = "Error conectando ... <strong>" . $con->connect_errno . "</strong>";
//        }
//        $con->set_charset('utf8');
//        return $con;
//    }
//
////Funcio que realiza un sellect en la base de datos
//    public function select(string $c): array {
//        $filas = [];
//        if ($this->con == null) {
//            $this->con = $this->conexion();
//        }
//        $resultado = $this->con->query($c);
//        while ($fila = $resultado->fetch_row()) {//mientras fila sea distinto de null cogemos el siguiente valor
//            $filas[] = $fila;
//        }
//        return $filas;
//    }
//
////cerramos la conexion de la base de datos
//    public function cerrar() {//cerramos la conexion con la bbdd
//        $this->con->close();
//    }
//
////creamos un afuncion que nos devolvera los nombres de las columnas de la tabla
//// que especifiquemos como parámetro
//    public function nombres_campos($nombre_tabla): array {
//        $campos = [];
//        $consulta = "select * from $nombre_tabla";
//        $r = $this->con->query($consulta);
//        $campos_obj = $r->fetch_fields();
//        foreach ($campos_obj as $campo) {
//            $campos[] = $campo->name;
//        }
//        return $campos;
//    }
//
////funcion que devuelve un query
//    public function modify($c) {
//        return $this->con->query($c);
//    }
//
////    function obtener_tabla($bd, $productos, $tabla) {
////    $campos = $bd->nombres_campos("producto");
////    $tabla .= "<table>
////            <tr>
////            <th> $campos[1]</th>
////            <th> $campos[2]</th>
////            <th> $campos[3]</th>
////            <th> $campos[4]</th>
////            </tr>";
////    foreach ($productos as $dato) {
////        $nombreCorto = $dato[2];
////        $tabla .= "<form action = 'editar.php' method = POST>";
////        $tabla .= "<input type = hidden value = '$nombreCorto' name = 'nombreCorto'>"
////                . "<tr><td>$dato[1]</td>"
////                . "<td>$nombreCorto </td>"
////                . "<td>$dato[3]</td>"
////                . "<td>$dato[4]</td>"
////                . "<td><input type = 'submit' value = 'Modificar' name = 'modificar'<td></tr>";
////        $tabla .= "</form>";
////    }
////    $tabla .= "</table>";
////    return $tabla;
////}
//}
