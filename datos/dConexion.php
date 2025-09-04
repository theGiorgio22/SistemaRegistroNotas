<?php
class dConexion {
    private $servidor = "localhost";
    private $usuario = "root";
    private $clave = "";
    private $bd = "bdsistemaregistronotas";
    private $puerto = 3308;

    function Conectar() {
        $con = mysqli_connect($this->servidor, $this->usuario, $this->clave, $this->bd, $this->puerto);
        if (!$con) {
            die("❌ Error de conexión a la base de datos: " . mysqli_connect_error());
        }
        return $con;
    }
}
?>
