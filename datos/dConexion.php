<?php
class dConexion {
    private $servidor;
    private $basededatos;
    private $puerto;
    private $usuario;
    private $clave;

    function __construct() {
        $this->servidor = "localhost";
        $this->basededatos = "bdsistemaregistronotas";
        $this->puerto = 3306;
        $this->usuario = "root";
        $this->clave = "";
    }

    function Conectar() {
        $con = mysqli_connect(
            $this->servidor,
            $this->usuario,
            $this->clave,
            $this->basededatos,
            $this->puerto
        );

        if (!$con) {
            die("Error en la conexión a la base de datos: " . mysqli_connect_error());
        }
        return $con;
    }
}
