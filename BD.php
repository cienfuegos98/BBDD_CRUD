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
    public function __construct($host = "172.17.0.2", $user = "root", $pass = "root", $bd = null) {
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
            $this->error = $e->getMessage();
        }
    }

    public function cerrar() {//cerramos la conexion con la bbdd
        $this->con = null;
    }

    public function consulta($c) {
        return $this->con->query($c);
    }

    public function selection($c) {
        $filas = [];
        if ($this->con == null) {
            $this->con = $this->conexion();
        }
        $resultado = $this->con->query($c);
        while ($fila = $resultado->fetch(PDO::FETCH_NUM)) {
            $filas[] = $fila;
        }
        return $filas;
    }

    public function nombres_campos($nombre_tabla): array {
        $campos = [];
        $consulta = "select * from $nombre_tabla";
        $r = $this->con->query($consulta);
        $campos_obj = $r->fetch(PDO::FETCH_ASSOC);
        foreach ($campos_obj as $i => $campo) {
            $campos[] = $i;
        }
        return $campos;
    }

}
